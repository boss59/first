<?php
	//连接 缓存
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211) or die ("连接失败");

	$send = $mem->get("info");

	$uname=$send['uname'];
	$address=$send['address'];
	$hobby=$send['hobby'];
	$add_time=$send['add_time'];

	// 连接数据库
	$link = mysqli_connect('127.0.0.1','root','root','boss');
	// mysqli_select_db($link,"boss");
	$sql = "insert into men (uname,address,hobby,add_time) values ('$uname','$address','$hobby','$add_time')";
	$res = mysqli_query($link,$sql);
    file_put_contents("D:/phpstudy_pro/WWW/shop/person/s.txt",$res."\n",FILE_APPEND);


?>