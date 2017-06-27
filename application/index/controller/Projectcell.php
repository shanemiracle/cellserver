<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/6/23
 * Time: 下午5:05
 */

namespace app\index\controller;


use app\index\table\tableSearchProject;
use think\controller\Rest;
use think\Request;
use think\View;

class Projectcell extends Rest
{
    public function index() {

        return (new View())->fetch('/projectcell/index');
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

}