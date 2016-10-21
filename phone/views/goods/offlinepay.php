<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = $article->title;
?>
<style>
    body{background: #ffffff;}
</style>
<div class="container-fluid buyinfo">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8"><?=$article->title?></div>
        <div class="col-xs-2"></div>
    </div>
    <div class="row blank-div"></div>
    <div class="row new-info-content">
        <?=$article->content?>
    </div>



</div>


</body>
</html>