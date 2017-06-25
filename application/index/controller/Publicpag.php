<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/3/31
 * Time: 下午1:46
 */

namespace app\index\controller;


use app\index\api\apiHospital;
use app\index\api\apiPrivatepag;
use app\index\api\apiPublicpag;
use think\controller\Rest;
use think\Request;
use think\Session;
use think\View;

class Publicpag extends Rest
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
        if ($this->attest() != true) {
            abort(401);
        }

        $hard_ver = Request::instance()->param('hard_ver');
        if( $hard_ver == 1){
            $hard_name = "采集端程序";
        }
        else if( $hard_ver == 2){
            $hard_name = "审核端程序";
        }
        else if( $hard_ver == 3){
            $hard_name = "观察者端程序";
        }
        else if( $hard_ver == 4){
            $hard_name = "会诊端程序";
        }
        else{
            $hard_ver = 1;
            $hard_name = "采集端程序";
//            $hard_name = "包管理"+$hard_ver;
        }

        return (new View())->fetch('/publicpag/add',['hard_name'=>$hard_name, 'hard_ver'=>$hard_ver]);

    }

    public function index() {
        if( $this->attest() != true ) {
            abort(401);
        }

        $hard_ver = Session::get('public_hard_ver');

        if($hard_ver>4||$hard_ver==0){
            $hard_ver = 1;
        }


        return (new View())->fetch('/publicpag/index',['total_num'=>0,'hard_ver'=>$hard_ver]);
    }

    public function ajax_count() {
        $attest = Session::get('attest');
        $hard_ver = Request::instance()->param('hard_ver');
        $retData = apiPublicpag::apiPublicpagList($attest,$hard_ver,0,0);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print $retData['total_num'];
            }
            else{
                print 0;
            }
        }
        else {
            print 0;
        }
    }

    public  function ajax_add() {
        $attest = Session::get('attest');
        $app_vercode = Request::instance()->param('app_vercode');
        $app_ver = Request::instance()->param('app_ver');
        $mid_ver = Request::instance()->param('mid_ver');
        $upgrade_file_id = Request::instance()->param('upgrade_file_id');
        $upgrade_remark = Request::instance()->param('upgrade_remark');
        $hard_ver = Request::instance()->param('hard_ver');

        $retData = apiPublicpag::apiPublicpagAdd($attest,$app_vercode,$app_ver,$mid_ver,$upgrade_file_id,$upgrade_remark,$hard_ver);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                print 0;
            }
            else {
                print $retData['err_desc'];
            }
        }
        else {
            print 10000;
        }
    }

    public function ajax_hard_ver(){
        $hard_ver = Request::instance()->param('hard_ver');

        Session::set('public_hard_ver',$hard_ver);
    }

    public  function ajax_list() {
        $attest = Session::get('attest');
        $hard_ver = Request::instance()->param('hard_ver');
        $allData = [];
        $get_num = 0;

        $start = 0xFFFFFFFF;
        for($i=0;$i<1000;$i++){
            $retData = apiPublicpag::apiPublicpagList($attest,$hard_ver,$start,10);
            if ($retData) {
                if ($retData['ret_code'] == 0) {
                    $total_num = $retData['total_num'];
                    $data = $retData['data'];
                    $this_num = count($data);
                    $get_num += $this_num;


                    $allData = array_merge($allData,$data);
                    if( $this_num != 0 ) {
                        $start = $data[count($data)-1]['upgrade_index'];
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
}