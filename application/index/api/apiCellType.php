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
    public static function apiCellTypeAdd($attest,$check_type,$father_cell_type,$cn_name,$en_name,$abb_name,$size_max,$size_min,$remark) {
        $sendArray = ['id'=>intval(16),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'father_cell_type'=>intval($father_cell_type),'cn_name'=>$cn_name,'en_name'=>$en_name,'abb_name'=>$abb_name,
            'size_max'=>intval($size_max),'size_min'=>intval($size_min),'remark'=>$remark] ];
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

    public static function apiCellTypeDrop($attest,$check_type,$cell_type) {
        $sendArray = ['id'=>intval(17),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),'cell_type'=>intval($cell_type)] ];
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

    public static function apiCellTypeList($attest,$check_type,$cell_start,$get_num) {
        $sendArray = ['id'=>intval(18),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),'cell_start'=>intval($cell_start),'get_num'=>intval($get_num)] ];
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

    public static function apiCellTypeSonList($attest,$check_type,$cell_type) {
        $sendArray = ['id'=>intval(30),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),'cell_type'=>intval($cell_type)] ];
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

    public static function apiCellTypeGet($attest,$check_type,$cell_type) {
        $sendArray = ['id'=>intval(31),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),'cell_type'=>intval($cell_type)] ];
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

    public static function apiCellTypeSet($attest,$check_type,$cell_type,$info_ver,$cn_name,$en_name,$abb_name,$size_max,$size_min,$remark) {
        $sendArray = ['id'=>intval(32),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'check_type'=>intval($check_type),
            'cell_type'=>intval($cell_type), 'info_ver'=>intval($info_ver),'cn_name'=>$cn_name,'en_name'=>$en_name,'abb_name'=>$abb_name,
            'size_max'=>intval($size_max),'size_min'=>intval($size_min),'remark'=>$remark] ];
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