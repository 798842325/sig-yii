<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = Yii::$app->cache->get('PHONE_SITE_TITLE');
?>
<style>
    #carousel-example-generic .carousel-indicators {
        bottom: -6px;
        z-index: 9;
    }

    #carousel-example-generic .carousel-indicators li {
        width: 8px;
        height: 8px;
        vertical-align: middle;
    }

    #carousel-example-generic .carousel-inner * {
        height: 225px;
        width: 100%;
    }
</style>

<div class="container-fluid">
    <div class="row home-head-but">
        <div class="col-xs-6">
            <span class="menu-icon"></span>

            <div class="row home-menu">
                <span class="on-icon"></span>
                <?php if (!Yii::$app->user->isGuest): ?>
                    <div class="avatar">
                        <a href="<?=Url::to(['user/member'])?>"><img src="<?= Url::to(Yii::$app->user->identity->avatar) ?>" alt=""></a>
                    </div>
                    <div><a href=""><?= Yii::$app->user->identity->nickname ?></a></div>
                <?php else: ?>
                    <p><a href="<?= Url::to(['site/login']) ?>" class="btn">登录/注册</a></p>
                <?php endif; ?>

                <p><a href="" style="color:#6FD251;">首页</a></p>
                <p><a href="<?= Url::to(['article/index']) ?>">发现</a></p>
                <p><a href="<?=Url::to(['user/member'])?>">用户中心</a></p>
                <p><a href="<?=Url::to(['user/order'])?>">我的订单</a></p>
                <p><a href="">消息</a></p>
                <p><a href="">关于我们</a></p>
            </div>
        </div>
        <div class="col-xs-6"><span class="icon-kefu" onclick=" $('.kefu-k-bg').show();">客服</span></div>
    </div>
    <div class="row blank-div"></div>
    <div class="row">
        <div id="carousel-example-generic" class="carousel slide " data-ride="carousel">

            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php foreach ($slide_v1 as $slide_k => $slide_v): ?>
                    <li data-target="#carousel-example-generic" data-slide-to="<?= $slide_k ?>"
                        class="<?= $slide_k == 0 ? 'active' : '' ?>"></li>
                <?php endforeach; ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <?php foreach ($slide_v1 as $slide_k => $slide_v): ?>
                    <div class="item <?= $slide_k == 0 ? 'active' : '' ?>">
                        <a href="<?= Url::to($slide_v['url']) ?>">
                            <img src="<?= Url::to($slide_v['picture']) ?>" alt="<?= $slide_v['title'] ?>" height="225px"
                                 width="100%">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <?php foreach ($slide_v2 as $slide_v): ?>
        <div class="row">
            <a href="<?= Url::to($slide_v['url']) ?>">
                <img src="<?= Url::to($slide_v['picture']) ?>" height="225px" width="100%" alt="">
            </a>
        </div>
    <?php endforeach; ?>

    <div class="row home-list">
        <div class="col-xs-12 home-list-head">
            <div class="col-xs-12 home-list-title">您可以通过分类快速找到需要的服务</div>
        </div>
        <div class="col-xs-12 home-list-classify-content">
            <?php foreach ($CateGoods as $vc): ?>
                <a href="<?= Url::to(['site/classify', 'cate_id' => $vc['id']]) ?>" class="col-xs-4">
                    <img src="<?= Url::to($vc['cover']) ?>" alt="" width="100%">
                </a>
            <?php endforeach; ?>
            <?php if (!empty($CateGoods)): ?>
                <a href="<?= Url::to(['site/classify']) ?>" class="col-xs-<?= 12 - 4 * (count($CateGoods) % 3) ?> ">
                    <img src="/statics/img/qbfw.png" alt="" width="100%">
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="row home-list">
        <div class="col-xs-12 home-list-head">
            <div class="col-xs-12 home-list-title">推荐服务</div>
        </div>
        <div class="col-xs-12 home-list-goods-content">
            <?php foreach ($TopGoods as $TopGoods_v): ?>
                <a href="<?= Url::to(['goods/info', 'id' => $TopGoods_v['id']]) ?>" class="col-xs-12">
                    <div class="col-xs-4"><img src="<?= Url::to($TopGoods_v['main_map']) ?>" alt=""></div>
                    <div class="col-xs-8">
                        <p class="col-xs-12 home-goods-description"><?= $TopGoods_v['abstract'] ?></p>
                        <div class="col-xs-12 home-goods-price">
                            <?=$TopGoods_v['goods_price'].$TopGoods_v['goods_units']?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="row hone-phone">
        客户服务：4006-656-286
        <!--<img src="./Public/phone/img/contact.png" height="100px" width="100%" alt="">-->
    </div>
    <div class="row home-footer-copyright">
        <p>北京西格会计服务有限公司 版权所有</p>
        <p>京ICP备09012291号</p>
    </div>

    <div class="row kefu-k-bg">
        <ul class="ul_li text-center">
            <li><a href="http://p.qiao.baidu.com/cps/chatIndex?reqParam=%7B%22from%22%3A0%2C%22sid%22%3A%22-100%22%2C%22tid%22%3A%22-1%22%2C%22ttype%22%3A1%2C%22siteId%22%3A%228956314%22%2C%22userId%22%3A%221906775%22%7D">在线客服</a></li>
            <li><a href="tel:4006-656-286">拨打电话</a></li>
            <li><a href="<?=Url::to(['back-dial'])?>">电话回拨</a></li>
            <li onclick="$('.kefu-k-bg').hide();">暂时不用</li>
        </ul>
    </div>
</div>

<script>
    $('.menu-icon').click(function () {
        $(this).hide();
        $('.home-menu').slideDown(200);
        $('.on-icon').show();
        $('html,body').css({'overflow':'hidden','height':'100%'});
    });

    $('.on-icon').click(function () {
        $(this).hide();
        $('.home-menu').slideUp(200);
        $('.menu-icon').show();
        $('html,body').css({'overflow':'auto','height':'auto'});
    });




    //    $(window).scroll( function() {
    //        t = $(document).scrollTop();
    //        if(t > 350){
    //            $('.home-head-but').css({'background':'#ffffff'})
    //        }else{
    //            $('.home-head-but').css({'background':'transparent'})
    //        }
    //    } );
</script>

</body>
</html>