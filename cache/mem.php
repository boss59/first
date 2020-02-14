<?php
	//连接
	$mem = new Memcache();
	$mem->connect("127.0.0.1", 11211) or die ("连接失败");

	// set
	$bol=$mem->set("name","lisi",0,400);
	var_dump($bol);
	// get
	// $men->get("name");
	// replsce
	// $men->replsce("name","uuuu",0,120);
	// delete
	// $men->delete("name");
	//increment
	// $men->increment("id");
	//decr

	// $arr = array(
	// 		"id" =>1,
	// 		"name"=>"lisi",
	// 	);

	// $str = serialize($arr);
	// $info = unserialize($str);
	// print_r($info);
	// echo $str;
	// $bol =$mem->set("info",$arr,0,120);
	// var_dump($bol);
?>