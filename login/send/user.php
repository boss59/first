<?php
	// header("Access-Control-Allow-Origin:*");
	// 连接数据库
	$link = mysqli_connect('127.0.0.1','root','root','boss');
	$sql = "select * from rob";
	$result = mysqli_query($link,$sql);
	$data=mysqli_fetch_all($result,MYSQLI_ASSOC);
	$json=json_encode($data);
	
	$callback = $_REQUEST['jsonpCallback'];
	echo "$callback($json)";
?>