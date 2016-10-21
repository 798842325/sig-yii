<?php
namespace common\libs;
/**
 * Created by PhpStorm.
 * User: yuer
 * Date: 16/8/22
 * Time: 11:34
 */
class Weixin{

    public static $appid = 'wx25ba78c76718f75c';
    public static $appsecret = '6db54fa03597b5e6ba8a637fdda68fad';


    //获取用户openid
    public static function openid(){
        $appid = Weixin::$appid;// 公众号的唯一标识
        $appsecret = Weixin::$appsecret;
        //通过code获得openid
        if(!isset($_GET['code'])){
            //触发微信返回code码

            $redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; //授权后重定向的回调链接地址，请使用urlencode对链接进行处理
            $url ="https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";

            return  Header("Location: $url");
        }else{
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$_GET[code]&grant_type=authorization_code";
            $res = self::SendHttp($url,'','GET');

            return $res;
        }






    }

    /**
     *
     * 拼接签名字符串
     * @param array $urlObj
     *
     * @return 返回已经拼接好的字符串
     */
    private function ToUrlParams($urlObj)
    {
        $buff = "";
        foreach ($urlObj as $k => $v)
        {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }


    //微信统一下单
    public static function UnifiedOrder($order_data){

        ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
        require_once "wxpay/lib/WxPay.Api.php";
        require_once "wxpay/example/WxPay.JsApiPay.php";
        require_once 'wxpay/example/log.php';

        //初始化日志
        $logHandler= new \CLogFileHandler("../../common/libs/wxpay/logs/".date('Y-m-d').'.log');
        $log = \Log::Init($logHandler, 15);

        //①、获取用户openid
        $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();

        //②、统一下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($order_data['body']);
        $input->SetAttach($order_data['attach']);
        $input->SetOut_trade_no(\WxPayConfig::MCHID.date("YmdHis"));
        $input->SetTotal_fee("$order_data[total_fee]");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 60000));
        $input->SetGoods_tag($order_data['goods_tag']);
        $input->SetNotify_url($order_data['notify_url']);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);

        $jsApiParameters = $tools->GetJsApiParameters($order);

//        //获取共享收货地址js函数参数
//        $editAddress = $tools->GetEditAddressParameters();

echo '<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信支付样例-支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
            "getBrandWCPayRequest",
			'.$jsApiParameters.',
function(res){
WeixinJSBridge.log(res.err_msg);
alert(res.err_code+res.err_desc+res.err_msg);
}
);
}

function callpay()
{
if (typeof WeixinJSBridge == "undefined"){
if( document.addEventListener ){
document.addEventListener("WeixinJSBridgeReady", jsApiCall, false);
}else if (document.attachEvent){
document.attachEvent("WeixinJSBridgeReady", jsApiCall);
document.attachEvent("onWeixinJSBridgeReady", jsApiCall);
}
}else{
jsApiCall();
}
}
</script>
</head>
<body>
<br/>
<font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px">1分</span>钱</b></font><br/><br/>
<div align="center">
    <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
</div>
</body>
</html>';
        
        

    }


    /**
     *  发送 Http 请求
     * @param string $httpUrl  请求 url 地址
     * @param null $data 请求数据
     * @param string $type  请求类型 'POST' or 'GET'
     */
    public static function SendHttp($httpUrl='',$data=null,$type='POST')
    {

        $ch = curl_init();  // 初始化一个curl会话

        $header = array("Content-type:text/html,application/xhtml+xml,application/xml;charset=utf-8");

        curl_setopt($ch, CURLOPT_URL, $httpUrl); //需要获取的URL地址，也可以在 curl_init()函数中设置。
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type); //使用一个自定义的请求信息来代替"GET"或"HEAD"作为HTTP请求。这对于执行"DELETE" 或者其他更隐蔽的HTTP请求。有效值如"GET"，"POST"，"CONNECT"等等。也就是说，不要在这里输入整个HTTP请求。例如输入"GET /index.html HTTP/1.0\r\n\r\n"是不正确的
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);//禁用后cURL将终止从服务端进行验证。使用CURLOPT_CAINFO选项设置证书使用CURLOPT_CAPATH选项设置证书目录 如果CURLOPT_SSL_VERIFYPEER(默认值为2)被启用，CURLOPT_SSL_VERIFYHOST需要被设置成TRUE否则设置为FALSE。
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);//一个用来设置HTTP头字段的数组。使用如下的形式的数组进行设置： array('Content-type: text/plain', 'Content-length: 100')
//        curl_setopt($ch, CURLOPT_HEADER, true);//启用时会将头文件的信息作为数据流输出。
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 允许重定向
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环

        $output = curl_exec($ch); //执行一个cURL会话
        curl_close($ch);//关闭一个cURL会话

        return  json_decode($output,true);;
    }
}