<?php
namespace app\index\controller;

use app\index\api\apiHospital;
use app\index\api\apiLogin;
use think\controller\Rest;
use think\Cookie;
use think\Request;
use think\Session;
use think\View;

class Index
{
    public function index()
    {
       // return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p> ThinkPHP V5<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
        $attest = Cookie::get('attest');
        if( $attest == null ) {
            $user_name = Request::instance()->param('user_name');
            $pwd = Request::instance()->param('pwd');

            if($user_name != null && $pwd != null ) {
                $recv = apiLogin::apiLogin($user_name,$pwd);

                if($recv['ret_code'] == 0) {
                    echo $recv['ret_code'];
                    Session::set('attest', $recv['attest']);
                    Cookie::set('attest',$recv['attest'],1800);
                    return (new View())->fetch('index');
                }
            }
        }
        else {
            if($attest == Session::get('attest')) {
                return (new View())->fetch('index');
            }
        }

        return (new View())->fetch('login/index');

    }

    public function test() {
        $data = ['attest'=>Session::get('attest'),'hospital_name'=>'test5','hospital_number'=>'5','zone'=>'杭州','logo'=>'','level'=>'专家'];
        return '';
    }


//      为了提高私令硬件的加解密速度,加解密算法采用了对称加密(AES-256加密算法)。而对称算法的关键在于客户端与服务端保持相同的加解密KEY,
//    因此,密钥的安全分发成了一个难点。本系统采用了双层加密通道,实现了密钥的安全分发。
//      第一层,基础通道。在终端初始化时,服务端与客户端保留一个共同的key池。通过同步时间后,根据时间段的hash,决定使用key池中的哪一个key
//    作为基础通道的加密key。第一个分发的key用此通道的加密key加密后,发送给客户端。
//      第二层,通信通道。通讯数据使用基础通道分发的key加密要发动的的数据。此后,更新key的时候,采用前一个key来加密新key实现key的更新。
//
//
//      密钥的更新是本系统的另一个难点。系统中采用了可配置的时间段更新秘钥机制。可根据需求设置密钥多长时间更新一次,最短30秒更新一次密钥。
//    密钥分发中涉及旧密钥的废弃以及新密钥的启用。采用了四次握手交互,实现了密钥的更替及验证,保障了密钥的准确分发。
}
