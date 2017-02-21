<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/2/9
 * Time: 下午2:27
 */

namespace app\index\controller;


use think\View;

class Hospital
{
    public function index() {
        return (new View())->fetch('/hospital/index');
    }
}