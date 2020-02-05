<?php
//对称加密
    $key = uniqid();
    $data="一叶之秋";
    $method="DES-CBC";
   // $arr = openssl_get_cipher_methods();
    $iv=12345678;
    $content= openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
    $content = base64_encode($content);

    $content = base64_decode($content);
    $baseContent = openssl_decrypt($content, $method, $key,OPENSSL_RAW_DATA,$iv);
    echo $baseContent;

   echo "<hr />";
//==============================================================
// 非对称加密
	$config = array(
    "digest_alg"    => "sha512",
    "private_key_bits" => 4096,           //字节数  512 1024 2048  4096 等 ,不能加引号，此处长度与加密的字符串长度有关系，可以自己测试一下
    "private_key_type" => OPENSSL_KEYTYPE_RSA,   //加密类型
  );
	$res = openssl_pkey_new($config); 
	
	//提取私钥
	openssl_pkey_export($res, $private_key);

	//生成公钥
	$public_key = openssl_pkey_get_details($res);
	// var_dump($public_key);

	$public_key=$public_key["key"];

	//显示数据
	var_dump($private_key);    //私钥
	var_dump($public_key);     //公钥

	//要加密的数据
	$data = "http://www.cnblogs.com/wt645631686/";
	echo '加密的数据：'.$data."\r\n";  

	//私钥加密后的数据
	openssl_private_encrypt($data,$encrypted,$private_key);

	//加密后的内容通常含有特殊字符，需要base64编码转换下
	$encrypted = base64_encode($encrypted);
	echo "私钥加密后的数据:".$encrypted."\r\n";  

	//公钥解密  
	openssl_public_decrypt(base64_decode($encrypted), $decrypted, $public_key);
	echo "公钥解密后的数据:".$decrypted,"\r\n";  
	  
	//----相反操作。公钥加密 
	openssl_public_encrypt($data, $encrypted, $public_key);
	$encrypted = base64_encode($encrypted);  
	echo "公钥加密后的数据:".$encrypted."\r\n";
	  
	openssl_private_decrypt(base64_decode($encrypted), $decrypted, $private_key);//私钥解密  
	echo "私钥解密后的数据:".$decrypted."n";


exit;


//生成证书
function exportOpenSSLFile(){
  $config = array(
    "digest_alg"        => "sha512",
    "private_key_bits"     => 4096,           //字节数  512 1024 2048  4096 等
    "private_key_type"     => OPENSSL_KEYTYPE_RSA,   //加密类型
  );
  $res = openssl_pkey_new($config);
  if ( $res == false ) return false;
  openssl_pkey_export($res, $private_key);
  $public_key = openssl_pkey_get_details($res);
  $public_key = $public_key["key"];
  file_put_contents("./cert_public.key", $public_key);
  file_put_contents("./cert_private.pem", $private_key);
  openssl_free_key($res);
}
//加密解密
function authcode($string, $operation = 'E') {
  $ssl_public     = file_get_contents("./cert_public.key");
  $ssl_private    = file_get_contents("./cert_private.pem");
  $pi_key         = openssl_pkey_get_private($ssl_private);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id
  $pu_key         = openssl_pkey_get_public($ssl_public);//这个函数可用来判断公钥是否是可用的
  if( false == ($pi_key || $pu_key) ) return '证书错误';
  $data = "";
  if( $operation == 'D') {
    openssl_private_decrypt(base64_decode($string),$data,$pi_key);//私钥解密
  } else { 
    openssl_public_encrypt($string, $data, $pu_key);//公钥加密
    $data = base64_encode($data);
  }
  return $data;
}
// exportOpenSSLFile();         //生成秘钥证书
echo authcode('http://www.cnblogs.com/wt645631686/','E');        //加密
echo authcode('dBYP0fSjY1i0yM+TOaP8vwlUcCC4XvNIcWQGjNZCvajABE40wjHEUTuwauCIkqBzjCb04prcBkvsZdEO1VoBCmOOqL5CBsIm0yHjjnLHR6XaPfdcFjdsR/9oeQq2JGLMzjym/txgvxJyyl3RikjnzHvYQ4bxMS8G2ajWaHZjDSp+fddEBcDkHgPiJGfNosDtpC3FOeuK6LW9ShrjB3QD5s+hTY8iUC38+dnnhdEUGtfeF02mShC5gfxl6uGz/5LHbzDV1wvWz+ybd3axMZ5vSIlL8QDWnohYpRar1NBZhEv/QtKaV6teCI1Yj15aIvfhQYbT+K2EbakSYQ6pOHAs6gbmhMo7Gc4iD1UXl1Qr7qW8uhTDz2vek1JqFUnU9B845dWPEv3u1DKzDxjXwiqNoghtu4R1iZOBKMaykUVu6yZH/mJdJiDCwOmM3l+c8YAbCsYTH2gI5E/DE8km9Cecm8GY252s9hGqWUGm2kGZXTjRl+MAkHD4zRJIyAExwX5yiq/FpvBj6v/E32H/06/jodw22WyHuvpPi33rAgbyAyhm5MIWF90v9TyClJDOI7JOZnuTofr0W9jC55uZKoF/4rTpFTFdOtatmg5y4iIjdzQ92EioB9oa9wAKwh35IQJLzk6hY73/LpOm+vwQ+5SEiRSJNzRuOIqbc77sA53oCd8=','D');       //解密









   $private_key = "-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDQ4xk0ndiFQrFrehPeFsQzcKLnnPbqbq/WutpskDGo5QvMf3/G
