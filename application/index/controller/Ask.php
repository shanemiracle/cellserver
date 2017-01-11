<?php
/**
 * Created by PhpStorm.
 * User: xiaoj
 * Date: 2017/1/10
 * Time: 10:26
 */

namespace app\index\controller;


use app\index\cell\Cell;

class Ask
{
    public function index( $name) {

       $recv = Cell::bizSend($name);

       return $recv;
    }
}