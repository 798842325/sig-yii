<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\helpers\Url;


$this->title = $meta_title;
?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= Html::encode($this->title) ?></h5>
                    <div class="ibox-tools">
                        <button data-toggle="dropdown" class="btn btn-primary btn-xs dropdown-toggle">操作 <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><?= Html::a('新增菜单', ['create']) ?></li>
                            <li><a href="buttons.html#">禁用</a></li>
                            <li class="divider"></li>
                            <li><a href="buttons.html#">删除</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-8 m-b-xs">

                        </div>
                        <div class="col-sm-4">
                            <form action="" method="post">
                                <div class="input-group">
                                    <input type="text" name="keywords" placeholder="请输入关键词" class="input-sm form-control">
                                    <span class="input-group-btn">
                                            <button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
                                        </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-hover table-list" id="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>名称</th>
                            <th>父级</th>
                            <th>路由</th>
                            <th>数据</th>
                            <th>排序</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr id="node-42" class="child-of-node-31">

                        <tr data-tt-id="42" data-tt-parent-id="31">

                        <?php foreach ($model as $td): ?>
                        <tr>
                            <td><?=$td['id']?></td>
                            <td><a href="<?=Url::to(['','pid'=>$td['id'],'name'=>$td['name']])?>"><?=$td['name']?></a></td>
                            <td><?=isset($_GET['name'])?$_GET['name']:'顶级菜单'?></td>
                            <td><?=$td['route']?></td>
                            <td><?=$td['data']?></td>
                            <td><?=$td['sort']?></td>
                            <td class="text-navy">
                                <a href="<?=Url::to(['menu/update','id'=>$td['id']])?>">编辑</a>
                                <a href="<?=Url::to(['menu/delete','id'=>$td['id']]) ?>" class="ajax-del"  ajax-form-method="POST" >删除</a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <?= $this->render('/_page', ['pages' => $pages,]) ?>
            </div>
        </div>
    </div>
</div>
<script>


    $('.ajax-del').click(function () {
        var t = $(this);
        var ajaxUrl = t.attr('href');
        var ajaxMethod = t.attr('ajax-form-method');
        var ajaxData = "_csrf=<?php  echo Yii::$app->getRequest()->getCsrfToken(); ?>&"+t.attr('ajax-form-data');

        swal({
            title: "您确定要删除这条信息吗",
            text: "删除后将无法恢复，请谨慎操作！",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "删除",
            cancelButtonText:'取消',
            closeOnConfirm: true
        }, function (isConfirm) {
            if(isConfirm){
                $.ajax({
                    type: ajaxMethod,
                    url: ajaxUrl,
                    dataType:'json',
                    data: ajaxData,
                    success: function(msg){

                        setTimeout(function(){
                            if(msg.status){
                                swal(msg.message, "您已经永久删除了这条信息。", "success");
                                t.parents('tr').empty();
                            }else{
                                swal(msg.message, "删除失败,请稍后再试!", "error");
                            }
                        }, 100);

                    }
                });

            }
        });
        return false;
    });

</script>
</body>



