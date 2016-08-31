<?php

namespace backend\controllers;

use common\models\AuthGroup;
use common\models\AuthRule;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\filters\VerbFilter;


/**
 * 权限 之 角色
 * Class RoleController
 * @package backend\controllers
 */
class RoleController extends BaseController
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
     * 列表
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new AuthGroup();

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
                ['like','title',$keywords],
                ['like','id',$keywords],
            ];
        }

        //查询数据结果
        $model = $query->offset($pages->offset)->where($cond)->limit($pages->limit)->asArray()->all();

        return $this->render('index', ['meta_title'=>'角色管理','model'=>$model,'pages'=>$pages]);

    }


    /**
     *  创建
     * @return string
     */
    public function actionCreate()
    {
        $resMsg = [];

        $model = new AuthGroup();

        if ($model->load(Yii::$app->request->post())) {
            //处理权限
            $model->rules=implode(',',Yii::$app->request->post('rules'));

            if($model ->validate() && $model->save()){
                $resMsg=['status'=>1,'title'=>'创建成功','info'=>'创建成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'创建失败','info'=>'创建失败'];
            }
        }

        //获取 所有权限
        $d_rule=AuthRule::find()->all();

        return $this->render('_form', ['meta_title'=>'创建','model'=>$model,'d_rule'=>$d_rule,'to_rule'=>[],'resMsg'=>json_encode($resMsg)]);
    }


    /**
     *  更新
     * @param $id  主键ID
     * @return string
     */
    public function actionUpdate($id)
    {
        $resMsg = [];
        $model = new AuthGroup();

        $model = $model->find()->where(['id'=>$id])->one();

        if ($model->load(Yii::$app->request->post())) {
            $model ->rules = implode(',',Yii::$app->request->post('rules'));
            if($model ->validate() && $model ->save()){
                $resMsg=['status'=>1,'title'=>'更新成功','info'=>'更新成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'更新失败','info'=>'更新失败'];
            }
        }

        //实例化 模型
        $AuthRule =new AuthRule();
        $Query=$AuthRule ->find();
        //获取所有权限
        $d_rule=$Query ->all();
        //获取已有权限
        $to_rule=$Query->where(['in','id',explode(',',$model->rules)])->all();

        return $this->render('_form', ['meta_title'=>'更新:'.$model ->title,'model'=>$model,'d_rule'=>$d_rule,'to_rule'=>$to_rule,'resMsg'=>json_encode($resMsg)]);
    }

    /**
     *  删除
     * @param $id 主键ID
     * @return string
     */
    public function actionDelete($id)
    {
        $resMsg = [];

        $model = new AuthGroup();

        if (Yii::$app->request->post()) {

            if($model ->find()->where(['id'=>$id])->one()->delete()){
                $resMsg=['status'=>1,'title'=>'删除成功','info'=>'删除成功','url'=>Url::to(['index'],true)];
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
        $model = new AuthGroup();

        $model = $model->find()->where(['id'=>$id])->one(); //获取id等于$id的模型

        $model->status = $status; //修改status属性值

        if($model->save()){
            $resMsg =['status'=>1,'title'=>'修改状态','info'=>'修改状态成功'];
        }else{
            $resMsg =['status'=>0,'title'=>'修改状态','info'=>'修改状态失败'];
        }
        return json_encode($resMsg);
    }

}
