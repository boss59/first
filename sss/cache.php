<?php
	$mysql_obj  = new Mysqli('127.0.0.1','root','root','aaa');

	$mysql_obj -> query('set names utf8');// 设置字符集

	$redis = new Redis();
	$redis -> connect('127.0.0.1','6379');

	# 拼接 redis 的 key
	$key = 'user_list_123';

	# 读取 redis 数据
	$user_list = $redis -> get($key);

	if ( $user_list === false) 
	{
		echo 'redis不存在数据，从mysql读取';
		$sql = 'select * form user where user_id < 1';
		$result = $mysql_obj -> query($sql);

		if ($result) {
			$result = $result -> fetch_all(MYSQLI_ASSOC);
		}

		# 没有读取到数据
		if ( empty($result) ) {
			# 数据库在没有查询到数据的时候，缓存一个 NUll，缓存60s，防止缓存穿透
			$redis -> set($key,Null,60);
			echo 'mysql中没有数据';
			echo '<hr />';
			exit;
		}else{
			# 读取到了数据
			$redis -> set($key,json_encode($result));
			$redis -> expire($key,60 * 5);
		}

	}else{
		echo "redis存在数据，直接读取";
		echo "<hr />";
		var_dump($user_list);
	}


