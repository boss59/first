<?php
if (file_exists("D:/phpstudy_pro/WWW/shop/list.html")) {
	$res=unlink("D:/phpstudy_pro/WWW/shop/list.html");
	file_put_contents("D:/phpstudy_pro/WWW/shop/1.txt",$res."\n",FILE_APPEND);
}
?>