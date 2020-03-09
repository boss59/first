<?php
    # 把 MYSQL 数据 同步到 Es 中
    header('content-type:text/html;charset=utf-8');

    $limit = 2;
    $goods_log = __DIR__.'/sync_goods.log';

    if (file_exists($goods_log)){
        $sync_id = file_get_contents($goods_log);
    }else{
        $sync_id = 0;
    }

    // 连接数据库
    $mysql  = new Mysqli('127.0.0.1','root','root','new_blog');
    $mysql -> query('set names utf8'); // 设置字符集

    $sql = 'select * from goods where goods_id >'.$sync_id.' limit '.$limit;
    $goods_list = $mysql -> query($sql) -> fetch_all(MYSQLI_ASSOC);

    echo '<pre/>';
    print_r($goods_list);

    if (empty($goods_list)){
        exit('商品同步完成');
    }


    # 将查询出来的数据 写入 Es 中
    include_once __DIR__ .'/Es.class.php';
    $es_obj = new Es();

    foreach($goods_list as $k=>$v){

        $add = $es_obj
            ->index('goods')
            ->save($v['goods_id'],$v);

        if ($add){
            file_put_contents($goods_log,$v['goods_id'],FILE_USE_INCLUDE_PATH);
        }else{
            exit('die');
        }
    }

?>