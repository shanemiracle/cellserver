<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/2/9
 * Time: 下午2:27
 */

namespace app\index\controller;


use app\index\api\apiHospital;
use app\index\tool\Ext;
use think\controller\Rest;
use think\Request;
use think\response\Redirect;
use think\Session;
use think\View;

class Hospital extends Rest
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

    public function index() {
        if( $this->attest() != true ) {
            return (new View())->fetch('login/index');
        }

        return (new View())->fetch('/hospital/index',['total_num'=>0]);
    }

    public function add() {
        if( $this->attest() != true ) {
            return (new View())->fetch('login/index');
        }

        return (new View())->fetch('/hospital/add');
    }

    public function edit() {

        if( $this->attest() != true ) {
            return (new View())->fetch('login/index');
        }

        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');
        $data=[];
        $retData = apiHospital::apiHospitalOneGet($attest,$hospital_no);
        if($retData) {
            if($retData['ret_code']==0) {
                if(substr( $retData['logo'],10,2)!='00'){
                    $logUrl = '/file/'.substr( $retData['logo'],10,2).'/'.substr( $retData['logo'],12,30).Ext::typeToName(substr( $retData['logo'],42,2));
                }
                else{
                    $logUrl = '';
                }
//                $logUrl = '/file/'.substr( $retData['logo'],10,2).'/'.substr( $retData['logo'],12,30).Ext::typeToName(substr( $retData['logo'],42,2));

                $data = [
                    'hospital_no'=>$retData['hospital_no'],
                    'hospital_ver'=>$retData['hospital_ver'],
                    'hospital_name'=>$retData['hospital_name'],
                    'hospital_number'=>$retData['hospital_number'],
                    'zone'=>$retData['zone'],
                    'level'=>$retData['level'],
                    'logo'=>$retData['logo'],
                    'logourl'=>$logUrl
                ];
            }
        }


        return (new View())->fetch('/hospital/edit',$data);
    }

    public function ajax_count() {
        $attest = Session::get('attest');
        $retData = apiHospital::apiHospitalGet($attest,0,1);
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

    public function ajax_list()
    {
        $attest = Session::get('attest');
        $data = [];
        $allData = [];
        $get_num = 0;

        $start = 0;
        for($i=0;$i<1000;$i++){
            $retData = apiHospital::apiHospitalGet($attest, $start, 100);
            if ($retData) {
                if ($retData['ret_code'] == 0) {
                    $data = $retData['data'];
                }
            }
            if ($retData) {
                if ($retData['ret_code'] == 0) {
                    $total_num = $retData['total_num'];
                    $data = $retData['data'];
                    $this_num = count($data);
                    $get_num += $this_num;


                    $allData = array_merge($allData,$data);
                    if( $this_num != 0 ) {
                        $start = $data[count($data)-1]['hospital_no'];
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

    public  function ajax_add() {
        $attest = Session::get('attest');
        $hospital_name = Request::instance()->param('hospital_name');
        $hospital_number = Request::instance()->param('hospital_number');
        $zone = Request::instance()->param('zone');
        $logo = Request::instance()->param('logo');
        $level = Request::instance()->param('level');

        ///$data = ['hos_name'=>$hospital_name,'hos_num'=>$hospital_number,'zone'=>$zone,'logo'=>$logo,'level'=>$level];

        $retData = apiHospital::apiHospitalAdd($attest,$hospital_name,$hospital_number,$zone,$logo,$level);
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

    public  function ajax_set() {
        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');
        $hospital_ver = Request::instance()->param('hospital_ver');
        $hospital_name = Request::instance()->param('hospital_name');
        $zone = Request::instance()->param('zone');
        $logo = Request::instance()->param('logo');
        $level = Request::instance()->param('level');

        $retData = apiHospital::apiHospitalSet($attest,$hospital_no,$hospital_ver,$zone,$hospital_name,$logo,$level);
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

    public  function ajax_exist() {
        $attest = Session::get('attest');
        $hospital_number = Request::instance()->param('hospital_number');

        $retData = apiHospital::apiHospitalNumberGet($attest,$hospital_number);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {
                return false;
            }
            else if($retData['ret_code'] == 0x22){
                return true;
            }
        }
        else {
            return false;
        }
    }

    public  function ajax_drop() {
        $attest = Session::get('attest');
        $hospital_no = Request::instance()->param('hospital_no');

        $retData = apiHospital::apiHospitalDrop($attest,$hospital_no);
        if( $retData ) {
            if( $retData['ret_code'] == 0 ) {

                if( $hospital_no == Session::get('default_device_hos_no') ) {
                    Session::delete('default_device_hos_no');
                    Session::delete('default_device_hos_name');
                }

                print 0;
            }
            else {
                print $retData['err_desc'];
            }
        }        else {
            print 10000;
        }
    }
}




























