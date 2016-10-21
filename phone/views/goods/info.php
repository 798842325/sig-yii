<?php

/* @var $this yii\web\View */
use yii\helpers\Url;

$this->title = $goods['title'];
?>
<div class="container-fluid">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8"><?=$goods['title']?></div>
        <div class="col-xs-2"></div>
    </div>
    <div class="row blank-div"></div>
    <div class="row  goods">
        <?php foreach ($goods['goods_spec'] as $goodsK=>$goodsV): ?>
        <div class="goods-block col-xs-12">
            <div class="goods-xuan-title col-xs-12" data-spec-id="<?=$goodsV['id']?>"  data-spec-figure="<?=$goodsV['compute_mode']?>" ><?=$goodsV['name']?></div>
            <div class="goods-select">
                <ul>
                <?php foreach ($goodsV['_child'] as $goodsK2=>$goodsV2): ?>
                    <?php if(isset($goodsV2['name'])):?>
                    <li onclick="switch_spec(this);"  data-spec-value-id="<?=$goodsV2['id']?>" class="<?=$goodsK2==0?'active':''?>"><?=$goodsV2['name']?></li>
                        <?php endif; ?>
                <?php  endforeach; ?>
                </ul>
            </div>
        </div>
        <?php  endforeach; ?>
        <?php if(!empty($goods['service'])>0): ?>
        <div class="goods-block col-xs-12">
            <div class="goods-related-title col-xs-12">您可能需要的其他相关服务</div>
            <div class="goods-related-select">
                <div class="soller" >
                    <ul style="width:<?= 160 * 3 ?>px;">
                        <?php foreach ($goods['service'] as $v):?>
                        <li data-service-id="<?=$v['id']?>" onclick="switch_spec(this);"><img src="<?=$v['cover']?>" alt=""></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="goods-block col-xs-12">
            <div class="goods-order-title col-xs-12">服务明细单</div>
            <div class="goods-order-detail col-xs-12">
                <ul></ul>
            </div>
            <p class="goods-total">总价格：¥ <span>0</span></p>
        </div>
        <div class="goods-block col-xs-12 goods-crat">
            <div class="col-xs-4"><button class="kefu-btn">客服</button></div>
            <div class="col-xs-8" ><button class="cart-btn" onclick="analog_form_sub();">立即购买</button></div>
        </div>
        <div class="col-xs-12 goods-content">

            <div class="tabs-container">

                <div class="tabs-left">
                    <ul class="nav nav-tabs">
                        <li class="col-xs-6 active"><a data-toggle="tab" href="#tab-1">产品详情</a></li>
                        <li class="col-xs-6"><a data-toggle="tab" href="#tab-2">用户评价</a></li>
                    </ul>
                    <div class="tab-content col-xs-12">
                        <div id="tab-1" class="tab-pane active">
                            <div class="panel-body ">
                                <?=$goods['content']?>
                            </div>
                        </div>
                        <div id="tab-2" class="tab-pane">
                            <div class="panel-body goods-evaluation">
                                <div class="row label_count">
                                    <div class="col-xs-12 evaluation-label">
                                        <?php foreach ($label_count as $ks=>$vs): ?>
                                            <span><?=$ks?></span><i>(<?=$vs?>)</i>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php foreach ($goods_evaluation as $k=>$v): ?>
                                <div class="row">
                                    <p class="col-xs-12">
                                        <div class="col-xs-6 user-name"><?=$v['nickname']?:substr_replace($v['phone'],'****',3,4);?></div>
                                        <div class="col-xs-6 user-score">
                                            <?php for ($i=5;$i>0;$i--): ?>
                                                <?php if($i> $v['service_score']): ?>
                                                    <i class="no-xin"></i>
                                                    <?php else:?>
                                                    <i class="active-xin"></i>

                                                <?php endif; ?>

                                            <?php endfor; ?>

                                        </div>
                                    </p>
                                    <p class="col-xs-12 user-evaluation-content"><?=$v['content']?></p>
                                    <div class="col-xs-12 evaluation-label">
                                        <?php foreach (explode(',',$v['label']) as $ks=>$vs): ?>
                                        <span><?=$vs?></span>
                                        <?php endforeach; ?>
                                    </div>

<!--                                    <div class="col-xs-12 order-head">-->
<!--                                        <div class="col-xs-6 order-head-user"><img src="./info.php" alt="">负责人：王磊</div>-->
<!--                                        <div class="col-xs-6 score">综合好评率：99%</div>-->
<!--                                    </div>-->
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>


<script>

$(document).ready(function(){
    // 更新商品价格
    count_goods_price();
});

