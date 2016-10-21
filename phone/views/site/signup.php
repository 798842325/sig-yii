<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \phone\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <style>
        body{ background: #ffffff;}
    </style>

    <div class="row reg-form">
        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'phone')->textInput(['autofocus' => true,'class'=>'padding_leng3 phone','minlength'=>'11','maxlength'=>'11','placeholder'=>''])->label('手机号') ?>

            <?= $form->field($model, 'realname')->textInput(['class'=>'padding_leng4','maxlength'=>8,'placeholder'=>'(用于下单使用)'])->label('真实姓名') ?>

            <?= $form->field($model, 'password')->textInput(['class'=>'padding_leng2','minlength'=>6,'placeholder'=>'(6位以上，区分大小写)'])->label('密码') ?>

            <?= $form->field($model, 'verifyPassword')->textInput(['class'=>'padding_leng4','minlength'=>6,'placeholder'=>'(6位以上，区分大小写)'])->label('确认密码') ?>

            <div class="form-group">
                <label for="" class="code-label">验证码</label>
                <div class="col-xs-8"><input type="text" name="code" class="padding_leng3" maxlength="6" placeholder=""></div>
                <div class="col-xs-4" onclick="sendsms($(this));"><button type="button" class="code-but">发送验证码</button></div>
                <p class="help-block help-block-error">
                    <?php foreach ($model->getErrors('code') as $error_v): ?>
                        <?= $error_v ?>
                    <?php endforeach; ?>
                </p>
            </div>
            <input type="image" class="but-img" src="/statics/img/reg_button.png">

        <input type="hidden" name="<?=$model->formName()?>[invite_code]" value="<?php if(!empty($_GET['invite_code'])){ echo $_GET['invite_code']; } ?>">
        <input type="hidden" name="<?=$model->formName()?>[head_user_id]" value="<?php if(!empty($_GET['head_user_id'])){ echo $_GET['head_user_id']; } ?>">

        <input type="hidden" name="<?=$model->formName()?>[openid]" value="<?php   if(!empty($_SESSION['openid'])){ echo $_SESSION['openid']; } ?>">

        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="row alert-ks">
    <div class="alert-ok">
        <div class="col-xs-12 head-title">我们已经收到了您的联系方式</div>
        <div class="col-xs-12 content-info">相关人员会在1个小时内与您联系，请保持电话畅通。</div>
        <div class="col-xs-12 ok-button2">
            <a href="<?=Url::to(['/'])?>" class="col-xs-6"> 先逛逛 </a>
            <a href="<?=Url::to(['user/'])?>" class="col-xs-6"> 个人中心 </a>
        </div>
    </div>
</div>

<script>
    var count = 60;
    function sendsms(t) {

      var phone =  $(".phone").val();

        if(count == 60){
            $.ajax({
                type: "POST",
                url: "<?=Url::to(['site/sendsms'])?>",
                dataType:'json',
                data: "_csrf=<?php echo Yii::$app->getRequest()->getCsrfToken(); ?>&phone="+phone,
                success: function(msg){

                    start =0;
                    if(msg.returnstatus == 'Success'){
                        var settime=setInterval(function () {
                            console.log(count);
                            if(count == 0){
                                t.find('button').text('发送验证码');
                                clearInterval(settime);
                                count =60;
                            }else{
                                t.find('button').text('重新发送'+count);
                                count--;
                            }

                        },1000);
                    }

                }
            });
        }


        return false;
    }


    var resMsg = <?= $resMsg ?>;

    if(resMsg.status == 1){
        $('.alert-ok').find('.head-title').text(resMsg.title);
        $('.alert-ok').find('.content-info').text(resMsg.info);
        $('.alert-ks').show();

    }



</script>
