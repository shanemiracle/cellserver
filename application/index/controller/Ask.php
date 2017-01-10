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

        $client = new swoole_client(SWOOLE_SOCK_TCP);
        if (!$client->connect('115.236.177.85', 20000, -1))
        {
            exit("connect failed. Error: {$client->errCode}\n");
        }

        $buf = new Byte();
        $writeData = '123456';
        $buf->writeChar('xiao');
        $buf->writeShortInt(strlen($writeData));
        $buf->writeChar($writeData);
        $buf->writeChar('code');

// echo $buf->getByte();
        $client->send($buf->getByte());
        echo $client->recv();
        $client->close();


        return $ret;
    }
}