// 切换规格
function switch_spec(spec){

    spec_figure =  $(spec).parent().parent().parent().find('div[data-spec-figure]').attr('data-spec-figure');// 获取当前规格项的计算模式

    switch (spec_figure){
        case '1':
            $(spec).siblings().removeClass('active'); //删除当前同级的 所有选中的规格项的class
            $(spec).addClass('active'); //选中当前规格项的class
            break;
        case '2':
            $(spec).toggleClass('active');
            break;
        case '3':
            $(spec).toggleClass('active');
            break;
        default:
            $(spec).siblings().removeClass('active'); //删除当前同级的 所有选中的规格项的class
            $(spec).toggleClass('active'); //选中当前规格项的class
    }


    var pattern_type = <?=$goods['pattern_type']?>; // 商品模式类型  1 商品  2 服务
    var goods_spec_price = <?=$goods_spec_value?>;// 商品 规格 对应  价格 库存

    if(pattern_type == 1){

        $('.goods-block .goods-select ul:first-child li.active').each(function(k,v){
            var spec_value_id =  $(this).attr('data-spec-value-id'); //获取当前规格项的ID
            var goods_spec_key_str ='';  //规格项key ID字符串
            var goods_spec_key_arr = new Array();//规格项key ID 数组

            for(var i=0;i<goods_spec_price.length;i++){
                if(goods_spec_price[i]['spec_key'].indexOf(spec_value_id) > -1){
                    goods_spec_key_str += goods_spec_price[i]['spec_key']+'_';
                }

            }

            goods_spec_key_arr =goods_spec_key_str.replace(/_$/gi,'').split('_');//分割规格字符串key 为数组

            $('.goods-block:nth-child('+(k+2)+') .goods-select ul:first-child li').each(function(){
                spec_value_id =  $(this).attr('data-spec-value-id');
                if($.inArray(spec_value_id,goods_spec_key_arr) >-1){
                    $(this).show();
                }else{
                    $(this).hide();
                }
            });
            //判断选中的 元素 是否隐藏
            var display =  $('.goods-block:nth-child('+(k+2)+') .goods-select ul:first-child li.active').css('display');
            if(display == 'none'){
                $('.goods-block:nth-child('+(k+2)+') .goods-select ul:first-child li.active').removeClass('active')
                $('.goods-block:nth-child('+(k+2)+') .goods-select ul:first-child li:visible').eq(0).addClass('active');
            }

        });
    }

    // 更新商品价格
    count_goods_price();
}

// 统计计算 商品价格
function count_goods_price() {
    var goods_total_price = 0; //初始化商品总价格
    var pattern_type = <?=$goods['pattern_type']?>; // 商品模式类型  1 商品  2 服务
    var goods_price  = <?=$goods['goods_price']?>; //商品起始价格
    var goods_spec_price = <?=$goods_spec_value?>;// 商品 规格 对应  价格 库存
    var goods_service=  <?=$goods['jsonService']?>; //商品相关服务

    //如果没有商品规格 就赋值 商品起始价
    if(goods_spec_price != null){

        if(pattern_type == 1){
            var goods_spec_key_arr = new Array();
            $('.goods-block .goods-select ul li.active').each(function(){
                goods_spec_key_arr.push($(this).attr('data-spec-value-id'));
            });
            var spec_key = goods_spec_key_arr.sort().join('_');  //排序后组合成 key
            for(var i=0;i<goods_spec_price.length;i++){
                //判断当前的 规格key 是否存在
                if(goods_spec_price[i]['spec_key'] == spec_key){
                    goods_total_price += Number(goods_spec_price[i]['price']);  //找到对应的商品规格价格
                }
            }

        }else{
           var  after_price = 0;
            $('.goods-block .goods-select ul li.active').each(function(){
                spec_figure =  $(this).parent().parent().parent().find('div[data-spec-figure]').attr('data-spec-figure');// 获取当前规格项的计算模式
                var spec_key =$(this).attr('data-spec-value-id');
                for(var i=0;i<goods_spec_price.length;i++){
                    if(goods_spec_price[i]['spec_key'] == spec_key){

                        switch (spec_figure){
                            case '1':
                                goods_total_price += Number(goods_spec_price[i]['price']);
                                break;
                            case '2':
                                if(after_price < Number(goods_spec_price[i]['price'])){
                                    after_price =Number(goods_spec_price[i]['price']);
                                }
                                break;
                            case '3':
                                goods_total_price += Number(goods_spec_price[i]['price']);
                                break;
                            default:

                        }
                    }
                }
            });
            goods_total_price +=after_price;

        }
    }else{
        goods_total_price += goods_price;
    }

    detail_html(goods_total_price); //显示选择明细
    //获取选择的其他服务的价格
    $('.goods-block .soller ul  li.active').each(function(){
        service_id = $(this).attr('data-service-id');
        for(var f=0;f<goods_service.length;f++){
            if(goods_service[f]['id'] == service_id){
                goods_total_price+=Number(goods_service[f]['service_price']);
            }
        }
    });

    $('.goods-total span').html(goods_total_price); //更新商品总价显示

    PostData['total'] = goods_total_price;//把商品总价赋值给模拟表单数据
}


