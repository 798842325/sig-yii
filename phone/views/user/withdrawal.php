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

<div class="container-fluid withdrawal">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8">累计返利</div>
        <div class="col-xs-2"></div>
    </div>
    <div class="blank-div"></div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        <div class="col-xs-12 form-input">
            <div class="col-xs-6">请输入提现金额：</div>
            <div class="col-xs-6"><input type="text" name="<?=$model->formName()?>[amount]" value="0">元</div>
        </div>
        <div class="col-xs-12">
            <div class="col-xs-5"></div>
            <div class="col-xs-7 tishi-info">您的最大提现金额为<?=$user_info['money']?>元</div>
        </div>
        <div class="col-xs-12 img-submit">
            <input type="image" src="/statics/img/quer-ok-bth.png">
        </div>

    </div>

    <?php ActiveForm::end(); ?>
    <div class="row instructions">
        <div class="col-xs-12 instructions-head-title">返利金额提取业务说明：</div>
        <div class="col-xs-12 instructions-content">
            <p>1.使用此业务前请务必关注小绿灯公众微信号；</p>
            <p>2.提取的金额我们会以微信转账的形式发放到您的微信钱包中；</p>
            <p>3.您提取的金额会在7个自然日之内到账，请您留意微信钱包的金额变化，若有疑问请联系首页客服。</p>
        </div>
    </div>
    <div class="row alert-ks">
        <div class="alert-ok">
            <div class="col-xs-12 head-title">我们已经收到了您的联系方式</div>
            <div class="col-xs-12 content-info">相关人员会在1个小时内与您联系，请保持电话畅通。</div>
            <div class="col-xs-12 ok-button">好的</div>
        </div>
    </div>
    <script>
        $('form').submit(function(){
                s_price= $('.form-input input').val();
                if(s_price > <?=$user_info['money']?> ){
                    $('.form-input input').val(0);
                    alert('抱歉,你输入的提现金额超出你的最大提现金额!!');
                    return false;
                }else if(s_price < 1 ){
                    alert('抱歉,你输入的提现金额不能低于1元!!!');
                    return false;
                }

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


        });

    </script>

</div>