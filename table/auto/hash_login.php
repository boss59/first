<?php

    # hash 分表 登陆

    $mysql  = new Mysqli('127.0.0.1','root','root','aaa');

    $redis = new Redis();
    $redis -> connect('127.0.0.1',6379);

    // 接值
    $user_name = $_GET['name'];
    if (empty($user_name)){
        exit('缺少name参数');
    }

    $password = $_GET['psd'];
    if (empty($password)){
        exit('缺少psd参数');
    }

    # 1. 根据用户输入的名字确认，需要写入那张表
    $first_char = substr(hash('md5',$user_name),0,1);
    $table_number = base_convert($first_char,16,10);

    if ($table_number < 10){
        $table_name = 'hash_user_0'.$table_number;
    }else{
        $table_name = 'hash_user_'.$table_number;
    }

    # 2. 去对应的表中查询用户是否存在
    $select_sql = 'select * from '.$table_name.' where user_name="'.$user_name.'" and password="'.$password.'"';
    $user_info = $mysql -> query($select_sql) -> fetch_assoc();

    if (empty($user_info)){
        exit('信息有误');
    }else{
        echo "登陆成功";
    }
?>