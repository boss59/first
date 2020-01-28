<?php
	
	// 第一种： for
	// for($i=1; $i<=strlen($str);$i++){
 //        echo substr($str,-$i,1);
 //    }
	// 第二种： 递归
	// function reverse_r($str){
	//   if(strlen($str)>0){
	//     reverse_r(substr($str,1));
	//   }
	//   echo substr($str,0,1);
	//   return;
	// }
	// $str = "asdfgh";
	// echo reverse_r($str);
	// (1) 用递归来实现    5*4*3*2*1
	// function aa($num){
	// 	if($num <=1){
	// 		return $num;
	// 	}
	// 	$num=aa($num-1)*$num;
	// 	return $num;
	// }
	// $num=5;
	// echo aa($num);
	// (2) 用递归来 实现1到100 偶数 成为一个 数组
	// $arr=array();//亲测可用
	// $max=100;
	// function array_Even($arr,$max) {
	// 	global $arr;
	// 	if ($max >-1 && $max %2 ==0) {
	// 		array_push($arr,$max);
	// 		$max-=2;
	// 	} else {
	// 		return;
	// 	}
	// 	array_Even($arr,$max);
	// }
	// array_Even($arr,$max);
	// print_r($arr);

	// 1 到 1000 的水仙花数
	
// for($i=100;$i<1000;$i++){
	
// 	$a=intval($i/100);
// 	$b=intval($i/10)%10;
// 	$c=$i%10;

// 	if(pow($a,3)+pow($b,3)+pow($c,3)==$i){

// 		echo $i."\t";

// 	}
// }

// for ($i=1;$i<=9;$i++) for ($j=0;$j<=9;$j++) for ($k=0;$k<=9;$k++)
// if ($i*$i*$i + $j*$j*$j + $k*$k*$k == $i*100 + $j*10 + $k) echo $i*100 + $j*10 + $k,"\t";
//--------------------------------------------------------------------------
	// $arr = [1,3,5,7,100];
	// for ($i=0; $i <count($arr) ; $i++) { 
	// 	echo $i;
	// }
	// $num=0;
	// foreach($arr as $k=>$v){
	//     $num++;
	// }
	// $nums=[];
	// for ($i=$num-1;$i>=0;$i--){
	//     if ($arr[$i] == 7 && $arr[$i - 1] == 5){
	//         $arr[$i+1]=$arr[$i];
	//         $arr[$i]=90;
	//         break;
	//     }else{
	//         $arr[$i+1]=$arr[$i];
	//     }
	// }
 //    var_dump($arr);
	

	// $url = "http://www.abc.com/aa/bb/cc/txt/dd.txt";

 	// $path=parse_url($url);
  // 	$path=basename($path['path']);
 	// echo $path;

	// echo pathinfo(parse_url( $url, PHP_URL_PATH ), PATHINFO_EXTENSION );

 	// $path = substr($url,-3);
 	// echo $path;

	// $aa=strstr($url,'dd');
	// echo $aa;
	// 
	
	// ====================   二维数组排序   ======================
	$arr = array(
		array("id"=>1,"name"=>"lisi1",'age'=>20),
		array("id"=>2,"name"=>"lisi2",'age'=>50),
		array("id"=>3,"name"=>"lisi3",'age'=>10),
		array("id"=>4,"name"=>"lisi4",'age'=>9),
		array("id"=>5,"name"=>"lisi5",'age'=>4),
	);
	// $length=count($arr);
 //    for($n=0;$n<$length-1;$n++){
 //        //内层循环n-i-1
 //         for($i=0;$i<$length-$n-1;$i++){
 //             //判断数组元素大小，交换位置，实现从小往大排序
 //            if($arr[$i]['age']>$arr[$i+1]['age']){
 //                $temp=$arr[$i+1];
 //                $arr[$i+1]=$arr[$i];
 //                $arr[$i]=$temp; 
 //             }
 //         } 
 //    }
	// echo "<pre>";
 //    print_r($arr);
 	

 // 	$arrInfo=array();
	//  foreach ($arr as $key => $value) {	
	//  	array_push($arrInfo,$value['age']);
	//  }
	// sort($arrInfo);
	// print_r($arrInfo);
	// $data = array();
	// foreach ($arr as $key => $value) {
	// 	$data[$value['age']]=$value;
	// }
	// print_r($data);
	// $restult = array();
	// foreach ($arrInfo as $key => $value) {
	// 	array_push($restult,$data[$value]);
	// }
	// print_r($restult);
	

?>