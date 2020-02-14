<?php
	
	$mysql_obj  = new Mysqli('127.0.0.1','root','root','aaa');

	$mysql_obj -> query('set names utf8');// 设置字符集

	$redis = new Redis();
	$redis -> connect('127.0.0.1','6379');

	$user_list_version = 'user_list_version';
	$cache_version = $redis -> incr($user_list_version);
?>