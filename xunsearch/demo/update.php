<?php

    // 修改
    // 连接数据库
    $mysql  = new Mysqli('127.0.0.1','root','root','new_blog');
    $mysql -> query('set names utf8'); // 设置字符集

    $article_id = $_GET['id'] ?? 0;
    $article_id = intval($article_id);
    if (empty($article_id)){
        echo json_encode(['status'=>100,'msg'=>'少参数 article_id error！','data'=>[]]);exit;
    }


    if (!empty($_POST)){

        # 修改 mysql 的数据
        $title = $_POST['title'] ?? '';
        if (empty($title)){
            echo json_encode(['status' => 1000,'msg'=>'标题不可为空']);exit;
        }
        $content = $_POST['content'] ?? '';
        if (empty($content)){
            echo json_encode(['status' => 1000,'msg'=>'内容不可为空']);exit;
        }


        $click_count = rand(1,1000);
        $favour_count = rand(1,1000);

        $update_sql = 'update blog_artice  set
        `title` ="'.addslashes($title).'",`content` = "'.addslashes($content).'",`click_count` ='.$click_count.',`favour_cont` = '.$favour_cont.',`publish_time` = '.time().' where id ='.$article_id;
        //        echo $update_sql;exit;
        $update_result = $mysql -> query($update_sql);

        if ($update_result){
            # 加载核心类
            require_once '/usr/local/xunsearch/sdk/php/lib/XS.php';

            # 找到对应的配置文件，生成对象
            $xs = new XS('/usr/local/xunsearch/sdk/php/app/blog.ini');

            $index = $xs -> index;
            $data = array(
                'id'=> $article_id,
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

            if ($add){
                echo json_encode(['status' => 200,'msg'=>'success','data'=>[]]);exit;
            }else{
                echo json_encode(['status' => 100,'msg'=>'fail','data'=>[]]);exit;
            }
        }else{
            echo json_encode(['status' => 100,'msg'=>'mysql update fail','data'=>[]]);exit;
        }



    }else{

        $sql = 'select * from blog_article where id='.$article_id;
        $info = $mysql -> query($sql) -> fetch_assoc();
        if (empty($info)){
            echo json_encode(['status' => 102,'msg'=>'暂无数据','data'=>[]]);exit;
        }

    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>讯搜 * 修改</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!--    <link rel="stylesheet" href="http://47.104.210.223:1903/xs/demo/layui/css/layui.css"  media="all">-->
    <link rel="stylesheet" href="http://1903.vonetxs.com/status/layui/css/layui.css" media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
<center>
<br />
<a href="index.php">返回列表</a>
<hr/>

<form class="layui-form" >
    <input type="text" name="hidden" readonly value="<?php echo $article_id?>"/>
    <div class="layui-form-item">
        <label class="layui-form-label">标题</label>
        <div class="layui-input-block">
            <input type="text" name="title" lay-verify="required" lay-reqtext="标题不能为空"
                   placeholder="请输入标题" autocomplete="off"
                   value="<?php echo $info['title']?>"
                   class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">内容</label>
        <div class="layui-input-block">
            <input type="tel" name="content" placeholder="请输入文章内容" lay-verify="required"
                   autocomplete="off" class="layui-input" value="<?php echo $info['content']?>" >
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script src="http://1903.vonetxs.com/status/layui/layui.js"></script>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form;
        var $ = layui.jquery;

        //监听提交
       form.on('submit(formDemo)', function(data){
           var json = data.field;
           $.ajax({
               url:'./update.php',
               type:'post',
               dataType:'json',
               data:json,
               success:function( json_info ){
                   console.log(json_info);
               }
           });
           return false;
       });
    });
</script>

</center>
</body>
</html>
