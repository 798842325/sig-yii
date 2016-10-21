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
        <div class="new-head-title col-xs-8">全部订单</div>
        <div class="col-xs-2"></div>
    </div>
    <div class="blank-div"></div>

    <div class="tabs-container order-list">
        <ul class="nav nav-tabs">
            <li class="<?php if(empty($_GET['status'])){ echo 'active';} ?>"><a href="<?=Url::to([''])?>">全部</a></li>
            <li class="<?php if(!empty($_GET['status'])){ echo  $_GET['status']==1?'active':'';} ?>"><a href="<?=Url::to(['','status'=>1])?>">未付款</a></li>
            <li class="<?php if(!empty($_GET['status'])){ echo  $_GET['status']==2?'active':'';} ?>"><a href="<?=Url::to(['','status'=>2])?>">进行中</a></li>
            <li class="<?php if(isset($_GET['is_evaluate'])){ echo  $_GET['is_evaluate']==0?'active':'';} ?>"><a href="<?=Url::to(['','status'=>3,'is_evaluate'=>0])?>">待评价</a></li>
            <li class="<?php if(!empty($_GET['status']) && !isset($_GET['is_evaluate'])){ echo  $_GET['status']==3?'active':'';} ?>"><a href="<?=Url::to(['','status'=>3])?>">已完成</a></li>
        </ul>

        <div class="tab-content">
            <div>
                <div class="panel-body">
                            <?php foreach ($Order as $ko =>$vo): ?>
                            <div class="row order-list-item">
                                <a href="<?=Url::to(['user/admin-order-info','order_code'=>$vo['order_code']])?>">
                                <div class="row order-list-item-head">
                                    <div class="col-xs-8">
                                        <span class="col-xs-12 order-status stocks">
                                            <?php
                                                switch ($vo['status']){
                                                    case '1':
                                                        echo '待付款';
                                                        break;
                                                    case '2':
                                                        echo '进行中';
                                                        break;
                                                    case '3':
                                                        echo '已完成';
                                                        break;
                                                }
                                            ?>

                                        </span>
                                        <span class="col-xs-12 order-code">订单编号：<?=$vo['order_code']?></span>
                                    </div>
                                    <div class="col-xs-3 order-info">
                                        <i class="glyphicon glyphicon-menu-right"></i>
                                    </div>
                                </div>
                                </a>
                                <div class="col-xs-12 goods-order-detail">
                                    <ul>
                                        <?php foreach (json_decode($vo['norms'],true) as $kn =>$vn): ?>
                                            <li  class="col-xs-12 order-spec-title"><div class="col-xs-8"><?=$vn['name']?></div><div class="col-xs-4">&yen;<?=$vn['price']?></div></li>
                                            <?php if(!empty($vn['_child'])): ?>
                                                <?php foreach ($vn['_child'] as $kn2 =>$vn2): ?>
                                                    <li class="col-xs-12">
                                                        <div class="col-xs-8">
                                                            <div class="col-xs-4"><?=$vn2['name']?>:</div>
                                                            <div class="col-xs-8">
                                                                <?php if(!empty($vn2['_child'])): ?>
                                                                    <?php foreach ($vn2['_child'] as $kn3 =>$vn3): ?>
                                                                        <span><?=$vn3['name']?></span>
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
                                    <div class="col-xs-6">共计：¥<?=$vo['total']?></div>
                                </div>
                                <div class="col-xs-12 order-total">
                                    <div class="col-xs-6"></div>
                                    <div class="col-xs-6">应付款：¥<?=$vo['amount']?></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                </div>