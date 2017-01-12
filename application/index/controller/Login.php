<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/12
 * Time: 下午5:01
 */

namespace app\index\controller;


use think\controller\Rest;
use think\Request;

class Login extends Rest
{
    public function index() {
        $name = Request::instance()->param('name');
        $pwd = Request::instance()->param('pwd');

        $array = ['name'=>$name,'pwd'=>$pwd];

        return $this->response($array,'json',200);
    }

}