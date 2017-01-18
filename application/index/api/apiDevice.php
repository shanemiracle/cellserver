<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/17
 * Time: 下午6:49
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiDevice
{
    public static function apiDeviceAdd($attest,$machine_code,$hospital_no,$valid_sec) {
        $sendArray = ['id'=>intval(12),'flag'=>intval(0),'attest'=>$attest,'machine_code'=>$machine_code,
            'hospital_no'=>$hospital_no,'valid_sec'=>$valid_sec];
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

    public static function apiDeviceHospitalGet($attest,$hospital_no) {
        $sendArray = ['id'=>intval(13),'flag'=>intval(0),'attest'=>$attest,'hospital_no'=>$hospital_no];
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

    public static function apiDeviceGet($attest,$machine_code) {
        $sendArray = ['id'=>intval(14),'flag'=>intval(0),'attest'=>$attest,'machine_code'=>$machine_code];
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

    public static function apiDeviceSetTime($attest,$device_no,$add_sec) {
        $sendArray = ['id'=>intval(15),'flag'=>intval(0),'attest'=>$attest,'device_no'=>$device_no,'add_sec'=>$add_sec];
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