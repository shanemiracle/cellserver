<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2017/1/20
 * Time: 上午10:18
 */

namespace app\index\controller;


use app\index\api\apiCellPer;
use app\index\api\apiCellPerType;
use app\index\api\apiCellType;
use app\index\api\apiCheckType;
use app\index\api\apiDevice;
use app\index\api\apiDiagCheck;
use app\index\api\apiDoctor;
use app\index\api\apiHospital;
use app\index\api\apiLogin;
use app\index\api\apiManager;
use app\index\table\tableSearchCell;
use think\controller\Rest;
use think\Request;
use think\Session;
use think\View;

class Test extends Rest
{
    public function upfile(){
        return '<form action="/test/up" enctype="multipart/form-data" method="post">
                <input type="file" name="file"/> <br>
                <input type="submit" value="上传" />
                </form>';
    }

    public function test() {
        return (new View())->fetch('/test/test',['logourl'=>'']);
    }

    public function tableAdd() {
        $data = ['cell_no'=>'2','hospital_no'=>'1','project_no'=>'2','sign_doctor'=>'1',
        'end_time'=>'2017-06-01 17:34:11', 'photo_type'=>4,'section_seq'=>1,'file_id'=>'12',
        'x_pos'=>1,'y_pos'=>1,'x_length'=>1,'y_length'=>1,'cell_type'=>23,'ph_value'=>'5.6'];

        srand(time());
        for($i = 0; $i < 20; $i++ ) {
            $hos_no = sprintf("%04d", $i + 1);
            $time = 1420000000;
            for( $j = 0; $j < 5000; $j++) {

                $pro_no = sprintf("%s%016d",$hos_no, $time+= 14000 );
                $sign_doc = sprintf("%s%08d",$hos_no, ($j %5 + 1 ));
                $end_time = date('Y-m-d H:i:s', $time);

                for($k = 0; $k < 500; $k++ ) {
                    $photo_type = $k % 4 + 1;
                    $section_seq = $k %2 + 1;
                    $file_id = sprintf("%044x", rand());
                    $x_pos = $k+2;
                    $y_pos = $k+50;
                    $x_len = 1024;
                    $y_len = 760;
                    $cell_type = rand()%200 + 1;
                    $ph_value = sprintf("%02d.%01d",rand()%13+1, rand()%10);

                    $cell_no = sprintf("%s%02d",$pro_no,$k+1);

                    $data = ['cell_no'=>$cell_no,'hospital_no'=>$hos_no,
                    'project_no'=>$pro_no,'sign_doctor'=>$sign_doc,
                    'end_time'=>$end_time,'photo_type'=>$photo_type,
                    'section_seq'=>$section_seq,'file_id'=>$file_id,
                    'x_pos'=>$x_pos,'y_pos'=>$y_pos,
                    'x_length'=>$x_len,'y_length'=>$y_len,
                    'cell_type'=>$cell_type,'ph_value'=>$ph_value];

                    if( 0 != tableSearchCell::addSearchCell($data) ) {
                        return -1;
                    }

                }

            }
        }

        return 0;
    }

    public function tableGet( ) {
        $hospital_no = Request::instance()->param('hos_no');
        $project_no = Request::instance()->param('pro_no');
        $sign_doctor = Request::instance()->param('doc_no');
        $start_time = Request::instance()->param('s_time');
        $end_time = Request::instance()->param('e_time');

        $data = tableSearchCell::getSearchCell($hospital_no,$project_no,$sign_doctor,$start_time,$end_time);
        $data = ['num'=>count($data),'data'=>$data];
//        print_r($data);
        return $this->response( $data, 'json', 200 );
    }

    public function tableCount( ) {
        $hospital_no = Request::instance()->param('hos_no');
        $project_no = Request::instance()->param('pro_no');
        $sign_doctor = Request::instance()->param('doc_no');
        $start_time = Request::instance()->param('s_time');
        $end_time = Request::instance()->param('e_time');

        $data = tableSearchCell::countSearchCell($hospital_no,$project_no,$sign_doctor,$start_time,$end_time);
//        print_r($data);
        return $this->response( $data, 'json', 200 );
    }

