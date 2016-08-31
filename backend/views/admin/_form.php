<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */

$this->title = '更新: ' . $model->username;

?>

    <style>
        #uploader-demo{width:120px;}
        #uploader-demo .info{ overflow: hidden;}
        #uploader-demo .file-item{position: relative;}
        #uploader-demo .file-del{ position: absolute; right:0px; top:-15px; font-size:18px; background: #ffffff;color:red;}
    </style>

    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?=$meta_title?></h5>
                        <div class="ibox-tools">
                            <a href="<?=Url::to(['/admin'])?>">
                                <button type="button" class="btn btn-warning  btn-xs">
                                    <i class="fa  fa-mail-reply-all"></i><span class="bold">返回</span>
                                </button>
                            </a>

                        </div>
                    </div>
                    <div class="ibox-content">


                        <?php $form = ActiveForm::begin(['options'=>['class'=>'form-horizontal ajax-form'],'fieldConfig'=>[
                            'template' =>"{label}\n<div class=\"col-sm-10\">{input}\n{error}</div>",
                        ]]); ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">头像: </label>
                            <div class="col-sm-10">

                                <div id="upload-img-one">
                                    <img src="<?=Url::to($model->avatar?:'@upload/uploads/avatar/admin_pic.png') ?>" alt="">
                                    <div class="upload-img-btn"> <div id="filePicker">选择图片</div></div>
                                    <input type="hidden" name="<?=$model->formName()?>[avatar]" value="<?=$model->avatar?:'@upload/uploads/avatar/admin_pic.png'?>">
                                </div>
                                <?= $this->render('/_upload') ?>
                            </div>
                        </div>

                        <?=$form->field($model,'nickname')->textInput(['class'=>'form-control'])->label('昵称：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'username')->textInput(['class'=>'form-control'])->label('用户名：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'password')->passwordInput(['class'=>'form-control'])->label('密码：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'confirmPassword')->passwordInput(['class'=>'form-control'])->label('确认密码：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'email')->textInput(['class'=>'form-control'])->label('邮箱：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'phone')->textInput(['class'=>'form-control'])->label('手机号：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'landline')->textInput(['class'=>'form-control'])->label('座机号：',['class'=>'col-sm-2  control-label'])?>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?= Html::submitButton('提交',['class' =>'btn btn-primary']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        //弹窗JS
        var resMsg = <?= $resMsg ?>;

        if(resMsg.status != null || resMsg.status != undefined){

            if(resMsg.status){

                swal({
                    title: resMsg['title'],
                    text: resMsg['info'],
                    type: "success",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "返回列表",
                    cancelButtonText:'继续',
                    closeOnConfirm: true
                }, function (isConfirm) {
                    if(isConfirm){
                        window.location.href = resMsg.url;
                    }else{
                        window.location.href ='';
                    }
                });
            }else{
                swal(resMsg['title'], resMsg['info'], "error");
            }
        }
    </script>
