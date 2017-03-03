<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/3
 * Time: 14:31
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiCellPerType
{
    public static function apiCellPerTypeAdd($attest,$check_type,$per_name,$expression,$remark) {
        $sendArray = ['id'=>intval(33),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
           'per_name'=>$per_name,'expression'=>$expression,'remark'=>$remark] ];
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

    public static function apiCellPerTypeDrop($attest,$check_type,$cell_per_type) {
        $sendArray = ['id'=>intval(34),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'cell_per_type'=>intval($cell_per_type)] ];
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

    public static function apiCellPerTypeList($attest,$check_type,$cell_per_start,$get_num) {
        $sendArray = ['id'=>intval(35),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'cell_per_start'=>intval($cell_per_start),'get_num'=>intval($get_num)] ];
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

    public static function apiCellPerTypeGet($attest,$check_type,$cell_per_type) {
        $sendArray = ['id'=>intval(36),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'cell_per_type'=>intval($cell_per_type)] ];
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

    public static function apiCellPerTypeSet($attest,$check_type,$cell_per_type,$info_ver,$per_name,$expression,$remark) {
        $sendArray = ['id'=>intval(37),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'cell_per_type'=>intval($cell_per_type),'info_ver'=>intval($info_ver),'per_name'=>$per_name,'expression'=>$expression,'remark'=>$remark] ];
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