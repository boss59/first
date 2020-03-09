<?php
    include_once __DIR__ .'/Es.class.php';
    $es_obj = new Es();

    // 连接数据库
    $mysql  = new Mysqli('127.0.0.1','root','root','new_blog');
    $mysql -> query('set names utf8'); // 设置字符集

    $goods_id = $_GET['goods_id'] ?? 0;

    $goods_id = intval($goods_id);
    if (empty($goods_id)){
        echo json_encode(['status'=>100,'msg'=>'少参数 goods_id error！','data'=>[]]);exit;
    }

    $info = $es_obj
        ->index('goods')
        ->fields(['goods_id,goods_name','goods_price','goods_stack','goods_desc'])
        ->findOne($goods_id);

    if ( !empty($_POST) ){
        $goods_name= $_POST['goods_name'] ?? '';
        if (empty($goods_name)){
            echo json_encode(['status' => 1000,'msg'=>'商品名称不可为空']);exit;
        }
        $goods_price = $_POST['goods_price'] ?? '';
        if (empty($goods_price)){
            echo json_encode(['status' => 1000,'msg'=>'商品价格不可为空']);exit;
        }
        $goods_stack = $_POST['goods_stack'] ?? '';
        if (empty($goods_stack)){
            echo json_encode(['status' => 1000,'msg'=>'商品库存不可为空']);exit;
        }
        $goods_desc = $_POST['goods_desc'] ?? '';
        if (empty($goods_desc)){
            echo json_encode(['status' => 1000,'msg'=>'商品描述不可为空']);exit;
        }

        $update_sql = 'update goods  set
        `goods_name` ="'.addslashes($goods_name).'",`goods_price` = '.$goods_price.',`goods_stack` ='.$goods_stack.',`goods_desc` = "'.addslashes($goods_desc).'",`create_time` = '.time().' where id ='.$goods_id;
        //        echo $update_sql;exit;
        $update_result = $mysql -> query($update_sql);

        if ($update_result){
            $data = [
                'goods_id' => $goods_id,
                'goods_name' => $goods_name,
                'goods_price' => $goods_price,
                'goods_stack' =>$goods_stack,
                'goods_desc' =>$goods_desc,
                'create_time' => date('Y-m-d H:i:s'),
            ];

            $fp = fopen(__DIR__.'/myKeyword.txt','a+');
            $len = fwrite($fp,$data['goods_name']."\r\n");
            fclose($fp);

            echo json_encode(['status' => 102,'msg'=>'fail','data'=>[]]);exit;

        }else{
            echo json_encode(['status' => 102,'msg'=>'mysql update fail','data'=>[]]);exit;
        }

    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>es 修改</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="http://1903.vonetxs.com/status/layui/css/layui.css" media="all">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
</head>
<body>
<center>
    <br />
    <a href="./index.php">返回列表</a>
    <hr/>

    <form class="layui-form layui-form-pane" >

        <input type="hidden" name="goods_id" readonly value="<?php echo $goods_id?>"/>
        <div class="layui-form-item">
            <label class="layui-form-label">商品名称</label>
            <div class="layui-input-block">
                <input type="text" name="goods_name" lay-verify="required" lay-reqtext="商品名称不能为空"
                       placeholder="请输入商品名称" autocomplete="off" class="layui-input"
                       value="<?php echo $info['goods_name']?>">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">商品价格</label>
            <div class="layui-input-block">
                <input type="text" name="goods_price" lay-verify="required" lay-reqtext="商品价格不能为空"
                       placeholder="请输入商品价格" autocomplete="off" class="layui-input"
                       value="<?php echo $info['goods_price']?>">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">商品库存</label>
            <div class="layui-input-block">
                <input type="text" name="goods_stack" lay-verify="required" lay-reqtext="商品库存不能为空"
                       placeholder="请输入商品库存" autocomplete="off" class="layui-input"
                       value="<?php echo $info['goods_stack']?>">
            </div>
        </div>


        <div class="layui-form-item">
            <label class="layui-form-label">商品描述</label>
            <div class="layui-input-block">
                <input type="text" name="goods_desc" lay-verify="required" lay-reqtext="商品描述不能为空"
                       placeholder="请输入商品描述" autocomplete="off" class="layui-input"
                       value="<?php echo $info['goods_desc']?>">
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
                        if (json_info.status == 200){
                            window.location.replace("http://1903.vonetxs.com/Es/index.php");
                        }else{
                            window.location.replace("http://1903.vonetxs.com/Es/add.php");
                        }
                    }
                });
                return false;
            });
        });
    </script>

</center>
</body>
</html>
