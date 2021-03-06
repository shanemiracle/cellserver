<?php
/**
 * Created by PhpStorm.
 * User: xiaojie
 * Date: 2018/7/3
 * Time: 14:51
 */

namespace app\index\api;


use Elasticsearch\ClientBuilder;

class apiElastic
{
    private $hosts = ['127.0.0.1:9200'];
    private $client = null;

    /**
     * apiElastic constructor.
     */
    public function __construct()
    {
        if($this->client == null){
            $this->client = ClientBuilder::create()->setHosts($this->hosts)->build();
        }
    }


//    public function apiDelIndex($name)
//    {
//        $params = ['index'=>$name];
//
//        if($this->client == null){
//            return 0;
//        }
//
//        return $this->client->indices()->delete($params);
//    }
    

    public function apiAddIndexProject()
    {
        $params=[
            'index'=>'project',
            'body'=>[
                'settings'=>[
                    'refresh_interval'=>'10s',
                    'translog'=>[
                        'sync_interval'=>'20s',
                        'durability'=>'async'
                    ],
                    'number_of_shards'=>3,
                    'number_of_replicas'=>0,
                    'max_result_window'=>1000000

                ],
                'mappings'=>[
                    'project'=>[
                        'properties'=>[
                            'project_no'=>['type'=>'keyword'],
                            'hospital_no'=>['type'=>'integer'],
                            'hospital_name'=>['type'=>'keyword'],
                            'percent'=>['type'=>'integer'],
                            'end_time'=>['type'=>'keyword'],
                            'sign_doctor'=>['type'=>'keyword'],
                            'sign_name'=>['type'=>'keyword'],
                            'patient_name'=>['type'=>'keyword'],
                            'patient_gender'=>['type'=>'keyword'],
                            'patient_age'=>['type'=>'keyword'],
                            'section_id'=>['type'=>'keyword'],
                            'sample_part'=>['type'=>'keyword'],
                            'diag_doctor'=>['type'=>'keyword'],
                            'diag_name'=>['type'=>'keyword'],
                            'diag_time'=>['type'=>'keyword'],
                            'shot_doctor'=>['type'=>'keyword'],
                            'shot_name'=>['type'=>'keyword'],
                            'shot_time'=>['type'=>'keyword'],
                            'suggest'=>['type'=>'text'],
                            'check_result'=>['type'=>'text'],
                            'diag_data'=>['type'=>'text'],
                            'project_db'=>['type'=>'integer'],
                            'photo_db'=>['type'=>'integer']
                        ]
                    ]
                ]
            ]
        ];

        return $this->client->indices()->create($params);
    }

    public function apiAddIndexPhoto()
    {
        $params=[
            'index'=>'photo',
            'body'=>[
                'refresh_interval'=>'10s',
                'translog'=>[
                    'sync_interval'=>'20s',
                    'durability'=>'async'
                ],
                'settings'=>[
                    'number_of_shards'=>3,
                    'number_of_replicas'=>0,
                    'max_result_window'=>1000000

                ],
                'mappings'=>[
                    'photo'=>[
                        'properties'=>[
                            'project_no'=>['type'=>'keyword'],
                            'photo_seq'=>['type'=>'short'],
                            'photo_type'=>['type'=>'byte'],
                            'file_id'=>['type'=>'keyword'],
                            'file_name'=>['type'=>'keyword'],
                            'is_select_check'=>['type'=>'byte'],
                            'slide_no'=>['type'=>'byte'],
                            'end_time'=>['type'=>'keyword']
                        ]
                    ]
                ]
            ]
        ];

        return $this->client->indices()->create($params);
    }

    public function apiAddIndexCell()
    {
        $params=[
            'index'=>'cell',
            'body'=>[
                'settings'=>[
                    'refresh_interval'=>'10s',
                    'translog'=>[
                        'sync_interval'=>'20s',
                        'durability'=>'async'
                    ],
                    'number_of_shards'=>3,
                    'number_of_replicas'=>0,
                    'max_result_window'=>1000000

                ],
                'mappings'=>[
                    'cell'=>[
                        'properties'=>[
                            'project_no'=>['type'=>'keyword'],
                            'cell_seq'=>['type'=>'short'],
                            'photo_seq'=>['type'=>'short'],
                            'file_id'=>['type'=>'keyword'],
                            'file_name'=>['type'=>'keyword'],
                            'x_pos'=>['type'=>'integer'],
                            'y_pos'=>['type'=>'integer'],
                            'x_length'=>['type'=>'integer'],
                            'y_length'=>['type'=>'integer'],
                            'cell_type'=>['type'=>'integer'],
                            'is_select_check'=>['type'=>'byte'],
                            'slide_no'=>['type'=>'byte'],
                            'photo_type'=>['type'=>'byte'],
                            'end_time'=>['type'=>'keyword']
                        ]
                    ]
                ]
            ]
        ];

        return $this->client->indices()->create($params);
    }


