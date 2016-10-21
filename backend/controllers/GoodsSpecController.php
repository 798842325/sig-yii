<?php

namespace backend\controllers;


use common\models\GoodsSpec;
use common\models\GoodsType;
use common\models\SpecValue;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;


/**
 *  商品规格
 * Class GoodsSpecController
 * @package backend\controllers
 */
class GoodsSpecController extends BaseController
{

    /**
     * 列表
     * @return mixed
     */
    public function actionIndex()
    {

        $model = new GoodsSpec();

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

        return $this->render('index', ['meta_title'=>'分类平台管理','model'=>$model,'pages'=>$pages]);

    }


    /**
     *  创建
     * @return string
     */
    public function actionCreate()
    {
        $resMsg = [];

        $GoodsSpec = new GoodsSpec();
        $SpecValue = new SpecValue();

        if ($GoodsSpec->load(Yii::$app->request->post())) {

            $spec_value=explode("\r\n",trim($_POST['spec_value']));

            if($GoodsSpec ->validate() && $GoodsSpec->save()){

                $arrV = [];
                foreach ($spec_value as $k=>$v){
                    $arrV[$k]['value_id']=$GoodsSpec->attributes['id'].$k;
                    $arrV[$k]['spec_id']=$GoodsSpec->attributes['id'];
                    $arrV[$k]['item']=$v;

                }

                if($SpecValue ->find()->createCommand()->batchInsert('{{%spec_value}}', ['value_id', 'spec_id','item'],$arrV)->execute()){
                    $resMsg=['status'=>1,'title'=>'创建','info'=>'创建成功','url'=>Url::to(['index'],true)];
                }else{
                    $resMsg =['status'=>0,'title'=>'创建','info'=>'创建失败'];
                }
            }else{
                $resMsg =['status'=>0,'title'=>'创建','info'=>'创建失败'];
            }

        }

        $GoodsType= GoodsType::find()->asArray()->all();

        return $this->render('_form', ['meta_title'=>'创建','SpecValue'=>$SpecValue,'GoodsType'=>$GoodsType,'GoodsSpec'=>$GoodsSpec,'resMsg'=>json_encode($resMsg)]);
    }


    /**
     *  更新
     * @param $id  主键ID
     * @return string
     */
    public function actionUpdate($id)
    {
        $resMsg = [];
        $GoodsSpec = new GoodsSpec();
        $SpecValue = new SpecValue();


        $GoodsSpec = $GoodsSpec->find()->where(['id'=>$id])->one();


        if ($GoodsSpec->load(Yii::$app->request->post())) {

            $spec_value=explode("\r\n",trim($_POST['spec_value']));
            if($GoodsSpec ->validate() && $GoodsSpec ->save()){
                $SpecValue->deleteAll(['spec_id'=>$id]);
                $arrV = [];
                foreach ($spec_value as $k=>$v){
                    $arrV[$k]['value_id']=$GoodsSpec->attributes['id'].$k;
                    $arrV[$k]['spec_id']=$GoodsSpec->attributes['id'];
                    $arrV[$k]['item']=$v;

                }

                if($SpecValue ->find()->createCommand()->batchInsert('{{%spec_value}}', ['value_id', 'spec_id','item'],$arrV)->execute()){
                    $resMsg=['status'=>1,'title'=>'更新','info'=>'更新成功','url'=>Url::to(['index'],true)];
                }else{
                    $resMsg =['status'=>0,'title'=>'更新','info'=>'更新失败'];
                }


            }else{
                $resMsg =['status'=>0,'title'=>'更新','info'=>'更新失败'];
            }
        }
        $GoodsType= GoodsType::find()->asArray()->all();
        $SpecValue = $SpecValue ->find()->where(['spec_id'=>$id])->all();

        return $this->render('_form', ['meta_title'=>'更新:'.$GoodsSpec ->name,'SpecValue'=>$SpecValue,'GoodsType'=>$GoodsType,'GoodsSpec'=>$GoodsSpec,'resMsg'=>json_encode($resMsg)]);
    }

    /**
     *  删除
     * @param $id 主键ID
     * @return string
     */
    public function actionDelete($id)
    {
        $resMsg = [];

        $model = new GoodsSpec();

        if (Yii::$app->request->post()) {

            if($model ->find()->where(['id'=>$id])->one()->delete()){
                $SpecValue = new SpecValue();
                $SpecValue->deleteAll(['spec_id'=>$id]);
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
