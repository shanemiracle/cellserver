<?php
namespace app\index\cell;
use app\index\tool\RawClient;

/**
 * Created by PhpStorm.
 * User: xiaoj
 * Date: 2017/1/11
 * Time: 16:17
 */
class Cell
{
    public static function bizSend($data) {
        $client = new RawClient('115.236.177.85',20000);
        $recv = $client->send($data);
        if( $recv ) {
            return $recv;
        }
        return 'error';
    }
}