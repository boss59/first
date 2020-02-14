<?php

    # 根据用户 id 分表 之后 如何 登陆

    $user_name = $_GET['name']??'';
    if (empty($user_name)){
        echo '无参数';exit;
    }

    $password = $_GET['psd']??'';
    if (empty($password)){
         echo '无参数';exit;
    }

    $mysql  = new Mysqli('127.0.0.1','root','root','aaa');

    $name_crc32 = crc32($user_name);

    # 去关联表中 查询对应的 关联关系，找到用户所在的表
    $sql = 'select * from user_table_relation where user_name_crc32 =' .$name_crc32;
    $table_info = $mysql -> query($sql) -> fetch_assoc();

    if ( $table_info === false){
        echo ("登陆的用户不存在");exit;
    }else{
        $table_name = 'user_'.$table_info['table']; // 找到 对应的表

        $sql = 'select * from '.$table_name.' where user_name="'.$user_name.'"';
        $obj =$mysql -> query($sql);

        if ($obj === false){
            echo ("你要登陆的用户不存在");exit;
        }else{
            $user_info = $obj -> fetch_assoc();
            $psd = $user_info['password'];

            if ($psd == $password){
                echo 'login success';
            }else{
                echo 'login fail';
            }
        }

//        var_dump($table_name);
    }

?>