<?php
    // 删除
    # 加载核心类
    require_once '/usr/local/xunsearch/sdk/php/lib/XS.php';

    # 找到对应的配置文件，生成对象
    $xs = new XS('/usr/local/xunsearch/sdk/php/app/blog.ini');

    $index = $xs -> index;

    $all = $_REQUEST;
    $id = isset($all['id']) && !empty($all['id']) ? trim($all['id']) : 1;
    $index->del($id); // 删除字段 subject 上带有索引词 abc 的所有记录

    header("refresh:2,url='/xunsearch/xs_list.php'");
?>