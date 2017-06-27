<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/6/26
 * Time: 下午1:45
 */

namespace app\index\table;


class tableSearchProject
{
    public static function sqlGet( $hospital_no,$project_no,$sign_doctor,$start_time,$end_time ) {
        $sql = 'FROM search_project';

        $project_no_min = sprintf("'%08x0000000000000000'",$hospital_no);
        $project_no_max = sprintf("'%08xzzzzzzzzzzzzzzzz'",$hospital_no);

        if($hospital_no != null ) {
            $sql .= ' WHERE project_no>='.$project_no_min.' AND project_no <'.$project_no_max;

            if($start_time!=null&&$end_time!=null) {
                $sql .= " AND end_time>UNIX_TIMESTAMP('".$start_time."') AND end_time<=(UNIX_TIMESTAMP('".$end_time."')+86400)";
            }

            return $sql;
        }

        if( $sign_doctor != null ) {
            $sql .= ' WHERE sign_doctor='.$sign_doctor;
            if($project_no != null ) {
                $sql .= " AND project_no='".$project_no."'";
            }
            if($start_time!=null&&$end_time!=null) {
                $sql .= " AND end_time>UNIX_TIMESTAMP('".$start_time."') AND end_time<=(UNIX_TIMESTAMP('".$end_time."')+86400)";
            }

            return $sql;
        }

        if($project_no!=null) {
            $sql .= " WHERE project_no='".$project_no."'";
            if($start_time!=null&&$end_time!=null) {
                $sql .= " AND end_time>UNIX_TIMESTAMP('".$start_time."') AND end_time<=(UNIX_TIMESTAMP('".$end_time."')+86400)";
            }

            return $sql;
        }

        if($start_time!=null&&$end_time!=null) {
            $sql .= " WHERE end_time>UNIX_TIMESTAMP('".$start_time."') AND end_time<=(UNIX_TIMESTAMP('".$end_time."')+86400)";
        }

        return $sql;

    }


    public static function getSearchCell($hospital_no,$project_no,$sign_doctor,$start_time,$end_time, $id, $num ) {

        $sql = tableSearchProject::sqlGet( $hospital_no,$project_no,$sign_doctor,$start_time,$end_time );

        if( $id!=null && $num!= null) {
            $sql = "SELECT id,project_no,sign_doctor,from_unixtime(end_time) as end_time,patient_name,patient_age,patient_gender,section_id,sample_part ".$sql." AND id>".$id.""." LIMIT 0,".$num;
        }
        else{
            $sql = "SELECT id,project_no,sign_doctor,from_unixtime(end_time) as end_time,patient_name,patient_age,patient_gender,section_id,sample_part ".$sql;
        }

        $data = \think\Db::query($sql);

        return $data;
    }
}