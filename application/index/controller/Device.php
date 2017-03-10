<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/2/23
 * Time: 16:30
 */

namespace app\index\controller;


use app\index\api\apiDevice;
use app\index\api\apiHospital;
use think\controller\Rest;
use think\Request;
use think\Session;
use think\View;

class Device extends Rest
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

        public function edit() {
            if( $this->attest() != true ) {
                abort(401);
            }

            $machine_code = Request::instance()->param('machine_code');
            $hospital_name = Request::instance()->param('hospital_name');
            $data = [];

            $retData = apiDevice::apiDeviceGet(Session::get('attest'),$machine_code);
            if($retData) {
                if($retData['ret_code']==0) {
                    $data = ['machine_code'=>$machine_code,'hospital_name'=>$hospital_name,'device_no'=>$retData['device_no'],
                        'info_ver'=>$retData['info_ver'],
                        'create_time'=>$retData['create_time'],
                        'end_time'=>$retData['end_time']];
                }

            }

            return (new View())->fetch('/device/edit',$data);
        }

        public function add() {
            if( $this->attest() != true ) {
                abort(401);
            }

            $hospital_no = Request::instance()->param('hospital_no');
            $hospital_name = Request::instance()->param('hospital_name');

            return (new View())->fetch('/device/add',['hospital_no'=>$hospital_no,'hospital_name'=>$hospital_name]);
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
            return (new View())->fetch('/device/index',$data);
        }

        public function ajax_default_set() {
            $hospital_no = Request::instance()->param('hospital_no');
            $hospital_name = Request::instance()->param('hospital_name');

            Session::set('default_device_hos_no',$hospital_no);
            Session::set('default_device_hos_name',$hospital_name);

            print 0;
        }

        public  function ajax_add() {
        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');
        $machine_code = Request::instance()->param('machine_code');
        $valid_sec = Request::instance()->param('valid_sec');

        $retData = apiDevice::apiDeviceAdd($attest,$machine_code,$hospital_no,$valid_sec);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else{
                print $retData['err_desc'];
            }

        }
        else {
            print 10000;
        }
    }

    public  function ajax_list() {
        $data = [];
        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');
        $retData = apiDevice::apiDeviceHospitalGet($attest,$hospital_no);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                $data = $retData['data'];
            }
        }
        return $this->response(['data'=>$data],'json',200);
    }

    public  function ajax_exist() {
        $data = [];
        $attest = Session::get('attest');
        $machine_code = Request::instance()->param('machine_code');
        $retData = apiDevice::apiDeviceGet($attest,$machine_code);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                return false;
            }
            else if($retData['ret_code'] == 0x26){
                return true;
            }
        }
        return false;
    }

    public  function ajax_set_time() {
        $attest = Session::get('attest');
        $device_no= Request::instance()->param('device_no');
        $info_ver= Request::instance()->param('info_ver');
        $add_sec = Request::instance()->param('add_sec');

        $retData = apiDevice::apiDeviceSetTime($attest,$device_no,$info_ver,$add_sec);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else{
                print $retData['err_desc'];
            }

        }
        else {
            print 10000;
        }
    }

    public  function ajax_drop() {
        $attest = Session::get('attest');
        $machine_code = Request::instance()->param('machine_code');

        $retData = apiDevice::apiDeviceDrop($attest,$machine_code);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else{
                print $retData['err_desc'];
            }

        }
        else {
            print 10000;
        }
    }
}



















