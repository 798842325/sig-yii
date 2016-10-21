<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = '登陆';
$this->params['breadcrumbs'][] = $this->title;
?>







<div class="container-fluid">
    <style>
        body{ background: #ffffff;}
    </style>
    <div class="row login-form">
        <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal ajax-form'], 'fieldConfig' => [
            'template' => "<div class=\"col-sm-12\">{label}{input}</div>{error}",
        ]]); ?>
            <?= $form->field($model, 'phone')->textInput(['autofocus' => true,'class'=>'padding_leng3','minlength'=>'11','maxlength'=>'11','placeholder'=>''])->label('手机号') ?>

            <?= $form->field($model, 'password')->passwordInput(['class'=>'padding_leng2','minlength'=>6,'placeholder'=>'(6位以上，区分大小写)'])->label('密码') ?>

        <div class=" login-Forgot">
                <label>
                    <a href="">忘记密码 <i class="question-icon"></i> </a>
                </label>
            </div>
            <input type="image" class="btn but-img" src="/statics/img/login_button.png">
            <div class="login-reg">
                <label>
                    <a href="<?=Url::to(['site/signup'])?>">注册新用户</a>
                </label>
            </div>
        <input type="hidden" name="<?=$model->formName()?>[openid]" value="<?php   if(!empty($_SESSION['openid'])){ echo $_SESSION['openid']; } ?>">
        <?php ActiveForm::end(); ?>
    </div>
</div>