<?php
    include_once __DIR__ .'/Es.class.php';
    $es_obj = new Es();

    // 删除
    if (empty($_POST)){
        echo json_encode(['status'=>100,'msg'=>'error !','data'=>[]]);exit;
    }

    $goods_id = $_POST['goods_id'] ?? 0;
//    echo $goods_id;exit;
    if (empty($goods_id)){
        echo json_encode(['status'=>100,'msg'=>'少参数 goods_id error！','data'=>[]]);exit;
    }

    // 连接数据库
    $mysql  = new Mysqli('127.0.0.1','root','root','new_blog');
    $mysql -> query('set names utf8'); // 设置字符集

    $delete_sql = 'delete from goods where id='.$goods_id;
    $delete_result = $mysql -> query($delete_sql);

    if ($delete_result){
        $del = $es_obj
            -> index('goods')
            -> delete($goods_id);
        if ($del){
            echo json_encode(['status'=>200,'msg'=>'success','data'=>[]]);exit;
        }else{
            echo json_encode(['status'=>102,'msg'=>'文档删除失败','data'=>[]]);exit;
        }
    }else{
        echo json_encode(['status'=>102,'msg'=>'mysql delete fail','data'=>[]]);exit;
    }


?>