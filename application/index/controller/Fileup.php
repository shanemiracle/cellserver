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
use think\View;

class Fileup
{
    public function index(){

        return (new View())->fetch('/file/index');
    }

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

    private function subAjaxUp()
    {
        $retObj = null;
        $file = Request::instance()->file('file');
        if($file){
            $info = $file->rule('md5')->move(ROOT_PATH . 'public' . DS . 'file');

            if ($info) {
                $tpye = $info->getExtension();
                $md5 = $info->md5();
                $size = $info->getSize();


                $retArray = apiFile::apiFileUp($md5, $size, $tpye);
                if ($retArray) {

                    if ($retArray['ret_code'] != 0) {
                        if($retArray['ret_code'] == 2) {
                            $retObj = ['ret'=>0,'logo'=>$retArray['logo']];
                        }
                        else{
                            $retObj = ['ret'=>$retArray['ret_code'],'error' => $retArray['err_desc']];
                        }

                        return $retObj;
                    }

                    $retArray1 = apiFile::apiFileDataUp($md5, $size, $tpye, $retArray['web_name'], $retArray['server_id'], $retArray['flag_index']);

                    if ($retArray1) {

                        if ($retArray1['ret_code'] != 0) {
                            return ['ret'=>$retArray1['ret_code'],'error' => $retArray1['err_desc']];
                        }

                        $retArray2 = apiFile::apiFileUpOk($md5, $size, $tpye);
                        if ($retArray2) {
                            if ($retArray2['ret_code'] != 0){
                                return ['ret'=>$retArray2['ret_code'],'error' => $retArray2['err_desc']];
                            }
                            else {
                                return ['ret'=>0,'logo'=>$retArray2['logo']];
                            }

                        }

                    }

                }

                return ['ret'=>10000,'error' => 'server_error'];

            } else {
                return ['ret'=>10001,'error' => $file->getError()];
            }

        }

        return ['ret'=>10002,'error' => "file null"];
    }

    public function ajax_up()
    {

        $retObj = $this->subAjaxUp();

        echo json_encode($retObj);

        return;
    }
}