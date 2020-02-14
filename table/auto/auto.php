<?php

    $user_name = $_GET['name'];
    if (empty($user_name)){
        echo '无参数';exit;
    }

    # 用户的类型 在id_auto表中 type=1
    $mysql  = new Mysqli('127.0.0.1','root','root','aaa');

    $sql = 'select * from id_auto where `type` = 1';
    $id_info = $mysql -> query($sql) -> fetch_assoc();

    if ($id_info){
        $user_id =1;
    }else{
        $user_id = $id_info['auto_number'];
    }

    $table_name = 'user_0'.$user_id %4;// 表的名称

    # 开启事务
    $mysql -> query('begin');

    $insert_user_sql = "insert into ".$table_name."(user_id,uname) values(NULL,'$user_name')";
    $insert_result = $mysql -> query($insert_user_sql);

    if ($user_id == 1){

        $id_sql = 'insert into id_auto values (NULL,1,2)';
        $id_result = $mysql -> query($id_sql);

    }else{
        $next_id = $user_id +1;
        $id_sql = 'update id_auto set `type`="'.$user_id.'" where auto_number="'.$next_id.'"';
        $id_result = $mysql -> query($id_sql);
    }

    if ($id_result && $insert_result){
        echo 'successuly';
        $mysql -> query('commit');
    }else{
        echo '失败';
        $mysql -> query('rollback');
    }
?>