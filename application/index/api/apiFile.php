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
        $sendArray = ['id'=>intval(23),'flag'=>intval(0),'data'=>['proto_ver'=>intval(1),'md5_id'=>$md5_id,
            'file_size'=>intval($file_size),'file_type'=>intval($file_type)]];
        $sendData = json_encode($sendArray);
        if($sendData) {
            $recvData = Cell::downRootSend($sendData);
            if($recvData) {
                $recvArray = json_decode($recvData,true);
                if($recvArray) {
                    return $recvArray;
                }
            }
        }

        return false;
    }

    public static function apiFileDataUp($md5_id, $file_size, $file_type,$web_name,$server_id,$flag_index) {
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
        $sendArray = ['id'=>intval(24),'flag'=>intval(0),'data'=>['proto_ver'=>intval(1),'md5_id'=>$md5_id,
            'file_size'=>intval($file_size),'file_type'=>intval($file_type), 'web_name'=>$web_name,
            'server_id'=>intval($server_id), 'flag_index'=>doubleval($flag_index)]];
        $sendData = json_encode($sendArray);
        if($sendData) {
            $recvData = Cell::downDataSend($sendData);
            if($recvData) {
                $recvArray = json_decode($recvData,true);
                if($recvArray) {
                    return $recvArray;
                }
            }
        }

        return false;
    }

    public static function apiFileUpOk($md5_id, $file_size, $file_type) {
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
        $sendArray = ['id'=>intval(25),'flag'=>intval(0),'data'=>['proto_ver'=>intval(1),'md5_id'=>$md5_id,
            'file_size'=>intval($file_size),'file_type'=>intval($file_type)]];
        $sendData = json_encode($sendArray);
        if($sendData) {
            $recvData = Cell::downRootSend($sendData);
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