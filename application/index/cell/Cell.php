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
    public static $ip = "115.236.69.122";
    private $biz;
    private $downRoot;
    private $downData;
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
            $cellOb->biz  = new RawClient(Cell::$ip,20000);
        }
        $recv =$cellOb->biz->send($data);
        if( $recv ) {
            return $recv;
        }
        return 'error';
    }

    public static function downRootSend($data) {
        $cellOb = self::getCell();
        if( $cellOb->downRoot == null ) {
            $cellOb->downRoot  = new RawClient(Cell::$ip,20001);
        }
        $recv =$cellOb->downRoot->send($data);
        if( $recv ) {
            return $recv;
        }
        return 'error';
    }

    public static function downDataSend($data) {
        $cellOb = self::getCell();
        if( $cellOb->downData == null ) {
            $cellOb->downData  = new RawClient(Cell::$ip,20002,60);
        }
        $recv =$cellOb->downData->send($data);
        if( $recv ) {
            return $recv;
        }
        return 'error';
    }
}