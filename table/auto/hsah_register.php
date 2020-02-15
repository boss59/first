<?php

    # 按照用户名 hash 分表 【16 张表 【hash_user_00 .... hash_user_15】 【建立唯一索引】】

    # 注册 【添加数据 流程】

    $mysql  = new Mysqli('127.0.0.1','root','root','aaa');

    $redis = new Redis();
    $redis -> connect('127.0.0.1',6379);


    $user_name = $_GET['name'];
    if (empty($user_name)){
        exit('缺少name参数');
    }


    # 对用户名 hash 并 根据 hash 值 确定 用户要写入那张表中
    $first_char = substr(hash('md5',$user_name),0,1);
    $table_number = base_convert($first_char,16,10);

    if ($table_number < 10){
        $table_name = 'hash_user_0'.$table_number;
    }else{
        $table_name = 'hash_user_'.$table_number;
    }
    echo "<br />";
    echo "该用户写入了".$table_name.'表中';

    # 2. 取出要写入的用户 用户id
    $key = 'hash_user_id';
    $insert_user_id = $redis -> get($key);

    # redis 不存在 这个 id
    if ($insert_user_id === false)
    {
        # 从数据库读取出来 最大的id
        $sql = 'select * FROM hash_user_00 UNION
                select * FROM hash_user_01 UNION
                select * FROM hash_user_02 UNION
                select * FROM hash_user_03 UNION
                select * FROM hash_user_04 UNION
                select * FROM hash_user_05 UNION
                select * FROM hash_user_06 UNION
                select * FROM hash_user_07 UNION
                select * FROM hash_user_08 UNION
                select * FROM hash_user_09 UNION
                select * FROM hash_user_10 UNION
                select * FROM hash_user_11 UNION
                select * FROM hash_user_12 UNION                                       
                select * FROM hash_user_13 UNION                                       
                select * FROM hash_user_14 UNION                                       
                select * FROM hash_user_15
                ORDER BY user_id DESC limit 1';
        $id_info = $mysql -> query($sql) -> fetch_assoc();

        if ( empty($id_info)){
            $insert_user_id = 1;
        }else{
            $insert_user_id = $id_info['user_id'];
        }
    }

    # 3. 写入用户表的数据
    $insert_sql = 'insert into '.$table_name.' (`user_id`,`user_name`,`password`) values('.$insert_user_id.' ,"'.$user_name.'","123456")';

    # 4. 把下一次要写入的id 记录在 redis中
    $redis -> set($key,($insert_user_id +1), 60*60);

    echo "<hr />";
    echo $insert_sql;
    echo "<hr />";

    $insert = $mysql -> query($insert_sql);
    if ( $insert ){

        echo "注册成功";
    }else{
        echo "注册失败";
    }



?>