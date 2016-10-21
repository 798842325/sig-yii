<?php

namespace backend\controllers;


use common\models\GoodsService;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 *  商品服务
 * Class GoodsServiceController
 * @package backend\controllers
 */
class GoodsServiceController extends BaseController
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
        $model = new GoodsService();

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
        $model = new GoodsService();

        //加载数据以及调用创建方法
        if ($model->load(Yii:: $app-> request->post())) {

            if($model ->validate() && $model->save()){
                $resMsg=['status'=>1,'title'=>'创建成功','info'=>'创建成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'创建失败','info'=>'创建失败'];
            }

        }


        return $this->render('_form', ['meta_title'=>'创建','model'=>$model,'resMsg'=>json_encode($resMsg)]);
    }



    /**
     * 更新
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $resMsg = [];

        $model = new GoodsService();

        //查询信息
        $model= $model ->findOne(['id'=>$id]);

        if ($model->load(Yii:: $app-> request->post())) {

            if($model ->validate() && $model->save()){
                $resMsg=['status'=>1,'title'=>'更新','info'=>'更新成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'更新','info'=>'更新失败'];
            }
        }




        return $this->render('_form',['meta_title'=>'更新','model'=>$model,'resMsg'=>json_encode($resMsg)]);

    }


    /**
     *  删除
     * @param $id 主键ID
     * @return string
     */
    public function actionDelete($id)
    {
        $resMsg = [];

        $model = new GoodsService();

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
