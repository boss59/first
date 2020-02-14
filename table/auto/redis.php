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
        $sql = 'select * FROM user_0 UNION
                select * FROM user_1 UNION
                select * FROM user_2 UNION                                          
                select * FROM user_3 UNION
                select * FROM user_4 
                ORDER BY user_id DESC limit 1';

        $result = $mysql -> query($sql) -> fetch_assoc();
        $next_user_id = $result['user_id'] + 1;
    }

    # 根据 分表规则 写入对应的数据
    $table_name = 'user_'.($next_user_id % 4);// 取余
    $table_number = $next_user_id % 4;

    # 因为这一步要做2部 操作
        # 1. 把 redis 中记录的id +1
        # 2. 把注册的用户写入用户表

    # 按照 1 2 执行 还是 按照 2 1执行

    /*
     * 需要分系一下那中操作执行顺序 对业务的影响最小 就用那种方案
     *
     * 一，先写 redis 在写 mysql 【建议】
     *      第一步执行成功 redis + 1
     *      第二步执行失败 mysql没有写入成功 则主键 id 浪费了一个
     *
     * 二，先写入 mysql 在写入 redis
     *      第一步执行成功 第二步执行失败
     *              影响 例子： 现在注册用户 从 redis读取出来的id 是4 mysql 写入成功 redis没有成功
     *                          下一个用户在注册的会后 取出来的id 还是4 按照 分表 还还在第四张表中
     *                              主键冲突
     *
     */



    $redis_result = $redis -> set($user_id_key,$next_user_id+1,60 * 60);

    # 先写 redis 在写 mysql 【建议】
    if ($redis_result){

        # 开启事务
        $mysql -> query('begin');

        $insert_user_sql = 'insert into  ' .$table_name. ' (`user_id`,`uname`) values('.$next_user_id.',"'.$user_name.'")';
        $insert_result = $mysql -> query($insert_user_sql);

        # 用户写入表成功之后，在关联表中写入用户和表的关联关系
        $user_name_crc32 = crc32($user_name);
        $relation_sql = 'insert into user_table_relation values (NULL ,'.$user_name_crc32.','.$table_number.')';
        $relation_result = $mysql -> query($relation_sql);

        if ($insert_result && $relation_result){
            $mysql -> query('commit');
            echo "success";
        }else{
            $mysql -> query('rollback');
            echo "fail";
        }
    }else{
        echo 'redis操作失败';exit;
    }

?>