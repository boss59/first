<?php
	//连接
	$mem = new Memcache();
	$mem->connect("127.0.0.1",11211);

	//1.接收页码
	$p = empty($_REQUEST['p']) ? 1:intval($_REQUEST['p']);
	//2.计算偏移量
	$page_num = ($p-1) * 3;

	// 连接数据库
	$link = mysqli_connect('127.0.0.1','root','root','boss');

	// 缓存
	$key = "data_$p";
	if (!empty($mem->get($key))) {
		$data=$mem->get($key);
	}else{
		$sql = "select * from shop limit $page_num,3";
		$result = mysqli_query($link,$sql);
		$data=mysqli_fetch_all($result,MYSQLI_ASSOC);
		$mem->set($key,$data,0,200);
	}

	//计算页码
	//1.查询总条数
	$sql2 = "select count(*) as con from shop";
	$result2 = mysqli_query($link,$sql2);
	$res2 = mysqli_fetch_assoc($result2);
	$count = $res2['con'];
	//计算总页码      总条数/每页显示的条数 = 总页数   ceil向上取整
	$total = ceil($count/3);

	//上一頁的判斷
	$pp = $p-1;
	if($pp <= 0 ){
		$pp = 1;
	}
	//下一頁
	$ppp = $p + 1;
	if($ppp > $total){
		$ppp = $total;
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
<button><a href="add.html">添加</a></button>
		<table border="66">
			<tr>
				<td>编号：</td>
				<td>名称：</td>
				<td>价格：</td>
				<td>数量：</td>
				<td>添加时间</td>
				<td>操作</td>
			</tr>
		<?php 
			foreach ($data as $k => $v) {
		?>
			<tr>
				<td><?php echo $v['id'] ?></td>
				<td><?php echo $v['sname'] ?></td>
				<td><?php echo $v['price'] ?></td>
				<td><?php echo $v['num'] ?></td>
				<td><?php echo date("Y-m-d H:i:s",$v['add_time']) ?></td>
				<td>
					<a href="del.php?id=<?php echo $v['id'];?>" class="del">删除</a> ||
					<a href="update.php?id=<?php echo $v['id'];?>">修改</a>
				</td>
			</tr>
		<?php }?>
		</table>

	<a href="list.php?p=1">首页</a> &nbsp;
	<a href="list.php?p=<?php echo $pp ?>">上一页</a> &nbsp;
		<?php 
			for ($i=1; $i <=$total ; $i++) { 
		 ?>
			<a href="list.php?p=<?php echo $i ?>"><?php echo $i ?></a>
		 <?php } ?>
	&nbsp;
	<a href="list.php?p=<?php echo $ppp ?>">下一页</a> &nbsp;
	<a href="list.php?p=<?php echo $total ?>">尾頁</a>		
</center>
</body>
</html>
<script>
$(document).ready(function(){
	$(".del").click(function(){
		event.preventDefault();//阻止默认事件行为的触发  a 标签
  		var _this = $(this);//定义
  		var url = _this.attr('href');//获取 a 标签// alert(url);
  		$.ajax({
		    url:url,//请求地址
		    success:function(res){ //成功之后回调的方法
		      if(res == 1){
		        alert("ojbk");
		        window.location.reload();
		      }else{
		        alert("删除失败");
		      }
		    }
		})

	});
});
</script>