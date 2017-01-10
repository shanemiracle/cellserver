<?php
/**
 * Created by PhpStorm.
 * User: xiaoj
 * Date: 2017/1/10
 * Time: 10:26
 */

namespace app\index\controller;


use Swoole\Client\WebSocket;

class Ask
{
    public function index( $name) {
        $ret = '';
        $client = new WebSocket('115.236.177.85',20000);

        if( $client ) {
            $ret = 'yes';
        }
        else {
            $ret = 'no';
        }
        return $ret;
    }
}