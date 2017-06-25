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
    public static function sqlGet( $hospital_no,$project_no,$cell_type,$sign_doctor,$start_time,$end_time ) {
        $sql = 'FROM search_cell';

        if($hospital_no != null ) {
            $sql .= ' WHERE hospital_no='.$hospital_no;
            if($project_no != null ) {
                $sql .= " AND project_no='".$project_no."'";
            }
            if($cell_type != null) {
                $sql .= " AND cell_type=".$cell_type;
            }
            if($sign_doctor != null) {
                $sql .= " AND sign_doctor='".$sign_doctor."'";
            }
            if($start_time!=null&&$end_time!=null) {
                $sql .= " AND end_time>UNIX_TIMESTAMP('".$start_time."') AND end_time<=UNIX_TIMESTAMP('".$end_time."')";
            }
            
            return $sql;
        }


        if($cell_type != null) {
            $sql .= " WHERE cell_type=".$cell_type;
            if($project_no != null ) {
                $sql .= " AND project_no='".$project_no."'";
            }

            if($sign_doctor != null) {
                $sql .= " AND sign_doctor='".$sign_doctor."'";
            }

            if($start_time!=null&&$end_time!=null) {
                $sql .= " AND end_time>UNIX_TIMESTAMP('".$start_time."') AND end_time<=UNIX_TIMESTAMP('".$end_time."')";
            }

            return $sql;

        }

        if( $sign_doctor != null ) {
            $sql .= ' WHERE sign_doctor='.$sign_doctor;
            if($project_no != null ) {
                $sql .= " AND project_no='".$project_no."'";
            }
            if($start_time!=null&&$end_time!=null) {
                $sql .= " AND end_time>UNIX_TIMESTAMP('".$start_time."') AND end_time<=UNIX_TIMESTAMP('".$end_time."')";
            }

            return $sql;
        }

        if($project_no!=null) {
            $sql .= " WHERE project_no='".$project_no."'";
            if($start_time!=null&&$end_time!=null) {
                $sql .= " AND end_time>UNIX_TIMESTAMP('".$start_time."') AND end_time<=UNIX_TIMESTAMP('".$end_time."')";
            }

            return $sql;
        }

        if($start_time!=null&&$end_time!=null) {
            $sql .= " WHERE end_time>UNIX_TIMESTAMP('".$start_time."') AND end_time<=UNIX_TIMESTAMP('".$end_time."')";
        }
        
        return $sql;
        
    }


    public static function getSearchCell($hospital_no,$project_no,$cell_type,$sign_doctor,$start_time,$end_time, $id, $num ) {

        $sql = tableSearchCell::sqlGet( $hospital_no,$project_no,$cell_type,$sign_doctor,$start_time,$end_time );

        if( $id!=null && $num!= null) {
            $sql = "SELECT cell_no,file_id,x_pos,y_pos,x_length,y_length,cell_type ".$sql." AND id>".$id.""." LIMIT 0,".$num;
        }
        else{
            $sql = "SELECT cell_no,file_id,x_pos,y_pos,x_length,y_length,cell_type ".$sql;
        }


        echo $sql.'\n';

        $data = \think\Db::query($sql);

        return $data;
    }

    public static function countSearchCell($hospital_no,$project_no,$cell_type,$sign_doctor,$start_time,$end_time,$id, $num ) {
//
        $sql = tableSearchCell::sqlGet( $hospital_no,$project_no,$cell_type,$sign_doctor,$start_time,$end_time );
        if( $id!=null && $num!= null) {
            $sql = "SELECT count(*) ".$sql." AND id>".$id.""." LIMIT 0,".$num;
        }
        else{
            $sql = "SELECT count(*) ".$sql;
        }


        echo $sql.'\n';

        $data = \think\Db::query($sql);


        return $data;

    }

    public static function addSearchCell($data) {
        $ret = Db::table('search_cell')->insert($data);

        return $ret == 1?0:1;
    }

}