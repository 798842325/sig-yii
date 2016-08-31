<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/statics/css/bootstrap.min.css',
        '/statics/css/font-awesome.min.css',
        '/statics/css/animate.min.css',
        '/statics/css/style.min862f.css?v=4.1.0',
        '/statics/css/admin_style.css',
        '/statics/css/plugins/sweetalert/sweetalert.css',
    ];
    public $js = [
        '/statics/js/jquery.min.js?v=2.1.4',
        '/statics/js/plugins/peity/jquery.peity.min.js',
        '/statics/js/plugins/sweetalert/sweetalert.min.js',
        '/statics/js/plugins/iCheck/icheck.min.js',
        '/statics/js/demo/peity-demo.min.js',
        '/statics/js/bootstrap.min.js?v=3.3.6',
        '/statics/js/plugins/metisMenu/jquery.metisMenu.js',
        '/statics/js/plugins/slimscroll/jquery.slimscroll.min.js',
        '/statics/js/plugins/layer/layer.min.js',
        '/statics/js/hplus.min.js?v=4.1.0',
        '/statics/js/contabs.min.js',
        '/statics/js/plugins/pace/pace.min.js',


    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}