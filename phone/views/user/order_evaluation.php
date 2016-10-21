<?php
/**
 * Created by PhpStorm.
 * User: yuer
 * Date: 16/9/19
 * Time: 16:03
 */
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
$this->title = Yii::$app->cache->get('PHONE_SITE_TITLE');
?>
<style>
    body{background:#FFFFFF; }
</style>

<style type="text/css">

    <!--

    body{font-size:12px;}

    ul{padding:0;margin:0;}

    .star_rating {list-style:none;margin:-1px 0 0 -1px; padding:0; width:170px; height:30px; position:relative; background:url(/statics/img/xingxing.gif) -2px -20px repeat-x; background-size:34px 50px;  overflow:visible;font-size:0;}

    .star_rating li{ height:30px; width:30px; padding:0;margin:0;float:left; margin-right:4px;}

    .star_rating li a{ display:block;width:30px;height:30px;text-decoration:none;text-indent:-9000px;z-index:20;position:absolute;padding:0;margin:0;}

    .star_rating li a:hover{background:url(/statics/img/xingxing.gif) -2px -20px repeat-x;z-index:2;left:0;}

    .star_rating a.one_star{left:0;}

    .star_rating a.one_star:hover{width:30px;background-position: -2px 2px;  background-size:34px 50px;}

    /*.star_rating a.two_stars{left:14px;}*/

    .star_rating a.two_stars:hover{width:60px;background-position: -2px 2px;  background-size:34px 50px;}

    /*.star_rating a.three_stars{left:28px;}*/

    .star_rating a.three_stars:hover{width:98px;background-position: -2px 2px;  background-size:34px 50px;}

    /*.star_rating a.four_stars{left:42px;}*/

    .star_rating a.four_stars:hover{width:132px;background-position: -2px 2px;  background-size:34px 50px;}

    /*.star_rating a.five_stars{left:56px;}*/

    .star_rating a.five_stars:hover{width:166px;background-position: -2px 2px;  background-size:34px 50px;}

    .star_rating li.current_rating{background:url(/statics/img/xingxing.gif) -2px 4px;position:absolute; height:30px; display:block;text-indent:-9000px;z-index:1;left:0; background-size:34px 50px;}

    #www_zzjs_net{margin:0 0 20px 20px;}

    #www_zzjs_net p{margin:20px 0 5px 0;}

    -->

</style>

<div class="container-fluid order-evaluation">
    <div class="row new-head col-xs-12">
        <div class="col-xs-2" onclick="history.go(-1)"><span class="left-icon"></span></div>
        <div class="new-head-title col-xs-8">订单评价</div>
        <div class="col-xs-2"></div>
    </div>
    <div class="row blank-div"></div>
    <br/>
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>

            <div class="col-xs-12 evaluation-label">
                <p class="evaluation-lan-title">请您留下对我们的印象（1个或以上）:</p>
                <label class="" for="服务态度好"><input type="checkbox" id="服务态度好" name="<?=$GoodsEvaluation ->formName()?>[label][]" value="服务态度好"><span>服务态度好</span></label>
                <label class="" for="办事效率高"><input type="checkbox" id="办事效率高" name="<?=$GoodsEvaluation ->formName()?>[label][]" value="办事效率高"><span>办事效率高</span></label>
                <label class="" for="非常的专业"><input type="checkbox" id="非常的专业" name="<?=$GoodsEvaluation ->formName()?>[label][]" value="非常的专业"><span>非常的专业</span></label>
                <label class="" for="细致有耐心"><input type="checkbox" id="细致有耐心" name="<?=$GoodsEvaluation ->formName()?>[label][]" value="细致有耐心"><span>细致有耐心</span></label>
                <label class="" for="响应速度快"><input type="checkbox" id="响应速度快" name="<?=$GoodsEvaluation ->formName()?>[label][]" value="响应速度快"><span>响应速度快</span></label>
                <label class="" for="业务能力强"><input type="checkbox" id="业务能力强" name="<?=$GoodsEvaluation ->formName()?>[label][]" value="业务能力强"><span>业务能力强</span></label>
                <label class="" for="服务周到"><input type="checkbox" id="服务周到" name="<?=$GoodsEvaluation ->formName()?>[label][]" value="服务周到"><span>服务周到</span></label>
                <label class="" for="主动热情"><input type="checkbox" id="主动热情" name="<?=$GoodsEvaluation ->formName()?>[label][]" value="主动热情"><span>主动热情</span></label>
            </div>
            <div class="textarea col-xs-12">
                <p class="evaluation-lan-title">您的反馈会让我们做得更好</p>
                <textarea name="<?=$GoodsEvaluation ->formName()?>[content]" id="" cols="30" rows="10" placeholder=""></textarea>
            </div>
            <div class="col-xs-12 order-score">
                <p class="evaluation-lan-title">您对本次服务的评价：</p>
                <div id="www_zzjs_net" star_width="14">



                    <ul class="star_rating">

                        <li style="display:none;">

                            <input type="text" name="<?=$GoodsEvaluation ->formName()?>[service_score]" value="" />

                        </li>

                        <li class="current_rating">default level</li>

                        <li><a href="#" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" title="1 of 5 stars" class="one_star">1</a></li>

                        <li><a href="#" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" title="2 of 5 stars" class="two_stars">2</a></li>

                        <li><a href="#" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" title="3 of 5 stars" class="three_stars">3</a></li>

                        <li><a href="#" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" title="4 of 5 stars" class="four_stars">4</a></li>

                        <li><a href="#" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" rel="external nofollow" title="5 of 5 stars" class="five_stars">5</a></li>

                    </ul>
                </div>

            </div>
            <div class="col-xs-12 submit-bth">
                <input type="image"  src="/statics/img/plsub.png" value="提交评价">
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>


<script>
    $('.evaluation-label input').click(function(){
        $(this).parents('label').toggleClass('active');
    });
</script>



<script type="text/javascript">

    <!--

    function __start(){

        var initialize_width=0;

        if(document.getElelmentById){return false};

        if(document.getElementsByTagName==null){return false;}

        var startLevelObj=document.getElementById("www_zzjs_net")

        if(startLevelObj==null){return false;}

        initialize_width=parseInt(startLevelObj.getAttribute("star_width"),10);

        if(isNaN(initialize_width) || initialize_width==0){return false;}

        var ul_obj=startLevelObj.getElementsByTagName("ul");

        if(ul_obj.length<1){return false;}

        var length=ul_obj.length;

        var li_length=0;

        var a_length=0;

        var li_obj=null;

        var a_obj=null;

        var defaultInputObj=null;

        var defaultValue=null;

        for(var i=0;i<length;i++){

            li_obj=ul_obj[i].getElementsByTagName("li");

            li_length=li_obj.length;

            if(li_length<0){return false;}

            //获取默认值

            defaultInputObj=li_obj[0].getElementsByTagName("input");if(!defaultInputObj){return false;}

            defaultValue=parseInt(defaultInputObj[0].value,10);

            if(!isNaN(defaultValue) && defaultValue!=0){

                //alert("有初始值!");

                //li_obj[1].style.width=initialize_width*defaultValue+"px";

                //defaultValue=0;

            }

            for(var j=0;j<li_length;j++){

                a_obj=li_obj[j].getElementsByTagName("a");

                if(a_obj.length<1){continue;}

                if(a_obj[0].className.indexOf("star")>0){

                    a_obj[0].onclick=function(){

                        return give_value(this);

                    }

                    a_obj[0].onfocus=function(){

                        this.blur();

                    }

                }

            }

        }

    }

    function give_value(obj){

        var status=true;

        var parent_obj=obj.parentNode;

        var i=0;

        while(status){

            i++;

            if(parent_obj.nodeName=="UL"){break;}

            parent_obj=parent_obj.parentNode;

            if(i>1000){break;}//防止找不到ul发生死循环

        }

        var hidden_input=parent_obj.getElementsByTagName("input")[0];

        if(hidden_input.length<1){/*alert("sorry?\nprogram error!")*/;}

        var txt=obj.firstChild.nodeValue;//确保不能存在空格哦，因为这里用的firstChild

        if(isNaN(parseInt(txt,10))){/*alert('level error!')*/;return false;}

        hidden_input.setAttribute("value",txt.toString());

        //固定选中状态,先找到初始化颜色那个li

        var current_li=parent_obj.getElementsByTagName("li");

        var length=current_li.length;

        var ok_li_obj=null;

        for(var i=0;i<length;i++){

            if(current_li[i].className.indexOf("current_rating")>=0){

                ok_li_obj=current_li[i];break;//找到

            }

        }

        __current_width=txt*32;

        ok_li_obj.style.width=__current_width+"px";

        return false;

    }

    __start();

    //-->

</script>


