<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/3/28
 * Time: 上午10:25
 */

namespace app\index\tool;


class Ext
{

    public static function nameToType($file_type) {
        if($file_type == 'bmp'){
            $file_type = 1;
        }
        else if( $file_type == 'jpeg' ){
            $file_type = 2;
        }
        else if( $file_type == 'png' ){
            $file_type = 3;
        }
        else if( $file_type == 'jpg'){
            $file_type = 4;
        }
        else if( $file_type == 'txt'){
            $file_type = 5;
        }
        else {
            $file_type = 0;
        }

        return $file_type;
    }

    public static function typeToName($fileType){
        if($fileType){
            if($fileType == '01') {
                return '.bmp';
            }
            else if($fileType == '02') {
                return '.jpeg';
            }
            else if($fileType == '03') {
                return '.png';
            }
            else if($fileType == '04') {
                return '.jpg';
            }
            else if($fileType == '05') {
                return '.txt';
            }
        }
        else{
            return '';
        }
    }
}