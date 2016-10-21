<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    body{background: #ffffff;}
</style>
<div class="container-fluid">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2">1</div>
        <div class="new-head-title col-xs-8">发现</div>
        <div class="col-xs-2">1</div>
    </div>
    <div class="blank-div"></div>
    <div class="row new-info-img"><img src="<?=$ArticleInfo['cover'] ?>" alt=""></div>
    <div class="row new-info-title">
        <p><?=$ArticleInfo['title'] ?></p>
    </div>
    <div class="row col-xs-12 new-info-sub">
        <div class="col-xs-8">发布时间：2016年6月12日</div>
        <div class="col-xs-4 new-info-like">被赞：23次</div>
    </div>
    <div class="row new-info-content">
        <?=$ArticleInfo['content'] ?>
    </div>
    <div class="row new-discuss">
        <p class="new-discuss-head col-xs-12">评论区</p>
        <ul class="row col-xs-12">
            <li class="col-xs-12">
                <div class="col-xs-12">
                    <div class="col-xs-6 new-discuss-user"><img src="./public/phone/img/new1.png" alt=""> 张三</div>
                    <div class="col-xs-6 new-discuss-choose"><a href=""><i class="glyphicon glyphicon-thumbs-up"></i>88</a></div>
                </div>
                <div class="new-discuss-content col-xs-12">
                    我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；
                </div>
            </li>
            <li class="col-xs-12">
                <div class="col-xs-12">
                    <div class="col-xs-6 new-discuss-user"><img src="./public/phone/img/new1.png" alt=""> 张三</div>
                    <div class="col-xs-6 new-discuss-choose"><a href=""><i class="glyphicon glyphicon-thumbs-up"></i>88</a></div>
                </div>
                <div class="new-discuss-content col-xs-12">
                    我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；
                </div>
            </li>
            <li class="col-xs-12">
                <div class="col-xs-12">
                    <div class="col-xs-6 new-discuss-user"><img src="./public/phone/img/new1.png" alt=""> 张三</div>
                    <div class="col-xs-6 new-discuss-choose"><a href=""><i class="glyphicon glyphicon-thumbs-up"></i>88</a></div>
                </div>
                <div class="new-discuss-content col-xs-12">
                    我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；
                </div>
            </li>
            <li class="col-xs-12">
                <div class="col-xs-12">
                    <div class="col-xs-6 new-discuss-user"><img src="./public/phone/img/new1.png" alt=""> 张三</div>
                    <div class="col-xs-6 new-discuss-choose"><a href=""><i class="glyphicon glyphicon-thumbs-up"></i>88</a></div>
                </div>
                <div class="new-discuss-content col-xs-12">
                    我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；我是占位符；
                </div>
            </li>
        </ul>
        <div class="row col-xs-12 new-discuss-form">
            <form action="" class="col-xs-12">
                <textarea name="" id="" cols="30" rows="10" class="col-xs-12"></textarea>
                <input type="image" src="/statics/img/tjpl.png" class="col-xs-12">
            </form>
        </div>
    </div>
</div>

</body>
</html>