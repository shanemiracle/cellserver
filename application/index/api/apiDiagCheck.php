<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/3
 * Time: 14:39
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiDiagCheck
{
    public static function apiDiagCheckAdd($attest,$check_type,$cn_name,$en_name,$expression,$remark) {
        $sendArray = ['id'=>intval(38),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'cn_name'=>$cn_name,'en_name'=>$en_name,'expression'=>$expression,'remark'=>$remark] ];
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

    public static function apiDiagCheckDrop($attest,$check_type,$diag_check_type) {
        $sendArray = ['id'=>intval(39),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'diag_check_type'=>intval($diag_check_type)]];
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
    public static function apiDiagCheckList($attest,$check_type,$diag_check_start,$get_num) {
        $sendArray = ['id'=>intval(40),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'diag_check_start'=>intval($diag_check_start),'get_num'=>intval($get_num)]];
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

    public static function apiDiagCheckGet($attest,$check_type,$diag_check_type) {
        $sendArray = ['id'=>intval(41),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'diag_check_type'=>intval($diag_check_type)]];
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

    public static function apiDiagCheckSet($attest,$check_type,$diag_check_type,$info_ver,$cn_name,$en_name,$expression,$remark) {
        $sendArray = ['id'=>intval(42),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'diag_check_type'=>intval($diag_check_type),'info_ver'=>intval($info_ver),'cn_name'=>$cn_name,'en_name'=>$en_name,'expression'=>$expression,'remark'=>$remark] ];
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