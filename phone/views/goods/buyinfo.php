<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = '结算';
?>
<div class="container-fluid buyinfo">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8"><?=$order_info['goods_title']?></div>
        <div class="col-xs-2"></div>
    </div>
    <div class="row blank-div"></div>

    <div class="row buy-user">
        <p class="col-xs-12">收件人: <?=$order_info['receiver']?></p>
        <p class="col-xs-12">收货电话: <?=$order_info['receiving_phone']?></p>
        <p class="col-xs-12">订单状态: 订单已提交</p>
        <p class="col-xs-12">订单编号: <?=$order_info['order_code']?></p>
    </div>
    <div class="row buy-order-info">
        <p class="col-xs-12 buy-title">订单详情</p>
        <div class="col-xs-12 goods-order-detail">
            <ul>
            <?php foreach ($order_info['norms'] as $ko =>$vo): ?>
                <li  class="col-xs-12 order-spec-title"><div class="col-xs-8"><?=$vo['name']?></div><div class="col-xs-4">&yen;<?=$vo['price']?></div></li>
                <?php if(!empty($vo['_child'])): ?>
                <?php foreach ($vo['_child'] as $k2 =>$v2): ?>
                    <li class="col-xs-12">
                        <div class="col-xs-8">
                            <div class="col-xs-4"><?=$v2['name']?>:</div>
                            <div class="col-xs-8">
                                <?php if(!empty($v2['_child'])): ?>
                                    <?php foreach ($v2['_child'] as $k3 =>$v3): ?>
                                        <span><?=$v3['name']?></span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-xs-4"></div>
                    </li>
                <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <?php if(!empty($coupons)): ?>
    <div class="row buy-coupons">
        <a href="<?=Url::to(['user/coupons','is_true'=>1])?>">
            <div class="col-xs-8">您可以使用的优惠券:</div>
            <div class="col-xs-4"><span>&yen;<?=$coupons['money']?></span><i class="glyphicon glyphicon-menu-right"> </i></div>
        </a>
    </div>
    <?php endif; ?>
    <div class="row buy-note">
        <textarea placeholder="备注:" name="user_remark"></textarea>
    </div>
    <div class="row buy-order-total">
        <div class="col-xs-4 buy-order-code"></div>
        <div class="col-xs-8 buy-order-total-price">付款金额：&yen;<span><?=$order_info['total']-$coupons['money']?></span></div>
    </div>


    <div class="row buy-payment">
        <p class="col-xs-12 buy-title">请选择付款方式：</p>
        <div class="col-xs-12 paytype">
            <ul>
                <li>
                    <label for="weixin">
                        <div class="col-xs-2"><input type="radio" id="weixin" <?=$order_info['payment']=='微信'?'checked':''?> name="payment" value="微信" checked></div>
                        <div class="col-xs-10"><img src="/statics/img/wxPay.png" alt=""></div>
                    </label>
                </li>
<!--                <li>-->
<!--                    <label for="yinlian">-->
<!--                        <div class="col-xs-2"><input type="radio" id="yinlian" name="payment" value="银联"></div>-->
<!--                        <div class="col-xs-10"><img src="/statics/img/yinlPay.png" alt=""></div>-->
<!--                    </label>-->
<!--                </li>-->
                <li>
                    <label for="xianxia">
                        <div class="col-xs-2"><input type="radio" id="xianxia"  <?=$order_info['payment']=='线下'?'checked':''?> name="payment" value="线下"></div>
                        <div class="col-xs-10"><img src="/statics/img/xianxiapay.png" alt=""></div>
                    </label>
                </li>
            </ul>
        </div>
    </div>
    <div class="row buy-button" onclick="analog_form_sub($(this));"><input type="image" src="/statics/img/buy_but.png"></div>

</div>
<script>
//模拟表单提交
function analog_form_sub() {
    var PostData = [];
    var form = $("<form method='post' id='mAjaxForm'></form>");
    form.attr({"action":"<?=Url::to(['goods/pay-port'])?>"}); //设置要表单要提交的地址

    //定义表单数据
    PostData['_csrf'] = '<?=Yii::$app->getRequest()->getCsrfToken() ?>';//验证CSRF
    PostData['order_code'] = <?=$order_info['order_code']?>; //商品订单
    PostData['coupons_id'] =<?=$coupons['id']?:0?>;
    PostData['coupons_price'] =<?=$coupons['money']?:0?>;
    PostData['amount'] = <?=$order_info['total']-$coupons['money']?>;
    PostData['payment'] = $('.paytype input[name="payment"]:checked').val();
    PostData['user_remark'] = $('textarea[name="user_remark"]').val();
    //生成表单input
    for(var kp in PostData) {
        var input = $("<input type='hidden'>");
        input.attr({"name": kp}).val(PostData[kp]);
        form.append(input);
    }

//    $.ajax({
//        type: "POST",
//        url:"<?//=Url::to(['','id'=>$goods['id']])?>//",
//        data: form.serialize(),
//        dataType:'json',
//        success: function(msg){
//            switch (msg['status']){
//                case 0:
//                    alert(msg['msg']);
//                    window.location.href=msg['url'];
//                    break;
//                case 1:
//                    window.location.href=msg['url'];
//                    break;
//            }
//
//        }
//    });

    form.submit();
}
</script>


</body>
</html>