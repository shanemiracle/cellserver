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
        $sendArray = ['id'=>intval(19),'flag'=>intval(0),'attest'=>$attest,'hospital_no'=>$hospital_no,'check_type'=>$check_type ];
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
        $sendArray = ['id'=>intval(20),'flag'=>intval(0),'attest'=>$attest,'hospital_no'=>$hospital_no,
            'check_type'=>$check_type,'info_ver'=>$info_ver,'data'=>$data ];
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