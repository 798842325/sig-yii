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
        <div class="new-head-title col-xs-8">累计注册</div>
        <div class="col-xs-2 qrcode">
<!--            <a href="--><?//=Url::to(['share-qrcode'])?><!--"><img src="/statics/img/qrcode.jpg" width="30px" height="30px" alt=""></a>-->
        </div>
    </div>
    <div class="blank-div"></div>
    <div class="row cumulative_count">
        <div class="col-xs-6">累计注册人数：</div>
        <div class="col-xs-6 text-right"><?=count($rec_regUser)?>人</div>
    </div>
    <div class="row">
        <div class="col-xs-6">注册名单：</div>
        <div class="col-xs-6 text-right"></div>
    </div>
    <div class="row cumulative_register_list">
        <div class="col-xs-12 head-title">
            <div class="col-xs-6">用户名</div>
            <div class="col-xs-6 text-right">注册时间</div>
        </div>

        <div class="col-xs-12 rebate-list">
            <ul>
                <?php foreach ($rec_regUser as $k=>$v): ?>
                <li class="col-xs-12">
                    <div class="col-xs-4 "><?=$v['phone']?></div>
                    <div class="col-xs-4"></div>
                    <div class="col-xs-4"><?=date('Y.m.d H:i')?></div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>