<?php
	// 连接redis
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379, 30);

	// 分页
	$p = empty($_REQUEST['p']) ? 0:intval($_REQUEST['p']);
	$a = 3;
	// //计算偏移量
	$page_num = ($p-1) * 3;
	// $p=isset($_REQUEST['p'])?$_REQUEST['p']-1:0;
	// $page = 3;
	
	// $p*=$page;
	//计算总页码      总条数/每页显示的条数 = 总页数   ceil向上取整
	$count = $redis->llen("list");
	$total = ceil($count/$a);


	// 获取redis数据
	$data=$redis->lrange("list",$page_num,$page_num+$a-1);
	$array = [];
	foreach ($data as $k => $v) {
		$arr=$redis->hmget($v,["sname","price","desc","add_time"]);
		$arr["id"]=$v;
		$array[] = $arr;
	}

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
	<script src="/redis/jq.js"></script>
</head>
<body>
<center>
<button><a href="redis.html">添加</a></button>
		<table border="66">
			<tr>
				<td>编号：</td>
				<td>商品名称：</td>
				<td>商品价格：</td>
				<td>商品描述：</td>
				<td>添加时间</td>
				<td>操作</td>
			</tr>
		<?php 
			foreach ($array as $k => $v) {
		?>	
			<tr>
				<td><?php echo $v['id']?></td>
				<td><?php echo $v['sname']?></td>
				<td><?php echo $v['price']?></td>
				<td><?php echo $v['desc']?></td>
				<td><?php echo date("Y-m-d H:i:s",$v['add_time']) ?></td>
				<td>
					<a href="del.php?id=<?php echo $v['id'];?>" class="del">删除</a> ||
					<a href="update.php?id=<?php echo $v['id']?>">修改</a>
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