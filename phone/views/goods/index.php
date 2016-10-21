<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = '小绿灯NEW-服务';
?>

<div class="container-fluid">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8">社保服务</div>
        <div class="col-xs-2"></div>
    </div>
    <div class="row blank-div"></div>
    <div class="row  services">
        <div class="services-block col-xs-12">
            <div class="services-xuan-title col-xs-12">请选择类型</div>
            <div class="services-select">
                <ul>
                    <li>朝阳区</li>
                    <li>朝阳区</li>
                    <li>朝阳区</li>
                    <li>朝阳区</li>
                    <li>朝阳区</li>
                    <li>朝阳区</li>
                </ul>
            </div>
        </div>
        <div class="services-block col-xs-12">
            <div class="services-related-title col-xs-12">您可能需要的其他相关服务</div>
            <div class="services-related-select">
                <div class="soller" >
                    <ul style="width:<?= 160 * 3 ?>px;">
                        <li><img src="/statics/img/service-x.png" alt=""></li>
                        <li><img src="/statics/img/service-x.png" alt=""></li>
                        <li><img src="/statics/img/service-x.png" alt=""></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="services-block col-xs-12">
            <div class="services-order-title col-xs-12">服务明细单</div>
            <div class="services-order-detail">

            </div>
            <p class="services-total">总价格：¥<span>4498</span>元</p>
        </div>
        <div class="services-block col-xs-12 services-crat">
            <div class="col-xs-4"><button class="kefu-btn">客服</button></div>
            <div class="col-xs-8"><button class="cart-btn">立即购买</button></div>
        </div>
        <div class="col-xs-12 services-content">

            <div class="tabs-container">

                <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <li class="col-xs-6 active"><a data-toggle="tab" href="#tab-1">产品详情</a></li>
                        <li class="col-xs-6"><a data-toggle="tab" href="#tab-2">用户评价</a></li>
                    </ul>
                    <div class="tab-content col-xs-12">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body ">
                                    123
                                </div>
                            </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body ">
                               456
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
    <div class="row package">
        <div class="package-head col-xs-12">
            <div class="col-xs-8">超值套餐，省钱更省心</div>
            <div class="col-xs-4 more"><a href="" >更多<i class="glyphicon glyphicon-menu-right"></i> </a></div>
        </div>
        <div class="col-xs-12 package-list">
            <div class="col-xs-6"><a href=""><img src="/statics/img/package-img.png" alt=""></a>  </div>
            <div class="col-xs-6 "><a href=""><img src="/statics/img/package-img.png" alt=""></a> </div>
        </div>
    </div>
</div>

</body>
</html>