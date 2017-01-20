<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/18
 * Time: 上午10:10
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiCellPer
{
    public static function apiCellPerGet($attest,$hospital_no,$check_type) {
        $sendArray = ['id'=>intval(20),'flag'=>intval(0),'data'=>['attest'=>intval($attest),
            'hospital_no'=>intval($hospital_no),'check_type'=>intval($check_type)] ];
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

    /*
     * $data {'cell_type','min_per','max_per','normal_per'}
     */
    public static function apiCellPerSet($attest,$hospital_no,$check_type,$info_ver,$data) {
        $sendArray = ['id'=>intval(21),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'hospital_no'=>intval($hospital_no),
            'check_type'=>intval($check_type),'info_ver'=>intval($info_ver),'data'=>$data] ];
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