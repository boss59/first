<?php
	//  分级缓存
	$mysql_obj  = new Mysqli('127.0.0.1','root','root','jew');

	$mysql_obj -> query('set names utf8');// 设置字符集
	$redis = new Redis();
	$redis -> connect('127.0.0.1','6379');

	$goods_id = 9;

	$product_deail_key = 'product_deail_'.$goods_id;
	
	# 判断 redis中是否有数据
	$product_info =$redis ->get($product_deail_key);

	echo "<pre>";
	echo "当前的key：".$product_deail_key.'<br />';

	if ($product_info === false) {
		# 获取一下标识位 
		$mark_key = $product_deail_key."_mark";
		$mark = $redis ->get($mark_key);
		
		# 在redis中写一个标识位
		if ($mark === false) {
			$redis -> set($mark_key,1);
			$detail_sql = "select * from shop_goods where goods_id=".$goods_id;

			$obj = $mysql_obj->query($detail_sql);
			if ($obj) {
				$product_info = $obj ->fetch_assoc();
				sleep(10);

				$redis -> set($product_deail_key,json_encode($product_info),60*5);
				# 数据写入redis成功之后，方式下一次读取到标识位
				$redis -> del($mark_key);
				echo 'mysql中的数据<br />';
				var_dump($product_info);
				exit;
			}else{
				echo "数据不存在<hr/>";
				// 防止 缓存穿透
				$redis -> set($product_deail_key,NULL,60*2);
			}
		}else{
			// 如果读取到标识位，说明其他地方正在读取对应的数据
			// 阻塞当前请求，等待其他进程完成数据的插叙和写入redis
			$i = 1;
			while($i < 15){
				sleep(1);
				$product_info = $redis -> get($product_deail_key);
				if ($product_info !== false) {
					echo '没有用户';
					var_dump($product_info);
					break;
				}
				$i++;
			}

			echo '5s之后获取到的数据';
			var_dump($product_info);
		}

	}else{
		echo "redis的数据<hr/>";
		var_dump($product_info);
		exit;
	}
?>