<?php
	// 连接redis
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379, 30);

	$arr=$_REQUEST;
	$shop_id=$arr['id'];

	$res=$redis->lrem("list",$shop_id);
	$ress=$redis->del("id");
	if ($res){
	    echo 1;
	}else{
	    echo 2;
	}
?>