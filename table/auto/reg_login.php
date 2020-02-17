<?php

    # 实现 支持手机号、邮箱、有户名 登录，
    $mysql  = new Mysqli('127.0.0.1','root','root','aaa');

    $redis = new Redis();
    $redis -> connect('127.0.0.1',6379);

    $user_name = $_GET['name']??'';
    $password = $_GET['psd']??'';

    if ( empty($user_name)){
        exit(' 缺少 name 参数');
    }
    if ( empty($password)){
        exit(' 缺少 psd 参数');
    }

    # 需要 根据 输入的用户名 进行判断，判断当前是  name？ phone？ email？
    # 邮箱包含 @  手机号是 存数字类型的 用户名是数字字母的
    if(strstr($user_name,'@')){
            $login_type = 2;
    }else{
        if (is_numeric($user_name)){
            $login_type = 3;
        }else{
            $login_type = 1;
        }
    }

    $user_name_crc32 = crc32($user_name);

    # 先去关联表中，去除用户的数据在第几张表中
    if ( $login_type == 1){
        $sql = 'select * from user_relation where user_name_crc32='.$user_name_crc32;
    }elseif($login_type == 2){
        $sql = 'select * from user_relation where email_crc32='.$user_name_crc32;
    }else{
        $sql = 'select * from user_relation where phone_crc32='.$user_name_crc32;
    }


    # 执行 sql 语句 ，确定数据在哪张表中
    $user_relation = $mysql -> query( $sql )-> fetch_assoc();
    var_dump($user_relation);
    if (empty($user_relation)){
        exit('要登陆的用户名不存在');
    }else{
        $table_name = 'user_0'.$user_relation['table_number'];

        # 去表中查询用户和密码是否正确
        if ($login_type == 1){
            $user_sql = 'select * from '.$table_name.' where user_name="'.$user_name.'" and password="'.$password.'"';
        }elseif ($login_type == 2){
            $user_sql = 'select * from '.$table_name.' where email="'.$user_name.'" and password="'.$password.'"';
        }else{
            $user_sql = 'select * from '.$table_name.' where phone="'.$user_name.'" and password="'.$password.'"';
        }

        echo $sql,"<hr />";

        $user_info = $mysql ->query($user_sql) ->fetch_assoc();

        if (empty($user_info)){
            exit('登陆成功');
        }else{
            exit('登陆的失败');
        }
    }
?>