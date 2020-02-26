<?php

    # 加载核心类
    require_once '/usr/local/xunsearch/xun/sdk/php/lib/XS.php';

    # 找到对应的配置文件，生成对象
    $xs = new XS('/usr/local/xunsearch/sdk/php/app/blog.ini');

    // 接值
    $all = $_REQUEST;
    $id = isset($all['id']) && !empty($all['id']) ? trim($all['id']) : 1;
    $title = isset($all['title']) && !empty($all['title']) ? intval($all['title']) : '';
    $content = isset($all['content']) && !empty($all['content']) ? intval($all['content']) : '';
    $click_count = isset($all['click_count']) && !empty($all['click_count']) ? intval($all['click_count']) : '';
    $favour_cont = isset($all['favour_cont']) && !empty($all['favour_cont']) ? intval($all['favour_cont']) : '';


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

    echo 1;
?>