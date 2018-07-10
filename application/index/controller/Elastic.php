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
        $size = Request::instance()->param('size');
        $perst = Request::instance()->param('perst');
        $pered = Request::instance()->param('pered');
        $es = new apiElastic();
        if($time==null){
            $time = "00000000000000";
        }
        if($perst == null){
            $per = 0;
        }
        if($pered == null){
            $per = 100;
        }

        $data = $es->getProject(0,1,$time,$hos,$perst,$pered);
        if($data)
        {
            if($size == null )
            {
                $size = $data['total'];
            }
            $data = $es->getProject(0,$size,$time,$hos,$perst,$pered);
        }

        return json($data)->options(['json_encode_param'=>JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE]);
    }

    public function projectLine()
    {
        $es = new apiElastic();
        $data = $es->getProject(0,500,"00000000000000",null,0,100);

        $r_data = [];

        $d = $data['data'];
        for($i = 0; $i < count($d); $i++)
        {
            array_push($r_data,[$d[$i]['end_time'],$d[$i]['percent']]);
        }

        return json($r_data);

    }

    public function photo()
    {
        $is_select = Request::instance()->param('is_select');
        if( null == $is_select ){
            $is_select = 1;
        }

        $es = new apiElastic();
        $data = $es->getPhoto(0,1,$is_select);
        if($data)
        {
            $data = $es->getPhoto(0,$data['total'],$is_select);
        }

        return json($data)->options(['json_encode_param'=>JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE]);
    }

    public function cell()
    {
        $is_select = Request::instance()->param('is_select');
        if( null == $is_select ){
            $is_select = 1;
        }

        $es = new apiElastic();
        $data = $es->getCell(0,1,$is_select);
        if($data)
        {
            $data = $es->getCell(0,$data['total'],$is_select);
        }

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

    public function firstinit()
    {
        $es = new apiElastic();

        print_r($es->apiAddIndexProject());
        print_r($es->apiAddIndexPhoto());
        print_r($es->apiAddIndexCell());

        return json(['ret'=>'ok']);
    }



}