<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/3
 * Time: 17:00
 */

namespace app\index\controller;


use app\index\api\apiCheckType;
use app\index\api\apiHospital;
use think\controller\Rest;
use think\Request;
use think\Session;
use think\View;

class CheckType extends Rest
{
    private function attest()
    {
        $attest = Session::get('attest');
        $retData = apiHospital::apiHospitalGet($attest, 0, 0);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                return true;
            }
        }

        return false;
    }

    public function index() {
        if ($this->attest() != true) {
            abort(401);
        }

        return (new View())->fetch('/checktype/index');
    }

    public function edit() {
        if ($this->attest() != true) {
            abort(401);
        }
        $check_type = Request::instance()->param('check_type');
        $data = [];

        $retData = apiCheckType::apiCheckTypeGet(Session::get('attest'), $check_type);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                $data = ['check_type'=>$check_type,'info_ver'=>$retData['info_ver'],'desc' => $retData['desc']];
            }
        }

        return (new View())->fetch('/checktype/edit',$data);
    }

    public  function ajax_add() {
        $attest = Session::get('attest');
        $desc = Request::instance()->param('desc');
        $retData = apiCheckType::apiCheckTypeAdd($attest,$desc);
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
        $check_type = Request::instance()->param('check_type');
        $retData = apiCheckType::apiCheckTypeDrop($attest,$check_type);
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

    public  function ajax_edit() {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $info_ver = Request::instance()->param('info_ver');
        $desc = Request::instance()->param('desc');
        $retData = apiCheckType::apiCheckTypeSet($attest,$check_type,$info_ver,$desc);
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
        $attest = Session::get('attest');
        $data = [];
        $retData = apiCheckType::apiCheckTypeList($attest);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                $data = $retData['data'];
            }
        }
        return $this->response(['data' => $data], 'json', 200);


    }
    public  function ajax_get() {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $retData = apiCheckType::apiCheckTypeGet($attest,$check_type);
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