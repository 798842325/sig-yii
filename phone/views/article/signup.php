<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \phone\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <style>
        body{ background: #ffffff;}
    </style>

    <div class="row reg-form">
        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'phone')->textInput(['autofocus' => true,'class'=>'padding_leng3','minlength'=>'11','maxlength'=>'11','placeholder'=>''])->label('手机号') ?>

            <?= $form->field($model, 'nickname')->textInput(['class'=>'padding_leng2','maxlength'=>8,'placeholder'=>'(用于评论区交流)'])->label('昵称') ?>

            <?= $form->field($model, 'password')->textInput(['class'=>'padding_leng2','minlength'=>6,'placeholder'=>'(6位以上，区分大小写)'])->label('密码') ?>

        <div class="form-group">
            <label for="">确认密码</label>
            <input type="password" name="password_s" class="padding_leng4" placeholder="(6位以上，区分大小写)" minlength="6">
            <p class="help-block help-block-error"><?php var_dump($model->getErrors('password_s'));?></p>
        </div>

            <div class="form-group">
                <label for="" class="code-label">验证码</label>
                <div class="col-xs-8"><input type="text" class="padding_leng3" maxlength="6" placeholder=""></div>
                <div class="col-xs-4"><button class="code-but">发送验证码</button></div>
            </div>
            <input type="image" class="but-img" src="/statics/img/reg_button.png">
        <?php ActiveForm::end(); ?>
    </div>
</div>