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
        $user = Request::instance()->param('user');
        $from = Request::instance()->param('from');
        $size = Request::instance()->param('size');
        $perst = Request::instance()->param('perst');
        $pered = Request::instance()->param('pered');
        $es = new apiElastic();
        if($time==null){
            $time = "0000000000000000";
        }
        if($perst == null){
            $perst = 0;
        }
        if($pered == null){
            $pered = 10000;
        }
        if($from == null){
            $from = 0;
        }

        if($size == null){
            $size = 10000;
        }
        else{
            if($size > 10000)
            {
                $size = 10000;
            }
        }

        $data = $es->getProject(intval($from),intval($size),$time,$hos,$user,intval($perst),intval($pered));

        return json($data)->options(['json_encode_param'=>JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE]);
    }

    public function projectLine()
    {
        $time = Request::instance()->param('time');
        $hos = Request::instance()->param('hos');
        $from = Request::instance()->param('from');
        $size = Request::instance()->param('size');
        $user = Request::instance()->param('user');
        $perst = Request::instance()->param('perst');
        $pered = Request::instance()->param('pered');
        $es = new apiElastic();
        if($time==null){
            $time = "0000000000000000";
        }
        if($perst == null){
            $perst = 0;
        }
        if($pered == null){
            $pered = 10000;
        }
        if($from == null){
            $from = 0;
        }

        if($size == null){
            $size = 10000;
        }
        else{
            if($size > 10000)
            {
                $size = 10000;
            }
        }


        $data = $es->getProject(intval($from),intval($size),$time,$hos,$user,intval($perst),intval($pered));

        $r_data = [];

        $d = $data['data'];
        $all = count($d);
        for($i =0; $i < $all; $i++)
        {
            $this_one = $all - $i - 1;
            array_push($r_data,[$d[$this_one]['end_time'],$d[$this_one]['percent']]);
        }

        return json($r_data);

    }

    public function photo()
    {
        $from = Request::instance()->param('from');
        $size = Request::instance()->param('size');
        $is_select = Request::instance()->param('is_select');
        if( null == $is_select ){
            $is_select = 1;
        }

        if($from == null){
            $from = 0;
        }

        if($size == null){
            $size = 10000;
        }
        else{
            if($size > 10000)
            {
                $size = 10000;
            }
        }

        $es = new apiElastic();
        $data = $es->getPhoto(intval($from),intval($size),intval($is_select));


        return json($data)->options(['json_encode_param'=>JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE]);
    }

    public function cell()
    {
        $from = Request::instance()->param('from');
        $size = Request::instance()->param('size');
        $project = Request::instance()->param('project');
        $type = Request::instance()->param('type');
        $is_select = Request::instance()->param('is_select');
        if( null == $is_select ){
            $is_select = 1;
        }

        if($from == null){
            $from = 0;
        }

        if($size == null){
            $size = 10000;
        }
        else{
            if($size > 10000)
            {
                $size = 10000;
            }
        }


        $es = new apiElastic();

        $data = $es->getCell(intval($from),intval($size),intval($is_select),$project,$type);

        return json($data)->options(['json_encode_param'=>JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE]);
    }

    public function initProject()
    {
        $es = new apiElastic();
       // print_r($es->apiDelIndex('project'));

        print_r($es->apiAddIndexProject());

        return json(['ret'=>'ok']);
    }

    public function initPhoto()
    {
        $es = new apiElastic();
     //   print_r($es->apiDelIndex('photo'));

        print_r($es->apiAddIndexPhoto());

        return json(['ret'=>'ok']);
    }

    public function initCell()
    {
        $es = new apiElastic();
      //  print_r($es->apiDelIndex('cell'));

        print_r($es->apiAddIndexCell());

        return json(['ret'=>'ok']);
    }

    public function init()
    {
        $es = new apiElastic();
     //   print_r($es->apiDelIndex('cell'));
     //   print_r($es->apiDelIndex('photo'));
     //   print_r($es->apiDelIndex('project'));

        print_r($es->apiAddIndexCell());
        print_r($es->apiAddIndexPhoto());
        print_r($es->apiAddIndexProject());

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