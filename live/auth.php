<?php

    /*
     * 生成直播的路径
     */

    $domain = 'http://zhibo.vonetxs.com'.'/liu/20200309';

    $time = time() + 1800;

    $rand = rand(100000,999999);

    $uid = 0;

    $ak = 'QZ6HDP0MLC';

    $hash_str = '/liu/test'.'-'.$time.'-'.$rand.'-'.$uid.'-'.$ak;

    $sign = md5($hash_str);

    $all = $domain.'?auth_key='.$time.'-'.$rand.'-'.$uid.'-'.$sign;

    echo $all;
    exit;


?>