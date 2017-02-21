<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/20
 * Time: 上午10:18
 */

namespace app\index\controller;


use app\index\api\apiCellPer;
use app\index\api\apiCellType;
use app\index\api\apiDevice;
use app\index\api\apiDoctor;
use app\index\api\apiFile;
use app\index\api\apiHospital;
use app\index\api\apiLogin;
use app\index\tool\Byte;
use think\Request;

class Test
{
    public function upfile(){
        return '<form action="/test/up" enctype="multipart/form-data" method="post">
                <input type="file" name="file"/> <br>
                <input type="submit" value="上传" />
                </form>';
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
                print_r($retArray);
                if( $retArray['ret_code'] != 0) {
                    echo '1111111<br>';
                    return json_encode($retArray);
                }

                $retArray1 = apiFile::apiFileDataUp($md5,$size,$tpye,$retArray['web_name'],$retArray['server_id'],$retArray['flag_index']);

                if($retArray1) {
                    print_r($retArray1);
                    if ($retArray1['ret_code'] != 0) {
                        echo '2222222222222<br>';
                        return json_encode($retArray1);
                    }

                    $retArray2 = apiFile::apiFileUpOk($md5,$size,$tpye);
                    if($retArray2){
                        print_r($retArray2);
                        echo '333333333333<br>';
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

    public function index() {
        $id = Request::instance()->param('id');

        $ret = array();

        switch ($id) {
            case 1:
                $user_name = Request::instance()->param('user_name');
                $pwd = Request::instance()->param('pwd');

                $ret = apiLogin::apiLogin($user_name,$pwd);
                break;


            case 2:
                $attest = Request::instance()->param('attest');
                $hospital_name = Request::instance()->param('hospital_name');
                $hospital_number = Request::instance()->param('hospital_number');
                $zone = Request::instance()->param('zone');
                $logo = Request::instance()->param('logo');
                $level = Request::instance()->param('level');

                $ret = apiHospital::apiHospitalAdd($attest,$hospital_name,$hospital_number,$zone,$logo,$level);
                break;

            case 3:
                $attest = Request::instance()->param('attest');
                $hospital_no = Request::instance()->param('hospital_no');
                $hospital_ver = Request::instance()->param('hospital_ver');
                $zone = Request::instance()->param('zone');
                $hospital_name = Request::instance()->param('hospital_name');
                $logo = Request::instance()->param('logo');
                $level = Request::instance()->param('level');

                $ret = apiHospital::apiHospitalSet(intval($attest),intval($hospital_no),intval($hospital_ver),$zone,$hospital_name,$logo,$level);
                break;

            case 4:
                $attest = Request::instance()->param('attest');
                $hospital_start = Request::instance()->param('hospital_start');
                $get_num = Request::instance()->param('get_num');

                $ret = apiHospital::apiHospitalGet(intval($attest),intval($hospital_start),intval($get_num));
                break;

            case 5:
                $attest = Request::instance()->param('attest');
                $hospital_number = Request::instance()->param('hospital_number');

                $ret = apiHospital::apiHospitalNumberGet(intval($attest),$hospital_number);
                break;

            case 6:
                $attest = Request::instance()->param('attest');
                $hospital_no = Request::instance()->param('hospital_no');

                $ret = apiHospital::apiHospitalDrop(intval($attest),intval($hospital_no));
                break;

            case 7:
                $attest = Request::instance()->param('attest');
                $doctor_name = Request::instance()->param('doctor_name');
                $hospital_no = Request::instance()->param('hospital_no');

                $ret = apiDoctor::apiDoctorNameGet(intval($attest),$doctor_name,intval($hospital_no));
                break;

            case 8:
                $attest = Request::instance()->param('attest');
                $doctor_name = Request::instance()->param('doctor_name');
                $pwd = Request::instance()->param('pwd');
                $hospital_no = Request::instance()->param('hospital_no');
                $level = Request::instance()->param('level');
                $department = Request::instance()->param('department');
                $logo = Request::instance()->param('logo');
                $sign_pic = Request::instance()->param('sign_pic');
                $mobile_no = Request::instance()->param('mobile_no');
                $role = Request::instance()->param('role');
                $learn_level = Request::instance()->param('learn_level');

                $ret = apiDoctor::apiDoctorAdd(intval($attest),$doctor_name,$pwd,intval($hospital_no),$level,
                    $department,$logo,$sign_pic,$mobile_no,intval($role),intval($learn_level));
                break;

            case 9:
                $attest = Request::instance()->param('attest');
                $doctor_no = Request::instance()->param('doctor_no');
                $pwd = Request::instance()->param('pwd');
                $doctor_ver = Request::instance()->param('doctor_ver');
                $level = Request::instance()->param('level');
                $department = Request::instance()->param('department');
                $logo = Request::instance()->param('logo');
                $sign_pic = Request::instance()->param('sign_pic');
                $mobile_no = Request::instance()->param('mobile_no');
                $role = Request::instance()->param('role');
                $learn_level = Request::instance()->param('learn_level');

                $ret = apiDoctor::apiDoctorSet(intval($attest),$doctor_no,intval($doctor_ver),$pwd,$level,
                    $department,$logo,$sign_pic,$mobile_no,intval($role),intval($learn_level));
                break;

            case 10:
                $attest = Request::instance()->param('attest');
                $doctor_no = Request::instance()->param('doctor_no');

                $ret = apiDoctor::apiDoctorDrop(intval($attest),$doctor_no);
                break;

            case 11:
                $attest = Request::instance()->param('attest');
                $hospital_no = Request::instance()->param('hospital_no');
                $doctor_start = Request::instance()->param('doctor_start');
                $get_num = Request::instance()->param('get_num');

                $ret = apiDoctor::apiDoctorGet(intval($attest),intval($hospital_no),$doctor_start,intval($get_num));
                break;

            case 12:
                $attest = Request::instance()->param('attest');
                $hospital_no = Request::instance()->param('hospital_no');
                $machine_code = Request::instance()->param('machine_code');
                $valid_sec = Request::instance()->param('valid_sec');

                $ret = apiDevice::apiDeviceAdd(intval($attest),$machine_code,intval($hospital_no),intval($valid_sec));
                break;

            case 13:
                $attest = Request::instance()->param('attest');
                $hospital_no = Request::instance()->param('hospital_no');

                $ret = apiDevice::apiDeviceHospitalGet(intval($attest),intval($hospital_no));
                break;

            case 14:
                $attest = Request::instance()->param('attest');
                $machine_code = Request::instance()->param('machine_code');

                $ret = apiDevice::apiDeviceGet(intval($attest),$machine_code);
                break;

            case 15:
                $attest = Request::instance()->param('attest');
                $device_no = Request::instance()->param('device_no');
                $add_sec = Request::instance()->param('add_sec');

                $ret = apiDevice::apiDeviceSetTime(intval($attest),$device_no,intval($add_sec));
                break;

            case 16:
                $attest = Request::instance()->param('attest');
                $cell_name = Request::instance()->param('cell_name');

                $ret = apiCellType::apiCellTypeAdd(intval($attest),$cell_name);
                break;

            case 17:
                $attest = Request::instance()->param('attest');
                $cell_name = Request::instance()->param('cell_name');

                $ret = apiCellType::apiCellTypeDrop(intval($attest),$cell_name);
                break;

            case 18:
                $attest = Request::instance()->param('attest');
                $cell_start = Request::instance()->param('cell_start');
                $get_num = Request::instance()->param('get_num');

                $ret = apiCellType::apiCellTypeGet(intval($attest),intval($cell_start),intval($get_num));
                break;

            case 19:
                $attest = Request::instance()->param('attest');
                $cell_start = Request::instance()->param('cell_start');
                $get_num = Request::instance()->param('get_num');

                $ret = apiCellType::apiCellTypeCustomGet(intval($attest),intval($cell_start),intval($get_num));
                break;

            case 20:
                $attest = Request::instance()->param('attest');
                $hospital_no = Request::instance()->param('hospital_no');
                $check_type = Request::instance()->param('check_type');

                $ret = apiCellPer::apiCellPerGet(intval($attest),intval($hospital_no),intval($check_type));
                break;

            case 21:
                $attest = Request::instance()->param('attest');
                $hospital_no = Request::instance()->param('hospital_no');
                $check_type = Request::instance()->param('check_type');
                $info_ver = Request::instance()->param('info_ver');

                $data = [
                    ['cell_type'=>intval(1),'min_per'=>'10.5%','max_per'=>'25.5%','normal_per'=>'18.5%'],
                    ['cell_type'=>intval(2),'min_per'=>'20.5%','max_per'=>'35.5%','normal_per'=>'28.5%'],
                    ['cell_type'=>intval(3),'min_per'=>'30.5%','max_per'=>'45.5%','normal_per'=>'38.5%'],
                    ['cell_type'=>intval(4),'min_per'=>'40.5%','max_per'=>'55.5%','normal_per'=>'48.5%']
                ];

                $ret = apiCellPer::apiCellPerSet(intval($attest),intval($hospital_no),intval($check_type),intval($info_ver),$data);
                break;

            case 22:
                $attest = Request::instance()->param('attest');
                $machine_code = Request::instance()->param('machine_code');

                $ret = apiDevice::apiDeviceDrop(intval($attest),$machine_code);
                break;

        }
        return json_encode($ret);
    }

}