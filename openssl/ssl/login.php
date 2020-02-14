<?php
# 客户段
# user_name password app_key sign
/*
1、给每个调用接口的客户端下发一个 appkey + appsecert 【 这2个参数 只有客户端和服务端知道 】
			2、调用接口的时候 把appkey作为参数传递到服务端去 
			3、按照指定的规则生成签名
				（1）请求接口的参数拼接好
				（2）把刚才appkey作为参数拼接进去
				（3）把请求接口的参数做一个排序 操作 【防止参数顺序不同，导致验签不成功】
				（4）把排序之后的参数，转成JSON格式
				（5）把JSON串在加上 appsecert 加上
				（6）把拼接好的串 ，生成一个md5值。把数据和签名发送到服务端
 */

$app_key = '1903';
$app_sercret = '1903a';

$url = "http://www.online.com/ssl/register";


#拼接请求登陆接口的数据
$login_data = [
	'user_name' => '今非昔比',
	'password' => '123456',
	'app_key' => $app_key,
];
// 防止重放
$login_data['time'] = time();
$login_data['rand_code'] = rand(000000,999999);
// =============== 参数使用非对称加密  ==============
$encrypt_data = RsaEncrypt( $login_data );


// ================  签名   =================
# 对接口参数 排序操作
Ksort( $login_data );

# 将数据 转换成 JSON 格式
$json_str = json_encode( $login_data );

# 拼接 sercret参数
$api_data = $json_str.'&app_secret='.$app_sercret;


# 生成签名
$sign = md5( $api_data );

// ============================    最终生成调用接口的参数   ============= 

$login_api_data = [
	'data' => $encrypt_data,
	'sign' => $sign,
];

$result = CurlPost( $url,$login_api_data );




// =================================   调用的方法  =============
// curl 方法
function CurlPost( $url ,$data )
{
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_POST, 1);

	curl_setopt($ch,CURLOPT_POSTFIELDS , http_build_query( $data ));

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

	$api_result = curl_exec( $ch );

	echo $api_result;

	exit;
}

// 对数据使用公钥加密
function RsaEncrypt( $data )
{
	if ( is_array($data) ) {
		$data = json_encode( $data );
	}
	$i = 0;
	$all = '';
	while ( $substr = substr( $data , $i ,117 )) {
		
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
	return $all_encrypt;
} 

?>