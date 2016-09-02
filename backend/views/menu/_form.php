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
                    <div class="form-group">
                        <label for="menu-name" class="col-sm-2  control-label">父级菜单：</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="<?=$model ->formName()?>[pid]">
                                <option value="0">/</option>
                                <?php foreach ($d_menu as $v): ?>
                                    <option value="<?=$v['id']?>" <?=$model->pid==$v['id']?'selected':'' ?>><?=$v['name']?></option>
                                    <?php if (!empty($vm['_child'])): ?>
                                        <?php foreach ($v['_child'] as $vs): ?>
                                            <option value="<?=$vs['id']?>" <?=$model->pid==$vs['id']?'selected':'' ?>>&nbsp;&nbsp;|-<?=$vs['name']?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="help-block"></div>
                        </div>
                    </div>

                    <?=$form->field($model,'name')->textInput(['class'=>'form-control'])->label('菜单名称：',['class'=>'col-sm-2  control-label'])?>
                    <?=$form->field($model,'route')->textInput(['class'=>'form-control'])->label('路由URL：',['class'=>'col-sm-2  control-label'])?>
                    <?=$form->field($model,'icon')->textInput(['class'=>'form-control'])->label('ICON图标：',['class'=>'col-sm-2  control-label'])?>

                    <?=$form->field($model,'sort')->textInput(['class'=>'form-control'])->label('排序：',['class'=>'col-sm-2  control-label'])?>

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
