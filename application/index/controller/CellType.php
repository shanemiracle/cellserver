<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/3
 * Time: 15:12
 */

namespace app\index\controller;


use app\index\api\apiCellType;
use think\Request;
use think\Session;

class CellType
{
    public  function ajax_add() {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $father_cell_type = Request::instance()->param('father_cell_type');
        $cn_name = Request::instance()->param('cn_name');
        $en_name = Request::instance()->param('en_name');
        $abb_name = Request::instance()->param('abb_name');
        $size_max = Request::instance()->param('size_max');
        $size_min = Request::instance()->param('size_min');
        $remark = Request::instance()->param('remark');
        $retData = apiCellType::apiCellTypeAdd($attest,$check_type,$father_cell_type,$cn_name,$en_name,$abb_name,$size_max,$size_min,$remark);
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
        $cell_type = Request::instance()->param('cell_type');
        $retData = apiCellType::apiCellTypeDrop($attest,$check_type,$cell_type);
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
        $check_type = Request::instance()->param('check_type');
        $cell_start = Request::instance()->param('cell_start');
        $get_num = Request::instance()->param('get_num');

        $retData = apiCellType::apiCellTypeList($attest,$check_type,$cell_start,$get_num);
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

    public  function ajax_son_list() {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $cell_type = Request::instance()->param('cell_type');
        $retData = apiCellType::apiCellTypeSonList($attest,$check_type,$cell_type);
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
        $cell_type = Request::instance()->param('cell_type');
        $retData = apiCellType::apiCellTypeGet($attest,$check_type,$cell_type);
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
        $cell_type = Request::instance()->param('cell_type');
        $info_ver = Request::instance()->param('info_ver');
        $cn_name = Request::instance()->param('cn_name');
        $en_name = Request::instance()->param('en_name');
        $abb_name = Request::instance()->param('abb_name');
        $size_max = Request::instance()->param('size_max');
        $size_min = Request::instance()->param('size_min');
        $remark = Request::instance()->param('remark');
        $retData = apiCellType::apiCellTypeSet($attest,$check_type,$cell_type,$info_ver,$cn_name,$en_name,$abb_name,$size_max,$size_min,$remark);
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