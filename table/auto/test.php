<?php

    // 绑定 邮箱手机号
    session_start();
    if (empty($_SESSION['user_info'])){
        exit('登陆成功之后可以绑定操作');
    }
    var_dump($_SESSION);

    $user_id = $_SESSION['user_info']['user_id'];
    $mysql  = new Mysqli('127.0.0.1','root','root','aaa');

    $redis = new Redis();
    $redis -> connect('127.0.0.1',6379);

    # 对参数进行校验，必选参数必须传递
    $bind_type = $_GET['bind_type']??exit('缺少 bind_type 参数');
    $bind_value = $_GET['bind_value']??exit('缺少 bind_value 参数');

    # 对参数进行较验 忧心必须包含 @ 手机号必须是存数字
    if ( $bind_type == 1){
        # 邮箱 包含 @
        if (!strstr($bind_value,'@')){
            exit('邮箱格式不正确');
        }
    }else{
        # 判断 手机号 必须是存数字的
        if (!is_numeric($bind_value) || strlen($bind_value)){
            exit('手机号必须是存数字的，必须是11位的');
        }
    }

    # 找到关联表的数据，更新 把对应的用户的数据也更新了
    # 开启事务
    $mysql -> query('begin');

    # 根据绑定的类型，把数据写入对应表的字段中
    $bind_value_crc32 = crc32($bind_value);

    #根据 分表规则，找到用户所在的表
    $table_number = $user_id % 10;
    $table_name = 'user_0'.$table_number;
    echo '<br />',$table_name,'<br />';

    if ($bind_type == 1){
        # 防止 用户多次绑定邮箱
        if ( $_SESSION['user_info']['email'] != ''){
            exit('邮箱不能重复绑定');
        }
        $relation_sql = 'update user_relation set email_crc32='.$bind_value_crc32.' where user_id='.$user_id;
        $user_sql = 'update '.$table_name.' set email="'.$bind_value.'" where user_id'.$user_id;
    }else{
        # 防止 用户多次绑定手机号
        if ( $_SESSION['user_info']['phone'] != ''){
            exit('手机号不能重复绑定');
        }
        $relation_sql = 'update user_relation set email_crc32='.$bind_value_crc32.' where user_id='.$user_id;
        $user_sql = 'update '.$table_name.' set phone="'.$bind_value.'" where user_id'.$user_id;
    }

    echo '<br />',$relation_sql,'<br />',$user_sql,'<br />';

    $relation_result = $mysql -> query($relation_sql);
    $user_update_result = $mysql -> query($user_sql);

    if ($relation_result && $user_update_result){
        if ($bind_type == 1){
            $_SESSION['user_info']['email'] = $bind_value;
        }else{
            $_SESSION['user_info']['phone'] = $bind_value;
        }
        $mysql -> query('commit');
        exit('绑定成功');
    }else{
        $mysql -> query('rollback');
        exit('绑定失败');
    }





?>