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


    public  function ajax_add() {
        $data = [];
        $attest = Session::get('attest');
        $hospital_name = Request::instance()->param('hospital_name');
        $hospital_number = Request::instance()->param('hospital_number');
        $zone = Request::instance()->param('zone');
        $logo = Request::instance()->param('logo');
        $level = Request::instance()->param('level');

        $retData = apiHospital::apiHospitalAdd($attest,$hospital_name,$hospital_number,$zone,$logo,$level);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else {
                print retData['ret_code'];
            }
        }
        print 10000;
    }

    public  function ajax_set() {
        $data = [];
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
                print retData['ret_code'];
            }
        }
        print 10000;
    }

    public  function ajax_del() {
        $data = [];
        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');

        $retData = apiHospital::apiHospitalDrop($attest,$hospital_no);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else {
                print retData['ret_code'];
            }
        }
        print 10000;
    }
}




























