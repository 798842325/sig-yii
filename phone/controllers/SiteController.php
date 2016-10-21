<?php
namespace phone\controllers;

use common\libs\Helpers;
use common\libs\Weixin;
use common\models\Classify;
use common\models\ClassifyType;
use common\models\Coupons;
use common\models\CouponsRules;
use common\models\Goods;
use common\models\LeaveMsg;
use common\models\Service;
use common\models\Slide;
use common\models\SlideType;
use common\models\User;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?','@'],
                    ],
                    [
                        'actions' => ['logout'],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Home 首页
     *
     * @return mixed
     */
    public function actionIndex()
    {

        //获取幻灯片\轮播
        $slide = Yii::$app->cache->get('SLIDE');

        $data['slide_v1'] = isset($slide['PHONE_SLIDE_INDEX'])?$slide['PHONE_SLIDE_INDEX']:[];
        $data['slide_v2'] = isset($slide['PHONE_SLIDE_INDEX_2'])?$slide['PHONE_SLIDE_INDEX_2']:[];

        //获取商品分类
        $classify = Yii::$app->cache->get('CLASSIFY');
        $data['CateGoods'] = isset($classify['PHONE_CATE_GOODS'])?$classify['PHONE_CATE_GOODS']:[];
        $cateGoodsID = [];
        foreach ($data['CateGoods'] as $v){
            $cateGoodsID[]=$v['id'];
        }

        //获取 推荐商品
        $m_goods = new Goods();
        $data['TopGoods'] = $m_goods ->find()->where(['and','status=1',['in','cate_id',$cateGoodsID]])->orderBy(['recommend'=>SORT_DESC])->asArray()->all();

        return $this->render('index',$data);
    }

    /**
     *  分类 - 服务 -全部
     * @return string
     */
    public function actionClassify(){
        //获取分类
        $classify = Yii::$app->cache->get('CLASSIFY');
        $CateGoods = isset($classify['PHONE_CATE_GOODS'])?$classify['PHONE_CATE_GOODS']:[];

        foreach ($CateGoods as $v){
            $cate_id[$v['id']]=$v['id'];
            $data['CateGoods'][$v['id']] = $v;
        }

        $Goods= new Goods();
        $d_Goods=$Goods ->find()->where(['and','status=1',['in','cate_id',$cate_id]])->asArray()->all();

        foreach ($d_Goods as $vs){
            $data['CateGoods'][$vs['cate_id']]['goods'][] = $vs;
        }


        return $this->render('classify',$data);
    }


    /**
     * 用户登录
     *
     * @return mixed
     */
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

    /**
     * 退出用户
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * 用户注册并登陆
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $data['resMsg'] = json_encode([]);

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {

            $verifycode = Yii::$app->session->get('verifycode');

            //判断验证码是否失效
            if(strtotime('+30 minutes',$verifycode['create_at']) < time()){
                $model ->addErrors(['code'=>'验证码已失效,请重新获取']);
            }else{
                //验证验证码
                if($verifycode['code'] != Yii::$app->request->post('code')){
                    $model ->addErrors(['code'=>'验证码输入错误,请重新输入']);
                }else{
                    $model ->username = 'sig'.time().mt_rand(11,99);
                    if ($user = $model->signup()) {

                        if (Yii::$app->getUser()->login($user)) {
                            //获取优惠价规则
                            $CouponsRules =  new CouponsRules();
                            $cond = ['and','status=1','type=2','rules="registered"',['<','start_time',time()],['>','end_time',time()]];
                            $coupons_rules_info=$CouponsRules=$CouponsRules ->find()->where($cond)->one();
                            //添加优惠卷
                            $Coupons = new Coupons();
                            $Coupons ->name =$coupons_rules_info['title']; //标题
                            $Coupons ->money =$coupons_rules_info['price'];//价格
                            $Coupons ->limit_price =$coupons_rules_info['limit_price']; //限制金额
                            $Coupons ->explain =$coupons_rules_info['explain'];//说明
                            $Coupons ->created_at =time();//说明
                            $Coupons ->start_time =time();
                            $Coupons ->end_time =strtotime("+$coupons_rules_info[effective_days] day");
                            $Coupons ->user_id =$model->attributes['id'];
                            if($Coupons ->save()){
                                $CouponsRules ->receive_num ++;
                                $CouponsRules ->save();

                                $title= '欢迎加入小绿灯'.$coupons_rules_info['price'].'元优惠券已经发放到您的账户';
                            }else{
                                $title = '欢迎加入小绿灯';
                            }


                            $data['resMsg'] = json_encode(['status'=>1,'title'=>$title,'info'=>'您可以进入个人中心完善您的个人资料，以便我们给您提供更细致的服务。']);
                        }
                    }
                }
            }
        }

        $data['model'] = $model ;

        return $this->render('signup', $data);
    }

    /**
     * 发送短信验证码
     * @return mixed json 数据 {"returnstatus":"Success","message":"操作成功","remainpoint":"44394","taskID":"1608293341294864","successCounts"
    :"1"}
     */
    public function actionSendsms(){

        //判断是否POST请求
        if(Yii::$app->request->post()){
            $account = urlencode('xd000858'); //短信账号
            $password =urlencode(md5('xd00085801'));//短信密码
            $verifycode['code'] = $code = mt_rand(1111,9999); //随机验证码
            $verifycode['create_at'] = time(); //验证码生成时间
            $mobile=Yii::$app->request->post('phone');
            $content =urlencode("欢迎您加入小绿灯，您的验证码为: {$code}。此验证码将在30分钟后失效，请您尽快完成注册。如有疑问，请拨打400-6656-486。【小绿灯】");

            $url='https://dx.ipyy.net/smsJson.aspx?action=send&userid=&account='.$account.'&password='.$password.'&mobile='.$mobile.'&content='.$content.'&sendTime=&extno=';

            //保存验证码到session
            Yii::$app->session->set('verifycode',$verifycode);
            return Helpers::SendHttp($url,'','GET');
        }

    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


    /**
     * 电话回拨
     */
    public function actionBackDial(){
        $model = new LeaveMsg();

        if($model->load(Yii::$app->request->post())){
            $jsonMsg = [];
            $model ->created_at = time();
            if($model->validate() && $model->save()){
                $jsonMsg = ['status'=>1,'url'=>Url::to(['/']),'title'=>'我们已经收到了您的联系方式','info'=>'相关人员会在1个小时内与您联系，请保持电话畅通。'];
            }else{
                $jsonMsg = ['status'=>0,'url'=>Url::to(['']),'title'=>'提交失败','info'=>'请稍后再试~'];
            }

            return json_encode($jsonMsg);
        }

        return $this->render('back_dial',['model'=>$model]);
    }
}
