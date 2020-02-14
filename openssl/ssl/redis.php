<?php
	
# 确定当前访问时间  次数应该加载那个时间段内
ini_set('date_timezone','PRC');

$ip=($_SERVER['REMOTE_ADDR']);// 获取当前ip
$redis_obj = new Redis();
$redis_obj ->connect('127.0.0.1',6379);


# 黑名单 【有序集合】
$black_list_key = 'black_list';
$black_list = $redis_obj->ZRangeByScore($black_list_key,1,10000000000);
if (in_array($ip,$black_list)) {
	#取出当前ip加入黑名单的时间
	$join_time = $redis_obj -> zScore($black_list_key,$ip);

	#判断进入黑名单时间是否超过 半个小时
	if (time() - $join_time >1800) {
		$redis_obj -> zRem($black_list_key,$ip);
	}else{
		echo '你还不能访问接口，还需等'.(1800 - (time() -$join_time)).'秒才能访问';
		exit;
	}
}

echo '当前黑名单:';
print_r($black_list);
echo '<hr />';

echo '当前ip是'.$ip;
echo '<hr />';

$date = date('H:i:s');
echo '当前时间是:'.$date;
echo '<hr />';

$key =  $ip.'-'.substr($date,0, strlen($date) -1).'0';
echo '写进去的key：'.$key;
echo '<hr />'; 


# 自增 次数加1
$number = $redis_obj ->incr($key);
if ($number == 1) {
	$redis_obj -> expire($key,60);
}

# 获取当前时间 之前 50秒的访问次数
$time = time();
echo '<br />';

$sum = 0;
for ( $i = 1; $i <6 ; $i++) { 
	$cur_time = $time - 10 * $i;
	$format_time = date('H:i:s',$cur_time);
	$time_key = $ip.'-'.substr($format_time,0, strlen($format_time) -1).'0';
	$number_a = $redis_obj -> get($time_key);
	$sum += $number_a;

	echo '<br >';
	echo $time_key.'时间段访问了',$number_a;
	echo '<br >';
}

#黑名单 【有序集合】
$black_list_key = 'black_list';
echo  '总共访问了'.($sum + $number).'次';

# 如果次数 超过 100 测不能访问
if ($sum + $number >= 10) {
	# 利用集合中的socre 分值字段加入黑名单
	$mark = $redis_obj ->zAdd( $black_list_key , time() , $ip );
	echo $ip . '加入黑名单';
	var_dump($mark);
}
echo 'end';
exit;
?>
