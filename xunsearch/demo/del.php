<?php

    // 删除
    if (empty($_POST)){
        echo json_encode(['status'=>100,'msg'=>'error !','data'=>[]]);exit;
    }

    $article_id = $_POST['article_id'] ?? 0;
    if (empty($article_id)){
        echo json_encode(['status'=>100,'msg'=>'少参数 article_id error！','data'=>[]]);exit;
    }

    // 连接数据库
    $mysql  = new Mysqli('127.0.0.1','root','root','new_blog');
    $mysql -> query('set names utf8'); // 设置字符集

    $delete_sql = 'delete from blog_article where id='.$article_id;
    $delete_result = $mysql -> query($delete_sql);

    if ($delete_result){
        # 加载核心类
        require_once '/usr/local/xunsearch/sdk/php/lib/XS.php';

        # 找到对应的配置文件，生成对象
        $xs = new XS('/usr/local/xunsearch/sdk/php/app/blog.ini');

        $index = $xs -> index;

        $del = $index->del($article_id); // 删除字段 subject 上带有索引词 abc 的所有记录

        if ($del){
            echo json_encode(['status'=>200,'msg'=>'success','data'=>[]]);exit;
        }else{
            echo json_encode(['status'=>102,'msg'=>'文档删除失败','data'=>[]]);exit;
        }

    }else{
        echo json_encode(['status'=>102,'msg'=>'mysql 删除失败','data'=>[]]);exit;
    }

?>