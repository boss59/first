<?php
	$key = "47f0d6f457ad4a1cbba846d5875cd927";// 
	$re = file_get_contents("http://api.avatardata.cn/ActNews/Query?key=".$key."&keyword=奥巴马");
	$res = json_decode($re,true,JSON_UNESCAPED_UNICODE);

	// 连接数据库
    foreach($res['result'] as $k=>$v){
        $title = $v['title'];
        $content = $v['content'];
        $pdate_src = $v['pdate_src'];
        $img = $v['img'];
        // var_dump($title);
        // var_dump($content);
        // var_dump($pdate_src);die;
        $con=mysqli_connect('127.0.0.1','root','root','boss');
        $sql="insert into new(title,content,pdate_src,img) values ('$title','$content','$pdate_src','$img')";
        $res=mysqli_query($con,$sql);
    }
	if ($res) {
		echo "<script>alert('恭喜您!添加成功');location.href='/new/list.php'</script>";
	}else{
		echo "失败";
	}
	

	// $valueStr = '';
	//  foreach ($data['result'] as $key => $value) {
	//  	$valueStr .= "('".$value['title']."','".$value['content']."'),";
	//  }
 //    $valueStr = rtrim($valueStr,',');
 //    $con=mysqli_connect('127.0.0.1','root','root','lianxi');
	// $sql="insert into app(title,content) values $valueStr";
	// $res=mysqli_query($con,$sql);
?>