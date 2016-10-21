<?php

namespace backend\controllers;

use backend\models\Menu;
use common\libs\Helpers;
use common\models\Article;
use common\models\Classify;
use common\models\ClassifyType;
use common\models\Goods;
use common\models\GoodsService;
use common\models\GoodsSpec;
use common\models\GoodsType;
use common\models\Spec;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 商品
 * Class GoodsController
 * @package backend\controllers
 */
class GoodsController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     *  列表
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Goods();

        //查询语句
        $query = $model::find();

        //分页
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages ->defaultPageSize=20;

        //查询数据结果
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();


        return $this->render('index', ['meta_title'=>'商品管理','model'=>$model,'pages'=>$pages]);


    }


    /**
     * 创建
     * @return mixed
     */
    public function actionCreate()
    {

        $resMsg = [];

        $model = new Goods();
        $GoodsSpec  = new GoodsSpec();

        //加载数据以及调用创建方法
        if ($model->load(Yii:: $app-> request->post())) {

            //处理规格
            foreach ($_POST[$model->formName()]['goods_spec'] as $ks=>$vs){
                foreach ($vs['_child'] as $k2 =>$v2){
                    if(!isset($v2['name'])){
                        unset($_POST[$model->formName()]['goods_spec'][$ks]);
                    }
                }

            }
            $model->goods_spec =$_POST[$model->formName()]['goods_spec'];
            $model->goods_spec=json_encode($model->goods_spec);

            //处理图片
            $picture = $model ->picture;
            $picture[0] = $model ->main_map;
            ksort($picture);
            $model ->picture= serialize(array_filter($picture));

            //验证数据  保存商品信息
            if($model ->validate() && $model->save()){
                //处理规格数据  添加规格数据值
                foreach ($_POST['spec_value'] as $k=>$v){
                    $_POST['spec_value'][$k] =null;
                    $_POST['spec_value'][$k]['goods_id']=$model->attributes['id']; //商品ID
                    $_POST['spec_value'][$k]['spec_key'] =$v['spec_key']; //规格key
                    $_POST['spec_value'][$k]['spec_value'] =$v['spec_value']; //规格值
                    $_POST['spec_value'][$k]['price'] =$v['price']; //价格
                    $_POST['spec_value'][$k]['stock'] =!empty($v['stock'])?$v['stock']:0; //库存
                }

                //删除之前的旧数据
                $GoodsSpec ->deleteAll(['goods_id'=>$model->attributes['id']]);

                //插入新的规格值
                $GoodsSpec ->find()->createCommand()->batchInsert('{{%goods_spec}}',[ 'goods_id','spec_key','spec_value','price','stock'],$_POST['spec_value'])->execute();


                $resMsg=['status'=>1,'title'=>'创建成功','info'=>'创建成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'创建失败','info'=>'创建失败'];
            }

        }


        // 获取商品分类
        $classify= ClassifyType::find()->joinWith([
            'classify' => function ($query) { $query->where('{{%classify}}.status =1')->orderBy(['sort'=>SORT_DESC]);}
        ])->where(['type'=>2])->orderBy(['sort'=>SORT_DESC])->asArray()->all();

        foreach ($classify as $k=>$v){
            $classify[$k]['classify'] =Helpers::list_to_tree($v['classify']);
        }


        $data['goods_classify'] = $classify; //获取商品分类
        $data['goods_spec_value'] =json_encode($GoodsSpec ->find()->where(['goods_id'=>$model->attributes['id']])->asArray()->all()); //获取商品 规格值
        $data['goods_type'] = GoodsType::find()->asArray()->all();//获取商品类型
        $data['goods_service'] = GoodsService::find()->all(); //获取全部服务
        $data['helis_goods_service'] = explode(',',$model->goods_service);//获取已有服务
        $data['resMsg']= json_encode($resMsg);  //返回JSON 消息数据
        $data['model'] = $model; //返回主模型
        $data['meta_title'] = '创建'; //页面标题


        return $this->render('_form', $data);
    }


    /**
     * ajax 获取 商品 规格
     */
    public function actionAjaxGoodsSpec($goodsType=''){
        $resMsg = [];
        $Spec =new Spec();
        $resMsg['data']=$Spec ->find()->where(['goods_type_id'=>$goodsType])->asArray()->all();

        foreach ($resMsg['data'] as $k=>$v){

            $resMsg['data'][$k]['spec_value'] = explode("\r\n",$v['spec_value']);
        }

        return  json_encode($resMsg);
    }

    //获取商品选择规格
    public function actionAjaxCheckSpec()
    {

        $A1 = [];
        $B1 = [];

        $PostSpec=json_decode($_POST['spec'],true);

        foreach ($PostSpec as $ks=>$vs){
            if(empty($A1)) {
                foreach ($vs['_child'] as $k2 => $v2) {
                    $A1[$k2][] = $v2;
                }
            }else{
                foreach ($vs['_child'] as $k2 => $v2) {
                    foreach ($A1 as $ka=>$va){
                        array_push($va,$v2);
                        $B1[]=$va;
                    }
                }
                $A1 = $B1;
                $B1 = [];
            }
        }

        $data['data'] = $A1;
        return json_encode($data);
    }

    /**
     * 更新
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $resMsg = [];

        $model = new Goods();
        $GoodsSpec  = new GoodsSpec();

        //查询信息
        $model= $model ->findOne(['id'=>$id]);


        //判断是否POST 提交
        if ($model->load(Yii::$app->request->post())) {

            foreach ($_POST['spec_value'] as $k=>$v){
                $_POST['spec_value'][$k] =null;
                $_POST['spec_value'][$k]['goods_id']=$id; //商品ID
                $_POST['spec_value'][$k]['spec_key'] =$v['spec_key']; //规格key
                $_POST['spec_value'][$k]['spec_value'] =$v['spec_value']; //规格值
                $_POST['spec_value'][$k]['price'] =$v['price']; //价格
                $_POST['spec_value'][$k]['stock'] =!empty($v['stock'])?$v['stock']:0; //库存
            }

            //处理规格
            foreach ($_POST[$model->formName()]['goods_spec'] as $ks=>$vs){
                foreach ($vs['_child'] as $k2 =>$v2){
                    if(!isset($v2['name'])){
                        unset($_POST[$model->formName()]['goods_spec'][$ks]);
                    }
                }

            }


            $model->goods_spec=json_encode($model->goods_spec);

            //处理图片
            $picture = $model ->picture;
            $picture[0] = $model ->main_map;
            ksort($picture);
            $model ->picture = serialize(array_filter($picture));


            if(is_array($model ->goods_service)){
                $model ->goods_service = implode(',',$model ->goods_service);
            }

            //保存商品数据
            if($model ->validate() && $model->save()){
                     //删除之前的旧数据
                    $GoodsSpec ->deleteAll(['goods_id'=>$id]);
                    //插入新的规格值
                    $GoodsSpec ->find()->createCommand()->batchInsert('{{%goods_spec}}',[ 'goods_id','spec_key','spec_value','price','stock'],$_POST['spec_value'])->execute();

                $resMsg=['status'=>1,'title'=>'更新','info'=>'更新成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'更新','info'=>'更新失败'];
            }
        }

        $model ->picture = unserialize($model ->picture);

        if(count($model ->picture) == 0){
            $model ->picture= array_merge($model ->picture,['1'=>'','2'=>'','3'=>'','4'=>'']);
        }

        // 获取商品分类
        $classify= ClassifyType::find()->joinWith([
            'classify' => function ($query) { $query->where('{{%classify}}.status =1')->orderBy(['sort'=>SORT_DESC]);}
        ])->where(['type'=>2])->orderBy(['sort'=>SORT_DESC])->asArray()->all();

        foreach ($classify as $k=>$v){
            $classify[$k]['classify'] =Helpers::list_to_tree($v['classify']);
        }

        $data['goods_classify'] = $classify; //获取商品分类
        $data['goods_spec_value'] =json_encode($GoodsSpec ->find()->where(['goods_id'=>$id])->asArray()->all()); //获取商品 规格值
        $data['goods_type'] = GoodsType::find()->asArray()->all();//获取商品类型
        $data['goods_service'] = GoodsService::find()->all(); //获取全部服务
        $data['helis_goods_service'] = explode(',',$model->goods_service);//获取已有服务
        $data['resMsg']= json_encode($resMsg);  //返回JSON 消息数据
        $data['model'] = $model; //返回主模型
        $data['meta_title'] = '更新'; //页面标题


        //返回页面视图与数据
        return $this->render('_form',$data);

    }


    /**
     *  删除
     * @param $id 主键ID
     * @return string
     */
    public function actionDelete($id)
    {
        $resMsg = [];

        $model = new Goods();

        if (Yii::$app->request->post()) {

            if($model ->find()->where(['id'=>$id])->one()->delete()){
                $GoodsSpec =new GoodsSpec();
                $GoodsSpec ->where(['goods_id'=>$id])->all()->delete();

                $resMsg=['status'=>1,'title'=>'删除','info'=>'删除成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'删除','info'=>'删除失败'];
            }

        }

        return json_encode($resMsg);
    }


    /**
     * 修改状态
     * @param $id
     * @param $status
     */
    public function actionState($id,$status){
        $model = new Goods();

        $model = $model->find()->where(['id'=>$id])->one(); //获取id等于$id的模型

        $model->status = $status; //修改status属性值

        if($model->save()){
            $resMsg =['status'=>1,'title'=>'状态','info'=>'修改状态成功'];
        }else{
            $resMsg =['status'=>0,'title'=>'状态','info'=>'修改状态失败'];
        }
        return json_encode($resMsg);
    }


}
