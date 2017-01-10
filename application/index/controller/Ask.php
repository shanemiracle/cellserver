<?php
/**
 * Created by PhpStorm.
 * User: xiaoj
 * Date: 2017/1/10
 * Time: 10:26
 */

namespace app\index\controller;



use think\Loader;

class Ask
{
    public function index( $name) {
        $ret = '';
        Loader::import('Swoole.Client.TCP');
        $client = new \Swoole\Client\TCP();

        if( $client ) {
            $ret = 'yes';
        }
        else {
            $ret = 'no';
        }
        return $ret;
    }
}