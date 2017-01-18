<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/16
 * Time: 上午11:02
 */

namespace app\index\controller;


use think\Cookie;
use think\Request;
use think\View;

class Welcome
{
    public function index() {
//        $cook = Request::instance()->cookie('attest');
//        Cookie::set('attest',1234567);
        $cook = Cookie::get('attest');
        return (new View())->fetch('welcome',['cook'=>'cook'.$cook]);
    }


}