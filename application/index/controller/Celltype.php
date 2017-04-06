<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/3
 * Time: 15:12
 */

namespace app\index\controller;


use app\index\api\apiCellType;
use app\index\api\apiHospital;
use app\index\tool\Ext;
use think\controller\Rest;
use think\Request;
use think\Session;
use think\View;

class Celltype extends Rest
{
    private function attest()
    {
        $attest = Session::get('attest');
        $retData = apiHospital::apiHospitalGet($attest, 0, 0);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                return true;
            }
        }

        return false;
    }

    public function add()
    {
        if ($this->attest() != true) {
            abort(401);
        }

        $father_cell_type = Request::instance()->param('father_cell_type');
        $father_cell_name = Request::instance()->param('father_cell_name');

        return (new View())->fetch('/celltype/add', ['father_cell_type' => $father_cell_type, 'father_cell_name' => $father_cell_name]);
    }

    public function edit()
    {
        if ($this->attest() != true) {
            abort(401);
        }

        $father_cell_type = Request::instance()->param('father_cell_type');
        $father_cell_name = Request::instance()->param('father_cell_name');
        $cell_type = Request::instance()->param('cell_type');
        $data = [];

        $retData = apiCellType::apiCellTypeGet(Session::get('attest'), 1, $cell_type);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                if(substr( $retData['file_id_big'],10,2)!='00'){
                    $bigUrl = '/file/'.substr( $retData['file_id_big'],10,2).'/'.substr( $retData['file_id_big'],12,30).Ext::typeToName(substr( $retData['file_id_big'],42,2));
                }
                else{
                    $bigUrl = '';
                }

                if(substr( $retData['file_id_small'],10,2) != '00'){
                    $smallUrl = '/file/'.substr( $retData['file_id_small'],10,2).'/'.substr( $retData['file_id_small'],12,30).Ext::typeToName(substr( $retData['file_id_small'],42,2));
                }
                else{
                    $smallUrl = '';
                }


                $data = ['father_cell_type' => $father_cell_type, 'father_cell_name' => $father_cell_name,
                    'cell_type'=>$cell_type,'info_ver'=>$retData['info_ver'],
                    'cn_name'=>$retData['cn_name'],'en_name'=>$retData['en_name'],
                    'abb_name'=>$retData['abb_name'],'size_max'=>$retData['size_max']/10,
                    'size_min'=>$retData['size_min']/10,'remark'=>$retData['remark'],
                    'file_id_big'=>$retData['file_id_big'],'file_id_small'=>$retData['file_id_small'],
                    'bigUrl'=>$bigUrl,'smallUrl'=>$smallUrl,'color_r'=>sprintf('%06x',$retData['color_r']),
                    'color_g'=>sprintf('%06x',$retData['color_g']),'color_b'=>sprintf('%06x',$retData['color_b'])];
            }
        }

        return (new View())->fetch('/celltype/edit', $data );
    }

    public function index()
    {
        if ($this->attest() != true) {
            abort(401);
        }

        $cur_cell_type = Request::instance()->param('cur_cell_type');
        $cur_cell_name = Request::instance()->param('cur_cell_name');

        $count = 0;
        $data = [];

        if ($cur_cell_type == null) {
            $cur_cell_type = 0;
            $cur_cell_name = '骨髓细胞检测';
        }

        $retData = apiCellType::apiCellTypeFacherList(Session::get('attest'), 1, $cur_cell_type);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                $data = $retData['data'];
                $count = count($data);
            }
        }

        return (new View())->fetch('/celltype/index', ['cur_cell_type' => $cur_cell_type, 'cur_cell_name' => $cur_cell_name,
            'count' => $count, 'data' => $data]);
    }

    public function ajax_add()
    {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $father_cell_type = Request::instance()->param('father_cell_type');
        $cn_name = Request::instance()->param('cn_name');
        $en_name = Request::instance()->param('en_name');
        $abb_name = Request::instance()->param('abb_name');
        $size_max = Request::instance()->param('size_max');
        $size_min = Request::instance()->param('size_min');
        $remark = Request::instance()->param('remark');
        $file_id_big = Request::instance()->param('file_id_big');
        $file_id_small = Request::instance()->param('file_id_small');
        $color_r = Request::instance()->param('color_r');
        $color_g = Request::instance()->param('color_g');
        $color_b = Request::instance()->param('color_b');
        $retData = apiCellType::apiCellTypeAdd($attest, 1, $father_cell_type, $cn_name, $en_name, $abb_name, $size_max * 10, $size_min * 10, $remark, $file_id_big,$file_id_small,
            $color_r,$color_g,$color_b);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                print 0;
            } else {
                print $retData['err_desc'];
            }

        } else {
            print 10000;
        }
    }

    public function ajax_drop()
    {
        $attest = Session::get('attest');
        $cell_type = Request::instance()->param('cell_type');
        $retData = apiCellType::apiCellTypeDrop($attest, 1, $cell_type);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                print 0;
            } else {
                print $retData['err_desc'];
            }

        } else {
            print 10000;
        }
    }

    public function ajax_list()
    {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $cell_start = Request::instance()->param('cell_start');
        $get_num = Request::instance()->param('get_num');
        $data = [];

        $retData = apiCellType::apiCellTypeList($attest, $check_type, $cell_start, $get_num);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                $data = $retData['data'];
            }
        }
        return $this->response(['data' => $data], 'json', 200);

    }

    public function ajax_son_list()
    {
        $attest = Session::get('attest');
        $cur_cell_type = Request::instance()->param('cur_cell_type');
        $data = [];

        $retData = apiCellType::apiCellTypeSonList($attest, 1, $cur_cell_type);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                $data = $retData['data'];

                for ($i = 0; $i < count($data); $i++) {
                    $data[$i]['size_max'] = $data[$i]['size_max'] / 10;
                    $data[$i]['size_min'] = $data[$i]['size_min'] / 10;
                }
            }
        }
        return $this->response(['data' => $data], 'json', 200);

    }


    public function ajax_get()
    {
        $attest = Session::get('attest');
        $data = [];
        $check_type = Request::instance()->param('check_type');
        $cell_type = Request::instance()->param('cell_type');
        $retData = apiCellType::apiCellTypeGet($attest, $check_type, $cell_type);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                $data = $retData['data'];
            }
        }
        return $this->response(['data' => $data], 'json', 200);

    }


    public function ajax_edit()
    {
        $attest = Session::get('attest');
        $check_type = Request::instance()->param('check_type');
        $cell_type = Request::instance()->param('cell_type');
        $info_ver = Request::instance()->param('info_ver');
        $cn_name = Request::instance()->param('cn_name');
        $en_name = Request::instance()->param('en_name');
        $abb_name = Request::instance()->param('abb_name');
        $size_max = Request::instance()->param('size_max');
        $size_min = Request::instance()->param('size_min');
        $remark = Request::instance()->param('remark');
        $file_id_big = Request::instance()->param('file_id_big');
        $file_id_small = Request::instance()->param('file_id_small');
        $color_r = Request::instance()->param('color_r');
        $color_g = Request::instance()->param('color_g');
        $color_b = Request::instance()->param('color_b');

        $retData = apiCellType::apiCellTypeSet($attest, 1, $cell_type, $info_ver, $cn_name, $en_name, $abb_name, $size_max * 10, $size_min * 10, $remark,$file_id_big,$file_id_small,
            $color_r,$color_g,$color_b);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                print 0;
            } else {
                print $retData['err_desc'];
            }

        } else {
            print 10000;
        }
    }

    public function ajax_father_list()
    {
        $attest = Session::get('attest');
        $data = [];
        $check_type = Request::instance()->param('check_type');
        $cell_type = Request::instance()->param('cell_type');
        $retData = apiCellType::apiCellTypeFacherList($attest, $check_type, $cell_type);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                $data = $retData['data'];
            }
        }
        return $this->response(['data' => $data], 'json', 200);

    }
}