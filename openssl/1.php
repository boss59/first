<?php
//================    对称加密   =======================
# 对称加密
	
	$data = [
		'user_name' =>'今非昔比',
		'password' => 'a11111111',
	];

	$key = uniqid();
	$iv= "1903190319031903";

	// var_dump(openssl_get_cipher_methods());
	$encrypt = openssl_encrypt(
			json_encode($data),
			'aes-256-cbc',
			$key,
			OPENSSL_RAW_DATA,
			$iv
	);

	$base64_str = base64_encode($encrypt);

	var_dump($base64_str);

	echo '<hr />';

// # 对称解密
	$decode_str = base64_decode($base64_str);

	$decrypt_str = openssl_decrypt(
			$decode_str,
			'aes-256-cbc',
			$key,
			OPENSSL_RAW_DATA,
			$iv
	);

	var_dump($decrypt_str);
	echo '<hr />';
	$encrpt_arr = json_decode( $decrypt_str , true);

	print_r($encrpt_arr);

	echo '<hr />';
?>