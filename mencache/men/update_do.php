<?php
	//接值
	$all = $_REQUEST;
	$sid = isset($all['id']) && !empty($all['id']) ? trim($all['id']) : "";
	$sname = isset($all['sname']) && !empty($all['sname']) ? trim($all['sname']) : "";
	$price = isset($all['price']) && !empty($all['price']) ? intval($all['price']) : 1;
	$num = isset($all['num']) && !empty($all['num']) ? intval($all['num']) : 1;
	$time = time();

	// 连接数据库
	$link = mysqli_connect('127.0.0.1','root','root','boss');
	// mysqli_select_db($link,"boss");
	$sql = "update shop set sname='$sname',price='$price',num='$num',add_time='$time' where id='$sid'";
	$res = mysqli_query($link,$sql);
	if ($res) {
		echo 1;
	}else{
		echo 2;
	}
?>