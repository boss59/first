<?php

    // 加入购物车
    header('content-type:text/html;charset=utf-8');

    $goods_id = $_GET['goods_id']??0;
    $buy_number = 1;

    if (!$goods_id){
        exit('goods_id不正确');
    }
    $business_id =$_GET['b_id'];
    $user_id =1;

    $mysql  = new Mysqli('127.0.0.1','root','root','order');

    $sql = 'insert into shop_cart(`goods_id`,`user_id`,`b_id`,`buy_number`,`status`) values('.$goods_id.','.$user_id.','.$b_id.',1,1)';

    $cart = $mysql -> query($sql);
    if ($cart){
        echo '<a href="./cart_list.php"> <button>购物车列表</button> </a>';
    }else{
        echo "fail";
    }
?>