<?php
namespace backend\controllers;

use common\models\GoodsType;
use common\models\Spec;
use yii\data\Pagination;
use Yii;
use yii\helpers\Url;


/**
 * 规格
 *
 * Class SpecController
 * @package backend\controllers
 */
class SpecController extends BaseController
{

    /**
     * 列表
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new Spec();

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

        return $this->render('index', ['meta_title'=>'规格管理','model'=>$model,'pages'=>$pages]);

    }


    /**
     *  创建
     * @return string
     */
    public function actionCreate()
    {
        $resMsg = [];

        $Spec = new Spec();

        if ($Spec->load(Yii::$app->request->post())) {

            if($Spec ->validate() && $Spec->save()){

                $resMsg=['status'=>1,'title'=>'创建','info'=>'创建成功','url'=>Url::to(['index'],true)];

            }else{
                $resMsg =['status'=>0,'title'=>'创建','info'=>'创建失败'];
            }

        }

        //查询所有商品类型
        $GoodsType= GoodsType::find()->asArray()->all();

        return $this->render('_form', ['meta_title'=>'创建','GoodsType'=>$GoodsType,'Spec'=>$Spec,'resMsg'=>json_encode($resMsg)]);
    }


    /**
     *  更新
     * @param $id  主键ID
     * @return string
     */
    public function actionUpdate($id)
    {
        $resMsg = [];
        //实例化 规格 Spec 模型
        $Spec = new Spec();

        //查询
        $Spec = $Spec->find()->where(['spec_id'=>$id])->one();

        if ($Spec->load(Yii::$app->request->post())) {

            //验证数据   并  保存
            if($Spec ->validate() && $Spec ->save()){
                $resMsg=['status'=>1,'title'=>'更新','info'=>'更新成功','url'=>Url::to(['index'],true)];
            }else{
                $resMsg =['status'=>0,'title'=>'更新','info'=>'更新失败'];
            }
        }

        //查询所有商品类型
        $GoodsType= GoodsType::find()->asArray()->all();


        return $this->render('_form', ['meta_title'=>'更新:'.$Spec ->spec_name,'GoodsType'=>$GoodsType,'Spec'=>$Spec,'resMsg'=>json_encode($resMsg)]);
    }

    /**
     *  删除
     * @param $id 主键ID
     * @return string
     */
    public function actionDelete($id)
    {
        $resMsg = [];

        $Spec = new Spec();

        if (Yii::$app->request->post()) {

            if($Spec ->find()->where(['spec_id'=>$id])->one()->delete()){

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
        $model = new GoodsSpec();

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
