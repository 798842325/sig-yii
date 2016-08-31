<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@phone', dirname(dirname(__DIR__)) . '/phone');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@upload', 'http://upload.sig-yii.com');


function dump($data){
    echo '<div style="height:50%;overflow: scroll;"><pre>';
    print_r($data);
    echo '</pre></div>';
}