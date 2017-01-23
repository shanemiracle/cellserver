<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/23
 * Time: 下午3:04
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiFile
{
    public static function apiFileUp($md5_id, $file_size, $file_type) {
        if($file_type == 'bmp'){
            $file_type = 1;
        }
        else if( $file_type == 'jpeg' ){
            $file_type = 2;
        }
        else if( $file_type == 'png' ){
            $file_type = 3;
        }
        else {
            $file_type = 0;
        }
        $sendArray = ['id'=>intval(23),'flag'=>intval(0),'data'=>['file_ver'=>intval(1),'md5_id'=>$md5_id,
            'file_size'=>intval($file_size),'file_type'=>intval($file_type)]];
        $sendData = json_encode($sendArray);
        if($sendData) {
            $recvData = Cell::downSend($sendData);
            if($recvData) {
                $recvArray = json_decode($recvData,true);
                if($recvArray) {
                    return $recvArray;
                }
            }
        }

        return false;
    }
}