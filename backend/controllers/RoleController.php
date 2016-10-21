<?php

namespace backend\controllers;

use common\models\Admin;
use common\models\AuthGroup;
use common\models\AuthGroupAccess;
use common\models\AuthRule;
use common\models\User;
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


    /**
     * 分配角色用户
     * @param $id
     * @return string
     */
    public function actionAllotuser($id){
        $resMsg = [];
        //获取当前分配角色
        $d_role=AuthGroup::find()->where(['id'=>$id])->one();

        $model= new AuthGroupAccess();

        if(Yii::$app->request->post()){
            //处理数据
            $d_uid=Yii::$app->request->post('uid');
            foreach ($d_uid as $v){
                $data[]=[ 'uid' =>$v,'group_id'=> $id];
            }
            //删除原始旧数据
            $model ->find()->createCommand()->delete('{{%auth_group_access}}','group_id='.$id)->execute();
            if($model->find()->createCommand()->batchInsert('{{%auth_group_access}}',['uid','group_id'],$data)->execute()){
                $resMsg =['status'=>1,'title'=>'分配','info'=>'分配成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'分配','info'=>'分配失败'];
            }
        }

        //实例化模型
        $User = new User();
        $Query = $User ->find();
        //获取所有用户
        $d_admin=$Query ->all();
        //获取已分配的用户
        $to_admin=$Query ->where(['in','id',$model ->find()->select(['uid'])->where(['group_id'=>$id])])->all();

        return $this->render('AllotUserform', ['meta_title'=>'分配用户:','to_admin'=>$to_admin,'d_role'=>$d_role,'d_admin'=>$d_admin,'model'=>$model,'resMsg'=>json_encode($resMsg)]);
    }
}
