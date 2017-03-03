<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/3
 * Time: 17:00
 */

namespace app\index\controller;


use app\index\api\apiCheckType;
use think\Request;
use think\Session;

class CheckType
{
    public  function ajax_add() {
        $attest = Session::get('attest');
        $desc = Request::instance()->param('desc');
        $retData = apiCheckType::apiCheckTypeAdd($attest,$desc);
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
        $check_type = Request::instance()->param('check_type');
        $retData = apiCheckType::apiCheckTypeDrop($attest,$check_type);
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
        $check_type = Request::instance()->param('check_type');
        $info_ver = Request::instance()->param('info_ver');
        $desc = Request::instance()->param('desc');
        $retData = apiCheckType::apiCheckTypeSet($attest,$check_type,$info_ver,$desc);
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
        $attest = Session::get('attest');
        $retData = apiCheckType::apiCheckTypeList($attest);
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
    public  function ajax_get() {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $retData = apiCheckType::apiCheckTypeGet($attest,$check_type);
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