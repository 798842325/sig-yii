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
        <div class="new-head-title col-xs-8">我的客户</div>
        <div class="col-xs-2 withdrawal-a">
            <a href="<?=Url::to(['withdrawal'])?>">提现</a>
        </div>
    </div>
    <div class="blank-div"></div>
    <div class="row cumulative_count">
        <div class="col-xs-6">您的关联客户：</div>
        <div class="col-xs-6 text-right"><?=count($head_user)?>个</div>
    </div>

    <div class="row">
        <div class="col-xs-6">关联客户列表：</div>
        <div class="col-xs-6 text-right"></div>
    </div>
    <div class="row cumulative_register_list">
        <div class="col-xs-12 head-title">

            <div class="col-xs-6">联系电话</div>
            <div class="col-xs-6">注册时间</div>
        </div>

        <div class="col-xs-12 rebate-list">
            <ul>
                <?php foreach ($head_user as $k=>$v): ?>
                <li class="col-xs-12">
                    <div class="col-xs-6"><?=$v['phone']?></div>
                    <div class="col-xs-6"><?=date('Y.md H:i:s',$v['created_at'])?></div>

                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>