<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/2/21
 * Time: 下午5:24
 */

namespace app\index\controller;


use app\index\api\apiFile;
use think\Request;

class File
{
    public function up(){
        $file = Request::instance()->file('file');
        $info = $file->rule('md5')->move(ROOT_PATH.'public'.DS.'file');
        if($info){
            $tpye = $info->getExtension();
            echo '<br>';
            echo $info->getSaveName();
            echo '<br>';
            echo $info->getFilename();
            echo '<br>';
            $md5 = $info->md5();
            $size = $info->getSize();


            $retArray = apiFile::apiFileUp($md5,$size,$tpye);
            if($retArray){

                if( $retArray['ret_code'] != 0) {
                    return json_encode($retArray);
                }

                $retArray1 = apiFile::apiFileDataUp($md5,$size,$tpye,$retArray['web_name'],$retArray['server_id'],$retArray['flag_index']);

                if($retArray1) {

                    if ($retArray1['ret_code'] != 0) {
                        return json_encode($retArray1);
                    }

                    $retArray2 = apiFile::apiFileUpOk($md5,$size,$tpye);
                    if($retArray2){
                        return json_encode($retArray2);
                    }

                }

            }

            return 'error';

        }
        else {
            echo $file->getError();
        }
    }
}