    public function up(){
        $file = Request::instance()->file('file');
        print_r($file);
//        $info = $file->rule('md5')->move(ROOT_PATH.'public'.DS.'file');
//        if($info){
//            $tpye = $info->getExtension();
//            echo '<br>';
//            echo $info->getSaveName();
//            echo '<br>';
//            echo $info->getFilename();
//            echo '<br>';
//            $md5 = $info->md5();
//            $size = $info->getSize();
//
//
//           $retArray = apiFile::apiFileUp($md5,$size,$tpye);
//            if($retArray){
//                print_r($retArray);
//                echo '1111111<br>';
//                if( $retArray['ret_code'] != 0) {
//                    echo '1111111<br>';
//                    return json_encode($retArray);
//                }
//
//                $retArray1 = apiFile::apiFileDataUp($md5,$size,$tpye,$retArray['web_name'],$retArray['server_id'],$retArray['flag_index']);
//
//                if($retArray1) {
//                    print_r($retArray1);
//                    echo '22222222<br>';
//                    if ($retArray1['ret_code'] != 0) {
//                        echo '2222222222222<br>';
//                        return json_encode($retArray1);
//                    }
//
//                    $retArray2 = apiFile::apiFileUpOk($md5,$size,$tpye);
//                    if($retArray2){
//                        print_r($retArray2);
//                        echo '333333333333<br>';
//                        return json_encode($retArray2);
//                    }
//
//                }
//
//            }
//
//            return 'error';
//
//        }
//        else {
//            echo $file->getError();
//        }
    }

