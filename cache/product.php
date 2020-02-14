<?php
	# 原子性缓存
	$mysql_obj  = new Mysqli('127.0.0.1','root','root','jew');

	$mysql_obj -> query('set names utf8');// 设置字符集

	$redis = new Redis();
	$redis -> connect('127.0.0.1','6379');

	$page = $_GET['page']??1;

	# redis缓存版本号
	$product_list_version = 'product_list_version';
	$cache_version = $redis ->get($product_list_version);
	if (!$cache_version) {
		$cache_version = $redis -> incr($product_list_version);
	}

	# 拼接好商品缓存的key
	$product_list_key = 'product_list_'.$page.'_'.$cache_version;

	# 先获取redis数据
	$product_list = $redis -> get($product_list_key);

	# 定义每页条数
	$page_size = 2;

	# 计算偏移量
	$limit = ($page - 1) * $page_size;

	if ($product_list === false) {
		$sql = "select * from shop_goods  limit ".$limit.','.$page_size;

		$obj = $mysql_obj->query($sql);

		echo 'mysql中的数据<br />';
		if ($obj) {
			$product_list = $obj ->fetch_all(MYSQLI_ASSOC);

			$product_id_arr = [];
			foreach ($product_list as $k => $v) {

				$product_id_arr[] = $v['goods_id'];
				$product_detail_key = 'product_detail_'.$v['goods_id'];
				// 存 goods_id_key 对应的 数据
				$redis -> set($product_detail_key,json_encode($v),60*5);
			}

			// 存redis中每一页的数据
			$redis -> set($product_list_key,json_encode($product_id_arr),60*5);
			var_dump($product_list);
		}else{
			$redis -> set($product_list_key,NUll,60*2);
		}

	}else{

		echo "redis中的数据<hr/>";
		$id_arr = json_decode($product_list,true);
		$product_list_all = [];

		foreach ($id_arr as $k => $v) {
			
			$product_detail_key = 'product_detail_'.$v;// goods_id_key

			$product_detail = $redis -> get($product_detail_key);


			# 商品详情的缓存刚好过期了
			if ($product_detail == false) {
				
				# 从数据库读取商品详情的缓存
				$sql_detail = 'select * from shop_goods where goods_id='.$v;
				$product_detail = $mysql_obj->query($sql_detail)->fetch_all();
				$redis -> set($product_list_key,json_encode($product_detail),60*5);
				$product_list_all[] = $product_detail;
			}else{
				$product_list_all[] = json_decode($product_detail,true);
			}
		}


		var_dump($product_list_all);exit;
	}

?>