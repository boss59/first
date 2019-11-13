<?php
	// 连接redis
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379, 30);

	$arr=$_REQUEST;
	$shop_id=$arr['id'];

	$arr=$redis->hmget($shop_id,["sname","price","desc","add_time"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>redis修改</title>
	<script src="/redis/jq.js"></script>
</head>
<body>
<marquee><h2><font color="blue">redis修改</font></h2></marquee>
<center>
	<input type="hidden" name="id" value="<?php echo $shop_id;?>">
	<table border="66">
		<tr>
			<td>商品名称：</td>
			<td>
				<input type="text" name="sname" value="<?php echo $arr['sname']?>">
			</td>
		</tr>
		<tr>
			<td>价格：</td>
			<td>
				<input type="number" name="price" value="<?php echo $arr['price']?>">
			</td>
		</tr>
		<tr>
			<td>描述：</td>
			<td>
				<input type="text" name="desc" value="<?php echo $arr['desc']?>">
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
		var id = $("input[name='id']").val();
		var sname = $("input[name='sname']").val();
		var price = $("input[name='price']").val();
		var desc = $("input[name='desc']").val();
		
		data.id = id;
		data.sname = sname;
		data.price = price;
		data.desc = desc;
		
		$.ajax({
			url:'/redis/update_do.php',//请求地址
			type:'post',//请求的类型
			dataType:'json',//返回的类型
			data:data,//要传输的数据
			success:function(res){ //成功之后回调的方法
				if (res==1) {
					alert("修改成功");
					location.href = "/redis/list.php";
				}else{
					alert("修改失败");
					location.href = "/add.html";
				}
			}
		})
	});
});
</script>