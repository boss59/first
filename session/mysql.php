<?php

class  MyMysqlSession implements SessionHandlerInterface
{

    private $mysql;
    private $expire = 1440; // 设置时间

    public function open($save_path, $session_id)
    {
        // TODO: Implement open() method.
        // var_dump(__METHOD__);// 打印当前方法

        $this -> mysql = new Mysqli('127.0.0.1','root','root','aaa');

        return true;
    }

    public function close()
    {
        // TODO: Implement close() method.

        $this -> mysql -> close();
        return true;
    }

    // 查询 数据库中的数据
    public function read($session_id)
    {
        // TODO: Implement read() method.
        // var_dump(__METHOD__);// 打印当前方法

        $select_sql = 'select * from t_session where session_id="'.$session_id.'"';
        $session_info = $this -> mysql -> query($select_sql) -> fetch_assoc();

        if ($session_info)
        {
            # 过期的session 不能被读取到
            if ($session_info['expire'] < time()){

                # 删除过期的session
                $del_sql = 'delete from t_session where session_id="'.$session_id.'"';
                $del_result = $this -> mysql -> query($del_sql);

                if ( $del_result ){
                    return serialize([]);
                }else{
                    return serialize([]);
                }
            }else{
                return $session_info['session_data'];
            }
        }else{
            return serialize([]);
        }
    }

    // 添加到 数据库中
    public function write($session_id, $session_data)
    {
        // TODO: Implement write() method.
        // var_dump($session_id,$session_data);
        # 查询 session_id 是否 存在
        $sql_count = 'select * from t_session where session_id="'.$session_id.'"';
        $result = $this -> mysql -> query($sql_count) -> fetch_all(MYSQLI_ASSOC);

        if (empty($result))
        {
            $insert_sql = 'insert into t_session  values(NULL ,"'.$session_id.'","'.addslashes($session_data).'",'.(time()+$this -> expire).')';
            $insert = $this -> mysql -> query($insert_sql);

            if ($insert){
                return true;
            }else{
                return false;
            }
        }else{
            $update_sql = 'update t_session set session_data="'.addslashes($session_data).'",expire='.(time() + $this ->expire).' where session_id="'.$session_id.'"';

            echo $update_sql;exit;
            $update = $this -> mysql -> query($update_sql);

            if ($update){
                return true;
            }else{
                return false;
            }
        }

    }

    // 删除 当前 session_id 的数据
    public function destroy($session_id)
    {
        // TODO: Implement destroy() method.

        $delete_sql = 'delete from t_session where session_id="'.$session_id.'"';
        $delete_result = $this -> mysql -> query($delete_sql);

        if ($delete_result){
            return true;
        }else{
            return false;
        }

    }

    // 全局 清理过期的session数据
    public function gc($maxlifetime)
    {
        // TODO: Implement gc() method.
//        var_dump('gc');
        # 手动 清理过期的session数据，
        $gc_sql = 'delete from t_session where expire <'.time();
        $gc_result = $this -> mysql -> query($gc_sql);

        if ($gc_result){
            return true;
        }else{
            return false;
        }

    }

}


$mysql_session  = new MyMysqlSession();

session_set_save_handler(
    [$mysql_session,'open'],
    [$mysql_session,'close'],
    [$mysql_session,'read'],
    [$mysql_session,'write'],
    [$mysql_session,'destroy'],
    [$mysql_session,'gc']
);

session_start();

$_SESSION['user_info'] = [
    'user_id' => 1,
    'user_name' => '暗无天日'
];

// session_destroy();
var_dump($_SESSION);

echo "<hr />";
?>