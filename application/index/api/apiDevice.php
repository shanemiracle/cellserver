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
        $sendArray = ['id'=>intval(12),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'machine_code'=>$machine_code,
            'hospital_no'=>intval($hospital_no),'valid_sec'=>intval($valid_sec)*86400]];
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
        $sendArray = ['id'=>intval(13),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'hospital_no'=>intval($hospital_no)]];
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
        $sendArray = ['id'=>intval(14),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'machine_code'=>$machine_code]];
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

    public static function apiDeviceSetTime($attest,$device_no,$info_ver,$add_sec) {
        $sendArray = ['id'=>intval(15),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'device_no'=>$device_no
           ,'info_ver'=>intval($info_ver),'add_sec'=>intval($add_sec)*86400]];
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

    public static function apiDeviceDrop($attest,$machine_code){
        $sendArray = ['id'=>intval(22),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'machine_code'=>$machine_code]];
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