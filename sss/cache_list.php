<?php
	// 分页缓存
	$mysql_obj  = new Mysqli('127.0.0.1','root','root','aaa');

	$mysql_obj -> query('set names utf8');// 设置字符集

	$redis = new Redis();
	$redis -> connect('127.0.0.1','6379');

	# 定义版本号
	$user_list_version = 'user_list_version';
	$cache_version = $redis ->get($user_list_version);
	if (!$cache_version) {
		$cache_version = $redis -> incr($user_list_version);
	}

	$page=$_GET['page']??1;

	# 拼接分页的key
	$page_key = 'user_list_'.$page.'_'.$cache_version;

	echo "<br />";
	echo "pageKey:".$page_key;
	echo "<br />";

	$page_size =2;

	# 判断 redis中是否有数据
	$user_list =$redis ->get($page_key);
	if ($user_list === false) {
		# 计算偏移量
		$limit = ($page - 1) * $page_size;
		$sql = "select * from user limit ".$limit.','.$page_size;

		$obj = $mysql_obj->query($sql);

		if ($obj) {
			$user_list = $obj ->fetch_all(MYSQLI_ASSOC);
			$redis -> set($page_key,json_encode($user_list),60*5);

			echo "<pre />";
			echo 'mysql<hr />';
			var_dump($user_list);
		}else{

			$redis -> set($page_key,NUll);
			echo 'mysql<hr />';
			echo "无数据";
		}

	}else{
		echo "redis<hr/>";
		var_dump($user_list);
	}

	

