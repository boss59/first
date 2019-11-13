<?php
	$all = $_REQUEST;
	$name = isset($all['name']) && !empty($all['name']) ? trim($all['name']) : "";
	$pwd = isset($all['pwd']) && !empty($all['pwd']) ? intval($all['pwd']) : 1;
	$key = "user";


	// 第一种：方法 设置参数
	setcookie($key,$name,time()+24*60*60,'/','.session.com');

	// 第二种：利用src属性
	// echo '<script scr="http://www.aaa.session.com/login.php?user=$name"></script>';

?>