<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/6/23
 * Time: 下午5:05
 */

namespace app\index\controller;


use think\View;

class Projectcell
{
    public function index() {

        return (new View())->fetch('/projectcell/index');
    }

}