<?php

use yii\widgets\LinkPager;

?>

<div class="ibox-content">
    <?= LinkPager::widget( ['pagination' => $pages,]) ?>
</div>