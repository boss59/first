<?php
	// $name = $_REQUST['user'];
	// setcookie('uid',$name,time()+24*60*60);
	if (empty($_COOKIE['user'])) {
		echo "未登录";die;
	}else{
		echo "<script>alert('登陆成功');location.href='info.html'</script>";
	}
?>