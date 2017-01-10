<?php
/**
 * Created by PhpStorm.
 * User: xiaoj
 * Date: 2017/1/10
 * Time: 17:13
 */

namespace app\index\controller;


class Byte
{
    private $length=0;

    private $byte='';
    //操作码
    private $code;
    public function setBytePrev($content){
        $this->byte=$content.$this->byte;
    }
    public function getByte(){
        return $this->byte;
    }
    public function getLength(){
        return $this->length;
    }
    public function writeChar($string){
        $this->length+=strlen($string);
        $str=array_map('ord',str_split($string));
        foreach($str as $vo){
            $this->byte.=pack('c',$vo);
        }
    }
    public function writeInt($str){
        $this->length+=4;
        $this->byte.=pack('L',$str);
    }
    public function writeShortInt($interge){
        $this->length+=2;
        $this->byte.=pack('n',$interge);
    }
}