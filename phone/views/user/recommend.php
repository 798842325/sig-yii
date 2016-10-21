<?php
/**
 * Created by PhpStorm.
 * User: yuer
 * Date: 16/9/19
 * Time: 16:03
 */
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$this->title = Yii::$app->cache->get('PHONE_SITE_TITLE');
?>

<style>
    body{background: #FFFFFF;}
</style>

<div class="container-fluid recommend">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8">累计返利</div>
        <div class="col-xs-2"></div>
    </div>
    <div class="blank-div"></div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-xs-12 head-title">请完善被推荐人信息，以便我们更好的为他服务。</div>

        <div class="col-xs-12 recommend-name">
            <div class="col-xs-3 name-label">姓名:</div>
            <div class="col-xs-9 name-input"><input type="text" name="<?=$model->formName()?>[name]"></div>
        </div>

        <div class="col-xs-12 recommend-sex">
            <div class="col-xs-3 sex-label">性别:</div>
            <div class="col-xs-9 sex-input"><input type="radio" name="<?=$model->formName()?>[sex]" value="1" checked>男  &nbsp;&nbsp; &nbsp;&nbsp;<input type="radio" name="<?=$model->formName()?>[name]" value="2">女</div>
        </div>

        <div class="col-xs-12 recommend-age">
            <div class="col-xs-3 age-label">年龄:</div>
            <div class="col-xs-9 age-input"><input type="text" name="<?=$model->formName()?>[age]" value="0">岁  （可不填）</div>
        </div>

        <div class="col-xs-12 recommend-phone">
            <div class="col-xs-4 phone-label">联系方式:</div>
            <div class="col-xs-8 phone-input"><input type="text" name="<?=$model->formName()?>[phone]"></div>
        </div>

        <div class="col-xs-12 recommend-describe">
            <div class="col-xs-12 describe-label">基本需求描述:</div>
            <div class="col-xs-12 describe-textarea">
                <textarea name="<?=$model->formName()?>[describe]" id="" cols="30" rows="10"></textarea>
            </div>
         </div>
        <div class="col-xs-12 recommend-submit">
            <input type="image" src="/statics/img/tijiao_button.png">
        </div>
    </div>
    <div class="row alert-ks">
        <div class="alert-ok">
            <div class="col-xs-12 head-title">我们已经收到了您的联系方式</div>
            <div class="col-xs-12 content-info">相关人员会在1个小时内与您联系，请保持电话畅通。</div>
            <div class="col-xs-12 ok-button">好的</div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

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

</div>