<?php
	//连接
	// $mem = new Memcache();
	// $mem->connect("127.0.0.1",11211);
	
	$title = empty($_GET['title']) ? "" : $_GET['title'];
	$content = empty($_GET['content']) ? "" : $_GET['content'];
	
	//1.接收页码
	$p = empty($_REQUEST['p']) ? 1:intval($_REQUEST['p']);
	//2.计算偏移量
	$page_num = ($p-1) * 3;

	// 连接数据库
	$link = mysqli_connect('127.0.0.1','root','root','boss');
	$sql = 'select * from new where title like "%$title%" and content like "%$content%" limit $page_num,3';
	$result = mysqli_query($link,$sql);
	$data=mysqli_fetch_all($result,MYSQLI_ASSOC);


	//1.查询总条数
	$sql2 = 'select count(*) as con from new where title like "%$title%" and content like "%$content%"';
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
	<script src="/redis/jq.js"></script>
</head>
<body>
<center>
<button><a href="/new/add.php">添加</a></button>
<div>
	<form action="/new/list.php" method="get">
		标题：<input type="text" name='title'>
		内容：<input type="text" name='content'>
		<!-- 排序：<select name="sh">
				<option value="asc">正序</option>
				<option value="desc">倒叙</option>
		</select>	 -->
		<input type="submit" value='搜索' id="btn">
	</form>
</div>
		<table border="66">
			<tr>
				<td>标题：</td>
				<td>内容：</td>
				<td>时间：</td>
				<td>图片：</td>
				<td>操作：</td>
			</tr>
		<tbody id="#list">
		<?php 
			foreach ($data as $k => $v) {
		?>
			<tr align="center">
				<td><?php echo $v['title'] ?></td>
				<td><?php echo $v['content'] ?></td>
				<td><?php echo $v['pdate_src'] ?></td>
				<td><img src="<?php echo $v['img'] ?>" alt="没有图片" width="100" height="70"></td>
				<td>
					<a href="del.php?nid=<?php echo $v['nid'];?>">删除</a> 
					<a href="update.php?nid=<?php echo $v['nid'];?>">修改</a>
				</td>
			</tr>
		<?php }?>
		</table>
		</tbody>		
<div id="page">
	<a href="list.php?p=1&title=<?php echo $title ?>&content=<?php echo $content ?>">首页</a> &nbsp;
	<a href="list.php?p=<?php echo $pp ?>&title=<?php echo $title ?>&content=<?php echo $content ?>">上一页</a> &nbsp;
		<?php 
			for ($i=1; $i <=$total ; $i++) { 
		 ?>
			<a href="list.php?p=<?php echo $i ?>&title=<?php echo $title ?>&content=<?php echo $content ?>"><?php echo $i ?></a>
		 <?php } ?>
	&nbsp;
	<a href="list.php?p=<?php echo $ppp ?>&title=<?php echo $title ?>&content=<?php echo $content ?>">下一页</a> &nbsp;
	<a href="list.php?p=<?php echo $total ?>&title=<?php echo $title ?>&content=<?php echo $content ?>">尾頁</a>	
</div>		
</center>
</body>
</html>
<script>
// $(function(){
// 	// 分页
// 	$(document).on('click','#page a',function(){
// 	  event.preventDefault();//阻止默认事件行为的触发  a 标签
// 	  var url = $(this).attr('href');//获取  a 标签// alert(url);
// 	  page(url);
// 	})


// function page(url){
// 	$.ajax({
// 	    url:url,//请求地址
// 	    type:'get',//请求的类型
// 	    dataType:'json',//返回的类型
// 	    success:function(res){ //成功之后回调的方法
// 	      $('#list').empty();//清空 tr td
// 	      $.each(res.data,function(k,v){
// 	        var tr = $('<tr align="center"></tr>');//创建td

// 	        tr.append('<td>'+v.title+'</td>');
// 	        tr.append('<td>'+v.content+'</td>');
// 	        tr.append('<td>'+v.pdate_src+'</td>');
// 	        tr.append('<td><img src="'+v.img+'" alt="没有图片" width="100" height="70"></td>');
	 

	       
// 	        $('#list').append(tr).css('color','blue');
// 	      })
// 	       $('#page').html(res.page);//替换页码
// 	    }
// 	  })
// }
// })

</script>

