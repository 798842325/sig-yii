<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */

$this->title = $meta_title;

?>
<link rel="stylesheet" href="/public/js/kindeditor-4.1.10/themes/default/default.css"/>
<script charset="utf-8" src="/public/js/kindeditor-4.1.10/kindeditor-min.js"></script>
<script charset="utf-8" src="/public/js/kindeditor-4.1.10/lang/zh_CN.js"></script>
<script src="/statics/js/multiselect-master/dist/js/multiselect.min.js"></script>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= $meta_title ?></h5>
                    <div class="ibox-tools">
                        <a href="<?= Url::to(['index']) ?>">
                            <button type="button" class="btn btn-warning  btn-xs">
                                <i class="fa  fa-mail-reply-all"></i><span class="bold">返回</span>
                            </button>
                        </a>

                    </div>
                </div>
                <div class="ibox-content">

                    <?php $form = ActiveForm::begin(['options' => ['class' => 'form-horizontal ajax-form'], 'fieldConfig' => [
                        'template' => "{label}\n<div class=\"col-sm-10\">{input}\n{error}</div>",
                    ]]); ?>


                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true"> 基础商品</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2" aria-expanded="false">商品规格</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3" aria-expanded="false">商品服务</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active ">
                                <div class="panel-body">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品分类:</label>

                                        <div class="col-sm-10">
                                            <div class="col-sm-4 m-l-n">
                                                <select class="form-control" multiple=""
                                                        name="<?= $model->formName() ?>[cate_id]">
                                                    <?php foreach ($goods_classify as $v): ?>
                                                        <optgroup label="<?= $v['title'] ?>">
                                                            <?php foreach ($v['classify'] as $vs): ?>
                                                                <option
                                                                    value="<?= $vs['id'] ?>" <?= $model->cate_id == $vs['id'] ? 'selected' : '' ?>><?= $vs['title'] ?></option>
                                                                <?php if (!empty($vs['_child'])): ?>
                                                                    <?php foreach ($vs['_child'] as $vz): ?>
                                                                        <option
                                                                            value="<?= $vz['id'] ?>" <?= $model->cate_id == $vz['id'] ? 'selected' : '' ?>><?= $vz['title'] ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                    <?php endforeach; ?>

                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <?= $form->field($model, 'title')->textInput(['class' => 'form-control'])->label('商品名称:', ['class' => 'col-sm-2  control-label']) ?>

                                    <?= $form->field($model, 'abstract')->textarea(['class' => 'form-control'])->label('商品卖点:', ['class' => 'col-sm-2  control-label']) ?>

                                    <?= $form->field($model, 'goods_price')->textInput(['class' => 'form-control','value'=>0])->label('商品价格:', ['class' => 'col-sm-2  control-label']) ?>

                                    <?= $form->field($model, 'goods_units')->textInput(['class' => 'form-control'])->label('商品单位:', ['class' => 'col-sm-2  control-label']) ?>
                                    <?= $form->field($model, 'royalty_rate')->textInput(['class' => 'form-control'])->label('返利率:', ['class' => 'col-sm-2  control-label']) ?>


                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品主图: </label>
                                        <div class="col-sm-10">
                                            <div id="upload-img-one">
                                                <img
                                                    src="<?= Url::to($model->main_map ?: '/public/uploads/add_default.png') ?>"
                                                    alt="">
                                                <div class="upload-img-btn">
                                                    <div id="filePicker">选择图片</div>
                                                </div>
                                                <input type="hidden" name="<?= $model->formName() ?>[main_map]"
                                                       value="<?= $model->main_map ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">商品附图: </label>
                                        <div class="col-sm-10">
                                            <div class="col-sm-3 upload-img-one">
                                                <img
                                                    src="<?= Url::to($model->picture[0] ?: '/public/uploads/add_default.png') ?>"
                                                    alt="">
                                                <div class="upload-img-btn">
                                                    <div class="filePicker">选择图片</div>
                                                </div>
                                                <input type="hidden" name="<?= $model->formName() ?>[picture][0]"
                                                       value="<?= $model->picture[0] ?>">
                                            </div>
                                            <div class="col-sm-3 upload-img-one">
                                                <img
                                                    src="<?= Url::to($model->picture[1] ?: '/public/uploads/add_default.png') ?>"
                                                    alt="">
                                                <div class="upload-img-btn">
                                                    <div class="filePicker">选择图片</div>
                                                </div>
                                                <input type="hidden" name="<?= $model->formName() ?>[picture][1]"
                                                       value="<?= $model->picture[1] ?>">
                                            </div>
                                            <div class="col-sm-3 upload-img-one">
                                                <img
                                                    src="<?= Url::to($model->picture[2] ?: '/public/uploads/add_default.png') ?>"
                                                    alt="">
                                                <div class="upload-img-btn">
                                                    <div class="filePicker">选择图片</div>
                                                </div>
                                                <input type="hidden" name="<?= $model->formName() ?>[picture][2]"
                                                       value="<?= $model->picture[2] ?>">
                                            </div>
                                            <div class="col-sm-3 upload-img-one">
                                                <img
                                                    src="<?= Url::to($model->picture[3] ?: '/public/uploads/add_default.png') ?>"
                                                    alt="">
                                                <div class="upload-img-btn">
                                                    <div class="filePicker">选择图片</div>
                                                </div>
                                                <input type="hidden" name="<?= $model->formName() ?>[picture][3]"
                                                       value="<?= $model->picture[3] ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <?= $form->field($model, 'content')->textarea(['class' => 'form-control', 'id' => 'content', 'style' => 'height:400px;'])->label('商品详情：', ['class' => 'col-sm-2  control-label']) ?>


                                    <?= $form->field($model, 'sort')->textInput(['value' => '0', 'class' => 'form-control'])->label('排序：', ['class' => 'col-sm-2  control-label']) ?>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane  ">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">规格类型:</label>

                                        <div class="col-sm-10">
                                            <div class="col-sm-4 m-l-n">
                                                <select class="form-control spec-check-ajax" multiple=""
                                                        name="<?= $model->formName() ?>[goods_type]">
                                                    <?php foreach ($goods_type as $v): ?>
                                                        <option
                                                            value="<?= $v['id'] ?>" <?= $model->goods_type == $v['id'] ? 'selected' : '' ?>  onclick="HttpSpecAjax();" ><?= $v['name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group spec-table">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <td width="160px">商品规格</td>
                                                <td width="70%"></td>
                                                <td class="pattern_type">模式:

                                                    <input type="radio" name="<?= $model->formName() ?>[pattern_type]"
                                                           value="1" <?= $model->pattern_type == 1 ? 'checked' : 'checked' ?>
                                                           checked>商品&nbsp;&nbsp;
                                                    <input type="radio" name="<?= $model->formName() ?>[pattern_type]"
                                                           value="2" <?= $model->pattern_type == 2 ? 'checked' : '' ?>>服务
                                                </td>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="form-group spec-table-value">
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <td colspan="30">商品参数</td>
                                            </tr>
                                            <tr class="spec-head-2"></tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div id="tab-3" class="tab-pane ">
                                <div class="panel-body">
                                    <div class="form-group field-authgroup-title">
                                        <label for="authgroup-title" class="col-sm-2  control-label">权限：</label>
                                        <div class="col-sm-10">
                                            <div class="row">
                                                <div class="col-xs-5">
                                                    <select name="from[]" id="search" class="form-control" size="8"
                                                            multiple="multiple">
                                                        <?php foreach ($goods_service as $v): ?>
                                                            <option
                                                                value="<?= $v['id'] ?>"><?= $v['title'] . '-' . $v['service_price'] . '元' ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="col-xs-2">
                                                    <button type="button" id="search_rightAll" class="btn btn-block"><i
                                                            class="glyphicon glyphicon-forward"></i></button>
                                                    <button type="button" id="search_rightSelected"
                                                            class="btn btn-block"><i
                                                            class="glyphicon glyphicon-chevron-right"></i></button>
                                                    <button type="button" id="search_leftSelected"
                                                            class="btn btn-block"><i
                                                            class="glyphicon glyphicon-chevron-left"></i></button>
                                                    <button type="button" id="search_leftAll" class="btn btn-block"><i
                                                            class="glyphicon glyphicon-backward"></i></button>
                                                </div>

                                                <div class="col-xs-5">
                                                    <select name="<?= $model->formName() ?>[goods_service][]"
                                                            id="search_to" class="form-control" size="8"
                                                            multiple="multiple">
                                                        <?php foreach ($goods_service as $v): ?>
                                                            <?php if (in_array($v['id'], $helis_goods_service)): ?>
                                                                <option
                                                                    value="<?= $v['id'] ?>"><?= $v['title'] ?></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

        var goodsSpec = <?=$model->goods_spec ?: 0 ?>;
        var goodsSpecValue = <?=$goods_spec_value?:0 ?>;

    /* ajax 请求 规格 */
function HttpSpecAjax(){
    console.log(goodsSpec);
    //获取 选中商品类型ID
    var goodsType = $('.spec-check-ajax option:selected').val();
    //清除 旧商品规格
    $('.spec-table table tbody').empty();

    // ajax 请求 商品规格
    $.ajax({
        type: "GET",
        url: "<?=Url::to(['ajax-goods-spec'])?>",
        data: "goodsType=" + goodsType,
        dataType: 'json',
        success: function (msg) {
            //开始拼接商品规格
            var tr = '';
            var checked = '';
            var specv = '';
            for (var i = 0; i < msg['data'].length; i++) {
                tr += '<tr>';
                tr += '<td spec="' + msg['data'][i]['spec_id'] + '">';
                tr += msg['data'][i]['spec_name'] ;
                tr +='<input type="hidden" name="<?=$model->formName()?>[goods_spec]['+ msg['data'][i]['spec_id'] +'][name]" value="' + msg['data'][i]['spec_name'] + '">';
                tr +='<input type="hidden" name="<?=$model->formName()?>[goods_spec]['+ msg['data'][i]['spec_id'] +'][id]" value="' + msg['data'][i]['spec_id'] + '">';
                tr += '</td>';

                tr += '<td>';

                for (var j = 0; j < msg['data'][i]['spec_value'].length; j++) {
                    checked = '';
                    //判断是否被选中
                    if (Object.keys(goodsSpec).length > 0 && typeof(goodsSpec[msg['data'][i]['spec_id']]) == 'object') {

                        for (var jj in goodsSpec[msg['data'][i]['spec_id']]['_child']) {
                            checked = '';
                            if (goodsSpec[msg['data'][i]['spec_id']]['_child'][jj]['name'] == msg['data'][i]['spec_value'][j]) {
                                checked = 'checked';
                                break;
                            }
                        }

                    }

                    tr +='<label>';
                    tr +='<input spec_value_key="' + j + '" spec_value_id="' + msg['data'][i]['spec_id'] + j + '" ' + checked + ' name="<?=$model->formName()?>[goods_spec][' + msg['data'][i]['spec_id'] + '][_child][' + j + '][name]"  value="' + msg['data'][i]['spec_value'][j] + '" type="checkbox"  onclick="HttpSpecValueAjax();">';
                    tr += msg['data'][i]['spec_value'][j];
                    tr +='</label>';
                    tr +='&nbsp;&nbsp;&nbsp;&nbsp;';
                    tr +='<input type="hidden" name="<?=$model->formName()?>[goods_spec][' + msg['data'][i]['spec_id'] + '][_child][' + j + '][id]" value="' + msg['data'][i]['spec_id'] + j + '">';

                }

                // 判断是否需要输入
                switch (msg['data'][i]['entry_way']) {
                    case '1':
                        tr += '<label><input type="checkbox"><input type="text"></label>';
                        break;
                    case '2':

                        break;
                    case '3':
                        tr += '<label><input type="checkbox" name=""><input type="text" name=""></label>';
                        break;
                }

                tr += '</td>';
                tr += '<td>计算方式:';
                tr += '<input type="radio" name="<?=$model->formName()?>[goods_spec][' + msg['data'][i]['spec_id'] + '][compute_mode]" value="1" checked>单计 ';
                tr += '<input type="radio" name="<?=$model->formName()?>[goods_spec][' + msg['data'][i]['spec_id'] + '][compute_mode]" value="2">复计  ';
                tr += '<input type="radio" name="<?=$model->formName()?>[goods_spec][' + msg['data'][i]['spec_id'] + '][compute_mode]" value="3">多累积 </td>';

                tr += '</tr>';
            }
            //插入商品规格
            $('.spec-table table tbody').append(tr);
            HttpSpecValueAjax();
        }
    });

}


/*ajax 请求 获取选中规格的项的值*/
function HttpSpecValueAjax(){
    // 规格值 对象
    var trt = $('.spec-table-value table tbody');
    //获取模式
    var pattern_type = $('.pattern_type input[type="radio"]:checked').val();
    //拼接 变量
    var tr_v = '';
    // 规格ID
    var specID =0;
    // 清空规格值表格
    trt.empty();

    //判断商品模式  1 商品  2 服务
    if (pattern_type == 2) {
        //遍历 获取选中的规格
        $('.spec-table table tbody input[type="checkbox"]:checked').parents('tr').each(function (k, v) {
            //获取规格ID
            specID = $(this).find('td[spec]').attr('spec');
            //开始拼接规格值表格
            tr_v += '<tr>';
            tr_v += '<td width="160px"  spec="' + specID + '">' + $(this).find('td[spec]').text() + '<input type="hidden" name="<?=$model->formName()?>[goods_spec]['+specID+'][spec_id]" value="'+specID+'"><input type="hidden" name="<?=$model->formName()?>[goods_spec]['+specID+'][spec_name]" value="'+$(this).find('td[spec]').text()+'"></td>';
            tr_v += '<td>';

            $(this).find('input[type="checkbox"]:checked').each(function (k2, v2) {
                specv=0;
                spec_value_id= $(this).attr('spec_value_id'); //获取规格值 ID
                spec_value_key =$(this).attr('spec_value_key'); //获取规格值 key
                //判断已有的规格值 价格
                for(var ii = 0;ii<goodsSpecValue.length;ii++){
                    if(goodsSpecValue[ii]['spec_key'] == specID+k2 && $(this).val() == goodsSpecValue[ii]['spec_value']){
                        specv = goodsSpecValue[ii]['price'];
                    }
                }

                tr_v += '<div style="min-width:20%; display:inline-block; padding:8px 8px;">' + $(this).val() + ':&nbsp;<input value="' + specv + '" style="width:80px;" placeholder="价格" type="text" name="spec_value[' + spec_value_id + '][price]" > <input type="hidden" name="spec_value[' + spec_value_id + '][spec_value]" value="' + $(this).val() + '">  <input type="hidden" name="spec_value[' + spec_value_id + '][spec_key]" value="' + specID +k2+ '"> <input type="hidden" name="spec_value[' + spec_value_id + '][stock]" value="1"> <input type="hidden" name="<?=$model->formName()?>[goods_spec]['+specID+'][_child]['+spec_value_key+'][id]" value="' + spec_value_id + '">  </div>';

            });

            tr_v += '</td>';
            tr_v += '</tr>';
        });

        trt.append(tr_v);
    } else {

        $('.spec-head-2').empty();
        trt.empty();
        var postData = {};
        $('.spec-table table tbody input[type="checkbox"]:checked').parents('tr').each(function (k, v) {

            postData[k] = new Object();
            postData[k]['id'] = $(this).find('td[spec]').attr('spec');
            postData[k]['name'] = $(this).find('td[spec]').text();
            postData[k]['_child'] = new Object();

            $('.spec-head-2').append('<td>' + postData[k]['name'] + '</td>')

            $(this).find('input[type="checkbox"]:checked').each(function (k2, v2) {
                postData[k]['_child'][k2] = new Object();
                postData[k]['_child'][k2]['id'] = $(this).attr('spec_value_id');
                postData[k]['_child'][k2]['name'] = $(this).val();
            });

        });

        $.ajax({
            type: "POST",
            url: "<?=Url::to(['ajax-check-spec'])?>",
            data: "_csrf=<?php echo Yii::$app->getRequest()->getCsrfToken(); ?>&spec=" + JSON.stringify(postData),
            dataType: 'JSON',
            success: function (msg) {

                for (var k = 0; k < msg['data'].length; k++) {

                    spec_key= new Array();//规格项 key
                    specv_value='';
                    stock=price =0;
                    tr_v += '<tr>';
                    for(var k2=0;k2<msg['data'][k].length;k2++){
                        tr_v += '<td>' + msg['data'][k][k2]['name'] + '</td>';
                        spec_key.push(msg['data'][k][k2]['id']);
                        specv_value += msg['data'][k][k2]['name']+' ';
                    }

                    spec_key_str= spec_key.sort().join('_'); // 规格项 key 拼接字符串

                    for(var k3=0;k3<goodsSpecValue.length;k3++){
                        if(goodsSpecValue[k3]['spec_key'] == spec_key_str){
                            price = goodsSpecValue[k3]['price'];
                            stock = goodsSpecValue[k3]['stock'];
                        }
                    }

                    tr_v += '<td><input type="text" name="spec_value['+k+'][price]" value="'+price+'"><input type="hidden" name="spec_value['+k+'][spec_key]"  value="'+spec_key_str+'"><input type="hidden" name="spec_value['+k+'][spec_value]"  value="'+specv_value+'"></td>';
                    tr_v += '<td><input type="text" name="spec_value['+k+'][stock]" value="'+stock+'"></td>';
                    tr_v += '</tr>';
                }
                trt.append(tr_v);
            }
        });


        $('.spec-head-2').append('<td>价格</td><td>库存</td>');

    }

}

HttpSpecAjax();
</script>

<script>
    var editor;
    KindEditor.ready(function (K) {
        editor = K.create('textarea[id="content"]', {
            allowFileManager: true,
            width:'90%',
        });
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#search').multiselect({
            search: {
                left: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
                right: '<input type="text" name="q" class="form-control" placeholder="Search..." />',
            }
        });
    });
