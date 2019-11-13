<?php
	// 连接redis
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379, 30);

	//接值
	$all = $_REQUEST;
	$sname = isset($all['sname']) && !empty($all['sname']) ? trim($all['sname']) : "";
	$price = isset($all['price']) && !empty($all['price']) ? intval($all['price']) : 1;
	$desc = isset($all['desc']) && !empty($all['desc']) ? intval($all['desc']) : 1;
	$all['add_time'] = time();

	// 添加到redis
	$id = $redis->incr("id");
	$data = $redis->hmset($id,$all);
	$res = $redis->rpush("list",$id);
	
	if(!empty($res)){
		echo 1;
	}else{
		echo 2;
	}
?>