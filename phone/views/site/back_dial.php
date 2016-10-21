<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::$app->cache->get('PHONE_SITE_TITLE');
?>
<style>
    body{background: #FFFFFF;}
</style>

<div class="container-fluid back_dial">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8">电话回拨</div>
        <div class="col-xs-2 qrcode"></div>
    </div>
    <div class="row blank-div"></div>
    <div class="row">
        <div class="col-xs-12 head-info">为了更好的为您提供服务，请帮助我们完善以下信息。</div>
        <?php $form = ActiveForm::begin(); ?>
        <div class="col-xs-12">
            <div class="col-xs-3">您的姓氏：</div>
            <div class="col-xs-5"><input type="text" name="<?=$model->formName()?>[name]"></div>
            <div class="col-xs-4 text-right">
                <input type="radio" name="<?=$model->formName()?>[sex]"  value="先生" checked> 先生
                <input type="radio" name="<?=$model->formName()?>[sex]" value="女士"> 女士
            </div>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-3">您的电话：</div>
            <div class="col-xs-9"><input type="text" name="<?=$model->formName()?>[phone]"></div>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-12">您的需求：</div>
            <div class="col-xs-12">
                <textarea name="<?=$model->formName()?>[demand]" id="" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="col-xs-12">
            <input type="image" src="/statics/img/tijiao_button.png">
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <div class="row alert-ks">
        <div class="alert-ok">
            <div class="col-xs-12 head-title">我们已经收到了您的联系方式</div>
            <div class="col-xs-12 content-info">相关人员会在1个小时内与您联系，请保持电话畅通。</div>
            <div class="col-xs-12 ok-button">好的</div>
        </div>
    </div>
</div>



<script>
    $('form').submit(function(){

        $.ajax({
            type: "POST",
            url: "<?=Url::to([''])?>",
            data: $(this).serialize(),
            dataType:'json',
            success: function(msg){
                $('.alert-ks').show();
                $('.alert-ok').find('.head-title').text(msg.title);
                $('.alert-ok').find('.content-info').text(msg.info);
                $('.ok-button').click(function(){
                    window.location.href = msg.url;
                });
            }
        });


        return false;
    });
</script>

</body>
</html>