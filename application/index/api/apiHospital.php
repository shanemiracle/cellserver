<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/16
 * Time: 下午6:23
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiHospital
{
    public static function apiHospitalAdd($attest,$hospital_name,$hospital_number,$zone,$logo,$level) {
        $sendArray = ['id'=>intval(2),'flag'=>intval(0),'attest'=>$attest, 'hospital_name'=>$hospital_name,
                'hospital_number'=>$hospital_number,'zone'=>$zone,'logo'=>$logo,'level'=>$level];
        $sendData = json_encode($sendArray);
        if($sendData) {
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

    public static function apiHospitalSet($attest,$hospital_no,$zone,$hospital_name,$logo,$level) {
        $sendArray = ['id'=>intval(3),'flag'=>intval(0),'attest'=>$attest,'hospital_name'=>$hospital_name,
            'hospital_no'=>$hospital_no,'zone'=>$zone,'logo'=>$logo,'level'=>$level];
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

    public static function apiHospitalGet($attest,$hospital_start,$get_num) {
        $sendArray = ['id'=>intval(4),'flag'=>intval(0),'attest'=>$attest,'hospital_start'=>$hospital_start,
            'get_num'=>$get_num ];
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

    public static function apiHospitalNumberGet($attest,$hospital_number) {
        $sendArray = ['id'=>intval(5),'flag'=>intval(0),'attest'=>$attest,'hospital_number'=>$hospital_number ];
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

    public static function apiHospitalDrop($attest,$hospital_no) {
        $sendArray = ['id'=>intval(6),'flag'=>intval(0),'attest'=>$attest,'hospital_no'=>$hospital_no ];
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