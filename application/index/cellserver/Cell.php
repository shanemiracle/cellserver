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
    private static $cell;
    private static $bizip = '115.236.177.85';
    private static $bizPort = 20000;
    private $bizClient;
    private $downRoot;

    private function __construct(){
        echo "cell create ";
    }

    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * @return mixed
     */
    public function getDownRoot()
    {
        return $this->downRoot;
    }

    /**
     * @param mixed $downRoot
     */
    public function setDownRoot($downRoot)
    {
        $this->downRoot = $downRoot;
    }

    /**
     * @return mixed
     */
    public function getBizClient()
    {
        return $this->bizClient;
    }

    /**
     * @param mixed $bizClient
     */
    public function setBizClient($bizClient)
    {
        $this->bizClient = $bizClient;
    }



    public static function getBiz() {
        if(!(self::$cell instanceof self)) {
            self::$cell = new self;
        }
        return self::$cell;
    }

    public static function bizSend($data) {
        $cell = self::getBiz();
        $biz = null;
        if(( $biz=$cell->getBizClient()) == null) {
            $cell->setBizClient( new RawClient(Cell::$bizip,Cell::$bizPort));
        }
        $biz = $cell->getBizClient();
        if($biz) {
            $recv = $biz->send($data);
            if($recv) {
                return $recv;
            }
        }
        return 'error';
    }

}