    public function getProject($from,$size,$start_time,$hos_no,$user,$per_st,$per_ed)
    {
        $match =  [];
        if($hos_no!=null)
        {
            array_push($match,["match"=>['hospital_no'=>$hos_no]]);
        }
        if($user != null )
        {
            array_push($match,["match"=>['sign_doctor'=>$user]]);
        }

        //print(json_encode($match));

        $params = [
            'index'=>'project',
            'type'=>'project',
            'body'=>[
                'query'=>[
                    'bool'=>[
                        'must'=>
                            count($match)!=0?$match:["match_all"=>new \stdClass()]
                           // ['match'=>['hospital_no'=>$hos_no]],
                          //  ['match'=>['sign_doctor'=>$user]]
                        ,
                        'filter'=>[
                            ['range'=>['end_time'=>['gt'=>$start_time]]],
                            ['range'=>['percent'=>['gte'=>$per_st,'lte'=>$per_ed]]]
                        ],


                    ],

                ],
                "sort"=> [
                    ["end_time"=>  ["order"=> "asc" ]]

                ],
                '_source'=>['hospital_no','hospital_name','project_no','end_time','project_db','photo_db','percent'],
                'from'=>$from,
                'size'=>$size
            ]

        ];
        // print(json_encode($params));
        $total = 0;
        $time = 0;
        $all_data = [];

        $response = $this->client->search($params);
//        return $response;

        if(array_key_exists('hits',$response))
        {
            $ret_code = 0;
            $ret_desc = 'ok';
            $all = $response['hits'];
            $total = $all['total'];
            $time = $response['took'];
            $r_data = $all['hits'];
            $all_num = count($r_data);
            for($i =$all_num; $i >0;  $i--){
                array_push($all_data,$r_data[$i-1]['_source']);
            }
        }
        else{
            $ret_code = -1;
            $ret_desc = '失败';
        }


        return ['ret_code'=>$ret_code,'ret_desc'=>$ret_desc,'time'=>$time,'total'=>$total,'get_num'=>count($all_data),'data'=>$all_data];
    }


    public function getCell($from,$size,$is_select,$project,$type)
    {
        $hos =  [];
        $match = [];
        if($project!= null)
        {
            array_push($match,["match"=>['project_no'=>$project]]);
        }

        if($type!= null)
        {
            array_push($match,["match"=>['cell_type'=>$type]]);
        }

        array_push($match,["match"=>['is_select_check'=>$is_select]]);

        $params = [
            'index'=>'cell',
            'type'=>'cell',
            'body'=>[
                'query'=>[
                    'bool'=>[
                        'must'=>$match,
                    ],

                ],

//                '_source'=>['file_id','x_pos','y_pos','x_length','y_length','cell_type','is_select_check','project_no'],
                'from'=>$from,
                'size'=>$size
            ]

        ];
        // print(json_encode($params));
        $total = 0;
        $time = 0;
        $all_data = [];

        $response = $this->client->search($params);
//        return $response;

        if(array_key_exists('hits',$response))
        {
            $all = $response['hits'];
            $total = $all['total'];
            $time = $response['took'];
            $r_data = $all['hits'];
            for($i =0; $i < count($r_data); $i++){
                array_push($all_data,$r_data[$i]['_source']);
            }
        }


        return ['time'=>$time,'total'=>$total,'get_num'=>count($all_data),'data'=>$all_data];
    }

    public function getPhoto($from,$size,$is_select)
    {
        $hos =  [];
        $params = [
            'index'=>'photo',
            'type'=>'photo',
            'body'=>[
                'query'=>[
                    'bool'=>[
                        'must'=>["match"=>['is_select_check'=>$is_select]],
                    ],

                ],

                //'_source'=>['file_id','x_pos','y_pos','x_length','y_length','cell_type','is_select_check','project_no'],
                'from'=>$from,
                'size'=>$size
            ]

        ];
        // print(json_encode($params));
        $total = 0;
        $time = 0;
        $all_data = [];

        $response = $this->client->search($params);
//        return $response;

        if(array_key_exists('hits',$response))
        {
            $all = $response['hits'];
            $total = $all['total'];
            $time = $response['took'];
            $r_data = $all['hits'];
            for($i =0; $i < count($r_data); $i++){
                array_push($all_data,$r_data[$i]['_source']);
            }
        }


        return ['time'=>$time,'total'=>$total,'get_num'=>count($all_data),'data'=>$all_data];
    }

}