<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = '全部分类';
?>
<style>
    body, html {
        height: 100%;
    }
</style>
<div class="row new-head col-xs-12">
    <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
    <div class="new-head-title col-xs-8">全部分类</div>
    <div class="col-xs-2"></div>
</div>
<div class="blank-div"></div>
<div class="row col-xs classify">
    <div class="col-xs-12">
        <div class="tabs-container">

            <div class="tabs-left">
                <ul class="nav nav-tabs col-xs-4">
                    <?php foreach ($CateGoods as $kc => $CateGoods_v): ?>
                        <li class="<?php if (isset($_GET['cate_id']) && $_GET['cate_id'] == $CateGoods_v['id']) {
                            echo 'active';
                        } elseif ($kc==1 && !isset($_GET['cate_id'])) {
                            echo 'active';
                        } ?>">
                            <a data-toggle="tab" href="#tab-<?= $CateGoods_v['id'] ?>"> <?= $CateGoods_v['title'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content col-xs-8">
                    <?php foreach ($CateGoods as $ks => $CateGoods_v): ?>
                        <div id="tab-<?= $CateGoods_v['id'] ?>" class="tab-pane <?= $ks == 1 ? 'active' : '' ?>">
                            <div class="panel-body ">
                                <ul>
                                    <?php if (isset($CateGoods_v['goods'])): ?>
                                        <?php foreach ($CateGoods_v['goods'] as $Goods_v): ?>
                                            <li>
                                                <a href="<?= Url::to(['goods/info', 'id' => $Goods_v['id']]) ?>"><?= $Goods_v['title'] ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </div>
    </div>
</div>


