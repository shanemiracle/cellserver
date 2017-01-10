<?php
/**
 * Created by PhpStorm.
 * User: xiaoj
 * Date: 2017/1/10
 * Time: 10:26
 */

namespace app\index\controller;

use \Swoole\Client\TCP;

class Ask
{
    public function index( $name) {
        $ret = '';
        phpinfo();
        $client = new TCP();

        if( $client ) {
            $ret = 'yes';
        }
        else {
            $ret = 'no';
        }
        return $ret;
    }
}