</script>

<script>

    //弹窗JS
    var resMsg = <?= $resMsg ?>;

    if (resMsg.status != null || resMsg.status != undefined) {

        if (resMsg.status) {

            swal({
                title: resMsg['title'],
                text: resMsg['info'],
                type: "success",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "返回列表",
                cancelButtonText: '继续',
                closeOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    window.location.href = resMsg.url;
                } else {
                    window.location.href = '';
                }
            });
        } else {
            swal(resMsg['title'], resMsg['info'], "error");
        }
    }
</script>

<script>
    var ts = '';
    $('.filePicker').click(function () {
        ts = $(this).parents('.upload-img-one');
    });

    // 初始化Web Uploader
    var uploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // 文件接收服务端。
        server: "<?=\yii\helpers\Url::to(['site/upload'])?>",

        formData: {
            _csrf: '<?php echo Yii::$app->getRequest()->getCsrfToken(); ?>',
            resType: 'ajax',
            savePath: 'uploads/goods/',
        },
        fileVal: 'UploadForm[File]',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '.filePicker',

        // 如果发现压缩后文件大小比原来还大，则使用原来图片
        // 此属性可能会影响图片自动纠正功能
        noCompressIfLarger: true,

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },

    });

    // 当有文件添加进来的时候
    // 当有文件添加进来的时候
    uploader.on('fileQueued', function (file) {

        $img = ts.find('img');


        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr('src', src);
        }, 1, 1);
    });


    // 文件上传过程中创建进度条实时显示。
    uploader.on('uploadProgress', function (file, percentage) {
        var $li = $('#upload-img-one');
        $percent = $li.find('.progress .progress-bar');

        // 避免重复创建
        if (!$percent.length) {
            $percent = $('<div class="progress progress-striped active">' +
                '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                '</div>' +
                '</div>').appendTo($li).find('.progress-bar');
        }

        $li.find('p.state').text('上传中');

        $percent.css('width', percentage * 100 + '%');
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on('uploadSuccess', function (file, data) {
        ts.addClass('upload-state-done');

        if (data['status']) {
            ts.find('input').attr('value', data.savePath);
        }
    });

    // 文件上传失败，显示上传出错。
    uploader.on('uploadError', function (file) {
        var $li = $('#' + file.id),
            $error = $li.find('div.error');

        // 避免重复创建
        if (!$error.length) {
            $error = $('<div class="error"></div>').appendTo($li);
        }

        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on('uploadComplete', function (file, data) {
        ts.find('.progress').remove();

    });


</script>

<script>
    // 初始化Web Uploader
    var uploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // 文件接收服务端。
        server: "<?=\yii\helpers\Url::to(['site/upload'])?>",

        formData: {
            _csrf: '<?php echo Yii::$app->getRequest()->getCsrfToken(); ?>',
            resType: 'ajax',
            savePath: 'uploads/goods/',
        },
        fileVal: 'UploadForm[File]',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',

        // 如果发现压缩后文件大小比原来还大，则使用原来图片
        // 此属性可能会影响图片自动纠正功能
        noCompressIfLarger: true,

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },

    });

    // 当有文件添加进来的时候
    // 当有文件添加进来的时候
    uploader.on('fileQueued', function (file) {
        $list = $('#upload-img-one');

        $img = $list.find('img');


        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr('src', src);
        }, 1, 1);
    });


    // 文件上传过程中创建进度条实时显示。
    uploader.on('uploadProgress', function (file, percentage) {
        var $li = $('#upload-img-one');
        $percent = $li.find('.progress .progress-bar');

        // 避免重复创建
        if (!$percent.length) {
            $percent = $('<div class="progress progress-striped active">' +
                '<div class="progress-bar" role="progressbar" style="width: 0%">' +
                '</div>' +
                '</div>').appendTo($li).find('.progress-bar');
        }

        $li.find('p.state').text('上传中');

        $percent.css('width', percentage * 100 + '%');
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on('uploadSuccess', function (file, data) {
        $('#upload-img-one').addClass('upload-state-done');

        if (data['status']) {
            $('#upload-img-one').find('input').attr('value', data.savePath);
        }
    });

    // 文件上传失败，显示上传出错。
    uploader.on('uploadError', function (file) {
        var $li = $('#' + file.id),
            $error = $li.find('div.error');

        // 避免重复创建
        if (!$error.length) {
            $error = $('<div class="error"></div>').appendTo($li);
        }

        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on('uploadComplete', function (file, data) {
        $('#upload-img-one').find('.progress').remove();

    });


</script>
