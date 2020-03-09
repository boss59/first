<?php
    include_once __DIR__ .'/Es.class.php';
    $es_obj = new Es();
    echo '<pre/>';


    ##########################   es  增删改查    ####################

    # 写入数据
//        $arr = [
//            'id' => 8,
//            'title' => '深海之心',
//            'content' => '顾名思义它来自深海，拥有再生复制的能力。直到疯狂科学家利用深海之心造出了机械要塞时，人们才意识到它的威力',
//            'click_count' => rand(1,1000)
//        ];
//        $info = $es_obj
//            ->index ('article')
//            ->save(8,$arr);


    # 查询多条数据
//        $info = $es_obj
//            ->index('goods')
//            ->findAll();


    # 查询单条数据
    //    $info = $es_obj
    //        ->index('article')
    //        ->fields(['title,'content'])
    //        ->findOne(8);


    # 删除数据
    //    $info = $es_obj
    //        -> index('article')
    //        -> delete(3);
    //
//        var_dump($info);


    ###########################  es where条件 page  #################

//    $where = [
//        ['title','=','布雷泽'],
//        ['click_count','=',849],
//        ['click_count','>',900],
//        ['content','like','亦正亦邪'],
//    ];
//
//    $arr = [
//        ['click_count','=',491],
//        ['title','=','艾尔·布鲁'],
//    ];
//    $data = $es_obj
//        ->where($where)
//        ->whereOr($arr)
//        ->index('article')
//        ->findAll();
//        ->page(1,5);


    ############################### es ik 分词  ###########################

    $match = [
        'goods_name' => '离子魔方'
    ];

    $list = $es_obj
            ->index('goods')
            ->match($match)
            ->findAll();

    var_dump($list);

    exit;


















?>