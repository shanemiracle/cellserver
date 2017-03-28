<?php
/**
 * Created by PhpStorm.
 * User: HC
 * Date: 2017/1/11
 * Time: 10:32
 */
namespace app\index\tool;

class Byte{
    //长度  
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

    public function writeU8($u8){

        $hex = '';
        $hex .= dechex(intval($u8));

        $this->length+=strlen($hex);
        $this->byte .= $hex;
    }

    public function writeInt($str){
        $this->length+=4;
        $this->byte.=pack('L',$str);
    }

    public function writeShortInt($interge){
        $this->length+=2;
        $this->byte.=pack('n',$interge);
    }

    public static function readShortInt($data){
        return unpack('n',$data);
    }

}

/*$client = new swoole_client(SWOOLE_SOCK_TCP);
if (!$client->connect('115.236.177.85', 20000, -1))
{
    exit("connect failed. Error: {$client->errCode}\n");
}
// $sendData = 'xiao';
// $sendData .= '';
// $sendData .= intval(5);
// $sendData .= 'hello';
// $sendData .= 'code';

$buf = new Byte();
$writeData = '123456';
$buf->writeChar('xiao');
$buf->writeShortInt(strlen($writeData));
$buf->writeChar($writeData);
$buf->writeChar('code');

// echo $buf->getByte();
$client->send($buf->getByte());
echo $client->recv();
$client->close();*/
