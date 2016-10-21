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
<style>
    html,body{height: 100%;overflow: hidden; background: #FFFFFF;}
    .new-head{position: static; }
    /* 分享二维码 */
    .qrcode{  padding:10px;   background: url("/statics/img/qrcode_bg.png") no-repeat; background-size: 100% 90%; height:90%; width:100%;background-origin:content-box;}
    .qrcode .qrcode-img{ position: absolute; bottom: 50px;left:1%;}
</style>


<div class="row new-head col-xs-12">
    <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
    <div class="new-head-title col-xs-8">二维码分享</div>
    <div class="col-xs-2"></div>
</div>
<div class="row blank-div"></div>

<div class="qrcode">
    <div class="qrcode-img"><img src="<?=Url::to(['qrcode'])?>" alt=""></div>
</div>