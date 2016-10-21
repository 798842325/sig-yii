<?php

namespace phone\assets;

use yii\web\AssetBundle;

/**
 * Main phone application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'statics/css/bootstrap-3.3.5-dist/css/bootstrap.min.css',
        'statics/css/style.css',
    ];
    public $js = [
        'statics/js/jquery.min.js',
        'statics/css/bootstrap-3.3.5-dist/js/bootstrap.min.js'
,    ];
    public $depends = [

    ];
}