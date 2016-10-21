<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = '小绿灯NEW-发现';
?>

<div class="container-fluid">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8">全部分类</div>
        <div class="col-xs-2"></div>
    </div>
    <div class="row new-classify">
        <ul>
            <li class="<?=isset($_GET['cate_id'])?:'active'?>"><a href="<?=Url::to(['index'])?>">全部</a></li>
            <?php foreach ($CateArticleV1 as $v): ?>
            <li class="<?php if(isset($_GET['cate_id']) && $_GET['cate_id']==$v['id'] ){ echo 'active'; } ?>" ><a href="<?=Url::to(['','cate_id'=>$v['id']])?>"><?=$v['title']?></a></li>
            <?php endforeach;?>
        </ul>
    </div>
    <div class="row new-list">
        <?php foreach ($article as $article_v):?>
            <a href="<?=Url::to(['article/info','id'=>$article_v['id']])?>">
                <div class="row col-xs-12 new-list-block">
                    <div class="col-xs-4"><img src="<?=Url::to($article_v['cover']) ?>" alt=""></div>
                    <div class="col-xs-8">
                        <p class="new-list-title"><?=$article_v['title']?></p>
                        <div class="new-list-date">2016-6-13</div>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>


</div>

</body>
</html>