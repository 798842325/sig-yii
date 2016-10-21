<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */

$this->title = '更新: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->username]];
$this->params['breadcrumbs'][] = 'Update';
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
                        <h5><?= Html::encode($this->title) ?></h5>
                        <div class="ibox-tools">
                            <a href="<?=Url::to(['/user'])?>">
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
                                    <img src="<?=$model->avatar?:'/public/uploads/user_pic.png' ?>" alt="">
                                    <div class="upload-img-btn"> <div id="filePicker">选择图片</div></div>
                                    <input type="hidden" name="<?=$model->formName()?>[avatar]" value="<?=$model->avatar?>">
                                </div>
                            </div>
                        </div>

                        <?=$form->field($model,'nickname')->textInput(['class'=>'form-control'])->label('昵称：',['class'=>'col-sm-2  control-label'])?>
                        <?=$form->field($model,'realname')->textInput(['class'=>'form-control'])->label('真实姓名：',['class'=>'col-sm-2  control-label'])?>
                        <?=$form->field($model,'type')->dropDownList(['管理员','客户','中介'])->label('类型:',['class'=>'col-sm-2  control-label'])?>
                        <?=$form->field($model,'username')->textInput(['class'=>'form-control'])->label('用户名：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'password')->passwordInput(['class'=>'form-control'])->label('密码：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'verifyPassword')->passwordInput(['class'=>'form-control'])->label('确认密码：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'email')->textInput(['class'=>'form-control'])->label('邮箱：',['class'=>'col-sm-2  control-label'])?>

                        <?=$form->field($model,'phone')->textInput(['class'=>'form-control'])->label('手机号：',['class'=>'col-sm-2  control-label'])?>

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
        // 初始化Web Uploader
        var uploader = WebUploader.create({

            // 选完文件后，是否自动上传。
            auto: true,

            // 文件接收服务端。
            server: "<?=\yii\helpers\Url::to(['site/upload'])?>",

            formData:{
                _csrf:'<?php echo Yii::$app->getRequest()->getCsrfToken(); ?>',
                resType:'ajax',
                savePath:'uploads/avatar/',
            },
            fileVal:'UploadForm[File]',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '#filePicker',

            // 如果发现压缩后文件大小比原来还大，则使用原来图片
            // 此属性可能会影响图片自动纠正功能
            noCompressIfLarger: true,

            // 只允许选择图片文件。
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },

        });

        // 当有文件添加进来的时候
        // 当有文件添加进来的时候
        uploader.on( 'fileQueued', function( file ) {
            $list = $('#upload-img-one');

            $img = $list.find('img');


            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr( 'src', src );
            }, 1, 1 );
        });


        // 文件上传过程中创建进度条实时显示。
        uploader.on( 'uploadProgress', function( file, percentage ) {
            var $li = $( '#upload-img-one' );
            $percent = $li.find('.progress .progress-bar');

            // 避免重复创建
            if ( !$percent.length ) {
                $percent = $('<div class="progress progress-striped active">' +
                    '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                    '</div>' +
                    '</div>').appendTo( $li ).find('.progress-bar');
            }

            $li.find('p.state').text('上传中');

            $percent.css( 'width', percentage * 100 + '%' );
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file,data) {
            $( '#upload-img-one' ).addClass('upload-state-done');

            if(data['status']){
                $('#upload-img-one').find('input').attr('value',data.savePath);
            }
        });

        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file ) {
            var $li = $( '#'+file.id ),
                $error = $li.find('div.error');

            // 避免重复创建
            if ( !$error.length ) {
                $error = $('<div class="error"></div>').appendTo( $li );
            }

            $error.text('上传失败');
        });

        // 完成上传完了，成功或者失败，先删除进度条。
        uploader.on( 'uploadComplete', function( file ,data ) {
            $( '#upload-img-one' ).find('.progress').remove();

        });





    </script>
    <script>
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























<!--    --><?//= $this->render('/_js') ?>