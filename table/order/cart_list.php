<?php

    //购物车列表 页
    header('content-type:text/html;charset=utf-8');
    $mysql  = new Mysqli('127.0.0.1','root','root','order');

    $mysql->query('set names utf8');

    $sql = 'select * from shop_cart c LEFT JOIN  shop_goods g ON g.goods_id = c.goods_id where user_id = 1';


    $cart_list = $mysql -> query($sql) -> fetch_all(MYSQLI_ASSOC);

    $cart_id = '';
    foreach($cart_list as $v){
        $cart_id .=$v['cart_id'].',';
    }

    echo '<a href="./submit.php?cart_id='.$cart_id.'">生成订单</a><br /><hr />';

    print_r($cart_list);
?>