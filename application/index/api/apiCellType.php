<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/17
 * Time: 下午6:59
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiCellType
{
    public static function apiCellTypeAdd($attest,$cell_name) {
        $sendArray = ['id'=>intval(16),'flag'=>intval(0),'data'=>['attest'=>$attest,'cell_name'=>$cell_name] ];
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

    public static function apiCellTypeDrop($attest,$cell_name) {
        $sendArray = ['id'=>intval(17),'flag'=>intval(0),'data'=>['attest'=>$attest,'cell_name'=>$cell_name] ];
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

    public static function apiCellTypeGet($attest,$cell_start,$get_num) {
        $sendArray = ['id'=>intval(18),'flag'=>intval(0),'data'=>['attest'=>$attest,'cell_start'=>$cell_start,'get_num'=>$get_num] ];
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

    public static function apiCellTypeCustomGet($attest,$cell_start,$get_num) {
        $sendArray = ['id'=>intval(19),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'cell_start'=>intval($cell_start),
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

}