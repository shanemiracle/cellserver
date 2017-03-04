<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/2/23
 * Time: 14:45
 */

namespace app\index\controller;


use app\index\api\apiDoctor;
use app\index\api\apiHospital;
use think\controller\Rest;
use think\Request;
use think\Session;
use think\View;

class Doctor extends Rest
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
        if( $this->attest() != true ) {
            abort(401);
        }

        $hospital_no = Request::instance()->param('hospital_no');
        $hospital_name = Request::instance()->param('hospital_name');

        return (new View())->fetch('/doctor/add',['hospital_no'=>$hospital_no,'hospital_name'=>$hospital_name]);
    }

    public function index() {
        if( $this->attest() != true ) {
            abort(401);
        }
        $data_list = [];
        $d_ho_no = Session::get('default_device_hos_no');
        $d_ho_name = Session::get('default_device_hos_name');
        $retData = apiHospital::apiHospitalGet(Session::get('attest'),0,100);
        if($retData) {
            if($retData['ret_code'] == 0) {
                $num = count($retData['data']);
                for($i = 0; $i < $num; $i++) {
                    if($retData['data'][$i]['hospital_no'] == $d_ho_no) {
                        continue;
                    }
                    array_push($data_list,[
                        'hospital_no'=>$retData['data'][$i]['hospital_no'],
                        'hospital_name'=>$retData['data'][$i]['hospital_name'],
                    ]);
                }
            }
        }

        $data=['default_value'=>($d_ho_no?$d_ho_no:'-1'),'default_name'=>($d_ho_name?$d_ho_name:''),'count'=>count($data_list),'data'=>$data_list];
        return (new View())->fetch('/doctor/index',$data);
    }

    public  function ajax_list() {
        $data = [];
        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');
        $retData = apiDoctor::apiDoctorGet($attest,$hospital_no,"",100);
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



















