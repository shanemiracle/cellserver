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
use think\Request;
use think\Session;
use think\View;

class Hospital extends Rest
{
    public function index() {
        return (new View())->fetch('/hospital/index');
    }

    public function add() {

        return (new View())->fetch('/hospital/add');
    }

    public function edit() {

        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');
        $data=[];
        $retData = apiHospital::apiHospitalOneGet($attest,$hospital_no);
        if($retData) {
            if($retData['ret_code']==0) {
                $data = [
                    'hospital_no'=>$retData['hospital_no'],
                    'hospital_ver'=>$retData['hospital_ver'],
                    'hospital_name'=>$retData['hospital_name'],
                    'hospital_number'=>$retData['hospital_number'],
                    'zone'=>$retData['zone'],
                    'level'=>$retData['level'],
                    'logo'=>$retData['logo']
                ];
            }
        }


        return (new View())->fetch('/hospital/edit',$data);
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

//    public  function ajax_get_one() {
//        $attest = Session::get('attest');
//        $hospital_no = Request::instance()->param('hospital_no');
//
//        $retData = apiHospital::apiHospitalOneGet($attest,$hospital_no);
//        if( $retData ) {
//            if( $retData['ret_code'] == 0 ) {
//                print 0;
//            }
//            else {
//                print $retData['ret_code'];
//            }
//        }
//        else {
//            print 10000;
//        }
//    }

    public  function ajax_add() {
        $attest = Session::get('attest');
        $hospital_name = Request::instance()->param('hospital_name');
        $hospital_number = Request::instance()->param('hospital_number');
        $zone = Request::instance()->param('zone');
        $logo = Request::instance()->param('logo');
        $level = Request::instance()->param('level');

        ///$data = ['hos_name'=>$hospital_name,'hos_num'=>$hospital_number,'zone'=>$zone,'logo'=>$logo,'level'=>$level];

        $retData = apiHospital::apiHospitalAdd($attest,$hospital_name,$hospital_number,$zone,$logo,$level);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else {
                print $retData['ret_code'];
            }
        }
        else {
            print 10000;
        }
    }

    public  function ajax_set() {
        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');
        $hospital_ver = Request::instance()->param('hospital_ver');
        $hospital_name = Request::instance()->param('hospital_name');
        $zone = Request::instance()->param('zone');
        $logo = Request::instance()->param('logo');
        $level = Request::instance()->param('level');

        $retData = apiHospital::apiHospitalSet($attest,$hospital_no,$hospital_ver,$zone,$hospital_name,$logo,$level);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else {
                print $retData['ret_code'];
            }
        }
        else {
            print 10000;
        }
    }

    public  function ajax_exist() {
        $attest = Session::get('attest');
        $hospital_number = Request::instance()->param('hospital_number');

        $retData = apiHospital::apiHospitalNumberGet($attest,$hospital_number);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                return false;
            }
            else if($retData['ret_code'] == 0x22){
                return true;
            }
        }
        else {
            return false;
        }
    }

    public  function ajax_drop() {
        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');

        $retData = apiHospital::apiHospitalDrop($attest,$hospital_no);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else {
                print $retData['ret_code'];
            }
        }        else {
            print 10000;
        }
    }
}




























