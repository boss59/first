<?php  
	$arr = $_FILES;
	$info = $_REQUEST;

	$ext = explode(".",$info['filename'])[1];// 取后缀
	// $fileName = md5(uniqid()),"$ext";// 
	$fileName = $info['filename'];

	// 创建目录
	$baseDir = "./".date("Y/m/d/",time());
	if (!is_dir($baseDir)) {
		mkdir($baseDir,0,777);
	}
	$filePath = $baseDir.$fileName;// 存放的路径

	// 读取 数据
	$tmpName = $arr['data']['tmp_name'];
	$content = file_get_contents($tmpName);
	file_put_contents($filePath,$content,FILE_APPEND);

	$filePath = ltrim($filePath,".");
	$filePath = "/file/".$filePath;// 处理后的展示路径
	$res = array(// 返回的数据
			"error"=>0,
			"data"=>array(
					'path'=>$filePath,
				),
		);
	echo json_encode($res);
?>
