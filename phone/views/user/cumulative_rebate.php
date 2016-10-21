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

<div class="container-fluid cumulative_register">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8">累计返利</div>
        <div class="col-xs-2 withdrawal-a">
            <a href="<?=Url::to(['withdrawal'])?>">提现</a>
        </div>
    </div>
    <div class="blank-div"></div>
    <div class="row cumulative_count">
        <div class="col-xs-6">累计返利订单：</div>
        <div class="col-xs-6 text-right"><?=count($rebate)?>个</div>
    </div>
    <div class="row cumulative_count">
        <div class="col-xs-6">累计返利金额：</div>
        <div class="col-xs-6 text-right">14124.5元</div>
    </div>
    <div class="row">
        <div class="col-xs-6">返利明细：</div>
        <div class="col-xs-6 text-right"></div>
    </div>
    <div class="row cumulative_register_list">
        <div class="col-xs-12 head-title">
            <div class="col-xs-3">用户名</div>
            <div class="col-xs-3">下单金额</div>
            <div class="col-xs-3">返利金额</div>
            <div class="col-xs-3">状态</div>
        </div>

        <div class="col-xs-12 rebate-list">
            <ul>
                <?php foreach ($rebate as $k=>$v): ?>
                <li class="col-xs-12">
                    <div class="col-xs-3 ">1222</div>
                    <div class="col-xs-3"><?=$v['amount']?></div>
                    <div class="col-xs-3">12312</div>
                    <div class="col-xs-3">123</div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>