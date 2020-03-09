<?php
    # 加载 composer 自动加载文件
    require 'vendor/autoload.php';

    use Elasticsearch\ClientBuilder;
    # 实例化Es客户端
    $client = ClientBuilder::create()->build();

    # 添加数据
    $params = [
        'index' => 'my_index',
        'id'    => 'my_id',
        'body'  => ['id' => 1,'title'=>'布鲁']
    ];

    $response = $client->index($params);
    echo "<pre/>";
    print_r($response);

    echo "<hr />";

    # 获取数据
//    $params = [
//        'index' => 'my_index',
//        'id'    => 1
//    ];
//
//    $response = $client->get($params);
//    print_r($response);
//
//    echo "<hr />";

    # 搜索数据
//    $params = [
//        'index' => 'my_index',
//        'body'  => [
//            'query' => [
//                'match' => [
//                    'title' => '布鲁'
//                ]
//            ]
//        ]
//    ];
//
//    $response = $client->search($params);
//    print_r($response);
//
//    echo "<hr />";

    # 删除文档
//    $params = [
//        'index' => 'my_index',
//        'id'    => 1
//    ];
//
//    try{
//        $response = $client->delete($params);
//    }catch (Exception $e){
//        var_dump($e ->getMessage());
//    }
//
//    print_r($response);
//
//
//    # 删除索引
//    $deleteParams = [
//        'index' => 'my_index'
//    ];
//    $response = $client->indices()->delete($deleteParams);
//    print_r($response);
//
//
//    # 搜索名称
//    $params = [
//        'index' => 'article',
//        'body'  => [
//            'query' => [
//                'match' => [
//                    'title' => '布雷泽'
//                ]
//            ]
//        ]
//    ];
//
//    $results = $client->search($params);

    $milliseconds = $results['took'];
    $maxScore     = $results['hits']['max_score'];

    $score = $results['hits']['hits'][0]['_score'];
    $doc   = $results['hits']['hits'][0]['_source'];

    var_dump($score);
    var_dump($doc);


?>