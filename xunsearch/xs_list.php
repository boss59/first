<?php

    # 加载核心类
    require_once '/usr/local/xunsearch/xun/sdk/php/lib/XS.php';

    # 找到对应的配置文件，生成对象
    $xs = new XS('/usr/local/xunsearch/sdk/php/app/blog.ini');

    # 获取 搜索对象
    $search = $xs -> search;

    $keyword = $_GET['keyword'] ?? '';
    if (empty($keyword)){
//        exit('请输入keyword参数');
    }

    $page = $_GET['page'] ?? 1;
    $page_size = 5;
    $limit = ($page - 1) * $page_size;

    // 设置搜索语句
    $search->setQuery($keyword);
    // 增加附加条件：提升标题中包含 'xunsearch' 的记录的权重
    //$search->addWeight('subject', 'xunsearch');
    // 设置返回结果最多为 5 条，并跳过前 10 条
    $search->setLimit($page_size, $limit);

    // 按照点击量进行排序
    $sorts = array('click_count' => false);
    // 设置搜索排序
    $search -> setMultiSort($sorts);


    // 执行搜索，将搜索结果文档保存在 $docs 数组中
    $docs = $search->search();
    // 获取搜索结果的匹配总数估算值
    $count = $search->count();

    echo '共找到'.$count.'条数据';
    echo '<pre/><hr/>';
    // print_r($docs);



    // 高亮处理
    echo '<style>
                 em{
                    color: blue;
                    font-weight: bold;
                 }
              </style>';
//    foreach ($docs as $doc)
//    {
//        $subject = $search->highlight($doc->subject); // 高亮处理 subject 字段
//        $message = $search->highlight($doc->content); // 高亮处理 message 字段
//        echo $doc->rank() . '. ' . $subject . " [" . $doc->percent() . "%] - ";
//        echo "\n" . strip_tags(htmlspecialchars_decode($message),'<em />') . "\n";
//
//        echo "\n点击量为".$doc->click_count;
//        echo '<hr />';
//    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>展示</title>
    <style>
        em{
            color: blue;
            font-weight: bold;
        }
    </style>
</head>
<body>
<table border="1" align="center">
    <tr align="center">
        <td>编号</td>
        <td>标题</td>
        <td>内容</td>
        <td>点击量</td>
        <td>浏览量</td>
        <td>时间</td>
        <td>操作</td>
    </tr>
    <?php foreach ( $docs as $doc){?>
        <tr align="center">
            <td><?php echo $doc['id']?></td>
            <td><?php echo $doc['title']?></td>
            <td><?php echo strip_tags(htmlspecialchars_decode($doc['content']))?></td>
            <td><?php echo $doc['click_count']?></td>
            <td><?php echo $doc['favour_cont']?></td>
            <td><?php echo $doc['publish_time']?></td>
            <td>
                <a href="./xs_del.php?id=<?php echo $doc['id']?>?>">删除</a>
                <a href="./xs_update.php?id=<?php echo $doc['id']?>?>">修改</a>
            </td>
        </tr>
    <?php }?>
</table>
</body>
</html>