//已选择的商品明细
function detail_html(spec_price) {
    var goods_service=  <?=$goods['jsonService']?>; //商品相关服务

    $('.goods-order-detail ul').empty(); //初始化明细
    $('.goods-order-detail ul').append('<li class="order-spec-title"><div class="col-xs-7 "><?=$goods['title']?></div><div  class="col-xs-5">&yen;'+spec_price+'</div></li>');  //当前商品的规格价格

    //向模拟表单添加数据
    form.empty();
    form.append($("<input type='hidden'>").attr({"name":'norms[<?=$goods['title']?>][name]'}).val("<?=$goods['title']?>"));
    form.append($("<input type='hidden'>").attr({"name":'norms[<?=$goods['title']?>][price]'}).val(spec_price));

    //显示选择规格的明细
    $('.goods-block .goods-xuan-title').each(function(k,v){
        var this_name = $(this).text(); //当前对象名称
        var s_li= '';

        s_li = '<div class="col-xs-4">'+ this_name+':</div><div class="col-xs-8">';

        //向模拟表单添加数据
        form.append($("<input type='hidden'>").attr({"name":'norms[<?=$goods['title']?>][_child]['+k+'][name]'}).val(this_name));

        $(this).parent().find('.goods-select ul li.active').each(function(k2,v2){
            s_li +='<span>'+$(this).text()+'</span>';

            form.append($("<input type='hidden'>").attr({"name":'norms[<?=$goods['title']?>][_child]['+k+'][_child]['+k2+'][name]'}).val($(this).text()));

        });

        s_li +='</div>';
        $('.goods-order-detail ul').append('<li><div class="col-xs-8">'+s_li+'</div><div class="col-xs-4"></div></li>');


    });

    //显示已选择的其他服务明细
    $('.goods-block .soller ul  li.active').each(function(){
        service_id = $(this).attr('data-service-id');
        for(var f=0;f<goods_service.length;f++){
            if(goods_service[f]['id'] == service_id){
                $('.goods-order-detail ul').append('<li class="order-spec-title"><div class="col-xs-7">'+goods_service[f]['title']+'</div><div class="col-xs-5">&yen;'+goods_service[f]['service_price']+'</div></li>');

                //向模拟表单添加数据
                form.append($("<input type='hidden'>").attr({"name":'norms['+goods_service[f]['title']+'][id]'}).val(goods_service[f]['id']));
                form.append($("<input type='hidden'>").attr({"name":'norms['+goods_service[f]['title']+'][name]'}).val(goods_service[f]['title']));
                form.append($("<input type='hidden'>").attr({"name":'norms['+goods_service[f]['title']+'][price]'}).val(goods_service[f]['service_price']));

            }
        }

    });


}

//模拟表单提交
var PostData = [];
//定义表单 Form 对象
var form = $("<form method='post' id='mAjaxForm'></form>");
function analog_form_sub() {

    form.attr({"action":"<?=Url::to(['','id'=>$goods['id']])?>"}); //设置要表单要提交的地址
    //定义表单数据
    PostData['_csrf'] = '<?=Yii::$app->getRequest()->getCsrfToken() ?>';//验证CSRF
    PostData['goods_id'] = <?=$goods['id']?>; //商品ID
    PostData['goods_title'] = '<?=$goods['title']?>'; //商品名称
//    PostData['norms']=JSON.stringify(PostData['norms']);


    //生成表单input
    for(var kp in PostData) {
        var input = $("<input type='hidden'>");
        input.attr({"name": kp}).val(PostData[kp]);
        form.append(input);
    }

    $.ajax({
        type: "POST",
        url:"<?=Url::to(['','id'=>$goods['id']])?>",
        data: form.serialize(),
        dataType:'json',
        success: function(msg){
            switch (msg['status']){
                case 0:
                    alert(msg['msg']);
                    window.location.href=msg['url'];
                    break;
                case 1:
                    window.location.href=msg['url'];
                    break;
            }

        }
    });

//    form.submit();
}

</script>





</body>
</html>