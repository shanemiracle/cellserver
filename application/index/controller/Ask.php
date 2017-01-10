<?php
/**
 * Created by PhpStorm.
 * User: xiaoj
 * Date: 2017/1/10
 * Time: 10:26
 */

namespace app\index\controller;
import('Swoole.Client.TCP');
use \Swoole\Client\TCP;

class Ask
{
    public function index( $name) {
        $ret = '';
        phpinfo();
        if(($sock = socket_create(AF_INET,SOCK_STREAM,SOL_TCP)) < 0) {
                echo "socket_create() 失败的原因是:".socket_strerror($sock)."\n";
         }
        else{
            echo "success";
        }

        return $ret;
    }
}