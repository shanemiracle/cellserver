<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/7/3
 * Time: 下午2:27
 */

namespace app\index\api;


use app\index\cell\Cell;

class apiProjectCell
{
    public static function apiProjectCellCreate($attest,$request_id,$id_list) {
        $sendArray = ['id'=>intval(91),'flag'=>intval(0),'data'=>['attest'=>intval($attest),
            'request_id'=>$request_id,'data'=>$id_list] ];
        $sendData = json_encode($sendArray);
        if($sendData){
            $recvData = Cell::searchSend($sendData);
            if($recvData) {
                $recvArray = json_decode($recvData,true);

                if($recvArray) {
                    return $recvArray;
                }
            }
        }
        return false;
    }

    public static function apiProjectCellProgress($attest,$request_id) {
        $sendArray = ['id'=>intval(92),'flag'=>intval(0),'data'=>['attest'=>intval($attest),
            'request_id'=>$request_id] ];
        $sendData = json_encode($sendArray);
        if($sendData){
            $recvData = Cell::searchSend($sendData);
            if($recvData) {
                $recvArray = json_decode($recvData,true);

                if($recvArray) {
                    return $recvArray;
                }
            }
        }
        return false;
    }

    public static function apiProjectCellCancel($attest,$request_id) {
        $sendArray = ['id'=>intval(93),'flag'=>intval(0),'data'=>['attest'=>intval($attest),
            'request_id'=>$request_id] ];
        $sendData = json_encode($sendArray);
        if($sendData){
            $recvData = Cell::searchSend($sendData);
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