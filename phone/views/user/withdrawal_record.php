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
        <div class="new-head-title col-xs-8">提现历史记录</div>
        <div class="col-xs-2"></div>
    </div>
    <div class="blank-div"></div>

    <div class="row cumulative_register_list">
        <div class="col-xs-12 head-title">
            <div class="col-xs-4">提现时间</div>
            <div class="col-xs-4 text-center">提现金额</div>
            <div class="col-xs-4 text-center">状态</div>
        </div>

        <div class="col-xs-12 rebate-list">
            <ul>
                <?php foreach ($withdrawal_record as $k=>$v): ?>
                <li class="col-xs-12">
                    <div class="col-xs-5 "><?=date('Y.m.d H:i:s',$v['created_at'])?></div>
                    <div class="col-xs-4"><?=$v['amount']?></div>
                    <div class="col-xs-3 text-center"><?=$v['status']?></div>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>