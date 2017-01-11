<?php
namespace app\index\cellserver;
use app\index\tool\RawClient;

/**
 * Created by PhpStorm.
 * User: xiaoj
 * Date: 2017/1/11
 * Time: 14:51
 */
class Cell
{
    private static $bizip = '115.236.177.85';
    private static $bizPort = 20000;
    private static $bizClient = null;
    private static $downRoot = null;

    private function __construct(){}

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function getBiz() {
        if(!(self::$bizClient instanceof RawClient)) {
            self::$bizClient = new RawClient(self::$bizip,self::$bizPort);
        }
        return self::$bizClient;
    }

    public static function bizSend($data) {
        $client = self::getBiz();

        $recv = $client->send($data);
        if(!$recv) {
            return 'error';
        }

        return $recv;
    }

}