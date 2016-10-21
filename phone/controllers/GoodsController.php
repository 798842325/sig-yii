<?php
namespace phone\controllers;

use common\libs\JsApiPay;
use common\libs\Weixin;
use common\models\Article;
use common\models\Coupons;
use common\models\Goods;
use common\models\GoodsEvaluation;
use common\models\GoodsService;
use common\models\GoodsSpec;
use common\models\Order;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 *  商品
 * Class GoodsController
 * @package phone\controllers
 */
class GoodsController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        //获取文章分类
        $ArticleCateType = new ArticleCateType();
        $ArticleCateData=$ArticleCateType ->find() ->where(['apply'=>'PHONE_ARTICLE_CATE'])->joinWith(['article_cate'=>function ($query) {
            $query->where('{{%article_cate}}.status =1')->orderBy(['sort'=>SORT_DESC]);
        }])->asArray()->all();
        $data['articleCate'] = $ArticleCateData[0]['article_cate'];


        //获取文章
        $ArticleCate =  new ArticleCate();
        $ArticleData= $ArticleCate ->find()->select(['id']) ->where(['apply_id' =>$ArticleCateData[0]['apply']]);
        $Article = new Article();
        $ArticleData=$Article ->find()->where(['in','cate_id',$ArticleData])->asArray()->all();
        $data['article'] = $ArticleData;



        return $this->render('index',$data);
    }


    /**
     *  商品详情
     * @param $id   商品ID
     * @return string
     */
    public function actionInfo($id)
    {

        //判断是否POST提交
        if(Yii::$app->request->post()){

            //验证用户是否登录
            if(Yii::$app->user->isGuest){
                return json_encode(['status'=>0,'url'=>Url::to(['site/login']),'msg'=>'你没有登录,请登录~']);
            }

            $Order = new Order();
            //生成订单编号
            $Order ->order_code = substr(time().mt_rand(1000000000,time()),0,-2);
            $Order ->goods_id = $_POST['goods_id']; //商品ID
            $Order ->goods_title = $_POST['goods_title']; //商品名称
            $Order ->amount=$Order ->total = $_POST['total'];//商品价格
            $Order ->norms = json_encode($_POST['norms']);//商品规格
            $Order ->user_id = Yii::$app->user->getId(); //购买用户ID
            $Order ->receiver = Yii::$app->user->identity->realname; // 收货人姓名
            $Order ->receiving_phone=Yii::$app->user->identity->phone;//收货联系电话
            $Order ->cretad_at = time(); // 订单生成时间

            //保存数据 返回 JSON 数据
            if($Order ->save()){
                return  json_encode(['status'=>1,'url'=>Url::to(['buy-goods','order_code'=>$Order ->order_code])]);
            }else{

            }

        }else{
            //获取商品信息
            $Goods= new Goods();
            $GoodsSpec  = new GoodsSpec();
            $data['goods']= $Goods ->find()->where(['id'=>$id])->asArray()->one();
            $data['goods']['goods_spec'] = json_decode($data['goods']['goods_spec'],true);

            $data['goods']['service']=GoodsService::find()->where(['in','id',$data['goods']['goods_service']])->asArray()->all();
            $data['goods']['jsonService'] = json_encode($data['goods']['service']);
            $data['goods_spec_value'] =json_encode($GoodsSpec ->find()->where(['and','goods_id='.$id,['>','stock',0]])->asArray()->all()); //获取商品 规格值
            $GoodsEvaluation = new GoodsEvaluation();
            $data['goods_evaluation'] = $GoodsEvaluation ->GoodsCommentsAll( $data['goods']['id']);
            $label_count = array();
            foreach ($data['goods_evaluation'] as $k=>$v){
                foreach (explode(',',$v['label']) as $ks=>$vs){
                    if(!isset($label_count[$vs])){
                        $label_count[$vs] = 1;
                    }else{
                        $label_count[$vs] ++;
                    }

                }

            }
            $data['label_count'] = $label_count;
        }

        return $this->render('info',$data);
    }

    /**
     *  立即购买 商品
     */
    public function actionBuyGoods($order_code)
    {


        //验证用户是否登录
        if(Yii::$app->user->isGuest){
            return  $this ->redirect(['site/login']);
        }

        $Order = new Order();  //实例化订单模型
        $Coupons = new Coupons(); //实例化优惠卷模型

        $UID = Yii::$app->user->getId();  //获取当前用户ID

        $session = Yii::$app->session;


        //查询订单 详情
        $data['order_info'] = $Order ->find()->where(['order_code'=>$order_code,'user_id'=>$UID])->one();
        $data['order_info']['norms'] = json_decode($data['order_info']['norms'],true); //转换解析 商品购买 规格

        $buy['amount'] = $data['order_info']['amount']; //当前订单应付金额

        //优惠卷查询条件
        $cond[] = 'and';
        $cond[] = "user_id=$UID";
        $cond[] = 'status=1';
        $cond[] = ['<=','limit_price',$data['order_info']['amount']];
        $cond[] = ['<=','start_time',time()];
        $cond[] = ['>=','end_time',time()];

        if(!$session['buy']['is_coupons']){
            if(!empty($session['buy']['coupons'])){
                $cond['id'] = "id=".$session['buy']['coupons'];
            }

            if(!$data['coupons'] = $Coupons ->find()->where($cond)->orderBy(['money'=>'desc'])->one()){
                unset($cond['id'] );
                $data['coupons'] = $Coupons ->find()->where($cond)->orderBy(['money'=>'desc'])->one();
            }
        }else{
            $data['coupons']['money'] = 0;
            $data['coupons']['id'] = 0;
        }






        //查询当前用户符合 当前订单的最大优惠卷
//        $buy['coupons'] =$data['coupons']['id']; // 保存优惠卷ID

        return $this ->render('buyinfo',$data);

    }

    /**
     *  支付接口  调起支付
     */
    public function actionPayPort(){


        $Order = new Order();
        $cond[] = 'and';
        $cond[] = "order_code=$_POST[order_code]";

        $Order = $Order ->find()->where($cond)->one();
        $Order ->coupons_id = $_POST['coupons_id']; // 优惠卷ID
        $Order ->coupons_price = $_POST['coupons_price']; //优惠券 价格
        $Order ->amount = $_POST['amount']; //应付金额
        $Order ->payment = $_POST['payment']; //支付方式
        $Order ->user_remark = $_POST['user_remark']; //用户备注

        $Goods = new Goods();
        $goods_info=$Goods ->find()->where(['id'=>$Order['goods_id']])->one();

        $Order ->rebate_amount =  $Order ->amount * ($goods_info['royalty_rate']/100);

        $Order->save();

        switch ($_POST['payment']){
            case '微信':
                return $this->redirect(['goods/weixinpay','order_code'=>$Order ->order_code]);
                break;
            case '银联':
                echo 2;
                break;
            case '线下':
                echo $this ->actionOfflinePay();
                break;
        }
    }

    //微信支付
    public function actionWeixinpay($order_code=0){

        $Weixin = new Weixin();

        $Order = new Order();
        $cond[] = 'and';
        $cond[] = "order_code='$order_code'";

        $Order = $Order ->find()->where($cond)->one();

        $data['body'] = $Order['goods_title']; //商品描述
        $data['attach'] ='test' ; //附加
        $data['total_fee'] =$Order['amount'] * 100;  //总金额
        $data['goods_tag'] ='test';  //商品标记
        $data['notify_url'] ="http://paysdk.weixin.qq.com/example/notify.php";    //通知地址

        $Weixin ->UnifiedOrder($data);
    }

    /**
     *  线下支付
     */
    public function actionOfflinePay(){



        $Article =  new Article();
        $cond[]= 'and';
        $cond[]= "uniques='OFFLINE_PAYMENT'";
        $data['article'] = $Article ->find()->where($cond)->one();

        return $this->render('offlinepay',$data);
    }


}
