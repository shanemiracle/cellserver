<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/2/23
 * Time: 14:45
 */

namespace app\index\controller;


use app\index\api\apiDoctor;
use think\controller\Rest;
use think\Request;
use think\Session;

class Doctor extends Rest
{
    public  function ajax_list() {
        $data = [];
        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');
        $doctor_start = Request::instance()->param('doctor_start');
        $get_num = Request::instance()->param('get_num');
        $retData = apiDoctor::apiDoctorGet($attest,$hospital_no,$doctor_start,$get_num);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                $data = $retData['data'];
            }
        }
        return $this->response(['data'=>$data],'json',200);
    }

    public  function ajax_name_get_no() {
        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');
        $doctor_name = Request::instance()->param('doctor_name');
        $retData = apiDoctor::apiDoctorNameGet($attest,$doctor_name,$hospital_no);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;//表示这个医生名存在
            }
            else if($retData['ret_code'] == 0x23 ) {
                print 1;//表示这个医生名不存在
            }
            else{
                print $retData['ret_code'];
            }

        }
        else {
            print 10000;
        }
    }

    public  function ajax_add() {
        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');
        $doctor_name = Request::instance()->param('doctor_name');
        $pwd = Request::instance()->param('pwd');
        $level = Request::instance()->param('level');
        $department = Request::instance()->param('department');
        $logo = Request::instance()->param('logo');
        $sign_pic = Request::instance()->param('sign_pic');
        $mobile_no = Request::instance()->param('mobile_no');
        $role = Request::instance()->param('role');
        $learn_level = Request::instance()->param('learn_level');
        $retData = apiDoctor::apiDoctorAdd($attest,$doctor_name,$pwd,$hospital_no,$level,
            $department,$logo,$sign_pic,$mobile_no,$role,$learn_level);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else{
                print $retData['ret_code'];
            }

        }
        else {
            print 10000;
        }
    }

    public  function ajax_set() {
        $attest = Session::get('attest');
        $doctor_no = Request::instance()->param('doctor_no');
        $doctor_ver = Request::instance()->param('doctor_ver');
        $pwd = Request::instance()->param('pwd');
        $level = Request::instance()->param('level');
        $department = Request::instance()->param('department');
        $logo = Request::instance()->param('logo');
        $sign_pic = Request::instance()->param('sign_pic');
        $mobile_no = Request::instance()->param('mobile_no');
        $role = Request::instance()->param('role');
        $learn_level = Request::instance()->param('learn_level');
        $retData = apiDoctor::apiDoctorSet($attest,$doctor_no,$doctor_ver,$pwd,$level,
            $department,$logo,$sign_pic,$mobile_no,$role,$learn_level);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else{
                print $retData['ret_code'];
            }

        }
        else {
            print 10000;
        }
    }
    public  function ajax_drop() {
        $attest = Session::get('attest');
        $doctor_no = Request::instance()->param('doctor_no');
        $retData = apiDoctor::apiDoctorDrop($attest,$doctor_no);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else{
                print $retData['ret_code'];
            }

        }
        else {
            print 10000;
        }
    }

}



















