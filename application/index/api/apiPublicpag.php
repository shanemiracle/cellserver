<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/3/31
 * Time: 上午11:27
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiPublicpag
{
    public static function apiPublicpagList($attest,$hard_ver,$upgrade_index_start,$get_num) {
        $sendArray = ['id'=>intval(66),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'hard_ver'=>intval($hard_ver),
            'upgrade_index_start'=>intval($upgrade_index_start),'get_num'=>intval($get_num)] ];
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

    public static function apiPublicpagAdd($attest,$app_vercode,$app_ver,$mid_ver,
        $upgrade_file_id,$upgrade_remark,$hard_ver) {
        $sendArray = ['id'=>intval(67),'flag'=>intval(0),'data'=>['attest'=>intval($attest),'hard_ver'=>intval($hard_ver),
            'app_vercode'=>$app_vercode,'app_ver'=>intval($app_ver),'mid_ver'=>intval($mid_ver),
            'upgrade_file_id'=>$upgrade_file_id, 'upgrade_remark'=>$upgrade_remark] ];
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