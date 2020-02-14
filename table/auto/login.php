<?php

    $user_name = $_GET['name'];
    if (empty($user_name)){
        echo '无参数';exit;
    }

    $password = $_GET['psd'];
    if (empty($password)){
         echo '无参数';exit;
    }

    $mysql  = new Mysqli('127.0.0.1','root','root','aaa');

    $name_crc32 = crc32($user_name);
    $sql = 'select * from user_table_relation where user_name_crc32 =' .$name_crc32;

    $table_info = $mysql -> query($sql) -> fetch_assoc();

    if ( $table_info === false){
        echo ("登陆的用户不存在");exit;
    }else{
        $table_name = 'user_'.$table_info['table'];

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


    }

?>