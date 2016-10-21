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
                    <style>
                        .table tbody tr td{ border-top:0px;}
                    </style>
                    <table class="table table-list">
                        <tbody>

                            <tr style="border-bottom: 1px solid #D3D3D3;">
                                <td style="width:100px;">订单编号:</td>
                                <td colspan="3"><?=$model->order_code?></td>
                                <td colspan="2"></td>
                                <td style="100px;">下单时间:</td>
                                <td><?=date('Y-m-d h:i:s',$model->cretad_at)?></td>
                            </tr>
                            <tr>
                                <td colspan="4">订单内容列表：</td>
                                <td style="width:100px; border-left:1px solid #d3d3d3;">用户名：</td>
                                <td><?=$model->receiver?></td>
                                <td>联系电话：</td>
                                <td><?=$model->receiving_phone?></td>
                            </tr>
                            <tr>
                                <td colspan="4" rowspan="3" style="border-bottom:1px dashed #D3D3D3;">
                                    <ul style="list-style: none;padding: 0px;margin: 0px; max-width:450px;">
                                        <?php foreach ($model['norms'] as $ko =>$vo): ?>
                                            <li  class="col-xs-12 order-spec-title"><div class="col-xs-8"><?=$vo['name']?></div><div class="col-xs-4">&yen;<?=$vo['price']?></div></li>
                                            <?php if(!empty($vo['_child'])): ?>
                                                <?php foreach ($vo['_child'] as $k2 =>$v2): ?>
                                                    <li class="col-xs-12">
                                                        <div class="col-xs-8">
                                                            <div class="col-xs-4"><?=$v2['name']?>:</div>
                                                            <div class="col-xs-8">
                                                                <?php if(!empty($v2['_child'])): ?>
                                                                    <?php foreach ($v2['_child'] as $k3 =>$v3): ?>
                                                                        <span><?=$v3['name']?></span>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4"></div>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td style="border-left:1px solid #D3D3D3;">
                                    用户备注:
                                </td>
                                <td colspan="3"><?=$model->user_remark?></td>
                            </tr>
                            <tr>
                                <td colspan="4" style="border-left:1px solid #D3D3D3;">请及时更新订单状态，确保前台可以正确显示。</td>
                            </tr>
                            <tr>
                                <td style="border-left:1px solid #D3D3D3;">支付方式:</td>
                                <td colspan="3"><?=$model->payment?></td>
                            </tr>
                            <tr>
                                <td>总价:</td>
                                <td style="text-align: right;" colspan="3">&yen;<?=$model->total?></td>
                                <td colspan="4" style="border-left:1px solid #D3D3D3;"> 支付状态:
                                    <input type="radio" name="<?=$model->formName()?>[pay_status]"  <?=$model->pay_status==1?'checked':''?>  value="1">已支付
                                    <input type="radio" name="<?=$model->formName()?>[pay_status]"  <?=$model->pay_status!=1?'checked':''?> value="0">未支付
                                </td>
                            </tr>
                            <tr>
                                <td>优惠卷:</td>
                                <td  style="text-align: right; " colspan="3">&yen;<?=$model->coupons_price?></td>
                                <td colspan="4" style="border-left:1px solid #D3D3D3;">订单状态:
                                    <input type="radio" name="<?=$model->formName()?>[status]" <?=$model->status==1?'checked':''?> value="1">待付款
                                    <input type="radio" name="<?=$model->formName()?>[status]" <?=$model->status==2?'checked':''?> value="2">进行中
                                    <input type="radio" name="<?=$model->formName()?>[status]" <?=$model->status==3?'checked':''?> value="3">已完成
                                    <input type="radio" name="<?=$model->formName()?>[status]" <?=$model->status==0?'checked':''?> value="0">已关闭
                                </td>
                            </tr>
                            <tr>
                                <td>实付价格:</td>
                                <td  style="text-align: right;" colspan="3">&yen;<?=$model->amount?></td>
                                <td  style="border-left:1px solid #D3D3D3;">评价状态：</td>
                                <td colspan="3"><?=$model->is_evaluate?'已评价':'未评价'?></td>
                            </tr>

                        </tbody>
                    </table>
                    <div class="col-sm-12">
                        <div class="col-sm-12">订单进度</div>
                        <div class="col-sm-12">
                            <ul style="background: #F2F2F2;">
                                <?php foreach ($order_when as $k=>$v): ?>
                                <li>
                                    <div><?=date('Y-m-d H:i:s',$v['created_at'])?></div>
                                    <p><?=$v['content']?></p>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="col-sm-12">订单进度录入</div>
                        <div class="col-sm-12">
                            <textarea style="width:100%;" name="content" id="" cols="30" rows="6"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="col-sm-12">备注</div>
                        <div class="col-sm-12">
                            <textarea style="width:100%;" name="<?=$model->formName()?>[admin_remark]" id="" cols="30" rows="6"><?=$model->admin_remark?></textarea>
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

