<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/6/23
 * Time: 下午5:05
 */

namespace app\index\controller;


use app\index\api\apiHospital;
use app\index\api\apiProjectCell;
use app\index\table\tableSearchProject;
use think\controller\Rest;
use think\Request;
use think\Session;
use think\View;

class Projectcell extends Rest
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
        if ($this->attest() != true) {
            return (new View())->fetch('login/index');
        }

        return (new View())->fetch('/projectcell/index');

    }
    public function chart() {
        if ($this->attest() != true) {
            return (new View())->fetch('login/index');
        }

        return (new View())->fetch('/projectcell/chart');

    }

    public function ajax_list() {
        $hospital_no = Request::instance()->param('hos_no');
        $start_time = Request::instance()->param('s_time');
        $end_time = Request::instance()->param('e_time');

        if( $hospital_no == -1 ) {
            $hospital_no = null;
        }


        $data = tableSearchProject::getSearchCell($hospital_no,null,null,$start_time,$end_time,0,0);

        return $this->response(['data' => $data], 'json', 200);
    }

    public function ajax_download_create()
    {
        $attest = Session::get('attest');

        $request_id = Request::instance()->param('request_id');
        $id_list = Request::instance()->param('id_list');

        $data = apiProjectCell::apiProjectCellCreate($attest,$request_id,$id_list);

        if( $data ) {
            if( $data['ret_code'] == 0 ) {
                print 0;
            }
            else {
                print $data['err_desc'];
            }
        }
        else {
            print 10000;
        }

    }

    public function ajax_download_progress()
    {
        $attest = Session::get('attest');

        $request_id = Request::instance()->param('request_id');

        $data = apiProjectCell::apiProjectCellProgress($attest,$request_id);

        if( $data ) {
            return $this->response($data, 'json', 200);
        }
        else {
            return null;
        }
    }

    public function ajax_download_cancel()
    {
        $attest = Session::get('attest');

        $request_id = Request::instance()->param('request_id');

        $data = apiProjectCell::apiProjectCellCancel($attest,$request_id);

        if( $data ) {
            if( $data['ret_code'] == 0 ) {
                print 0;
            }
            else {
                print $data['err_desc'];
            }
        }
        else {
            print 10000;
        }

    }

}