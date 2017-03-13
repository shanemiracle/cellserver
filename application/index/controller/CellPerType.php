<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/3
 * Time: 15:26
 */

namespace app\index\controller;


use app\index\api\apiCellPerType;
use app\index\api\apiHospital;
use think\Request;
use think\Session;

class CellPerType
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




    public  function ajax_add() {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $per_name = Request::instance()->param('per_name');
        $expression = Request::instance()->param('expression');
        $remark = Request::instance()->param('remark');
        $retData = apiCellPerType::apiCellPerTypeAdd($attest,$check_type,$per_name,$expression,$remark);
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
        $cell_per_type = Request::instance()->param('cell_per_type');
        $retData = apiCellPerType::apiCellPerTypeDrop($attest,$check_type,$cell_per_type);
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
        $cell_per_start = Request::instance()->param('cell_per_start');
        $get_num = Request::instance()->param('get_num');
        $retData = apiCellPerType::apiCellPerTypeList($attest,$check_type,$cell_per_start,$get_num);
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
        $cell_per_type = Request::instance()->param('cell_per_type');
        $retData = apiCellPerType::apiCellPerTypeGet($attest,$check_type,$cell_per_type);
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
        $cell_per_type = Request::instance()->param('cell_per_type');
        $info_ver = Request::instance()->param('info_ver');
        $per_name = Request::instance()->param('per_name');
        $expression = Request::instance()->param('expression');
        $remark = Request::instance()->param('remark');
        $retData = apiCellPerType::apiCellPerTypeSet($attest,$check_type,$cell_per_type,$info_ver,$per_name,$expression,$remark);
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