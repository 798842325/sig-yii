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
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8">订单详情</div>
        <div class="col-xs-2"></div>
    </div>
    <div class="blank-div"></div>
    <div class="row order-info">

        <p class="order-info-title"><?=$order_info['goods_title']?></p>

        <div class="col-xs-12 order-info-details">
            <p class="col-xs-12 order-info-details-head">订单详情</p>
            <div class="col-xs-12 buy-user">
                <p class="col-xs-12">收件人: <?=$order_info['receiver']?></p>
                <p class="col-xs-12">收货电话: <?=$order_info['receiving_phone']?></p>
                <p class="col-xs-12">订单状态: 订单已提交</p>
                <p class="col-xs-12">订单编号: <?=$order_info['order_code']?></p>
            </div>
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
            <div class="col-xs-12 order-total">
                <div class="col-xs-6"></div>
                <div class="col-xs-6">共计：¥<?=$order_info['amount']?></div>
            </div>
            <p class="col-xs-12 order-info-details-head">订单进度</p>
            <div class="col-xs-12">
                <div   class="col-xs-12 order-plan">
                    <ul>
                        <?php foreach ($order_when as $k=>$v): ?>
                            <li>
                                <div><?=date('Y-m-d H:i:s',$v['created_at'])?></div>
                                <p><?=$v['content']?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        </div>

    </div>

