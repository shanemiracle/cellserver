<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/3
 * Time: 16:34
 */

namespace app\index\controller;


use app\index\api\apiDiagCheck;
use think\Request;
use think\Session;

class DiagCheck
{
    public  function ajax_add() {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $cn_name = Request::instance()->param('cn_name');
        $en_name = Request::instance()->param('en_name');
        $expression = Request::instance()->param('expression');
        $remark = Request::instance()->param('remark');
        $retData = apiDiagCheck::apiDiagCheckAdd($attest,$check_type,$cn_name,$en_name,$expression,$remark);
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
        $diag_check_type = Request::instance()->param('diag_check_type');
        $retData = apiDiagCheck::apiDiagCheckDrop($attest,$check_type,$diag_check_type);
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
        $check_type = Request::instance()->param('check_type');
        $diag_check_start = Request::instance()->param('diag_check_start');
        $get_num = Request::instance()->param('get_num');
        $retData = apiDiagCheck::apiDiagCheckList($attest,$check_type,$diag_check_start,$get_num);
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


    public  function ajax_get() {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $diag_check_type = Request::instance()->param('diag_check_type');
        $retData = apiDiagCheck::apiDiagCheckGet($attest,$check_type,$diag_check_type);
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

    public  function ajax_set() {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $diag_check_type = Request::instance()->param('diag_check_type');
        $info_ver = Request::instance()->param('info_ver');
        $cn_name = Request::instance()->param('cn_name');
        $en_name = Request::instance()->param('en_name');
        $expression = Request::instance()->param('expression');
        $remark = Request::instance()->param('remark');
        $retData = apiDiagCheck::apiDiagCheckSet($attest,$check_type,$diag_check_type,$info_ver,$cn_name,$en_name,$expression,$remark);
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







