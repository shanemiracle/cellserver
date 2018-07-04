<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2018/7/3
 * Time: 12:52
 */

namespace app\index\controller;

use app\index\api\apiElastic;
use think\Request;

class Elastic
{
    public function index()
    {
       // $time = Request::instance()->param('time');
        //$hos = Request::instance()->param('hos');
        $es = new apiElastic();
//        $data = $es->getPro(0,500,'2017-01-01 12:00:00',65536002);
//        return json($data);

//        print_r($data);
        //return json($data)->options(['json_encode_param'=>JSON_PRETTY_PRINT]);
        return 0;
    }

    public function project()
    {
        $time = Request::instance()->param('time');
        $hos = Request::instance()->param('hos');
        $per = Request::instance()->param('per');
        $es = new apiElastic();
        if($time==null){
            $time = "2000-01-01 00:00:00";
        }
        $data = $es->getProject(0,500,$time,$hos,$per);

        return json($data)->options(['json_encode_param'=>JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE]);
    }

    public function photo()
    {
        $is_select = Request::instance()->param('is_select');
        if( null == $is_select ){
            $is_select = 1;
        }

        $es = new apiElastic();
        $data = $es->getPhoto(0,500,$is_select);

        return json($data)->options(['json_encode_param'=>JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE]);
    }

    public function cell()
    {
        $is_select = Request::instance()->param('is_select');
        if( null == $is_select ){
            $is_select = 1;
        }

        $es = new apiElastic();
        $data = $es->getCell(0,500,$is_select);

        return json($data)->options(['json_encode_param'=>JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE]);
    }

    public function init()
    {
        $es = new apiElastic();
        print_r($es->apiDelIndex('project'));
        print_r($es->apiDelIndex('photo'));
        print_r($es->apiDelIndex('cell'));

        print_r($es->apiAddIndexProject());
        print_r($es->apiAddIndexPhoto());
        print_r($es->apiAddIndexCell());

        return json(['ret'=>'ok']);
    }


}