    public function index() {
        $id = Request::instance()->param('id');

        $ret = array();

        switch ($id) {
            case 1:
                $user_name = Request::instance()->param('user_name');
                $pwd = Request::instance()->param('pwd');

                $ret = apiLogin::apiLogin($user_name,$pwd);
                if($ret){
                    if($ret['ret_code']==0) {
                        Session::set('attest',$ret['attest']);
                    }
                }
                break;


            case 2:
                $attest = Session::get('attest');
                $hospital_name = Request::instance()->param('hospital_name');
                $hospital_number = Request::instance()->param('hospital_number');
                $zone = Request::instance()->param('zone');
                $logo = Request::instance()->param('logo');
                $level = Request::instance()->param('level');

                $ret = apiHospital::apiHospitalAdd($attest,$hospital_name,$hospital_number,$zone,$logo,$level);
                break;

            case 3:
                $attest = Session::get('attest');
                $hospital_no = Request::instance()->param('hospital_no');
                $hospital_ver = Request::instance()->param('hospital_ver');
                $zone = Request::instance()->param('zone');
                $hospital_name = Request::instance()->param('hospital_name');
                $logo = Request::instance()->param('logo');
                $level = Request::instance()->param('level');

                $ret = apiHospital::apiHospitalSet(intval($attest),intval($hospital_no),intval($hospital_ver),$zone,$hospital_name,$logo,$level);
                break;

            case 4:
                $attest = Session::get('attest');
                $hospital_start = Request::instance()->param('hospital_start');
                $get_num = Request::instance()->param('get_num');

                $ret = apiHospital::apiHospitalGet(intval($attest),intval($hospital_start),intval($get_num));
                break;

            case 5:
                $attest = Session::get('attest');
                $hospital_number = Request::instance()->param('hospital_number');

                $ret = apiHospital::apiHospitalNumberGet(intval($attest),$hospital_number);
                break;

            case 6:
                $attest = Session::get('attest');
                $hospital_no = Request::instance()->param('hospital_no');

                $ret = apiHospital::apiHospitalDrop(intval($attest),intval($hospital_no));
                break;

            case 7:
                $attest = Session::get('attest');
                $doctor_name = Request::instance()->param('doctor_name');
                $hospital_no = Request::instance()->param('hospital_no');

                $ret = apiDoctor::apiDoctorNameGet(intval($attest),$doctor_name,intval($hospital_no));
                break;

            case 8:
                $attest = Session::get('attest');
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
                $attest = Session::get('attest');
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
                    $department,$logo,$sign_pic,$mobile_no,intval($role),$learn_level);
                break;

            case 10:
                $attest = Session::get('attest');
                $doctor_no = Request::instance()->param('doctor_no');

                $ret = apiDoctor::apiDoctorDrop(intval($attest),$doctor_no);
                break;

            case 11:
                $attest = Session::get('attest');
                $hospital_no = Request::instance()->param('hospital_no');
                $doctor_start = Request::instance()->param('doctor_start');
                $get_num = Request::instance()->param('get_num');

                $ret = apiDoctor::apiDoctorGet(intval($attest),intval($hospital_no),$doctor_start,intval($get_num));
                break;

            case 12:
                $attest = Session::get('attest');
                $hospital_no = Request::instance()->param('hospital_no');
                $machine_code = Request::instance()->param('machine_code');
                $valid_sec = Request::instance()->param('valid_sec');

                $ret = apiDevice::apiDeviceAdd(intval($attest),$machine_code,intval($hospital_no),intval($valid_sec));
                break;

            case 13:
                $attest = Session::get('attest');
                $hospital_no = Request::instance()->param('hospital_no');

                $ret = apiDevice::apiDeviceHospitalGet(intval($attest),intval($hospital_no));
                break;

            case 14:
                $attest = Session::get('attest');
                $machine_code = Request::instance()->param('machine_code');

                $ret = apiDevice::apiDeviceGet(intval($attest),$machine_code);
                break;

            case 15:
                $attest = Session::get('attest');
                $device_no = Request::instance()->param('device_no');
                $info_ver = Request::instance()->param('info_ver');
                $add_sec = Request::instance()->param('add_sec');

                $ret = apiDevice::apiDeviceSetTime($attest,$device_no,$info_ver,$add_sec);
                break;

            case 16:
                $attest = Session::get('attest');
                $father_cell_type = Request::instance()->param('father_cell_type');
                $check_type = Request::instance()->param('check_type');
                $cn_name = Request::instance()->param('cn_name');
                $en_name = Request::instance()->param('en_name');
                $abb_name = Request::instance()->param('abb_name');
                $size_max = Request::instance()->param('size_max');
                $size_min = Request::instance()->param('size_min');
                $remark = Request::instance()->param('remark');

                $ret = apiCellType::apiCellTypeAdd($attest,$check_type,$father_cell_type,$cn_name,$en_name,$abb_name,$size_max,$size_min,$remark);
                break;

            case 17:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $cell_type = Request::instance()->param('cell_type');

                $ret = apiCellType::apiCellTypeDrop($attest,$check_type,$cell_type);
                break;

            case 31:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $cell_start = Request::instance()->param('cell_start');
                $get_num = Request::instance()->param('get_num');

                $ret = apiCellType::apiCellTypeList($attest,$check_type,$cell_start,$get_num);
                break;

            case 19:
                $attest = Session::get('attest');
                $cell_start = Request::instance()->param('cell_start');
                $get_num = Request::instance()->param('get_num');

                break;

            case 20:
                $attest = Session::get('attest');
                $hospital_no = Request::instance()->param('hospital_no');
                $check_type = Request::instance()->param('check_type');

                $ret = apiCellPer::apiCellPerGet(intval($attest),intval($hospital_no),intval($check_type));
                break;

            case 21:
                $attest = Session::get('attest');
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
                $attest = Session::get('attest');
                $machine_code = Request::instance()->param('machine_code');

                $ret = apiDevice::apiDeviceDrop(intval($attest),$machine_code);
                break;

            case 30:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $cell_type = Request::instance()->param('cell_type');

                $ret = apiCellType::apiCellTypeSonList($attest,$check_type,$cell_type);
                break;
            case 18:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $cell_type = Request::instance()->param('cell_type');

                $ret = apiCellType::apiCellTypeGet($attest,$check_type,$cell_type);
                break;
            case 32:
                $attest = Session::get('attest');
                $cell_type = Request::instance()->param('cell_type');
                $check_type = Request::instance()->param('check_type');
                $info_ver = Request::instance()->param('info_ver');
                $cn_name = Request::instance()->param('cn_name');
                $en_name = Request::instance()->param('en_name');
                $abb_name = Request::instance()->param('abb_name');
                $size_max = Request::instance()->param('size_max');
                $size_min = Request::instance()->param('size_min');
                $remark = Request::instance()->param('remark');

                $ret = apiCellType::apiCellTypeSet($attest,$check_type,$cell_type,$info_ver,$cn_name,$en_name,$abb_name,$size_max,$size_min,$remark);
                break;
            case 33:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $per_name = Request::instance()->param('per_name');
                $expression = Request::instance()->param('expression');
                $remark = Request::instance()->param('remark');

                $ret = apiCellPerType::apiCellPerTypeAdd($attest,$check_type,$per_name,$expression,$remark);
                break;
            case 34:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $cell_per_type = Request::instance()->param('cell_per_type');
                $ret = apiCellPerType::apiCellPerTypeDrop($attest,$check_type,$cell_per_type);
                break;

            case 35:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $cell_per_start = Request::instance()->param('cell_per_start');
                $get_num = Request::instance()->param('get_num');
                $ret = apiCellPerType::apiCellPerTypeList($attest,$check_type,$cell_per_start,$get_num);
                break;
            case 36:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $cell_per_type = Request::instance()->param('cell_per_type');
                $ret = apiCellPerType::apiCellPerTypeGet($attest,$check_type,$cell_per_type);
                break;

            case 37:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $cell_per_type = Request::instance()->param('cell_per_type');
                $info_ver = Request::instance()->param('info_ver');
                $per_name = Request::instance()->param('per_name');
                $expression = Request::instance()->param('expression');
                $remark = Request::instance()->param('remark');

                $ret = apiCellPerType::apiCellPerTypeSet($attest,$check_type,$cell_per_type,$info_ver,$per_name,$expression,$remark);
                break;

            case 38:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $cn_name= Request::instance()->param('cn_name');
                $en_name= Request::instance()->param('en_name');
                $expression = Request::instance()->param('expression');
                $remark = Request::instance()->param('remark');

                $ret = apiDiagCheck::apiDiagCheckAdd($attest,$check_type,$cn_name,$en_name,$expression,$remark);
                break;
            case 39:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $diag_check_type= Request::instance()->param('diag_check_type');

                $ret = apiDiagCheck::apiDiagCheckDrop($attest,$check_type,$diag_check_type);
                break;

            case 40:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $diag_check_start= Request::instance()->param('diag_check_start');
                $get_num= Request::instance()->param('get_num');

                $ret = apiDiagCheck::apiDiagCheckList($attest,$check_type,$diag_check_start,$get_num);
                break;
            case 41:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $diag_check_type= Request::instance()->param('diag_check_type');
                $ret = apiDiagCheck::apiDiagCheckGet($attest,$check_type,$diag_check_type);
                break;
            case 42:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $diag_check_type = Request::instance()->param('diag_check_type');
                $info_ver = Request::instance()->param('info_ver');
                $cn_name= Request::instance()->param('cn_name');
                $en_name= Request::instance()->param('en_name');
                $expression = Request::instance()->param('expression');
                $remark = Request::instance()->param('remark');
                $ret = apiDiagCheck::apiDiagCheckSet($attest,$check_type,$diag_check_type,$info_ver,$cn_name,$en_name,$expression,$remark);
                break;

            case 43:
                $attest = Session::get('attest');
                $hospital_no = Request::instance()->param('hospital_no');

                $ret = apiHospital::apiHospitalOneGet($attest,$hospital_no);
                break;
            case 45:
                $attest = Session::get('attest');
                $desc = Request::instance()->param('desc');
                $ret = apiCheckType::apiCheckTypeAdd($attest,$desc) ;
                break;
            case 46:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $ret = apiCheckType::apiCheckTypeDrop($attest,$check_type) ;
                break;
            case 47:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $info_ver = Request::instance()->param('info_ver');
                $desc = Request::instance()->param('desc');

                $ret = apiCheckType::apiCheckTypeSet($attest,$check_type,$info_ver,$desc) ;
                break;

            case 48:
                $attest = Session::get('attest');
                $ret = apiCheckType::apiCheckTypeList($attest) ;
                break;
            case 49:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $ret = apiCheckType::apiCheckTypeGet($attest,$check_type) ;
                break;

            case 59:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $cell_type = Request::instance()->param('cell_type');
                $ret = apiCellType::apiCellTypeFacherList($attest,$check_type,$cell_type);
                break;

            case 65:
                $attest = Session::get('attest');

                $cell_no = Request::instance()->param('cell_no');

                $cell_no_list = explode(',',$cell_no);
                $data = [];
                for($i = 0; $i < count($cell_no_list); $i++ ) {
                    array_push($data,['cell_no'=>intval($cell_no_list[$i])]);
                }

                $ret = apiCellType::apiTenCellTypeAdd($attest,1,$data);
                break;
            case 66:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $ret = apiCellType::apiTenCellTypeDrop($attest,$check_type);
                break;

            case 67:
                $attest = Session::get('attest');
                $check_type = Request::instance()->param('check_type');
                $ret = apiCellType::apiTenCellTypeGet($attest,$check_type);
                break;
            case 68:
                $attest = Session::get('attest');
                $info_ver = Request::instance()->param('info_ver');
                $cell_no = Request::instance()->param('cell_no');

                $cell_no_list = explode(',',$cell_no);
                $data = [];
                for($i = 0; $i < count($cell_no_list); $i++ ) {
                    array_push($data,['cell_no'=>intval($cell_no_list[$i])]);
                }
                $ret = apiCellType::apiTenCellTypeSet($attest,1,$info_ver,$data);
                break;

            case 81:
                $attest = Session::get('attest');
                $user_name = Request::instance()->param('user_name');
                $password= Request::instance()->param('password');
                $mobile_no = Request::instance()->param('mobile_no');
                $power_data = Request::instance()->param('power_data');
                $ret = apiManager::apiManagerAdd($attest,$user_name,$password,$mobile_no,$power_data);
                break;

            case 82:
                $attest = Session::get('attest');

                $manager_no = Request::instance()->param('manager_no');
                $info_ver = Request::instance()->param('info_ver');
                $password = Request::instance()->param('password');
                $power_data = Request::instance()->param('power_data');


                $ret = apiManager::apiManagerSet($attest,$manager_no,$info_ver,$password,$power_data);
                break;

            case 83:
                $attest = Session::get('attest');
                $manager_no = Request::instance()->param('manager_no');

                $ret = apiManager::apiManagerDrop($attest,$manager_no);
                break;

            case 84:
                $attest = Session::get('attest');
                $manager_start = Request::instance()->param('manager_start');
                $get_num = Request::instance()->param('get_num');

                $ret = apiManager::apiManagerList($attest,$manager_start,$get_num);
                break;
            case 85:
                $attest = Session::get('attest');
                $manager_no = Request::instance()->param('manager_no');

                $ret = apiManager::apiManagerGet($attest,$manager_no);
                break;

            case 86:
                $attest = Session::get('attest');
                $manager_no = Request::instance()->param('manager_no');
                $hospital_no = Request::instance()->param('hospital_no');

                $ret = apiManager::apiManagerHospitalAdd($attest,$manager_no,$hospital_no);
                break;
            case 87:
                $attest = Session::get('attest');
                $manager_no = Request::instance()->param('manager_no');
                $hospital_no = Request::instance()->param('hospital_no');

                $ret = apiManager::apiManagerHospitalDrop($attest,$manager_no,$hospital_no);
                break;
            case 88:
                $attest = Session::get('attest');
                $hospital_start= Request::instance()->param('hospital_start');
                $manager_no = Request::instance()->param('manager_no');
                $get_num = Request::instance()->param('get_num');

                $ret = apiManager::apiManagerHospitalList($attest,$manager_no,$hospital_start,$get_num);
                break;
            case 89:
                $attest = Session::get('attest');
                $user_name= Request::instance()->param('user_name');
                $ret = apiManager::apiManagerNameGet($attest,$user_name);
                break;
        }



        return json_encode($ret);
    }

}