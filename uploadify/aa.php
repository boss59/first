<?php
	$arrInfo = $_FILES['Filedata'];
	$tmpName = $arrInfo['tmp_name'];// 接值
	$realName = $arrInfo['name'];

	$ext = explode(".",$realName)[1];
	$baseName = md5(uniqid()).".$ext";// 生成唯一的图片名称

	// 创建目录
	$baseDir = Date("Y/m/d/",time());
	if (!is_dir($baseDir)) {
		mkdir($baseDir,0,777);
	}
	$filePath = $baseDir.$baseName;// 存放的路径
	move_uploaded_file($tmpName,$filePath);

	
	echo $filePath;

?>
