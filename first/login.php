<?php
	// 连接数据库 查数据库
	$link = mysqli_connect('127.0.0.1','root','root','aaa');
	// 接值
	$all = $_REQUEST;
	$uname = isset($all['uname']) && !empty($all['uname']) ? trim($all['uname']) : "";
	$pwd = $all['pwd'];

	// 转数字
	$num = sprintf("%u",crc32($uname))%4;
	$sql = "select * from  user_".$num." where uname='$uname' and pwd='$pwd'";
	$result = mysqli_query($link,$sql);
	$arr=mysqli_fetch_assoc($result);
	if (isset($arr)) {
		echo 1;
	}else{
		echo 2;
	}
?>