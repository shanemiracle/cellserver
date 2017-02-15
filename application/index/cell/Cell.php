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
    private $biz;
    private $down;
    private static $cell;
    public static function getCell() {
        if(!(self::$cell instanceof self)){
            self::$cell = new self;
        }
        return self::$cell;
    }
    public static function bizSend($data) {
        $cellOb = self::getCell();
        if( $cellOb->biz == null ) {
            $cellOb->biz  = new RawClient('192.168.0.56',20000);
        }
        $recv =$cellOb->biz->send($data);
        if( $recv ) {
            return $recv;
        }
        return 'error';
    }

    public static function downSend($data) {
        $cellOb = self::getCell();
        if( $cellOb->down == null ) {
            $cellOb->down  = new RawClient('192.168.0.56',20001);
        }
        $recv =$cellOb->down->send($data);
        if( $recv ) {
            return $recv;
        }
        return 'error';
    }
}