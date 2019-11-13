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
	$arr = [1,3,5,7,100];
	// for ($i=0; $i <count($arr) ; $i++) { 
	// 	echo $i;
	// }
$num=0;
foreach($arr as $k=>$v){
     $num++;
}
$nums=[];
for ($i=$num-1;$i>=0;$i--){
    if ($arr[$i] == 7 && $arr[$i - 1] == 5){
        $arr[$i+1]=$arr[$i];
        $arr[$i]=90;
        break;
    }else{
        $arr[$i+1]=$arr[$i];
    }
}
var_dump($arr);
	
?>