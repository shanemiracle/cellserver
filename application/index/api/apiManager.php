<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/5/8
 * Time: 16:19
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiManager
{
    public static function apiManagerAdd($attest,$user_name,$password,$mobile_no,$power_data) {
        $sendArray = ['id'=>intval(81),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'doctor_name'=>$user_name,
           'password'=>$password, 'mobile_no'=>$mobile_no,'power_data'=>$power_data]];
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

    public static function apiManagerSet($attest,$manager_no,$info_ver,$password,$power_data) {
        $sendArray = ['id'=>intval(82),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'manager_no'=>intval($manager_no),
            'info_ver'=>intval($info_ver),'password'=>$password,'power_data'=>$power_data]];
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

    public static function apiManagerDrop($attest,$manager_no) {
        $sendArray = ['id'=>intval(83),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'manager_no'=>intval($manager_no)] ];
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

    public static function apiManagerList($attest,$manager_start,$get_num) {
        $sendArray = ['id'=>intval(84),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'manager_start'=>intval($manager_start),
            'get_num'=>intval($get_num)]];
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
    public static function apiManagerGet($attest,$manager_no) {
        $sendArray = ['id'=>intval(85),'flag'=>intval(0),'data'=>['attest'=>intval($attest),
            'manager_no'=>intval($manager_no)]];
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
    public static function apiManagerHospitalAdd($attest,$manager_no,$hospital_no) {
        $sendArray = ['id'=>intval(86),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'manager_no'=>intval($manager_no),
            'hospital_no'=>intval($hospital_no)]];
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

    public static function apiManagerHospitalDrop($attest,$manager_no,$hospital_no) {
        $sendArray = ['id'=>intval(87),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'manager_no'=>intval($manager_no),
            'hospital_no'=>intval($hospital_no)]];
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

    public static function apiManagerHospitalList($attest,$manager_no,$hospital_start,$get_num) {
        $sendArray = ['id'=>intval(88),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'manager_no'=>intval($manager_no),
            'hospital_start'=>intval($hospital_start),'get_num'=>intval($get_num)]];
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
    public static function apiManagerNameGet($attest,$user_name) {
        $sendArray = ['id'=>intval(89),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'user_name'=>$user_name]];
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