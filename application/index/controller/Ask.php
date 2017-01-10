<?php
/**
 * Created by PhpStorm.
 * User: xiaoj
 * Date: 2017/1/10
 * Time: 10:26
 */

namespace app\index\controller;


class Ask
{
    public function index( $name) {
        $ret = '';
        $client = new swoole_client(SWOOLE_SOCK_TCP);

        if( $client ) {
            $ret = 'yes';
        }
        else {
            $ret = 'no';
        }
        return $ret;
    }
}