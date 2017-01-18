<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/12
 * Time: 下午5:01
 */

namespace app\index\controller;


use app\index\cell\Cell;
use think\Cookie;
use think\Request;
use think\Session;
use think\View;

class Login
{
    public function index() {
        Session::delete('user_name');
        Session::delete('pwd');

        return (new View())->fetch('/login/index');
    }



}