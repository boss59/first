<?php

	# 解决缓存穿透的问题 【 通过map 进行限制】
	
	$mysql_obj  = new Mysqli('127.0.0.1','root','root','aaa');

	$mysql_obj -> query('set names utf8');// 设置字符集

	$redis = new Redis();
	$redis -> connect('127.0.0.1','6379');

	$map_key = 'keys_all_map';

	# 访问用户id为1的用户
	
	# 模拟写入的过程 【 正常程序产生的 】
	//$redis -> sAdd($map_key,'user_info_1','user_info_2');
	
	# 拼接好要访问的数据的key
	
	$id = $_GET['id'] ?? 1;

	$key = "user_info_".$id;

	# 判断是否允许访问
	if ( $redis->sIsMember($map_key,$key)) {
		echo '正常访问，<hr />';

		# 访问redis，读取数据
		$user_info = $redis -> get($key);
		if ($user_info !==false) {
			echo '缓存中有数据.<hr />';
			var_dump($user_info);
		}else{
			# redis不存在 从数据库读取，写入redis
			echo "缓存中没有数据，mysql中读取，<hr />";

			$sql = 'select * form user where user_id ='.intval($id);

			$obj =$mysql_obj -> query($sql);

			if ($obj) {
				$result = $obj ->fetch_assoc();
				if ( !empty($result)) {
					$redis -> set($key,json_encode($result),60*5);
				}else{
					$redis -> set($key,,Null,60);
				}
			}else{
				$redis -> set($key,,Null,60);
			}
		}
	}else{
		echo '你访问的key不正确，不可访问';exit;
	}
?>