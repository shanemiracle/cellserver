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


    public function apiDelIndex($name)
    {
        $params = ['index'=>$name];

        if($this->client == null){
            return 0;
        }

        return $this->client->indices()->delete($params);
    }
    

    public function apiAddIndexProject()
    {
        $params=[
            'index'=>'project',
            'body'=>[
                'settings'=>[
                    'number_of_shards'=>3,
                    'number_of_replicas'=>0

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
                'settings'=>[
                    'number_of_shards'=>5,
                    'number_of_replicas'=>0

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
                            'slide_no'=>['type'=>'byte']
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
                    'number_of_shards'=>5,
                    'number_of_replicas'=>0

                ],
                'mappings'=>[
                    'cell'=>[
                        'properties'=>[
                            'project_no'=>['type'=>'keyword'],
                            'cell_seq'=>['type'=>'short'],
                            'photo_seq'=>['type'=>'short'],
                            'file_id'=>['type'=>'keyword'],
                            'file_name'=>['type'=>'keyword'],
                            'x_pos'=>['type'=>'short'],
                            'y_pos'=>['type'=>'short'],
                            'x_length'=>['type'=>'short'],
                            'y_length'=>['type'=>'short'],
                            'cell_type'=>['type'=>'integer'],
                            'is_select_check'=>['type'=>'byte'],
                            'slide_no'=>['type'=>'byte'],
                            'photo_type'=>['type'=>'byte']
                        ]
                    ]
                ]
            ]
        ];

        return $this->client->indices()->create($params);
    }


    public function getProject($from,$size,$start_time,$hos_no,$per_st,$per_ed)
    {
        $hos =  [];
        $params = [
            'index'=>'project',
            'type'=>'project',
            'body'=>[
                'query'=>[
                    'bool'=>[
                        'must'=>[$hos_no!=null?["match"=>['hospital_no'=>$hos_no]]:["match_all"=>new \stdClass()]],
                        'filter'=>[
                            ['range'=>['end_time'=>['gt'=>$start_time]]],
                            ['range'=>['percent'=>['gt'=>$per_st,'lt'=>$per_ed]]]
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


    public function getCell($from,$size,$is_select)
    {
        $hos =  [];
        $params = [
            'index'=>'cell',
            'type'=>'cell',
            'body'=>[
                'query'=>[
                    'bool'=>[
                        'must'=>["match"=>['is_select_check'=>$is_select]],
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