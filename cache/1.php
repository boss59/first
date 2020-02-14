<?php
	// ==========百钱百鸡============
	// 1.公鸡5文钱一只
	// 母鸡3文钱一只
	// 小鸡一文钱3只
	
	//问可以买多少公鸡，母鸡，小鸡，有几种组合
	//
	// phpinfo();
	// for ($i=1; $i < 20; $i++) { 
	// 	for ($j=1; $j < 33; $j++) { 
	// 		for ($z=1; $z < 300; $z++) { 
	// 			if(($i+$j+$z==100) && ($i*5+$j*3+$z/3)==100){
	// 				echo "公鸡".$i."<br />";
	// 				echo "母鸡".$j."<br />";
	// 				echo "小鸡".$z."<br />";
	// 				echo "<hr>";
	// 			}
	// 		}
	// 	}
	// }
	
	// 合并数组
	// $arr=[3,5,7,9,11];
	// $arr1 = [11,12,79,90];

	// foreach ($arr1 as $key => $value) {
	// 	$arr[]=$value;
	// }
	function my_scandir($dir)
{
    //定义一个数组
    $files = array();
    //检测是否存在文件
    if (is_dir($dir)) {
        //打开目录
        if ($handle = opendir($dir)) {
            //返回当前文件的条目
            while (($file = readdir($handle)) !== false) {
                //去除特殊目录
                if ($file != "." && $file != "..") {
                    //判断子目录是否还存在子目录
                    if (is_dir($dir . "/" . $file)) {
                        //递归调用本函数，再次获取目录
                        $files[$file] = my_scandir($dir . "/" . $file);
                    } else {
                        //获取目录数组
                        $files[] = $dir . "/" . $file;
                    }
                }
            }
            //关闭文件夹
            closedir($handle);
            //返回文件夹数组
            return $files;
        }
    }
}
echo "<pre>";
print_r(my_scandir("e:\aaa")); //电脑的文件路径即可
?>