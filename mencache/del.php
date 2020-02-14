<?php
$sid =$_GET['id'];
$link =mysqli_connect('127.0.0.1','root','root','boss');
$sql ="delete from shop where id='$sid'";
$res =mysqli_query($link,$sql);
if($res){
	echo 1;
}else{
	echo 2;
}
?>