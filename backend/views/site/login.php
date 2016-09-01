<?php

/* @var $this yii\web\View */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Sig 西格';
$this->params['breadcrumbs'][] = $this->title;
?>
<link rel="stylesheet" href="/statics/css/login.css">
<body>
<div class="container-fluid">
    <div class="row login_bg">
        <div class="login">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <div class="login-title">
                    <font>Sig | 管理系统</font>
                </div>
                <div class="login-body">

                    <input type="hidden" value="<?php  echo Yii::$app->getRequest()->getCsrfToken(); ?>" name="_csrf" />
                    <div class="form-group">
                        <i class="glyphicon glyphicon-user"></i>
                        <input type="text" class="form-control" name="<?= $model ->formName() ?>[username]"  placeholder="用户名">
                        <p class="text-warning bg-warning">
                            <?php
                            foreach ($model->getErrors('username') as $error){
                                echo $error.'<br/>';
                            }
                            ?>
                        </p>
                    </div>
                    <div class="form-group">
                        <i class="glyphicon glyphicon-lock"></i>
                        <input type="password" class="form-control" name="<?= $model ->formName() ?>[password]" placeholder="密码">
                        <p class="text-warning bg-warning">
                        <?php
                        foreach ($model->getErrors('password') as $error){
                            echo $error.'<br/>';
                        }
                        ?>
                        </p>
                    </div>
<!--                    <div class="form-group code-group">-->
<!--                        <i class="glyphicon glyphicon-barcode"></i>-->
<!--                        <input type="password" class="form-control"  name="code" placeholder="输入验证码">-->
<!--                        <img src="{{ url('admin/login/code') }}" onclick="this.src='{{ url('admin/login/code') }}?'+Math.random()" alt="">-->
<!--                    </div>-->
                    <?= $form->field($model, 'rememberMe')->checkbox(['label'=>'记住密码']) ?>

                    <div class="form-group login-bth">
                        <button type="submit" class="btn btn-default">登&nbsp;录</button>
                    </div>
                </div>
                <div class="form-group login-record">
                    <p>2014-2016 © Sig 管理系统</p>
                    <p>版权所有：北京西格会计服务有限公司 京ICP备09012291号</p>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

</body>
</html>





