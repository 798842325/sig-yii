<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@phone', dirname(dirname(__DIR__)) . '/phone');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');


function dump($data){
    header("Content-type: text/html; charset=utf-8");
    echo '<div style="height:100%;overflow: scroll;"><pre>';
    var_dump($data);
    echo '</pre></div>';
}