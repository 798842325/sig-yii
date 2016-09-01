<?php
namespace common\libs;
/**
 * Created by PhpStorm.
 * User: yuer
 * Date: 16/8/22
 * Time: 11:34
 */
class Helpers{

    /**
     * 把返回的数据集转换成Tree
     * @param array $list 要转换的数据集
     * @param string $pid parent标记字段
     * @param string $level level标记字段
     * @return array
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    public static function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
        // 创建Tree
        $tree = array();
        if(is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId =  $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                }else{
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
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

        return  $output;
    }
}