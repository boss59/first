<?php

    $user_name = $_GET['name'];
    if (empty($user_name)){
        echo '无参数';exit;
    }

    $mysql  = new Mysqli('127.0.0.1','root','root','aaa');

    $redis = new Redis();
    $redis -> connect('127.0.0.1',6379);

    $user_id_key = 'max_user_id';
    $user_id = $redis -> get($user_id_key);

    if ($user_id !== false){
        $next_user_id = $user_id;
    }else{
        $sql = '';

        $result = $mysql -> query($sql) -> fetch_assoc();

        $next_user_id = $result['user_id'];
    }

?>