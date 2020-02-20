<?php

    // 商品列表
    header('content-type:text/html;charset=utf-8');
    $mysql  = new Mysqli('127.0.0.1','root','root','order');

    $mysql->query('set names utf8');

    $sql ='select * from shop_goods g LEFT JOIN shop_business b ON B.b_id = g.b_id';

    $goods_list = $mysql -> query($sql) -> fetch_all(MYSQLI_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品列表</title>
</head>
<body>
    <table border="1" align="center">
        <tr align="center">
            <td>编号</td>
            <td>商品名字</td>
            <td>商家id</td>
            <td>所属商家</td>
            <td>价格</td>
            <td>库存</td>
            <td>操作</td>
        </tr>
    <?php foreach ( $goods_list as $k => $v){?>
        <tr align="center">
            <td><?php echo $v['goods_id']?></td>
            <td><?php echo $v['goods_name']?></td>
            <td><?php echo $v['b_id']?></td>
            <td><?php echo $v['b_name']?></td>
            <td><?php echo $v['goods_price']?></td>
            <td><?php echo $v['stack']?></td>
            <td>
                <a href="./cart_add.php?goods_id=<?php echo $v['goods_id']?>&b_id=<?php echo $v['b_id']?>">加入购物车</a>
            </td>
        </tr>
    <?php }?>
    </table>
</body>
</html>
