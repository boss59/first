<?php
// ============   分段加密  =============
# 由于非对称加密  只能加密  117个字符 超过
# 则需要 分段加密
	
	$str = str_repeat('0123456789',30);
	// echo $str;
	
	#公钥加密过程
		# 1. 先把字符串截取 117 个字符 加密
		# 2. 将每次加密的结果拼成一个大的字符串
		# 3. 对这个大的字符串进行加密
		# 4. 对加密的结果进行base64编码
	
	$i = 0;
	$all = '';
	while ( $substr = substr($str,$i,117)) {
		
		openssl_public_encrypt(
			$substr,
			$encrypt,
			file_get_contents(__DIR__.'/public.key'),
			OPENSSL_PKCS1_PADDING
		);
		$all .= $encrypt;
		$i += 117;
	}

	$all_encrypt = base64_encode($all);
	echo $all_encrypt;
	echo '<hr />';

	# 私钥解密过程
		# 1. base64 反编码得到的加密串
		# 2. 获取 128 个长度,得到第一个的 加密的结果
		# 3. while循环 加密的数据 进行 拼接

	$all_decrypt = base64_decode( $all_encrypt );
	$j = 0;
	$all_new = '';

	while ( $substr_str = substr($all_decrypt, $j , 128)) {
		
		openssl_private_decrypt(
			$substr_str,
			$decrypt,
			file_get_contents(__DIR__.'/private.key'),
			OPENSSL_PKCS1_PADDING
		);
		$all_new .= $decrypt;
		$j += 128;
	}

	echo $all_new;
	exit;
?>