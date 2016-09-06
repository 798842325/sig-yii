<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */

$this->title = $meta_title;

?>
<script src="/statics/js/multiselect-master/dist/js/multiselect.min.js"></script>

    <body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?=$meta_title?></h5>
                        <div class="ibox-tools">
                            <a href="<?=Url::to(['index'])?>">
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


                        <?=$form->field($model,'title')->textInput(['class'=>'form-control'])->label('名称：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'name')->textInput(['class'=>'form-control'])->label('标识：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'describe')->textarea(['class'=>'form-control'])->label('描述：',['class'=>'col-sm-2  control-label'])?>

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
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('#search').multiselect({
                search: {
                    left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                    right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                }
            });
        });
    </script>
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
