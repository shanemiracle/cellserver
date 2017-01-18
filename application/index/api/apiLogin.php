<?php
namespace app\index\api;

use app\index\cell\Cell;
use think\Cookie;
use think\Request;
use think\Session;

/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/16
 * Time: 上午9:47
 */
class apiLogin
{
    public static function apiLogin($user_name, $pwd) {

        $sendArray = ['id'=>intval(1),'flag'=>intval(0),'user_name'=>$user_name,'pwd'=>$pwd];
        $sendData = json_encode($sendArray);
        if($sendData) {
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