<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

AppAsset::register($this);
//$this ->registerJs('jQuery(document).ready(function(){ App.init(); })',View::POS_END);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <script src="/statics/js/jquery.min.js?v=2.1.4"></script>
    <link rel="stylesheet" href="/statics/css/plugins/webuploader/webuploader.css">
    <script src="/statics/js/plugins/webuploader/webuploader.html5only.js"></script>
    <script src="/statics/js/plugins/sweetalert/sweetalert.min.js"></script>

</head>

<?php $this->beginBody() ?>

        <?= $content ?>

<?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>
