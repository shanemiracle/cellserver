<?php
/**
 * Created by PhpStorm.
 * User: xiaoj
 * Date: 2017/1/10
 * Time: 10:26
 */

namespace app\index\controller;

use app\index\tool\RawClient;

class Ask
{
    public function index( $name) {
       $client = new RawClient("115.236.177.85",20000);

       $recv = $client->send($name);

       if($recv!= null) {
           return $recv;
       }

        return "error";
    }
}