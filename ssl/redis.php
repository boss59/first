<?php
	
# 确定当前访问时间  次数应该加载那个时间段
ini_set('date_timezone','PRC');

$date = date('H:i:s');
echo '当前时间是:'.$date;
echo '<hr />';
echo '写去的key： ';
$key = substr($date,0, strlen($date) -1).'0';
echo $key;



$redis_obj = new Redis();
$redis_obj ->connect('127.0.0.1',6379);

# 自增 次数加1
$number = $redis_obj ->incr($key);

# 获取当前时间 之前 50秒的访问次数
$time = time();

echo '<br />';
$sum = 0;
for ($i=1; $i <6 ; $i++) { 
	$cur_time = $time - 10 * $i;
	$format_time = date('H:i:s',$cur_time);
	$time_key = substr($date,0, strlen($format_time) -1).'0';
	$numbers = $redis_obj -> get($time_key);
	$sum += $numbers;

	echo '<br >';
	echo $time_key.'时间段访问了',$numbers;
}

echo '<pre>';
var_dump($sum);

echo '<pre>';
echo $number;
?>
