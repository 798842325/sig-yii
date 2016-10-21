<?php
namespace phone\controllers;


use common\libs\Weixin;
use common\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use phone\models\LoginForm;
use phone\models\PasswordResetRequestForm;
use phone\models\ResetPasswordForm;
use phone\models\SignupForm;
use phone\models\ContactForm;

/**
 * Site controller
 */
class BaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {

        if(parent::beforeAction($action)){

            //判断用户是否登录
            if(Yii::$app->user->isGuest){
                $session = Yii::$app->session;
                //判断是否在微信里面打开
                if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')  &&  !$session['openid']){
                    //获取微信用户的openid
                    $Weixin = new Weixin();
                    $openid= $Weixin ->openid();
                    //根据openid 获取用户
                    $User = new User();
                    $User=$User ->find()->where(['openid'=>$openid['openid']])->one();
                    //判断此微信用户是否操作
                    if($User){
                        //用户存在就 默认登录
                        Yii::$app->user->login($User);
                    }else{
                        //用户不存在 保存 微信用户的openid
                        $session ->set('openid',$openid['openid']);
                    }
                }
            }
            return true;
        }else{
            return false;
        }
    }

}
