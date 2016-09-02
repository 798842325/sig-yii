<?php

namespace backend\controllers;


use common\models\SlideType;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;


/**
 *  轮播平台
 * Class SlideTypeController
 * @package backend\controllers
 */
class SlideTypeController extends BaseController
{

    /**
     * 列表
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new SlideType();

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
                ['like','slide',$keywords],
            ];
        }

        //查询数据结果
        $model = $query->offset($pages->offset)->where($cond)->limit($pages->limit)->asArray()->all();

        return $this->render('index', ['meta_title'=>'轮播平台管理','model'=>$model,'pages'=>$pages]);

    }


    /**
     *  创建
     * @return string
     */
    public function actionCreate()
    {
        $resMsg = [];

        $model = new SlideType();

        if ($model->load(Yii::$app->request->post())) {

            if($model ->validate() && $model->save()){
                $resMsg=['status'=>1,'title'=>'创建','info'=>'创建成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'创建','info'=>'创建失败'];
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
        $model = new SlideType();

        $model = $model->find()->where(['slide'=>$id])->one();

        if ($model->load(Yii::$app->request->post())) {

            if($model ->validate() && $model ->save()){
                $resMsg=['status'=>1,'title'=>'更新','info'=>'更新成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'更新','info'=>'更新失败'];
            }
        }


        return $this->render('_form', ['meta_title'=>'更新:'.$model ->title,'model'=>$model,'resMsg'=>json_encode($resMsg)]);
    }

    /**
     *  删除
     * @param $id 主键ID
     * @return string
     */
    public function actionDelete($id)
    {
        $resMsg = [];

        $model = new SlideType();

        if (Yii::$app->request->post()) {

            if($model ->find()->where(['slide'=>$id])->one()->delete()){
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
        $model = new SlideType();

        $model = $model->find()->where(['slide'=>$id])->one(); //获取id等于$id的模型

        $model->status = $status; //修改status属性值

        if($model->save()){
            $resMsg =['status'=>1,'title'=>'修改状态','info'=>'修改状态成功'];
        }else{
            $resMsg =['status'=>0,'title'=>'修改状态','info'=>'修改状态失败'];
        }
        return json_encode($resMsg);
    }

}
