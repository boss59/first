<?php
	$mysql_obj  = new Mysqli('127.0.0.1','root','root','aaa');

	$mysql_obj -> query('set names utf8');// 设置字符集
	$redis = new Redis();
	$redis -> connect('127.0.0.1','6379');

	// 接值
	$page=$_GET['page']??1;
	$name = $_GET['name']??'';
	$user_id = $_GET['user_id']??'';

	
	$where = '';
	// 用户名
	if ($name != '') {
		$where = 'where uname like "%'.$name.'%" ';
	}
	// user_id
	if ($user_id != '') {
		if ($where != '') {
			$where .= 'and user_id =' .$user_id;
		}else{
			$where .= 'where user_id =' .$user_id;
		}
	}
	echo $where;
	echo "<br />";


	# 定义版本号
	$user_list_version = 'user_list_version';
	$cache_version = $redis ->get($user_list_version);
	if (!$cache_version) {
		$cache_version = $redis -> incr($user_list_version);
	}

	# 拼接where分页的key
	// $page_key = 'user_list_'.$page.'_'.$cache_version;
	$where_list_key = 'user_list_'.md5($where).'_'.$page.'_'.$cache_version;

	echo $where_list_key;
	echo "<br />";

	$page_size =2;

	# 判断 redis中是否有数据
	$user_list =$redis ->get($where_list_key);

	# 计算偏移量
	$limit = ($page - 1) * $page_size;

	if ($user_list === false) {
		
		$sql = "select * from user $where limit ".$limit.','.$page_size;

		echo $sql;
		echo "<br />";
		$obj = $mysql_obj->query($sql);

		if ($obj) {
			$user_list = $obj ->fetch_all(MYSQLI_ASSOC);
			$redis -> set($where_list_key,json_encode($user_list),60*5);

			echo "<pre />";
			echo 'mysql<hr />';
			var_dump($user_list);
		}else{

			$redis -> set($where_list_key,NUll,60*2);
			echo 'mysql<hr />';
			echo "无数据";
		}

	}else{
		echo "redis<hr/>";
		var_dump($user_list);
	}
?>
