<?php
// ================   非对称加密 ======================================

	// [ 加密同样的数据，解密的结果不同 ]
	// openssl_public_encrypt()  公钥加密的方法
	// openssl_private_decrypt() 私钥解密的方法
	
	// openssl_private_encrypt() 私钥加密的方法
	// openssl_public_decrypt()  私钥解密的方法
	
	$data = [
		'user_name' =>'物是人非',
		'password' => 'b22222222',
	];
	$str = json_encode($data);
	#公钥加密
		#1.将数组转成json
		#2.加密数据
		#3.base转码
	openssl_public_encrypt(
			$str,
			$encrypt,
			file_get_contents(__DIR__.'/public.key'),
			OPENSSL_PKCS1_PADDING
	);

	$base64_str = base64_encode($encrypt);
	var_dump($base64_str);

	echo '<hr />';

	
	#私钥解密
		#1.对base64的数据反编码 { base64_decode }
		#2.解密
		#3.转数组
	openssl_private_decrypt(
			base64_decode($base64_str),
			$decrypt,
			file_get_contents(__DIR__.'/private.key'),
			OPENSSL_PKCS1_PADDING
	);

	$arr = json_decode($decrypt,true);
	var_dump($arr);
?>

