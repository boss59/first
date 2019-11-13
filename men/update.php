<?php
$sid =$_GET['id'];
$link =mysqli_connect('127.0.0.1','root','root','boss');
$sql ="select * from shop where id='$sid'";
$result2 = mysqli_query($link,$sql);
$data = mysqli_fetch_assoc($result2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>商品添加</title>
	<script src="/jq.js"></script>
</head>
<body>
<marquee><h2><font color="blue">商品修改</font></h2></marquee>
<center>
	<input type="hidden" name="id" value="<?php echo $data['id']?>">
	<table border="1">
		<tr>
			<td>商品名称：</td>
			<td>
				<input type="text" name="sname" value="<?php echo $data['sname']?>">
			</td>
		</tr>
		<tr>
			<td>价格：</td>
			<td>
				<input type="text" name="price" value="<?php echo $data['price']?>">
			</td>
		</tr>
		<tr>
			<td>库存：</td>
			<td>
				<input type="text" name="num" value="<?php echo $data['num']?>">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="button" value="修改" name="btn">
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
		var name = $("input[name='sname']").val();
		var price = $("input[name='price']").val();
		var num = $("input[name='num']").val();

		data.id = id;
		data.sname = name;
		data.price = price;
		data.num = num;
		
		$.ajax({
			url:'/men/update_do.php',//请求地址
			type:'post',//请求的类型
			dataType:'json',//返回的类型
			data:data,//要传输的数据
			success:function(res){ //成功之后回调的方法
				if (res==1) {
					alert("修改成功");
					location.href = "/list.php";
				}else{
					alert("修改失败");
					location.href = "/list.php";
				}
			}
		})
	});
});
</script>