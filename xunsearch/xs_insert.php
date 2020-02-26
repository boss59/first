<?php

    # 加载核心类
    require_once '/usr/local/xunsearch/sdk/php/lib/XS.php';

    # 找到对应的配置文件，生成对象
    $xs = new XS('/usr/local/xunsearch/sdk/php/app/blog.ini');

    // 接值
    $id = isset($_POST['id']) && !empty($_POST['id']) ? trim($_POST['id']) : 1;
    $title = isset($_POST['title']) && !empty($_POST['title']) ? trim($_POST['title']) : '';
    $content = isset($_POST['content']) && !empty($_POST['content']) ? trim($_POST['content']) : '';
    $click_count = isset($_POST['click_count']) && !empty($_POST['click_count']) ? trim($_POST['click_count']) : '';
    $favour_cont = isset($_POST['favour_cont']) && !empty($_POST['favour_cont']) ? trim($_POST['favour_cont']) : '';

    $index = $xs -> index;
    $data = array(
        'id'=> $id,
        'title' => $title,
        'content' => $content,
        'publish_time' => date('Y-m-d H:i:s'),
        'click_count' => $click_count,
        'favour_cont' => $favour_cont
    );

    // 创建文档对象
    $doc = new XSDocument;
    $doc->setFields($data);

    // 添加到索引数据库中
    $add = $index-> update($doc);

    print_r($add);
    if ($add){
        echo 1;
    }
?>