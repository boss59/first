<?php

    // 确认订单
    header('content-type:text/html;charset=utf-8');
    $mysql  = new Mysqli('127.0.0.1','root','root','order');
    $mysql->query('set names utf8');

    // 接值
    $cart_id = trim($_GET['cart_id'],',');
    $user_id = 1;

    # 取出来购物车的数据
    $cart_sql = 'select * from shop_cart c LEFT JOIN  shop_goods g ON g.goods_id = c.goods_id where cart_idin( '.$cart_id.' )';
    $cart_list = $mysql -> query($cart_sql) -> fetch_all(MYSQLI_ASSOC);

    # 1. 根据 用户 id 确定 用户的数量 写入那张表中
    # 分表规则：对用户 id 对 10 进行取余
    $table_number = $user_id % 10;
    $order_table_name = 'shop_order_0'.$table_number;// 订单表


    # 开启事务
    $mysql->query('begin');

    #########   2. 写入订单表的数据   ##############
    # 从 redis 中取出订单的 id
    $redis = new Redis();
    $redis -> connect('127.0.0.1',6379);

    $order_id_key = 'shop_order_next_id';
    $order_id = $redis -> get($order_id_key);

    # 从redis 中 没有读取到下一次要写入的id
    if ($order_id === false){
        $order_id_sql ='select * FROM shop_order_00 UNION
                select * FROM shop_order_01 UNION
                select * FROM shop_order_02 UNION
                select * FROM shop_order_03 UNION
                select * FROM shop_order_04 UNION
                select * FROM shop_order_05 UNION
                select * FROM shop_order_06 UNION
                select * FROM shop_order_07 UNION
                select * FROM shop_order_08 UNION
                select * FROM shop_order_09 UNION
                ORDER BY order_id DESC limit 1';
        echo "订单表sql：".$order_id_sql;
        $order_id_info = $mysql -> query($order_id_sql) ->fetch_assoc();

        if (empty($order_id_info)){
            $order_id = 1;
        }else{
            $order_id = $order_id_info['order_id'];
        }
    }
    echo "<hr />";
    ##########################################################

try{
    // 计算 订单 金额
    $order_amount = 0;
    foreach($cart_list as $k => $v){
        $order_amount += $v['goods_price'] * $v['buy_number'];// 订单总金额
    }

    // 生成订单号
    $order_no = time().rand(1000,9999);

    // 生成 订单
    $order_insert_sql = 'insert into '.$order_table_name.' 
    (`order_id`,`order_no`,`user_id`,`order_amount`,`order_status`) 
    values( '.$order_id.','.$order_no.','.$user_id.','.$order_amout.',1)';
    echo "订单sql:".$order_insert_sql;
    $obj = $mysql -> query($order_insert_sql);

    //$order_id = $mysql -> insert_id;// 获取order_id
    echo '<br />order_id:'.$order_id.'<hr />';
    ################### 2 写入订单表的数据 END ###########

    ################### 2 写入订单子表的数据 START ##################
    $order_son_id_key = 'shop_order_son_next_id';
    $order_son_id = $redis -> get($order_son_id_key);

    # 从redis中 没有读取 到下一次的要写入的id
    if ($order_son_id === false){
        $order_son_id_sql ='select * FROM shop_order_son_00 UNION
                select * FROM shop_order_son_01 UNION
                select * FROM shop_order_son_02 UNION
                select * FROM shop_order_son_03 UNION
                select * FROM shop_order_son_04 UNION
                select * FROM shop_order_son_05 UNION
                select * FROM shop_order_son_06 UNION
                select * FROM shop_order_son_07 UNION
                select * FROM shop_order_son_08 UNION
                select * FROM shop_order_son_09 UNION
                ORDER BY order_son_id DESC limit 1';
        echo "订单子表".$order_son_id_sql;
        $order_son_id_info = $mysql -> query($order_son_id_sql) ->fetch_assoc();

        if (empty($order_son_id_sql)){
            $order_son_id = 1;
        }else{
            $order_son_id = $order_son_id_info['order_son_id'];
        }
    }
    echo "<hr />";

    echo '写入订单子表的id：'.$order_son_id.'<br />';
    $order_son_table_name = 'shop_order_son_user_0'.$table_number;// 订单子表


    $new = [];
    foreach( $cart_list as $k =>$v){
        $new[$v['b_id']][] = $v;
    }

    ### 3. 获取 订单 详情表的 id #####################
    $detail_id_key = 'shop_order_detail_id_key';
    $detail_id = $redis -> get($detail_id_key);

    # 从redis中 没有读取 到下一次的要写入的id
    if ($detail_id === false){
        $detail_id_sql ='select * FROM shop_order_detail_user_00 UNION
                select * FROM shop_order_detail_user_01 UNION
                select * FROM shop_order_detail_user_02 UNION
                select * FROM shop_order_detail_user_03 UNION
                select * FROM shop_order_detail_user_04 UNION
                select * FROM shop_order_detail_user_05 UNION
                select * FROM shop_order_detail_user_06 UNION
                select * FROM shop_order_detail_user_07 UNION
                select * FROM shop_order_detail_user_08 UNION
                select * FROM shop_order_detail_user_09 UNION
                ORDER BY detail_id DESC limit 1';
        echo "订单详情表".$detail_id_sql;
        $detail_id_info = $mysql -> query($detail_id_sql) ->fetch_assoc();

        if (empty($detail_id_info)){
            $detail_id = 1;
        }else{
            $detail_id = $detail_id_info['detail_id'];
        }
    }
    echo "<hr />";

    echo '写入订单详情表的id：'.$detail_id.'<br />';
    $detail_table_name = 'shop_order_detail_user_0'.$table_number;// 订单详情表

    # 根据 商家 生成 子订单数 【写入订单子表】
    foreach ($new as $k => $v){
        # $v 当前商家下购买的商品数据
        $business_order_amount = 0;
        foreach ($v as $kk => $vv){
            $business_order_amount += $vv['buy_number'] * $vv['goods_price'];
            # 写入 订单详情表的数据
            $detail_id_insert_sql = 'insert into '.$detail_table_name.'
            (`detail_id`,`order_id`,`order_son_id`,`goods_id`,`goods_name`,`goods_price`)
            values( '.$detail_id.','.$order_id.','.$order_son_id.','.$vv['goods_id'].','.$vv['goods_name'].','.$vv['goods_price'].')';
            echo '订单详情表添加：'.$detail_id_insert_sql;
            $mysql -> query($detail_id_insert_sql);
            $detail_id ++;
        }
        echo "<br />";
        $order_son_insert_sql = 'insert into '.$order_son_table_name.'
        (`order_son_id`,`order_id`,`user_id`,`order_amout`,`order_status`)
        values( '.$order_son_id.','.$order_id.','.$user_id.','.$business_order_amount.',1)';
        $order_son_id ++;

        echo '订单子表添加：'.$order_son_insert_sql;
        $mysql -> query($order_son_insert_sql);
        echo '<hr />';

    }

    # 把订单 id 写入 redis 中
    $redis -> set($order_id_key,($order_id +1),60 * 30);
    # 把订单子表 id 写入 redis 中
    $redis -> set($order_son_id_key,$order_son_id,60 * 30);
    # 把订单详情 id 写入 redis 中
    $redis -> set($detail_id_key,$detail_id,60 * 30);

    $mysql ->query('commit');
}catch (Exception $e){
    $mysql ->query('rollback');
    var_dump($e -> getMessage());
}

?>