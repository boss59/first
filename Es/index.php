<?php
    header('content-type:text/html;charset=utf-8');
    include_once __DIR__ .'/Es.class.php';
    $es_obj = new Es();


    if (!empty($_POST))
    {
        $page = $_POST['page'] ?? 1;
        $page_size = $_POST['limit'] ?? 10;

        $keyword = $_POST['keyword'] ?? '';
        if (!empty($keyword)){
            $match = [
                'goods_name' => $keyword
            ];
            $data = $es_obj
                ->index('goods')
                ->match($match)
                ->page($page,$page_size)
                ->findAll();
        }else{
            $data = $es_obj
                ->index('goods')
                ->page($page,$page_size)
                ->findAll();
        }

        $list = [];
        foreach ($data['data'] as $k => $v)
        {
            $list[$k]['goods_id'] = $v['goods_id'];
            $list[$k]['goods_name'] = $v['goods_name'];
            $list[$k]['goods_price'] = $v['goods_price'];
            $list[$k]['goods_stack'] = $v['goods_stack'];
            $list[$k]['goods_desc'] = $v['goods_desc'];
            $list[$k]['create_time'] = date('Y-m-d H:i:s',$v['create_time']);
        }

        // 返回数据
        $data = [
            'code' => 0,
            'msg'=>'success',
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
    <title>es展示</title>
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
                ,url:'./index.php' //数据接口
                ,method:'post'
                ,page: true //开启分页
                ,cellMinWidth: 80
                // ,initSort:{
                //     field : 'id'
                //     ,type :'desc'
                // }
                ,cols: [[ //表头
                    {field: 'goods_id', width:80, title: 'ID'}
                    ,{field: 'goods_name', width:100, title: '商品名称'}
                    ,{field: 'goods_price', width:180, title: '商品价格', sort: true}
                    ,{field: 'goods_stack', width:180, title: '商品数量', sort: true}
                    ,{field: 'goods_desc', width:350, title: '商品描述',}
                    ,{field: 'create_time', width:180, title: '添加时间', sort: true}
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
                    url: './index.php'
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
                    url: './index.php'
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
                // alert(data);
                var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
                var tr = obj.tr; //获得当前行 tr 的 DOM 对象（如果有的话）

                console.log( data );
                if(layEvent === 'detail'){ //查看
                    layer.msg('查看');
                    //do somehing
                } else if(layEvent === 'del'){ //删除
                    layer.confirm('确定要删除这篇文章吗?', function(index){

                        //向服务端发送删除指令
                        var goods_id = data.goods_id;
                        // alert(goods_id);
                        $.ajax({
                            url:'./del.php',
                            data:'goods_id='+goods_id,
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
                    var goods_id = data.goods_id;
                    window.location.href = './update.php?goods_id='+goods_id;
                } else if(layEvent === 'LAYTABLE_TIPS'){
                    layer.alert('Hi，头部工具栏扩展的右侧图标。');
                }
            });


        });
    </script>

</center>
</body>
</html>

