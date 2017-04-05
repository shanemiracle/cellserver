<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/3/31
 * Time: 下午1:46
 */

namespace app\index\controller;


use app\index\api\apiHospital;
use app\index\api\apiPrivatepag;
use think\controller\Rest;
use think\Request;
use think\Session;
use think\View;

class Privatepag extends Rest
{
    private function attest(){
        $attest = Session::get('attest');
        $retData = apiHospital::apiHospitalGet($attest,0,0);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                return true;
            }
        }

        return false;
    }

    public function add() {
        if ($this->attest() != true) {
            abort(401);
        }

        $hard_ver = Request::instance()->param('hard_ver');
        $hospital_no = Request::instance()->param('hospital_no');
        $hospital_name = Request::instance()->param('hospital_name');
        if( $hard_ver == 1){
            $hard_name = "采集端程序";
        }
        else if( $hard_ver == 2){
            $hard_name = "审核端程序";
        }
        else if( $hard_ver == 3){
            $hard_name = "观察者端程序";
        }
        else if( $hard_ver == 4){
            $hard_name = "会诊端程序";
        }
        else{
            $hard_ver = 1;
            $hard_name = "采集端程序";
        }

        return (new View())->fetch('/privatepag/add',['hard_name'=>$hard_name, 'hard_ver'=>$hard_ver,
            'hospital_no'=>$hospital_no,'hospital_name'=>$hospital_name]);

    }

    public function index() {
        if( $this->attest() != true ) {
            abort(401);
        }
        $data_list = [];
        $hard_ver = Session::get('private_hard_ver');
        $d_ho_no = Session::get('default_device_hos_no');
        $d_ho_name = Session::get('default_device_hos_name');
        $retData = apiHospital::apiHospitalGet(Session::get('attest'), 0, 100);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                $num = count($retData['data']);
                for ($i = 0; $i < $num; $i++) {
                    if ($retData['data'][$i]['hospital_no'] == $d_ho_no) {
                        continue;
                    }
                    array_push($data_list, [
                        'hospital_no' => $retData['data'][$i]['hospital_no'],
                        'hospital_name' => $retData['data'][$i]['hospital_name'],
                    ]);
                }
            }
        }

        $data = ['default_value' => ($d_ho_no ? $d_ho_no : '-1'), 'default_name' => ($d_ho_name ? $d_ho_name : ''),
            'count' => count($data_list), 'data' => $data_list,
        'total_num'=>0,'hard_ver'=>$hard_ver];
        return (new View())->fetch('/privatepag/index', $data);
    }

    public function ajax_count() {
        $attest = Session::get('attest');
        $hard_ver = Request::instance()->param('hard_ver');
        $hospital_no = Request::instance()->param('hospital_no');
        $retData = apiPrivatepag::apiPrivatepagList($attest,$hospital_no,0,0,$hard_ver);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print $retData['total_num'];
            }
            else{
                print 0;
            }
        }
        else {
            print 0;
        }
    }

    public  function ajax_add() {
        $attest = Session::get('attest');
        $hard_ver = Request::instance()->param('hard_ver');
        $hospital_no = Request::instance()->param('hospital_no');
        $file_id = Request::instance()->param('file_id');
        $remark = Request::instance()->param('remark');

        $retData = apiPrivatepag::apiPrivatepagAdd($attest,$hospital_no,$file_id,$remark,$hard_ver);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else {
                print $retData['err_desc'];
            }
        }
        else {
            print 10000;
        }
    }

    public function ajax_hard_ver(){
        $hard_ver = Request::instance()->param('hard_ver');

        Session::set('private_hard_ver',$hard_ver);
    }


    public  function ajax_list() {
        $attest = Session::get('attest');
        $hard_ver = Request::instance()->param('hard_ver');
        $hospital_no = Request::instance()->param('hospital_no');
        $allData = [];
        $get_num = 0;

        $start = 0xFFFFFFFF;
        for($i=0;$i<1000;$i++){
            $retData = apiPrivatepag::apiPrivatepagList($attest,$hospital_no,$start,10,$hard_ver);
            if ($retData) {
                if ($retData['ret_code'] == 0) {
                    $total_num = $retData['total_num'];
                    $data = $retData['data'];
                    $this_num = count($data);
                    $get_num += $this_num;


                    $allData = array_merge($allData,$data);
                    if( $this_num != 0 ) {
                        $start = $data[count($data)-1]['file_ver'];
                    }
                    else {
                        break;
                    }

                }
                else{
                    break;
                }
            }
            else{
                break;
            }

            if($total_num==$get_num) {
                break;
            }
        }

        return $this->response(['data' => $allData], 'json', 200);

    }
}