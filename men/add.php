<?php
	//接值
	$all = $_REQUEST;
	$sname = isset($all['sname']) && !empty($all['sname']) ? trim($all['sname']) : "";
	$price = isset($all['price']) && !empty($all['price']) ? intval($all['price']) : 1;
	$num = isset($all['num']) && !empty($all['num']) ? intval($all['num']) : 1;
	$time = time();

	// 连接数据库
	$link = mysqli_connect('127.0.0.1','root','root','boss');
	// mysqli_select_db($link,"boss");
	$sql = "insert into shop (sname,price,num,add_time) values ('$sname','$price','$num','$time')";
	$res = mysqli_query($link,$sql);
	if ($res) {
		echo 1;
	}else{
		echo 2;
	}
?>