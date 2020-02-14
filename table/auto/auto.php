<?php

    // 注册用户的时候怎么确定写入那张表中？   ---  id记录下来，记录在mysql中

    # 注册为例，实现确定数据在那张表中
    $user_name = $_GET['name']??'';
    if (empty($user_name)){
        echo '无参数';exit;
    }

    # 用户的类型 在id_auto表中 type=1
    $mysql  = new Mysqli('127.0.0.1','root','root','aaa');

    $sql = 'select * from id_auto where `type` = 1';
    $id_info = $mysql -> query($sql) -> fetch_assoc();

    if (empty($id_info)){
        $user_id =1;
    }else{
        $user_id = $id_info['auto_number'];
    }

    ## 根据分表规则，把数据写入对应的表中  对 10 取余
    $table_name = 'user_'.$user_id % 4;// 表的名称

    # 开启事务 操作 2 张表 【用户表，id自增表】
    $mysql -> query('begin');

    $insert_user_sql = 'insert into  '.$table_name.' (`user_id`,`uname`)  values ('.$user_id.',"'.$user_name.'")';
    $insert_result = $mysql -> query($insert_user_sql);

    if ($user_id == 1){

        $id_sql = 'insert into id_auto values (NULL,1,2)';
        $id_result = $mysql -> query($id_sql);

    }else{
        $next_id = $user_id +1;
        $id_sql = 'update id_auto set auto_number=' . $next_id . ' where type=1';
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