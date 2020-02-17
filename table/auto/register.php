<?php
    # 实现 支持手机号、邮箱、有户名 登录，

    // 思路
    /*
     *  1.先确定 注册的方式  regt_ype name = 123213
     *          reg_type = 1  用户名注册
     *          reg_type = 2  邮箱注册
     *          reg_type = 3  手机号注册
     *  2. 先去 redis 获取 用的id
     *  3.根据 用户的id 确定用户数据 写入那张表中
     *  4.在根据注册的类型  去完善 关联表的数据
     *  5. 在完善 crc32 对应的表 以级用户的id
     *  6. 更新 redis 中的id
     */
    $mysql  = new Mysqli('127.0.0.1','root','root','aaa');

    $redis = new Redis();
    $redis -> connect('127.0.0.1',6379);

    # 对参数进行校验，必选参数必须传递
    $reg_type = $_GET['reg_type']??exit('缺少 reg_type 参数');
    $user_name = $_GET['name']??exit('缺少 name 参数');

    # 对参数进行 校验
    if($reg_type == 1){
        if (is_numeric( $user_name)){
            exit('用户名不能是纯数字的');
        }
    }elseif ($reg_type  == 2){
        if (strstr( $user_name,'@') === false){
            exit('邮箱格式不正确');
        }
    }else{
        if(!is_numeric($user_name) || strlen( $user_name ) != 11){
            exit('手机号不正确');
        }
    }

    # 获取 改用户要插入的表 【 根据用户 id 把数据对10 取余的方式 写入用户表中】
    $next_id_key = 'next_id_key';
    $next_user_id = $redis -> get($next_id_key);

    if ($next_user_id === false)
    {
        $sql = 'select * FROM user_0 UNION
                select * FROM user_1 UNION
                select * FROM user_2 UNION                                          
                select * FROM user_3
                ORDER BY user_id DESC limit 1';
        $result = $mysql -> query($sql) -> fetch_assoc();

        if ( empty($result)){
            $next_user_id = 1;
        }else{
            $next_user_id = $result['user_id'] + 1;
        }
    }

    # 确定 用户写入那张表中
    $table_number = $next_user_id % 10;
    $table_name = 'user_0'.$table_number;

    echo '写入'.$table_name."中<hr />";

    $name_crc32 = crc32($user_name);

    # 把下一次要使用的用户id 写入redis 中
    if($redis -> set($next_id_key,($next_user_id +1),60 * 30)){

        # 去完善关联表的数据，并且把用户的数据写入对应的表中
        $mysql -> query('begin');
        if ( $reg_type == 1)
        {
            $relation_sql = 'insert into user_relation(`id`,`table_number`,`user_id`,`user_name_crc32`) values( NULL,'.$table_number.', '.$next_user_id.', '.$name_crc32.')';

            $user_inser_sql = 'insert into '.$table_name.' (`user_id`,`password`,`user_name`) values('.$next_user_id.',"123456","'.$user_name.'")';
        }elseif ($reg_type == 2){
            $relation_sql = 'insert into user_relation(`id`,`table_number`,`user_id`,`email_crc32`) values( NULL,'.$table_number.', '.$next_user_id.', '.$name_crc32.')';

            $user_inser_sql = 'insert into '.$table_name.' (`user_id`,`password`,`email`) values('.$next_user_id.',"123456","'.$user_name.'")';
        }else{
            $relation_sql = 'insert into user_relation(`id`,`table_number`,`user_id`,`phone_crc32`) values( NULL,'.$table_number.', '.$next_user_id.', '.$name_crc32.')';

            $user_inser_sql = 'insert into '.$table_name.' (`user_id`,`password`,`phone`) values('.$next_user_id.',"123456","'.$user_name.'")';
        }

        $relation_result = $mysql -> query($relation_sql);

        echo $relation_sql;
        echo "<br>";
        echo $user_insert_sql;
        echo "<br>";

        # 写入用户的数据
        $user_insert_result = $mysql -> query($user_insert_sql);

        if ($relation_result && $user_insert_result){
            $mysql -> query('commit');
            exit('注册 成功');
        }else{
            $mysql -> query('rollback');
            exit('注册 失败');
        }
    }else{
        exit('失败');
    }
?>