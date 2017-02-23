<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/2/9
 * Time: 下午2:27
 */

namespace app\index\controller;


use app\index\api\apiHospital;
use think\controller\Rest;
use think\Session;
use think\View;

class Hospital extends Rest
{
    public function index() {
        $total_num = 0;
        $attest = Session::get('attest');
        $retData = apiHospital::apiHospitalGet($attest,0,1);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                $total_num = $retData['total_num'];
            }
        }

        return (new View())->fetch('/hospital/index',['total_num'=>$total_num]);
    }

    public  function ajax_list() {
        $data = [];
        $attest = Session::get('attest');
        $retData = apiHospital::apiHospitalGet($attest,0,100);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                $data = $retData['data'];
            }
        }

        return $this->response(['data'=>$data],'json',200);
    }
}