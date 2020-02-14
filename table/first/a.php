<?php
	// echo phpinfo();die;
	// 连接数据库 查数据库
	$link = mysqli_connect('127.0.0.1','root','root','aaa');
	$sql = "select * from user";
	$result = mysqli_query($link,$sql);
	$data=mysqli_fetch_all($result,MYSQLI_ASSOC);

	// 分表 操作
	foreach($data as $k=>$v){
		$nums = sprintf("%u",crc32($v['uname']))%4;
		// echo $nums."<br />";
		$uname= $v['uname']; $pwd= $v['pwd'];
		$sql2 = "insert into user_".$nums." (uname,pwd) values ('$uname','$pwd')";
		$result = mysqli_query($link,$sql2);
	}
	
	// 创建表 方法
	// function create_db($nums,$conn)
	// {
	// 	$sql = "CREATE TABLE user_".$nums." (
	// 				user_id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	// 				uname VARCHAR(15) NOT NULL,
	// 				upwd VARCHAR(20) NOT NULL,
	// 			)";

	// 	if ($conn->query($sql) === TRUE) {
	// 	    echo "Table MyGuests created successfully";
	// 	} else {
	// 	    echo "创建数据表错误: " . $conn->error;
	// 	}

	// 	$conn->close();
	// }
?>