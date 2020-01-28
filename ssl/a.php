<?php
	// 亦或 ^

	// echo phpinfo();
	
	// 加密
	// function encrpty($str,$key)
	// {
	// 	$target ="";
	// 	for ($i=0; $i <strlen($str) ; $i++) { 
	// 		$target .=$str[$i] ^ $key;
	// 	}
	// 	return $target;
	// }
	// // 解密
	// function decrpty($target,$key)
	// {
	// 	$info = "";
	// 	for ($i=0; $i <strlen($target) ; $i++) { 
	// 		$info .=$target[$i] ^ $key;
	// 	}
	// 	return $info;
	// }

	// $str= "wqewqeads";
	// $key ="1111";

	// $target=encrpty($str,$key);
	// $target = base64_encode($target);
	// echo $target;

	// $target = base64_decode($target);
	// echo decrpty($target,$key);
	
	// ===========================
	// 置换
	// function encrpty($str,$key)
	// {
	// 	$tmp = 0;
	// 	for($j=0;$j<strlen($key);$j++){
	// 		$tmp +=ord($str[$j]);
	// 	}
	// 	$target ="";
	// 	for ($i=0; $i <strlen($str) ; $i++) { 
	// 		$target .= ord($str[$i])+$tmp."-";
	// 	}
	// 	return $target;
	// }
	// // 解密
	// function decrpty($target,$key)
	// {
	// 	$tmp = 0;
	// 	for($j=0;$j<strlen($key);$j++){
	// 		$tmp +=ord($target[$j]);
	// 	}
	// 	$info ="";
	// 	for ($i=0; $i <strlen($target) ; $i++) { 
	// 		$target .= ord($target[$i])+$tmp."-";
	// 	}
	// 	return $info;
	// }
	// $str = "dasdsada";
	// $key = "aaaa";

	// $target=encrpty($str,$key);
	// $target = base64_encode($target);

	// $target = base64_decode($target);
	// $target=encrpty($target,$key);
	// echo  $target;
	
    //斐波那契   公式  f(n) = f(n-1) + f(n-2)
	$arr=array(100,8,3,90,70,120,2);
	$length=count($arr);
	// print_r($aa);
    for($n=0;$n<$length-1;$n++){
        //内层循环n-i-1
         for($i=0;$i<$length-$n-1;$i++){
             //判断数组元素大小，交换位置，实现从小往大排序
            if($arr[$i]>$arr[$i+1]){
                $temp=$arr[$i+1];
                $arr[$i+1]=$arr[$i];
                $arr[$i]=$temp; 
             }
             
         } 
    }
    print_r($arr);
	
	
?>