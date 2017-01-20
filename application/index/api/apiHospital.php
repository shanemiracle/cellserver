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
    /**
     * @param $attest 2
     * @param $hospital_name
     * @param $hospital_number
     * @param $zone
     * @param $logo
     * @param $level
     * @return bool|mixed
     */
    public static function apiHospitalAdd($attest,$hospital_name,$hospital_number,$zone,$logo,$level) {
        $sendArray = ['id'=>intval(2),'flag'=>intval(0),'data'=>['attest'=>intval($attest), 'hospital_name'=>$hospital_name,
                'hospital_number'=>$hospital_number,'zone'=>$zone,'logo'=>$logo,'level'=>$level]];
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

    public static function apiHospitalSet($attest,$hospital_no,$hospital_ver,$zone,$hospital_name,$logo,$level) {
        $sendArray = ['id'=>intval(3),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'hospital_name'=>$hospital_name,
            'hospital_ver'=>$hospital_ver,'hospital_no'=>$hospital_no,'zone'=>$zone,'logo'=>$logo,'level'=>$level]];
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
        $sendArray = ['id'=>intval(4),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'hospital_start'=>intval($hospital_start),
            'get_num'=>intval($get_num)] ];
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
        $sendArray = ['id'=>intval(5),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'hospital_number'=>$hospital_number] ];
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
        $sendArray = ['id'=>intval(6),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'hospital_no'=>intval($hospital_no) ]];
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