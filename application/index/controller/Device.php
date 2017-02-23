<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/2/23
 * Time: 16:30
 */

namespace app\index\controller;


use app\index\api\apiDevice;
use think\controller\Rest;
use think\Request;
use think\Session;

class Device extends Rest
{
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
                print $retData['ret_code'];
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

    public  function ajax_device_get() {
        $data = [];
        $attest = Session::get('attest');
        $machine_code = Request::instance()->param('machine_code');
        $retData = apiDevice::apiDeviceGet($attest,$machine_code);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                $data = $retData['data'];
            }
        }
        return $this->response(['data'=>$data],'json',200);
    }

    public  function ajax_set_time() {
        $attest = Session::get('attest');
        $device_no= Request::instance()->param('device_no');
        $add_sec = Request::instance()->param('add_sec');

        $retData = apiDevice::apiDeviceSetTime($attest,$device_no,$add_sec);
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



















