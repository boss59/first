<?php
	//连接
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211) or die ("连接失败");

	//接值
	$all = $_REQUEST;
	$uname = isset($all['uname']) && !empty($all['uname']) ? trim($all['uname']) : "";
	$address = isset($all['address']) && !empty($all['address']) ? intval($all['address']) : 1;
	$hobby = isset($all['hobby']) && !empty($all['hobby']) ? intval($all['hobby']) : 1;
	$all['add_time'] = time();

	// 存到 缓存
	$data = $mem->set("info",$all,0,24*60*60);
	if (!empty($data)) {
		echo 1;
	}else{
		echo 2;
	}

?>