<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/3/31
 * Time: 上午11:27
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiPrivatepag
{
    public static function apiPrivatepagList($attest,$hospital_no,$file_ver_start,$get_num,$hard_ver) {
        $sendArray = ['id'=>intval(61),'flag'=>intval(0),'data'=>['attest'=>intval($attest),
            'hospital_no'=>intval($hospital_no),'hard_ver'=>intval($hard_ver),
            'file_ver_start'=>intval($file_ver_start),'get_num'=>intval($get_num)] ];
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

    public static function apiPrivatepagAdd($attest,$hospital_no,$file_id,$remark,$hard_ver,$mid_ver,$app_ver) {
        $sendArray = ['id'=>intval(60),'flag'=>intval(0),'data'=>['attest'=>intval($attest),
            'hospital_no'=>intval($hospital_no),'mid_ver'=>intval($mid_ver),'app_ver'=>intval($app_ver),
            'hard_ver'=>intval($hard_ver),'file_id'=>$file_id,'remark'=>$remark] ];
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