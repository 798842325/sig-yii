<?php

namespace backend\controllers;

use common\models\User;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * ItemController implements the CRUD actions for AuthItem model.
 */
class UserController extends BaseController
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
     *  用户列表
     * @return mixed
     */
    public function actionIndex()
    {
        $m_user = new User();

        //查询语句
        $query = $m_user::find();

        //分页
        $pages = new Pagination(['totalCount' => $query->count()]);
        $pages ->defaultPageSize=20;

        $cond ='';

        if(Yii::$app->request->post()){
            $cond = [
                'or',
                ['like','username',Yii::$app->request->post('keywords')],
                ['like','id',Yii::$app->request->post('keywords')],
                ['like','phone',Yii::$app->request->post('keywords')],
                ['like','email',Yii::$app->request->post('keywords')],

            ];
        }

        //查询数据结果
        $data = $query->offset($pages->offset)->where($cond)->limit($pages->limit)->asArray()->all();


        $data['model'] = $data;
        $data['pages']  =$pages;
        return $this->render('index', $data);

    }


    /**
     *  创建
     * @return string
     */
    public function actionCreate()
    {
        $resMsg = [];

        $m_user = new User();

        if ($m_user->load(Yii::$app->request->post())) {
            $m_user->setPassword($m_user->password);
            $m_user->generateAuthKey();
            if($m_user->validate() && $m_user ->save()){
                $resMsg=['status'=>1,'title'=>'创建成功','info'=>'创建成功','url'=>Url::to(['/user'],true)];
            }else{
                $resMsg['status'] = 0;
            }
        }


        return $this->render('_form', ['model'=>$m_user,'resMsg'=>json_encode($resMsg)]);
    }


    /**
     *  更新
     * @param $id  主键ID
     * @return string
     */
    public function actionUpdate($id)
    {
        $resMsg = [];
        $m_user = new User();

        $m_user = $m_user->find()->where(['id'=>$id])->one();

        if ($m_user->load(Yii::$app->request->post())) {
            $m_user->setPassword($m_user->password);
            $m_user->generateAuthKey();
            if($m_user->validate() && $m_user ->save()){
                $resMsg=['status'=>1,'title'=>'更新成功','info'=>'更新成功','url'=>Url::to(['/user'],true)];
            }else{
                $resMsg=['status'=>0,'title'=>'更新失败','info'=>'更新失败','url'=>Url::to([''],true)];
            }
        }

        return $this->render('_form', ['model'=>$m_user,'resMsg'=>json_encode($resMsg)]);
    }

    /**
     *  删除
     * @param $id 主键ID
     * @return string
     */
    public function actionDelete($id)
    {
        $resMsg = [];

        $m_user = new User();

        if (Yii::$app->request->post()) {

            if($m_user ->find()->where(['id'=>$id])->one()->delete()){
                $resMsg=['status'=>1,'title'=>'删除成功','info'=>'删除成功','url'=>Url::to(['/user'],true)];
            }else{
                $resMsg['status'] = 0;
            }

        }

        return json_encode($resMsg);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
