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

<div class="container-fluid member">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8">用户中心</div>
        <div class="col-xs-2 qrcode"></div>
    </div>
    <div class="blank-div"></div>

    <div class="row user">
        <a href="col-xs-12">
            <div class="col-xs-3 user-pic">
                <img src="<?= Yii::$app->user->identity->avatar ?>" alt="">
            </div>
            <div class="col-xs-7 user-username">
                <div><?= Yii::$app->user->identity->realname ?></div>
                <div><?= substr_replace(Yii::$app->user->identity->phone, '****', 3, 4); ?></div>
            </div>
            <div class="col-xs-2 user-info-right"><i class="glyphicon glyphicon-menu-right"></i></div>
        </a>
    </div>

    <div class="row menu-tub">
        <div class="col-xs-3 ">
            <a href="<?= Url::to(['coupons']) ?>">
                <i class="icon-coupons"></i>
                <span>优惠券</span>
            </a>

        </div>
        <div class="col-xs-3">
            <a href="<?= Url::to(['withdrawal-record']) ?>">
                <i class="icon-record"></i>
                <span>提现记录</span>
            </a>
        </div>
        <div class="col-xs-3">
            <a href="<?= Url::to(['share-qrcode']) ?>">
                <i class="icon-qrcode"></i>
                <span>二维码</span>
            </a>
        </div>
        <div class="col-xs-3">
            <a href="<?= Url::to(['recommend']) ?>">
                <i class="icon-recommended"></i>
                <span>推荐有奖</span>
            </a>
        </div>
    </div>

    <?php if(Yii::$app->user->identity->type):?>
    <div class="row member-order">
        <div class="col-xs-12 member-order-head">
            <a href="<?= Url::to(['order']) ?>">
                <div class="col-xs-8">订单</div>
                <div class="col-xs-4">全部 <i class="glyphicon glyphicon-menu-right"></i></div>
            </a>
        </div>
        <?php if (!empty($order_info)): ?>
            <div class="col-xs-12">
                <div class="col-xs-12 order-head-title">
                    <div class="col-xs-6"><?= $order_info['goods_title'] ?></div>
                    <div class="col-xs-6">下单时间:<?= date('Y.m.d H:i:s', $order_info['cretad_at']) ?></div>
                </div>
                <div class="col-xs-12 order-plan">
                    <ul>
                        <li>
                            <p><?= date('Y.m.d H:i:s', $order_when['created_at']) ?></p>
                            <p><?= $order_when['content'] ?></p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 order-code">
                <div class="col-xs-4"></div>
                <div class="col-xs-8">订单号：<?= $order_info['order_code'] ?></div>
            </div>
        <?php endif; ?>
    </div>
    <div class="row member-order">
        <div class="col-xs-12 member-order-head">
            <div class="col-xs-8">推荐返利列表</div>
            <div class="col-xs-4"></div>
        </div>
    </div>
    <div class="row rebate-block">
        <a class="col-xs-12" href="<?= Url::to(['cumulative-register']) ?>">
            <div class="col-xs-6">累计注册人数</div>
            <div class="col-xs-4 text-center">2人</div>
            <div class="col-xs-2 user-coupons-right"><i class="glyphicon glyphicon-menu-right"></i></div>
        </a>
        <a class="col-xs-12" href="<?= Url::to(['cumulative-rebate']) ?>">
            <div class="col-xs-6">累计返利金额</div>
            <div class="col-xs-4 text-center">123123元</div>
            <div class="col-xs-2 user-coupons-right"><i class="glyphicon glyphicon-menu-right"></i></div>
        </a>
    </div>
        <?php else: ?>
        <div class="row member-order">
            <div class="col-xs-12 member-order-head">
                <a href="<?= Url::to(['admin-order']) ?>">
                <div class="col-xs-8">需要我跟进的订单</div>
                <div class="col-xs-4"><i class="glyphicon glyphicon-menu-right"></i></div>
                </a>
            </div>
            <div class="col-xs-12 member-order-head">
                <a href="<?= Url::to(['admin-customer']) ?>">
                    <div class="col-xs-8">我的客户</div>
                    <div class="col-xs-4"><i class="glyphicon glyphicon-menu-right"></i></div>
                </a>
            </div>
        </div>
    <?php endif; ?>


</div>
