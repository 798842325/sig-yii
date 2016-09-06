<?php

namespace backend\controllers;


use common\libs\Helpers;
use common\models\Classify;
use common\models\ClassifyType;
use common\models\Slide;
use common\models\SlideType;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;


/**
 * 分类
 * Class ClassifyController
 * @package backend\controllers
 */
class ClassifyController extends BaseController
{

    /**
     * 列表
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new Classify();

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

        return $this->render('index', ['meta_title'=>'分类管理','model'=>$model,'pages'=>$pages]);

    }


    /**
     *  创建
     * @return string
     */
    public function actionCreate()
    {
        $resMsg = [];

        $model = new Classify();

        if ($model->load(Yii::$app->request->post())) {

            if($model ->validate() && $model->save()){
                $resMsg=['status'=>1,'title'=>'创建','info'=>'创建成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'创建','info'=>'创建失败'];
            }
        }

        $d_classify= $model ->find()->all();

        $d_classifyType=ClassifyType::find()->all();

        return $this->render('_form', ['meta_title'=>'创建','d_classify'=>$d_classify,'d_classifyType'=>$d_classifyType,'model'=>$model,'resMsg'=>json_encode($resMsg)]);
    }


    /**
     *  更新
     * @param $id  主键ID
     * @return string
     */
    public function actionUpdate($id)
    {
        $resMsg = [];
        $model = new Classify();

        $model = $model->find()->where(['id'=>$id])->one();

        if ($model->load(Yii::$app->request->post())) {

            if($model ->validate() && $model ->save()){
                $resMsg=['status'=>1,'title'=>'更新','info'=>'更新成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'更新','info'=>'更新失败'];
            }
        }

        $d_classify= $model ->find()->all();

        $d_classifyType=ClassifyType::find()->all();

        return $this->render('_form', ['meta_title'=>'更新:'.$model ->title,'d_classify'=>$d_classify,'d_classifyType'=>$d_classifyType,'model'=>$model,'resMsg'=>json_encode($resMsg)]);
    }

    /**
     *  删除
     * @param $id 主键ID
     * @return string
     */
    public function actionDelete($id)
    {
        $resMsg = [];

        $model = new Classify();

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
        $model = new Classify();

        $model = $model->find()->where(['id'=>$id])->one(); //获取id等于$id的模型

        $model->status = $status; //修改status属性值

        if($model->save()){
            $resMsg =['status'=>1,'title'=>'状态','info'=>'修改状态成功'];
        }else{
            $resMsg =['status'=>0,'title'=>'状态','info'=>'修改状态失败'];
        }
        return json_encode($resMsg);
    }


    /**
     *  分类 更新缓存
     * @return bool
     */
    public function actionCacheClassify(){
        $model =  new ClassifyType();
        $cache = Yii::$app->cache;

        $d_classify= $model ->find()->joinWith([
            'classify' => function ($query) { $query->where('{{%classify}}.status =1')->orderBy(['sort'=>SORT_DESC]);}
        ])->orderBy(['sort'=>SORT_DESC])->asArray()->all();

        foreach ($d_classify as $k=>$v){
            $cache->set($v['name'], Helpers::list_to_tree($v['classify']));
        }

        return true;
    }

}
