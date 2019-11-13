<?php
	ob_start();// 开启缓冲
	// $res=ob_end_clean();die;#清空缓冲
	
	//连接 Memcache
	$mem = new Memcache();
	$mem->connect("127.0.0.1",11211);
	// 连接数据库
	$link = mysqli_connect('127.0.0.1','root','root','boss');

	if (file_exists("list.html")) {
		echo "html文件";
		$contents = file_get_contents("list.html");
		echo $contents;die;
	}else{
		// 判断redis中是否有数据
		$key = "list";
		if (!empty($mem->get($key))) {
			echo "memcache";
			$data=$mem->get($key);
		}else{
			echo "数据库";
			$sql = "select * from rob";
			$result = mysqli_query($link,$sql);
			$data=mysqli_fetch_all($result,MYSQLI_ASSOC);
			$mem->set($key,$data,0,24*60*60);
		}
	}	
?>
<marquee><h2><font color="blue">商品展示</font></h2></marquee>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>展示</title>
	<script src="/jq.js"></script>
</head>
<body>
<center>
		<table border="66">
			<tr>
				<td>编号：</td>
				<td>名称：</td>
				<td>地址：</td>
				<td>语录：</td>
				<td>操作</td>
			</tr>
		<?php 
			foreach ($data as $k => $v) {
		?>
			<tr>
				<td><?php echo $v['rid'] ?></td>
				<td><?php echo $v['name'] ?></td>
				<td><?php echo $v['address'] ?></td>
				<td><?php echo $v['desc'] ?></td>
				<td>
					<a href="del.php?id=<?php echo $v['rid'];?>" class="del">删除</a> ||
					<a href="update.php?id=<?php echo $v['rid'];?>">修改</a>
				</td>
			</tr>
		<?php }?>
		</table>
</center>
</body>
</html>
<?php
	$con = ob_get_contents();
	$res = file_put_contents("list.html",$con);
?>