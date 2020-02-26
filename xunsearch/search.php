<?php

    # 加载核心类
    require_once '/usr/local/xunsearch/xun/sdk/php/lib/XS.php';

    # 找到对应的配置文件，生成对象
    $xs = new XS('/usr/local/xunsearch/sdk/php/app/blog.ini');

    # 获取 搜索对象
    $search = $xs -> search;

    $keyword = $_GET['keyword'] ?? '';
    if (empty($keyword)){
        exit('请输入keyword参数');
    }

    // 设置搜索语句
    $search->setQuery($keyword);
    // 增加附加条件：提升标题中包含 'xunsearch' 的记录的权重
    //$search->addWeight('subject', 'xunsearch');
    // 设置返回结果最多为 5 条，并跳过前 10 条
    //$search->setLimit(5, 10);

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
    foreach ($docs as $doc)
    {
        $subject = $search->highlight($doc->subject); // 高亮处理 subject 字段
        $message = $search->highlight($doc->content); // 高亮处理 message 字段
        echo $doc->rank() . '. ' . $subject . " [" . $doc->percent() . "%] - ";
        echo "\n" . strip_tags(htmlspecialchars_decode($message),'<em />') . "\n";

        echo "\n点击量".$doc->click_count;
        echo '<hr />';
    }

?>