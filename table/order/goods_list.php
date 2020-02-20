<?php

    // 商品列表
    header('content-type:text/html;charset=utf-8');
    $mysql  = new Mysqli('127.0.0.1','root','root','order');

    $mysql->query('set names utf8');

    $sql ='select * from shop_goods g LEFT JOIN shop_business b ON B.b_id = g.b_id';

    $goods_list = $mysql -> query($sql) -> fetch_all(MYSQLI_ASSOC);

    echo "<style>td{padding: 5px 10px;}</style>";
    echo '<table cellpadding="0" cellspacing="0" border="1">
    <tr>
           <tb>编号</tb>
           <tb>商品名字</tb>
           <tb>所属商家</tb>
           <tb>价格</tb>
           <tb>库存</tb>
           <tb>操作</tb>
    </tr></table>';

    foreach( $goods_list as $k => $v){

    echo '<tr>
           <tb>'.$k.'</tb>
           <tb>'.$v['goods_name'].'</tb>
           <tb>'.$v['b_id'].'</tb>
           <tb>'.$v['b_name'].'</tb>
           <tb>'.$v['goods_price'].'</tb>
           <tb>'.$v['status'].'</tb> 
           <tb><a href="./cart_add.php?goods_id='.$v['goods_id'].'&b_id='.$v['b_id'].'">加入购物车</a></tb>
        </tr>';
    }
?>