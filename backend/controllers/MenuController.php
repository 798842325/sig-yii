<?php

namespace backend\controllers;

use backend\models\Menu;
use common\libs\Helpers;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 *  菜单管理
 * Class MenuController
 * @package backend\controllers
 */
class MenuController extends BaseController
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
     *  菜单列表
     * @return mixed
     */
    public function actionIndex($pid=0)
    {
        $model = new Menu();

        //查询语句
        $query = $model::find();

        //分页
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages ->defaultPageSize=20;

        $cond=['pid'=>$pid];

        //查询数据结果
        $model = $query->where($cond)->offset($pages->offset)->limit($pages->limit)->all();



        return $this->render('index', ['meta_title'=>'菜单管理','model'=>$model,'pages'=>$pages]);


    }


    /**
     * 创建菜单
     * @return mixed
     */
    public function actionCreate()
    {
        $resMsg = [];
        $model = new Menu();

        //加载数据以及调用创建方法
        if ($model->load(Yii:: $app-> request->post())) {

            if($model ->validate() && $model->save()){
                $resMsg=['status'=>1,'title'=>'创建成功','info'=>'创建成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'创建失败','info'=>'创建失败'];
            }

        }

        $d_menu=$model ->find()->asArray()->all();
        $d_menu=Helpers::list_to_tree($d_menu);

        return $this->render('_form', ['meta_title'=>'创建','d_menu'=>$d_menu,'model'=>$model,'resMsg'=>json_encode($resMsg)]);
    }

    /**
     * 更新菜单
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $resMsg = [];

        $model = new Menu();

        //查询信息
        $model= $model ->findOne(['id'=>$id]);

        if ($model->load(Yii:: $app-> request->post())) {

            if($model ->validate() && $model->save()){
                $resMsg=['status'=>1,'title'=>'更新','info'=>'更新成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'更新','info'=>'更新失败'];
            }
        }
        //获取所有菜单
        $d_menu=$model ->find()->asArray()->all();
        $d_menu=Helpers::list_to_tree($d_menu);

        return $this->render('_form',['meta_title'=>'更新','d_menu'=>$d_menu,'model'=>$model,'resMsg'=>json_encode($resMsg)]);

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

}
