<?php
namespace backend\controllers;


use backend\models\LoginForm;
use common\models\UploadForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class SiteController extends BaseController
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','login','index','error','upload'],
                'rules' => [
                    [
                        'actions' => ['signup','login','error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','upload'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * 上传
     * @return int|string
     */
    public function actionUpload()
    {
        $model = new UploadForm();

        if($_POST['resType'] == 'ajax'){
            foreach ($_FILES['UploadForm'] as $k=>$v){
                $_FILES['UploadForm'][$k]=$v;
            }
        }

        if (Yii::$app->request->isPost) {
            $model->File = UploadedFile::getInstance($model, 'File');
            $info=$model->upload($_POST['savePath']);
            if($_POST['resType'] == 'ajax') {
//                return json_encode(['status'=>'error']);
                if ($info) {
                    // 文件上传成功
                    return json_encode($info);
                } else {
                    return false;
                }
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * 更新全部缓存
     */
    public function actionUpdateCache(){
        header("Content-type:text/html;charset=utf-8");
        echo '<p>轮播缓存:更新中...</p>';
        echo '<p>'.Yii::$app->runAction('slide/cache-slide')?'轮播缓存:更新成功...':'轮播缓存:更新失败...'.'</p>';
        echo '<p>分类缓存:更新中...</p>';
        echo '<p>'.Yii::$app->runAction('classify/cache-classify')?'分类缓存:更新成功...':'分类缓存:更新失败...'.'</p>';
    }

}
