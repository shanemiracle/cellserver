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
    public static $bizip = '115.236.177.85';
    public static $bizPort = 20000;
    public static $bizClient = null;
    public static $downRoot = null;

    public static function bizSend($data) {
        if(Cell::$bizClient==null) {
            echo 'cell_biz_create';
            Cell::$bizClient = new RawClient(Cell::$bizip,Cell::$bizPort);
        }

        if( Cell::$bizClient ) {
            $recv = Cell::$bizClient->send($data);
        }

        if(!$recv) {
            return 'error';
        }

        return $recv;
    }

}