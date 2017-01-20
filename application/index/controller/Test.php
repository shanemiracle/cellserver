<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/20
 * Time: 上午10:18
 */

namespace app\index\controller;


use app\index\api\apiDevice;
use app\index\api\apiDoctor;
use app\index\api\apiHospital;
use app\index\api\apiLogin;
use think\Request;

class Test
{
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



        }
        return json_encode($ret);
    }

}