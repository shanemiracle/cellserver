<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/3
 * Time: 14:59
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiCheckType
{
    public static function apiCheckTypeAdd($attest,$desc) {
        $sendArray = ['id'=>intval(45),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'desc'=>$desc] ];
        $sendData = json_encode($sendArray);
        if($sendData){
            $recvData = Cell::bizSend($sendData);
            if($recvData) {
                $recvArray = json_decode($recvData,true);

                if($recvArray) {
                    return $recvArray;
                }
            }
        }
        return false;
    }

    public static function apiCheckTypeDrop($attest,$check_type) {
        $sendArray = ['id'=>intval(46),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type)] ];
        $sendData = json_encode($sendArray);
        if($sendData){
            $recvData = Cell::bizSend($sendData);
            if($recvData) {
                $recvArray = json_decode($recvData,true);

                if($recvArray) {
                    return $recvArray;
                }
            }
        }
        return false;
    }


    public static function apiCheckTypeSet($attest,$check_type,$info_ver,$desc) {
        $sendArray = ['id'=>intval(47),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'info_ver'=>intval($info_ver),'desc'=>$desc] ];
        $sendData = json_encode($sendArray);
        if($sendData){
            $recvData = Cell::bizSend($sendData);
            if($recvData) {
                $recvArray = json_decode($recvData,true);

                if($recvArray) {
                    return $recvArray;
                }
            }
        }
        return false;
    }

    public static function apiCheckTypeList($attest) {
        $sendArray = ['id'=>intval(48),'flag'=>intval(0),'data'=>['attest'=>intval($attest)] ];
        $sendData = json_encode($sendArray);
        if($sendData){
            $recvData = Cell::bizSend($sendData);
            if($recvData) {
                $recvArray = json_decode($recvData,true);

                if($recvArray) {
                    return $recvArray;
                }
            }
        }
        return false;
    }

    public static function apiCheckTypeGet($attest,$check_type) {
        $sendArray = ['id'=>intval(49),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type)] ];
        $sendData = json_encode($sendArray);
        if($sendData){
            $recvData = Cell::bizSend($sendData);
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