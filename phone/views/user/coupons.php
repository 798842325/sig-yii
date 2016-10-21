<?php
/**
 * Created by PhpStorm.
 * User: yuer
 * Date: 16/9/19
 * Time: 16:03
 */
use yii\helpers\Url;
$this->title = Yii::$app->cache->get('PHONE_SITE_TITLE');
?>

    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="self.location=document.referrer;"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8">优惠券</div>
        <div class="col-xs-2"></div>
    </div>
    <div class="blank-div"></div>
    <?php if(isset($_GET['is_true'])): ?>
    <div class="row coupons-bu">
        <label for="bucoupons" class="col-xs-12">
        <div class="col-xs-8" >不使用优惠券</div>
        <div class="col-xs-4"><input onclick="choose($(this));"  <?=$session['buy']['is_coupons']?'checked':''?>  id="bucoupons" name="is_coupons" value="1" type="checkbox"></div></label>
    </div>
    <?php endif; ?>
    <div class="col-xs-12 coupons-head">
        <div class="col-xs-8">您有 <span>1</span> 张优惠券可以使用</div>
        <div class="col-xs-4"><a href=""><i class="glyphicon glyphicon-question-sign"></i>优惠券说明</a></div>
    </div>
    <div class="row coupons">
        <ul class="col-xs-12">
            <?php foreach ($coupons as $ko =>$vo): ?>
            <li onclick="choose($(this));"  data-id="<?=$vo['id']?>"  class="col-xs-12  <?php if(isset($_GET['is_true'])){ if(isset($session['buy']['coupons']) && $session['buy']['coupons'] == $vo['id']){ echo 'active';} } ?>"  >
                <div class="col-xs-5 coupons-price"><?=$vo['money']?></div>
                <div class="col-xs-7">
                    <p class="coupons-tile"><?=$vo['name']?></p>
                    <div class="coupons-explain"><?=$vo['explain']?></div>
                </div>
            </li>
            <?php  endforeach; ?>
        </ul>
    </div>


<script>
function choose(t){
    var id=  t.attr('data-id');
    var is_coupons = $('#bucoupons:checked').val();
    if(is_coupons != 1){
        is_coupons = 0;
    }
//    console.log(is_coupons);

    t.siblings().removeClass('active');
    t.addClass('active');


    $.ajax({
        type: "POST",
        url: "<?=Url::to([''])?>",
        data: "_csrf=<?=Yii::$app->getRequest()->getCsrfToken() ?>&coupons="+id+'&is_coupons='+is_coupons,
        dataType:'json',
        success: function(msg){
//            if(msg.status ==1){
//                window.location.href='';
//            }
        }
    });
}
</script>
