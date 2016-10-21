<?php

namespace backend\controllers;

use common\models\Order;
use common\models\OrderWhen;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 订单
 * Class GoodsController
 * @package backend\controllers
 */
class OrderController extends BaseController
{

    /**
     *  列表
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Order();

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



        return $this->render('_form', $data);
    }


    /**
     * 更新
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $resMsg = [];

        $model = new Order();
        $OrderWhen= new OrderWhen(); //实例化订单进度模型


        //查询信息
        $model= $model ->findOne(['order_code'=>$id]);

        //判断是否POST 提交
        if ($model->load(Yii:: $app-> request->post())) {

            //保存商品数据
            if($model ->validate() && $model->save()){
                //判断是否有订单进度是否为空
                if(!empty($_POST['content'])){
                    //保存录入新的订单进度
                    $OrderWhen ->content = $_POST['content'];
                    $OrderWhen ->order_code =  $model ->order_code;
                    $OrderWhen ->created_at = time();
                    $OrderWhen ->save();
                }

                $resMsg=['status'=>1,'title'=>'更新','info'=>'更新成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'更新','info'=>'更新失败'];
            }
        }

        //获取当前订单进度
        $data['order_when']=$OrderWhen ->find()->where(['order_code'=>$model->order_code])->orderBy('created_at desc')->all();

        $model['norms'] = json_decode($model['norms'],true);
        $data['model'] = $model; //返回主模型
        $data['meta_title'] = '更新'; //页面标题
        $data['resMsg'] = json_encode($resMsg);
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
