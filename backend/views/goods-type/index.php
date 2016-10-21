<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\helpers\Url;
use yii\widgets\ActiveForm;


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
                            <li><?= Html::a('新增', ['create'])?></li>
                            <li><a href="buttons.html#">禁用</a></li>
                            <li class="divider"></li>
                            <li><a href="buttons.html#">删除</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-8 m-b-xs"></div>
                        <div class="col-sm-4">
                            <?php $form = ActiveForm::begin() ?>
                                <div class="input-group">
                                    <input type="text" name="keywords" placeholder="请输入关键词..." class="input-sm form-control">
                                    <span class="input-group-btn">
                                            <button type="submit" class="btn btn-sm btn-primary"> 搜索</button>
                                    </span>
                                </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                    <table class="table table-hover table-list">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>类型名称</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($model as $td): ?>
                        <tr>
                            <td><?=$td['id'] ?></td>
                            <td><?=$td['name']?></td>
                            <td class="text-navy">
                                <?= Html::a('编辑', ['update','id'=>$td['id']]) ?>
                                <?= Html::a('删除', ['delete','id'=>$td['id']],['class'=>'ajax-del','ajax-form-method'=>'POST']) ?>
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
    $('.ajax-get').click(function(){
        var url = $(this).attr('href');
        $.get(url, function(msg){
            if(msg.status){
                swal({
                    title: msg.title,
                    text: msg.info,
                    type: "success",
                    timer:2000,
                });

                setInterval(function(){
                    location.reload();
                },1000);
            }else{
                swal({
                    title: msg.title,
                    text: msg.info,
                    type: "error",
                    timer:2000,
                });
            }
        },'json');
        return false;
    });

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
                                swal(msg.title, msg.info, "success");
                                t.parents('tr').empty();
                            }else{
                                swal(msg.title, msg.info, "error");
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