g74qKemvQrADLayv8tZ3OKefB3T0laha1XlOzgM0HX9e7+N4sXHRSKn4nrEoUj9y
52j+jT01d+11o2f44XkLxaf8rHCK0LdQ6PtZ8kHBb59PB2YlU9woRuCFnQIDAQAB
AoGABJYn9IbOvUZUnPaGPyci0bpUaV+B8G3TwJRDvYSBAqNc2fWmuZYk88oNzoJZ
WQiEtSxQ1zdQPuasA77RfoUXb8BYCfyplcIQoptF7RsshEXo4+EA6qT53fouK4H0
UtpjXIsYTsJBTDrbvJsWqfFatTddf7gcdxCGp5pXTFksgsUCQQD6uVb+l1nOBSLt
F9VNyRJr2Yul+TYg8EThaBLDFs9e3Ll7X+lui3T0jXviIWAHiz3SFZBpyvfNln59
EEUX1+0fAkEA1UhhtdfBl5G3zpMzd6eJFJHpi5Ov5YNoXKPpk/TtTTkRxl6KqxIg
Juc+0YoxoirOA5TITuoDb5ZYNRoKmAU5wwJANXbGNT3i+Yqg2vwFETQ6SGM4YykU
QMvbdFF0BsPbbngU2VkndtooE2oEK8FAL/uiMCVHCTgtxVo9GMAaa64wswJBAMWX
5U4+sQ/m5E7xeQElqY3xEFlLXe5YK9uHz+JPS3n7oUgSVo3eoQLpwf0G9qyy02Hl
+R2DF+PNebLYiXAFh1kCQQC0sDv6wv1ZvRvPiRbtCMGBhtr6N8/n18coQlzPN6Yc
u31E/jMOIFx1LZrDj4pykwJbOwVGz2MoeIKvae+FO1/b
-----END RSA PRIVATE KEY-----";
	$public_key = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDQ4xk0ndiFQrFrehPeFsQzcKLn
nPbqbq/WutpskDGo5QvMf3/Gg74qKemvQrADLayv8tZ3OKefB3T0laha1XlOzgM0
HX9e7+N4sXHRSKn4nrEoUj9y52j+jT01d+11o2f44XkLxaf8rHCK0LdQ6PtZ8kHB
b59PB2YlU9woRuCFnQIDAQAB
-----END PUBLIC KEY-----";

?>