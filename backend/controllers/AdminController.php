<?php

namespace backend\controllers;

use common\models\Admin;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\filters\VerbFilter;


/**
 *  管理员-管理
 * Class AdminController
 * @package backend\controllers
 */
class AdminController extends BaseController
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
     * 管理员列表
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Admin();

        //查询语句
        $query = $model::find();

        //分页
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages ->defaultPageSize=20;

        $cond ='';

        if(Yii::$app->request->post()){
            $keywords = Yii::$app->request->post('keywords');
            $cond = [
                'or',
                ['like','username',$keywords],
                ['like','id',$keywords],
                ['like','phone',$keywords],
                ['like','email',$keywords],
            ];
        }

        //查询数据结果
        $model = $query->offset($pages->offset)->where($cond)->limit($pages->limit)->asArray()->all();

        return $this->render('index', ['meta_title'=>'管理员管理','model'=>$model,'pages'=>$pages]);

    }


    /**
     *  创建
     * @return string
     */
    public function actionCreate()
    {
        $resMsg = [];

        $model = new Admin();
        $model ->scenario = Admin::SCENARIOS_CREATE;
        if ($model->load(Yii::$app->request->post())) {

            if($model ->signup()){
                $resMsg=['status'=>1,'title'=>'创建成功','info'=>'创建成功','url'=>Url::to(['/admin'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'创建失败','info'=>'创建失败'];
            }
        }

        return $this->render('_form', ['meta_title'=>'创建','model'=>$model,'resMsg'=>json_encode($resMsg)]);
    }


    /**
     *  更新
     * @param $id  主键ID
     * @return string
     */
    public function actionUpdate($id)
    {
        $resMsg = [];
        $model = new Admin();

        $model = $model->find()->where(['id'=>$id])->one();
        $model ->scenario = Admin::SCENARIOS_UPDATE;
        if ($model->load(Yii::$app->request->post())) {

            if($model ->signup()){
                $resMsg=['status'=>1,'title'=>'更新成功','info'=>'更新成功','url'=>Url::to(['/admin'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'更新失败','info'=>'更新失败'];
            }
        }

        return $this->render('_form', ['meta_title'=>'更新:'.$model ->username,'model'=>$model,'resMsg'=>json_encode($resMsg)]);
    }

    /**
     *  删除
     * @param $id 主键ID
     * @return string
     */
    public function actionDelete($id)
    {
        $resMsg = [];

        $model = new Admin();

        if (Yii::$app->request->post()) {

            if($model ->find()->where(['id'=>$id])->one()->delete()){
                $resMsg=['status'=>1,'title'=>'删除成功','info'=>'删除成功','url'=>Url::to(['/admin'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'删除失败','info'=>'删除失败'];
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
        $model = new Admin();

        $model = $model->find()->where(['id'=>$id])->one(); //获取id等于$id的模型
        $model ->scenario = Admin::SCENARIOS_STATE;
        $model->status = $status; //修改status属性值

        if($model->save()){
            $resMsg =['status'=>1,'title'=>'修改状态','info'=>'修改状态成功'];
        }else{
            $resMsg =['status'=>0,'title'=>'修改状态','info'=>'修改状态失败'];
        }
        return json_encode($resMsg);
    }

}
