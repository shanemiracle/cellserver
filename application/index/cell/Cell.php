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
            $cellOb->biz  = new RawClient('115.236.177.85',20000);
        }
        $recv =$cellOb->biz->send($data);
        if( $recv ) {
            return $recv;
        }
        return 'error';
    }
}