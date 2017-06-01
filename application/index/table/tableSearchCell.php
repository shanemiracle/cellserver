<?php

namespace app\index\table;

use think\Db;

/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/6/1
 * Time: 上午9:53
 */
class tableSearchCell
{
    public static function sqlGet( $hospital_no,$project_no,$sign_doctor,$start_time,$end_time ) {
        if($start_time==null || $end_time == null ) {
            return " ";
        }


        $sqlHospital = ($hospital_no==null)?'':"hospital_no='".$hospital_no."'";
        $sqlProject = ($project_no==null)?'':"project_no='".$project_no."'";
        $sqlDoctor = ($sign_doctor==null)?'':"sign_doctor='".$sign_doctor."'";
        $sql = "(select * from search_cell where end_time>'".$start_time."' and end_time<='".$end_time."') ";


        if( $hospital_no != '') {
            $sql = '(select * from '.$sql.' as t1 where '.$sqlHospital.')';
        }

        if( $sqlProject != '') {
            $sql = '(select * from '.$sql.' as t2 where '.$sqlProject.') ';
        }

        if( $sqlDoctor != '') {
            $sql = '(select * from '.$sql.' as t3 where '.$sqlDoctor.')';
        }

        return $sql;
    }


    public static function getSearchCell($hospital_no,$project_no,$sign_doctor,$start_time,$end_time ) {

        $sql = tableSearchCell::sqlGet( $hospital_no,$project_no,$sign_doctor,$start_time,$end_time );

        $data = \think\Db::query($sql);

        return $data;
    }

    public static function countSearchCell($hospital_no,$project_no,$sign_doctor,$start_time,$end_time ) {
        $sql = tableSearchCell::sqlGet( $hospital_no,$project_no,$sign_doctor,$start_time,$end_time );

        $sql = 'select count(*) from '.$sql.' as t4';

        $data = \think\Db::query($sql);

        return $data;

    }

    public static function addSearchCell($data) {
        $ret = Db::table('search_cell')->insert($data);

        return $ret == 1?0:1;
    }

}