<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\Menu;
use common\libs\Helpers;
use common\models\UploadForm;
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
                'rules' => [
                    [
                        'actions' => ['login', 'error','upload'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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

}
