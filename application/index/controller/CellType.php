<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2017/3/3
 * Time: 15:12
 */

namespace app\index\controller;


use app\index\api\apiCellType;
use think\controller\Rest;
use think\Request;
use think\Session;
use think\View;

class CellType extends Rest
{
    public function add()
    {
        $father_cell_type = Request::instance()->param('father_cell_type');
        $father_cell_name = Request::instance()->param('father_cell_name');

        return (new View())->fetch('/celltype/add', ['father_cell_type' => $father_cell_type, 'father_cell_name' => $father_cell_name]);
    }

    public function edit()
    {
        $father_cell_type = Request::instance()->param('father_cell_type');
        $father_cell_name = Request::instance()->param('father_cell_name');
        $cell_type = Request::instance()->param('cell_type');
        $data = [];

        $retData = apiCellType::apiCellTypeGet(Session::get('attest'), 1, $cell_type);
        if ($retData) {
            if ($retData['ret_code'] == 0) {
                $data = ['father_cell_type' => $father_cell_type, 'father_cell_name' => $father_cell_name,
                    'cell_type'=>$cell_type,'info_ver'=>$retData['info_ver'],
                    'cn_name'=>$retData['cn_name'],'en_name'=>$retData['en_name'],
                    'abb_name'=>$retData['abb_name'],'size_max'=>$retData['size_max']/10,
                    'size_min'=>$retData['size_min']/10,'remark'=>$retData['remark']];
            }
        }

        return (new View())->fetch('/celltype/edit', $data );
    }

    public function index()
    {
        $cur_cell_type = Request::instance()->param('cur_cell_type');
        $cur_cell_name = Request::instance()->param('cur_cell_name');

        $count = 0;
        $data = [];

        if ($cur_cell_type == null) {
            $cur_cell_type = 0;
            $cur_cell_name = '骨髓有核细胞检测';
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
        $retData = apiCellType::apiCellTypeAdd($attest, 1, $father_cell_type, $cn_name, $en_name, $abb_name, $size_max * 10, $size_min * 10, $remark);
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
        $retData = apiCellType::apiCellTypeSet($attest, 1, $cell_type, $info_ver, $cn_name, $en_name, $abb_name, $size_max * 10, $size_min * 10, $remark);
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