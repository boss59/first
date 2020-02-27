<?php
    header('content-type:text/html;charset=utf-8');

    # 加载核心类
    require_once '/usr/local/xunsearch/sdk/php/lib/XS.php';

    # 找到对应的配置文件，生成对象
    $xs = new XS('/usr/local/xunsearch/sdk/php/app/blog.ini');

    if (!empty($_POST))
    {
        $page = $_POST['page'] ?? 1;
        $page_size = $_POST['limit'] ?? 10;

        $search = $xs -> search;

        # 计算偏移量
        $limit = ($page - 1) * $page_size;

        $keyword = $_POST['keyword'] ?? '';
        // 设置搜索语句
        $search->setQuery($keyword);

        // 增加附加条件：提升标题中包含 'xunsearch' 的记录的权重
        //$search->addWeight('subject', 'xunsearch');
        // 设置返回结果最多为 5 条，并跳过前 10 条
        $search->setLimit($page_size, $limit);

        // 字段排序
        if (empty($_POST['field'])){

            # 默认按照点击量进行排序
            $sorts = array('click_count' => false);
        }else{

            if ($_POST['order'] == 'asc'){
                $sorts = array($_POST['field'] => true);
            }else{
                $sorts = array($_POST['field'] => false);
            }
        }

        // 设置搜索排序
        $search -> setMultiSort($sorts);

        // 执行搜索，将搜索结果文档保存在 $docs 数组中
        $docs = $search->search();

        // 获取搜索结果的匹配总数估算值
        $count = $search->count();

        $list = [];
        foreach ($docs as $k => $doc)
        {
            $list[$k]['id'] = $doc -> id;
            $list[$k]['title'] = $search->highlight($doc -> title);
            $list[$k]['content'] = $search->highlight(strip_tags(htmlspecialchars_decode($doc ->content)));
            $list[$k]['publish_time'] = date('Y-m-d H:i:s',$doc -> publish_time);
            $list[$k]['click_count'] = $doc -> click_count;
            $list[$k]['favour_cont'] = $doc -> favour_cont;
        }

        // 返回数据
        $data = [
            'code' => 0,
            'msg'=>'success',
            'count'=>$count,
            'data'=>$list
        ];
        echo json_encode($data);
        exit;


    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>讯搜展示</title>
    <link rel="stylesheet" href="http://1903.vonetxs.com/status/layui/css/layui.css" media="all">
    <style>
        em{
            color: blue;
            font-weight: bold;
        }
    </style>
</head>
<body>
<center>
    <br />
    <a href="./add.php">返回添加</a>
    <hr />

    <div class="demoTable">
        搜索关键字：
        <div class="layui-inline">
            <input class="layui-input" name="keyword" id="keyword" autocomplete="off">
        </div>
        <button class="layui-btn" data-type="reload">搜索</button>
    </div>



<table class="layui-hide" lay-filter="test" id="test"></table>

<script src="http://1903.vonetxs.com/status/layui/layui.js"></script>
    <script type="text/html" id="barDemo">
        <a class="layui-btn layui-btn-xs" lay-event="detail">查看</a>
        <a class="layui-btn layui-btn-xs" lay-event="edit">编辑</a>
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>

    </script>

<script>
    layui.use('table', function(){
        var table = layui.table;
        var $ = layui.jquery;
        table.render({
            elem: '#test'
            ,url:'./list.php' //数据接口
            ,method:'post'
            ,page: true //开启分页
            ,cellMinWidth: 80
            // ,initSort:{
            //     field : 'id'
            //     ,type :'desc'
            // }
            ,cols: [[ //表头
                {field: 'id', width:80, title: 'ID'}
                ,{field: 'title', width:270, title: '标题'}
                ,{field: 'content', width:280, title: '内容'}
                ,{field: 'click_count', width:100, title: '点击量', sort: true}
                ,{field: 'favour_cont', width:100, title: '关注', sort: true}
                ,{field: 'publish_time',width:200, title: '发布时间', sort: true}
                ,{title: '操作',fixed: 'right', width:280, align:'center', toolbar: '#barDemo'} //这里的toolbar值是模板元素的选择器
            ]]
        });

        //监听排序事件  排序
        table.on('sort(test)', function(obj){ //注：sort 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
            console.log(obj.field); //当前排序的字段名
            console.log(obj.type); //当前排序类型：desc（降序）、asc（升序）、null（空对象，默认排序）
            console.log(this); //当前排序的 th 对象

            //尽管我们的 table 自带排序功能，但并没有请求服务端。
            //有些时候，你可能需要根据当前排序的字段，重新向服务端发送请求，从而实现服务端排序
            var keyword = $('#keyword').val();

            table.reload('test', {
                url: './list.php'
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where:{
                    'keyword':keyword
                    ,field: obj.field //排序字段
                    ,order: obj.type //排序方式
                } //设定异步数据接口的额外参数
            });

            //layer.msg('服务端排序。order by '+ obj.field + ' ' + obj.type);
        });



        // 搜索功能  重载
        $('.demoTable .layui-btn').on('click', function(){

            var keyword = $('#keyword').val();
            //执行重载
            table.reload('test', {
                url: './list.php'
                ,page: {
                    curr: 1 //重新从第 1 页开始
                }
                ,where: {
                    'keyword':keyword
                } //设定异步数据接口的额外参数
            });
        });


        //监听工具条  操作
        table.on('tool(test)', function(obj){ //注：tool 是工具条事件名，test 是 table 原始容器的属性 lay-filter="对应的值"
            var data = obj.data; //获得当前行数据
            var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
            var tr = obj.tr; //获得当前行 tr 的 DOM 对象（如果有的话）

            console.log( data );
            if(layEvent === 'detail'){ //查看
                layer.msg('查看');
                //do somehing
            } else if(layEvent === 'del'){ //删除
                layer.confirm('确定要删除这篇文章吗?', function(index){

                    //向服务端发送删除指令
                    var article_id = data.id;
                    alert(article_id);
                    $.ajax({
                        url:'./del.php',
                        data:'article_id='+article_id,
                        type:'post',
                        dataType:'json',
                        success:function( json_info ){
                            // console.log(json_info);
                            if( json_info.status == 200 ){
                                obj.del(); //删除对应行（tr）的DOM结构，并更新缓存
                                layer.close(index);
                            }
                        }

                    })
                });
            } else if(layEvent === 'edit'){ //编辑
                // console.log(data);
                var article_id = data.id;
                window.location.href = './update.php?id='+article_id;
            } else if(layEvent === 'LAYTABLE_TIPS'){
                layer.alert('Hi，头部工具栏扩展的右侧图标。');
            }
        });


    });
</script>

</center>
</body>
</html>
