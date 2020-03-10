<?php

//// 1. 定义房间管理凭证，并对凭证字符做URL安全的Base64编码
//roomAccess = {
//    "appId": "<AppID>"
//    "roomName": "<RoomName>",
//    "userId": "<UserID>",
//    "expireAt": <ExpireAt>,
//    "permission": "<Permission>"
//}
//roomAccessString = json_to_string(roomAccess)
//encodedRoomAccess = urlsafe_base64_encode(roomAccessString)
//// 2. 计算HMAC-SHA1签名，并对签名结果做URL安全的Base64编码
//sign = hmac_sha1(encodedRoomAccess, <SecretKey>)
//encodedSign = urlsafe_base64_encode(sign)
//// 3. 将AccessKey与以上两者拼接得到房间鉴权
//roomToken = "<AccessKey>" + ":" + encodedSign + ":" + encodedRoomAccess


function base64_urlSafeEncode($data)
{
    $find = array('+','/');
    $replace =array('-','_');
    return str_replace($find,$replace,base64_encode($data));
}

function base64_urlSafeDecode($str)
{
    $replace = array('+','/');
    $find =array('-','_');
    return base64_decode(str_replace($find,$replace,$str));
}


$ak = 'U1WYrFlcH2mWuIgnn941vwV8ejts6XygUprRNrwm';
$sk = 'PZ9rCkDpq_adH4kmB_gRDT9GKlr9_MpDMeWfOVGq';

$room_data = [
    'appId' => 'eng75uf5z',
    'roomName' => '1903',
    'userId' => 'user_002',
    'expireAt' => time() + 1800,
    'permission' => 'admin'
];

$room_str = json_encode($room_data);

$encode_str = base64_urlSafeEncode($room_str);

$sha1 = hash_hmac('sha1',$encode_str,$sk,true);

$sign = base64_urlSafeEncode($sha1);

$room_access_token = $ak.':'.$sign.':'.$encode_str;




echo $room_access_token;









?>