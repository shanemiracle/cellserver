<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/3
 * Time: 15:26
 */

namespace app\index\controller;


use app\index\api\apiDiagCheck;
use app\index\api\apiCheckType;
use app\index\api\apiHospital;
use think\controller\Rest;
use think\Request;
use think\Session;
use think\View;

class DiagCheck extends Rest
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

        return (new View())->fetch('/DiagCheck/index');
    }

    public function add() {
        if ($this->attest() != true) {
            abort(401);
        }

        return (new View())->fetch('/DiagCheck/add');
    }

    public function edit() {
        if ($this->attest() != true) {
            abort(401);
        }

        $diag_check_type = Request::instance()->param('diag_check_type');
        $data = [];

        $retData = apiDiagCheck::apiDiagCheckGet(Session::get('attest'),1,$diag_check_type);
        if($retData) {
            if($retData['ret_code'] == 0) {
                $data = ['diag_check_type'=>$diag_check_type,'info_ver'=>$retData['info_ver'],
                    'cn_name'=>$retData['cn_name'],'en_name'=>$retData['en_name'],
                    'expression'=>$retData['expression'],'remark'=>$retData['remark']];
            }
        }

        return (new View())->fetch('/DiagCheck/edit', $data);
    }

    public  function ajax_add() {
        $attest = Session::get('attest');
//        $check_type = Request::instance()->param('check_type');
        $cn_name = Request::instance()->param('cn_name');
        $en_name = Request::instance()->param('en_name');
        $expression = Request::instance()->param('expression');
        $remark = Request::instance()->param('remark');
        $retData = apiDiagCheck::apiDiagCheckAdd($attest,1,$cn_name,$en_name,$expression,$remark);
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
//        $check_type = Request::instance()->param('check_type');
        $diag_check_type = Request::instance()->param('diag_check_type');
        $retData = apiDiagCheck::apiDiagCheckDrop($attest,1,$diag_check_type);
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
//        $check_type = Request::instance()->param('check_type');
//        $cell_per_start = Request::instance()->param('cell_per_start');
//        $get_num = Request::instance()->param('get_num');
        $allData = [];
        $data = [];
        $total_num = 0;
        $get_num = 0;

        $start = 0;
        for($i=0;$i<10;$i++){
            $retData = apiDiagCheck::apiDiagCheckList($attest,1,$start,10);
            if ($retData) {
                if ($retData['ret_code'] == 0) {
                    $total_num = $retData['total_num'];
                    $data = $retData['data'];
                    $this_num = count($data);
                    $get_num += $this_num;


                    $allData = array_merge($allData,$data);
                    if( $this_num != 0 ) {
                        $start = $data[count($data)-1]['diag_check_type'];
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


    public  function ajax_edit() {
        $attest = Session::get('attest');
//        $check_type = Request::instance()->param('check_type');
        $diag_check_type = Request::instance()->param('diag_check_type');
        $info_ver = Request::instance()->param('info_ver');
        $cn_name = Request::instance()->param('cn_name');
        $en_name = Request::instance()->param('en_name');
        $expression = Request::instance()->param('expression');
        $remark = Request::instance()->param('remark');
        $retData = apiDiagCheck::apiDiagCheckSet($attest,1,$diag_check_type,$info_ver,$cn_name,$en_name,$expression,$remark);
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