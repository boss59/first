<?php

    # 把按照用户规则分表的数据 分到 商家id进行分表
    $redis = new Redis();
    $redis -> connect('127.0.0.1',6379);

    $sync_key = 'sync_mark';
    $mark = $redis -> get($sync_key);

    # 为了保证这个同步脚本只有一个进程在执行，需要在 redis 写一个标识位
    if($mark !== false){
        exit('有其他进程正在同步，请稍后再执行');
    }
    $redis -> set($sync_key,1);

    # 1、取出已经同步的订单id
    $mysql  = new Mysqli('127.0.0.1','root','root','order');
    $mysql->query('set names utf8');

    $order_sync_sql = 'select * from order_sync where `type` = 1';
    $order_sync_info = $mysql -> query($order_sync_sql) -> fetch_assoc();

    if (empty($order_sync_info)){
        $son_mark = 1;
        $sync_order_son_id = 1;
    }else{
        $son_mark = 2;
        $sync_order_son_id = $order_sync_info['order_sync_id'];
    }


    # 2、把没有同步的数据，从按照用户规则分表的 订单子表中取出来    # 从 shop_order_son_user_01 迁移到 shop_order_son_business_01
    $wait_sync_sql = 'select * FROM (
                select * FROM shop_order_son_user_00 UNION
                select * FROM shop_order_son_user_01 UNION
                select * FROM shop_order_son_user_02 UNION
                select * FROM shop_order_son_user_03 UNION
                select * FROM shop_order_son_user_04 UNION
                select * FROM shop_order_son_user_05 UNION
                select * FROM shop_order_son_user_06 UNION
                select * FROM shop_order_son_user_07 UNION
                select * FROM shop_order_son_user_08 UNION
                select * FROM shop_order_son_user_09 ) as t
                where t.order_id >= '.$sync_order_son_id.' order by order_son_id asc limit 10';

    $wait_sync = $mysql ->query($wait_sync_sql) -> fetch_all(MYSQLI_ASSOC);

    foreach ($wait_sync as $k =>$v){
        $max_son_id = $v['order_son_id'];
    }

    # 同步订单子表的数据 到 按照商家维度的表中

    foreach ($wait_sync as $k => $v){

        #根据商家 id 对 10 取余 写入商家对应的表中
        $table_number = $v['business_id'] % 10;
        $table_name = 'shop_order_son_business_0'.$table_number;

        $sync_sql = 'insert into  '.$table_name.'
        (`order_son_id`,`order_id`,`user_id`,`order_amount`,`order_status`,`business_id`)
        values('.$v['order_son_id'].','.$v['order_id'].','.$v['user_id'].','.$v['order_amount'].',
        '.$v['order_status'].','.$v['business_id'].' )';

        echo $sync_sql;
        echo "<hr />";
        $result = $mysql -> query($sync_sql);

        if ( !$result){
            file_put_contents(__DIR__.'/fail.log','order_son写入失败，id为'.$v['order_son_id']."\r\n",8);
        }
    }


    # 3.同步商品表的数据 查出已经同步的订单详情数据
    $order_detail_sync_sql = 'select * from order_sync where `type` = 2';
    $order_detail_sync_info = $mysql -> query($order_detail_sync_sql) -> fetch_assoc();

    if (empty($order_detail_sync_info)){
        $detail_mark = 1;
        $sync_order_detail_id = 1;
    }else{
        $detail_mark = 1;
        $sync_order_detail_id = $order_detail_sync_info['order_sync_id'];
    }

    $order_goods_sync_sql = 'select * FROM (
                select * FROM shop_order_detail_user_00 UNION
                select * FROM shop_order_detail_user_01 UNION
                select * FROM shop_order_detail_user_02 UNION
                select * FROM shop_order_detail_user_03 UNION
                select * FROM shop_order_detail_user_04 UNION
                select * FROM shop_order_detail_user_05 UNION
                select * FROM shop_order_detail_user_06 UNION
                select * FROM shop_order_detail_user_07 UNION
                select * FROM shop_order_detail_user_08 UNION
                select * FROM shop_order_detail_user_09 ) as t 
                where t.order_id >='.$sync_order_detail_id.' order by detail_id asc limit 20';

    $goods_detail_info =$mysql -> query($order_goods_sync_sql) -> fetch_all(MYSQLI_ASSOC);

    foreach ($goods_detail_info as $k => $v){
        $table_number = $v['business_id'] % 10;
        $table_name = 'shop_order_detail_business_0'.$table_number;

        $insert_sql = 'insert into '.$table_name.'
        (`detail_id`,`order_id`,`business_id`,`order_son_id`,`goods_id`,`goods_name`,`buy_number`,`goods_price`)
        values('.$v['detail_id'].','.$v['order_id'].','.$v['business_id'].','.$v['order_son_id'].','.$v['goods_id'].',"'.$v['goods_name'].'",'.$v['buy_number'].','.$v['goods_price'].' )';

        echo $insert_sql;
        echo "<hr />";
        $result = $mysql -> query($insert_sql);
        if (!$result){
            file_put_contents(__DIR__.'/fail.log','order_detail写入失败 ，id为'.$v['detail_id']."\r\n",8);
        }
        $max_detail_id = $v['detail_id'];
    }

    # 4 把同步完成的订单数据 把订单子表 order_son_id 写入到 同步表中 order_sync
    if ($son_mark == 1){
        $son_sql = 'insert into order_sync (`order_sync_id`,`type`) values('.$max_son_id.',1)';
    }else{
        $son_sql = 'update order_sync set order_sync_id='.$max_son_id.' where `type` = 2';
    }

    $mysql -> query($son_sql);

    # 5 详情的数据 同步完的数据id 记录下来
    if ($detail_mark == 1){
        $detail_sql = 'insert into order_sync (`order_sync_id`,`type`) values('.$max_detail_id.',1)';
    }else{
        $detail_sql = 'update order_sync set order_sync_id='.$max_detail_id.' where `type` = 2';
    }

    $mysql -> query($detail_sql);

    # 6 、 脚本执行完成之后，把标识位删掉，防止阻塞
    $redis -> del($sync_key);
?>