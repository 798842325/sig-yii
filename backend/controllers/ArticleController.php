<?php

namespace backend\controllers;

use backend\models\Menu;
use common\libs\Helpers;
use common\models\Article;
use common\models\Classify;
use common\models\ClassifyType;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * 文章管理
 * Class ArticleController
 * @package backend\controllers
 */
class ArticleController extends BaseController
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
        $model = new Article();

        //查询语句
        $query = $model::find();

        //分页
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages ->defaultPageSize=20;

        //查询数据结果
        $model = $query->offset($pages->offset)->limit($pages->limit)->all();


        return $this->render('index', ['meta_title'=>'文章管理','model'=>$model,'pages'=>$pages]);


    }


    /**
     * 创建
     * @return mixed
     */
    public function actionCreate()
    {
        $resMsg = [];
        $model = new Article();

        //加载数据以及调用创建方法
        if ($model->load(Yii:: $app-> request->post())) {

            if($model ->validate() && $model->save()){
                $resMsg=['status'=>1,'title'=>'创建成功','info'=>'创建成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'创建失败','info'=>'创建失败'];
            }

        }

        $d_classify= ClassifyType::find()->joinWith([
            'classify' => function ($query) { $query->where('{{%classify}}.status =1')->orderBy(['sort'=>SORT_DESC]);}
        ])->where(['type'=>1])->orderBy(['sort'=>SORT_DESC])->asArray()->all();

        foreach ($d_classify as $k=>$v){
            $d_classify[$k]['classify'] =Helpers::list_to_tree($v['classify']);
        }


        return $this->render('_form', ['meta_title'=>'创建','d_classify'=>$d_classify,'model'=>$model,'resMsg'=>json_encode($resMsg)]);
    }

    /**
     * 更新
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $resMsg = [];

        $model = new Article();

        //查询信息
        $model= $model ->findOne(['id'=>$id]);

        if ($model->load(Yii:: $app-> request->post())) {

            if($model ->validate() && $model->save()){
                $resMsg=['status'=>1,'title'=>'更新','info'=>'更新成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'更新','info'=>'更新失败'];
            }
        }
        $d_classify= ClassifyType::find()->joinWith([
            'classify' => function ($query) { $query->where('{{%classify}}.status =1')->orderBy(['sort'=>SORT_DESC]);}
        ])->where(['type'=>1])->orderBy(['sort'=>SORT_DESC])->asArray()->all();

        foreach ($d_classify as $k=>$v){
            $d_classify[$k]['classify'] =Helpers::list_to_tree($v['classify']);
        }

        return $this->render('_form',['meta_title'=>'更新','d_classify'=>$d_classify,'model'=>$model,'resMsg'=>json_encode($resMsg)]);

    }


    /**
     *  删除
     * @param $id 主键ID
     * @return string
     */
    public function actionDelete($id)
    {
        $resMsg = [];

        $model = new Menu();

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
        $model = new Article();

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
