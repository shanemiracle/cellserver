<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/12
 * Time: 下午5:01
 */

namespace app\index\controller;


use app\index\cell\Cell;
use think\controller\Rest;
use think\Cookie;
use think\Request;
use think\Session;
use think\View;

class Login extends Rest
{
    public function index() {
        Session::delete('user_name');
        Session::delete('pwd');

        return (new View())->fetch('/login/index');
    }

    public function getApiLoginInfo(){
        $name = Session::get( 'user_name');
//        $pwd  = Session::get('pwd');
        return $this->response(['ret_code'=>($name==null?1:0),'name'=>($name==null?'':$name)],'json',200);

    }



}