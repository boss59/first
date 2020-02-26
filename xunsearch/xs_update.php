<?php
    # 加载核心类
    require_once '/usr/local/xunsearch/sdk/php/lib/XS.php';

    # 找到对应的配置文件，生成对象
    $xs = new XS('/usr/local/xunsearch/sdk/php/app/blog.ini');

    # 获取 搜索对象
    $search = $xs -> search;

    $id = isset($_GET['id']) && !empty($_GET['id']) ? trim($_GET['id']) : 1;

    // 设置搜索语句
    $search->setQuery($id);

    // 执行搜索，将搜索结果文档保存在 $docs 数组中
    $docs = $search->search();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>讯搜修改</title>
    <script src="/redis/jq.js"></script>
</head>
<body>
<marquee><h2><font color="blue">讯搜修改</font></h2></marquee>
<center>
    <table border="1">
        <tr>
            <td>标号：</td>
            <td>
                <input type="number" name="id" <?php echo $docs['id']?>>
            </td>
        </tr>
        <tr>
            <td>标题：</td>
            <td>
                <input type="text" name="title" <?php echo $docs['title']?>>
            </td>
        </tr>
        <tr>
            <td>内容：</td>
            <td>
                <input type="text" name="content" <?php echo $docs['content']?>>
            </td>
        </tr>
        <tr>
            <td>点击量：</td>
            <td>
                <input type="number" name="click_count" <?php echo $docs['content']?>>
            </td>
        </tr>
        <tr>
            <td>浏览量：</td>
            <td>
                <input type="number" name="favour_cont" <?php echo $docs['content']?>>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="button" value="立即提交" name="btn">
            </td>
        </tr>
    </table>
</center>
</body>
</html>

<script>
    $(document).ready(function(){
        $("input[name='btn']").click(function(){
            var data = {};// 定义一个空的json串
            data.id = $("input[name='id']").val();
            data.title = $("input[name='title']").val();
            data.content = $("input[name='content']").val();
            data.click_count = $("input[name='click_count']").val();
            data.favour_cont = $("input[name='favour_cont']").val();

            $.ajax({
                url:'/xunsearch/xs_update_do.php',//请求地址
                type:'post',//请求的类型
                dataType:'json',//返回的类型
                data:data,//要传输的数据
                success:function(res){ //成功之后回调的方法
                    if (res==1) {
                        alert("修改成功");
                        location.href = "/xunsearch/xs_list.php";
                    }else{
                        alert("修改失败");
                        location.href = "/xunsearch/xs_list.php";
                    }
                }
            })
        });
    });
</script>
