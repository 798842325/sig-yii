<?php
namespace phone\controllers;


use common\models\Coupons;
use common\models\GoodsEvaluation;
use common\models\Order;
use common\models\OrderWhen;
use common\models\Recommend;
use common\models\User;
use common\models\WithdrawalRecord;
use dosamigos\qrcode\QrCode;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


/**
 *  用户中心
 * Class UserController
 * @package phone\controllers
 */
class UserController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['member','coupons','order-info','order','order-evaluation'],
                'rules' => [
                    [
                        'actions' => ['member','coupons','order-info','order','order-evaluation'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * 会员中心
     */
    public function actionMember()
    {
        //查询用户信息
        $User = new User();
        $data['user'] = $User = $User ->find()->one();


        //查询用户最新更新的一条订单
        $Order= new Order();
        $data['order_info']=$Order ->find()->where(['user_id'=>Yii::$app->user->id])->orderBy("updated_at desc")->one();
        $OrderWhen = new OrderWhen();
        //获取当前订单进度
        $data['order_when']=$OrderWhen ->find()->where(['order_code'=>$data['order_info']['order_code']])->orderBy('created_at desc')->one();

        return $this ->render('member',$data);
    }


    /**
     * 生成分享二维码
     */
    public function actionQrcode(){
        if(Yii::$app->user->identity->type==0){
            $head_user_id = Yii::$app->user->id;
        }else{
            $head_user_id = Yii::$app->user->identity->head_user_id;
        }

        QrCode::png(Url::to(['site/signup','invite_code'=>Yii::$app->user->id,'head_user_id'=>$head_user_id],true),false,1,4);
    }

    /**
     * 分享二维码
     */
    public function actionShareQrcode(){
        return $this ->render('share_qrcode');
    }


    /**
     *  用户优惠卷
     */
    public function actionCoupons(){
        $Coupons = new Coupons();

        $session = Yii::$app->session;

        if(Yii::$app->request->post()){
            $buy=$session['buy'];
            $buy['coupons']     = $_POST['coupons'];
            $buy['is_coupons']  = $_POST['is_coupons'];
            $session['buy'] = $buy;
            return true;
        }
        $map[] = 'and';
        $map[] = 'status=1';
        $map['user_id'] = Yii::$app->user->getId();
        $map[] = ['<=','start_time',time()];
        $map[] = ['>=','end_time',time()];
        if(isset($_GET['is_true']) && $_GET['is_true'] == 1){

        }
        $data['coupons'] = $Coupons ->find()->where($map)->all();
        $data['session'] = $session;

        return $this ->render('coupons',$data);
    }


    /**
     * 用户订单
     */
    public function actionOrder(){
        $Order = new Order();

        $cond[] = 'and';
        $cond[] ='user_id='.Yii::$app->user->getId();
        if(isset($_GET['status'])){
            $cond[] = 'status='.$_GET['status'];
        }
        if(isset($_GET['is_evaluate'])){
            $cond[] = 'is_evaluate='.$_GET['is_evaluate'];
        }

        $Order = $Order ->find()->where($cond)->orderBy(['cretad_at'=>'desc'])->all(); //查询当前用户的所有订单


        return $this ->render('order',['Order'=>$Order]);
    }

    /**
     * 用户订单详情
     * @param $order_code  //订单号
     */
    public function actionOrderInfo($order_code){

        $Order = new Order();
        $OrderWhen= new OrderWhen(); //实例化订单进度模型

        $data['order_info']=$Order= $Order ->find()->where(['order_code'=>$order_code])->one();
        //获取当前订单进度
        $data['order_when']=$OrderWhen ->find()->where(['order_code'=>$Order->order_code])->orderBy('created_at desc')->all();

        $data['order_info']['norms']= json_decode($data['order_info']['norms'],true);
        return $this ->render('orderInfo',$data);
    }


    /**
     * 用户订单
     */
    public function actionAdminOrder(){
        $Order = new Order();

        $cond[] = 'and';
        $cond[] ='head_user_id='.Yii::$app->user->getId();
        if(isset($_GET['status'])){
            $cond[] = 'status='.$_GET['status'];
        }
        if(isset($_GET['is_evaluate'])){
            $cond[] = 'is_evaluate='.$_GET['is_evaluate'];
        }

        $Order = $Order ->find()->where($cond)->orderBy(['cretad_at'=>'desc'])->all(); //查询当前用户的所有订单


        return $this ->render('admin_order',['Order'=>$Order]);
    }

    /**
     * 用户订单详情
     * @param $order_code  //订单号
     */
    public function actionAdminOrderInfo($order_code){

        $Order = new Order();
        $OrderWhen= new OrderWhen(); //实例化订单进度模型

        $data['order_info']=$Order= $Order ->find()->where(['order_code'=>$order_code])->one();
        //获取当前订单进度
        $data['order_when']=$OrderWhen ->find()->where(['order_code'=>$Order->order_code])->orderBy('created_at desc')->all();

        $data['order_info']['norms']= json_decode($data['order_info']['norms'],true);
        return $this ->render('admin_orderInfo',$data);
    }


    /**
     * 订单-待评价
     */
    public function actionOrderEvaluation($order_code){


        $Order = new Order();
        $GoodsEvaluation = new GoodsEvaluation();

        $data['order_info']=$Order= $Order ->find()->where(['order_code'=>$order_code])->one();

        if($GoodsEvaluation->load(Yii::$app->request->post())){

            $GoodsEvaluation->order_code = $data['order_info']['order_code']; //订单编号
            $GoodsEvaluation->goods_id = $data['order_info']['goods_id'];//商品ID
            $GoodsEvaluation->label =  implode(',', $GoodsEvaluation->label);//标签
            $GoodsEvaluation->user_id = Yii::$app->user->id; //当前用户ID

            if($GoodsEvaluation->validate() && $GoodsEvaluation ->save()){
                //修改订单评论状态
                $Order ->is_evaluate = 1;
                $Order ->save();
                return  json_encode(['status'=>1,'url'=>Url::to(['','order_code'=>$Order ->order_code])]);
            }else{
                return  json_encode(['status'=>1,'url'=>Url::to(['buy-goods','order_code'=>$Order ->order_code])]);
            }
        }

        $data['GoodsEvaluation'] = $GoodsEvaluation;
        return $this ->render('order_evaluation',$data);
    }

    /**
     *  推荐-累积注册
     */
    public function actionCumulativeRegister(){
        $User = new User();
        $data['rec_regUser']=$User ->find()->where(['invite_code'=>Yii::$app->user->id])->all();
        return $this ->render('cumulative_register',$data);
    }

    /**
     * 累计返利
     * @return string
     */
    public function actionCumulativeRebate(){

        //查询推荐的用户
        $User= new User();
        $subQuery= $User ->find()->select('id')->where(['invite_code'=>Yii::$app->user->id]);

        //查询推荐用户的订单
        $Order = new Order();
        $data['rebate']=$Order=$Order ->find()->where(['in','user_id',$subQuery])->all();

        return $this ->render('cumulative_rebate',$data);
    }

    /**
     * 提现
     */
    public function actionWithdrawal(){


        $model =  new WithdrawalRecord();

        if($model ->load(Yii::$app->request->post())){
            $model ->user_id  = Yii::$app->user->id;
            $model ->created_at = time();
            if($model ->validate() && $model->save()){
                $regMsg = ['status'=>1,'title'=>'提交成功','info'=>'已提交成功,请耐心等待~','url'=>Url::to([''])];
            }else{
                $regMsg = ['status'=>0,'title'=>'提交失败','info'=>'请稍后再试!','url'=>Url::to([''])];
            }

            return json_encode($regMsg);
        }
        //查询当前用户信息
        $User =  new User();
        $data['user_info']=$User ->find()->where(['id'=>Yii::$app->user->id])->one();

        $data['model'] = $model;
        return $this ->render('withdrawal',$data);
    }


    /**
     * 提现记录
     */
    public function actionWithdrawalRecord(){

        $WithdrawalRecord = new WithdrawalRecord();
        $data['withdrawal_record']=$WithdrawalRecord ->find()->where(['user_id' =>Yii::$app->user->id])->all();
        return $this ->render('withdrawal_record',$data);
    }

    /**
     * 推荐
     */
    public function actionRecommend(){
        $model =   new Recommend();

        if($model ->load(Yii::$app->request->post())){
            if($model ->validate() && $model ->save()){
                $regMsg = ['status'=>1,'title'=>'提交成功','info'=>'已提交成功','url'=>Url::to(['/'])];
            }else{
                $regMsg = ['status'=>0,'title'=>'提交失败','info'=>'请稍后再试!','url'=>Url::to([''])];
            }

            return json_encode($regMsg);
        }

        $data['model'] = $model;
        return $this ->render('recommend',$data);
    }


    /**
     * 业务员我的客户
     */
    public function actionAdminCustomer(){
        $User = new User();
        $data['head_user']=$User ->find()->where(['head_user_id'=>Yii::$app->user->id])->all();
        return $this ->render('admin_customer',$data);
    }
}
