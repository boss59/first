<?php

class  MyMysqlSession implements SessionHandlerInterface
{

    private $mysql;
    private $expire = 1440; // 设置时间
    private $key_prefix = "php-mysql-session:";// key的前缀

    public function open($save_path, $session_id)
    {
        // TODO: Implement open() method.
        // var_dump(__METHOD__);// 打印当前方法

        $this -> mysql = new Mysqli('127.0.0.1','root','root','aaa');

        return true;
    }


    public function read($session_id)
    {
        // TODO: Implement read() method.
        // var_dump(__METHOD__);// 打印当前方法
        $select_sql = 'select * from t_session where session_id="'.$session_id.'"';

        $session_info = $this -> mysql -> query($select_sql) -> fetch_assoc();
        if ($session_info){

            # 过期的session 不能被读取到
            if (){

            }else{
                return $session_info['session_data'];
            }
        }else{
            return serialize([]);
        }
    }

    public function write($session_id, $session_data)
    {
        // TODO: Implement write() method.
        // var_dump($session_id,$session_data);

        $sql_count = 'select * from t_session where session_id="'.$session_id.'"';

        $result = $this -> mysql -> query($sql_count) -> fetch_all(MYSQLI_ASSOC);
        if (empty($result)){

            $insert_sql = 'insert into t_session  values()';

            $insert = $this -> mysql -> query($insert_sql);
            if ($insert){
                return true;
            }else{
                return false;
            }
        }else{
            $update_sql = 'update ';

            $update = $this -> mysql -> query($update_sql);
            if ($update){
                return true;
            }else{
                return false;
            }
        }

    }

    public function close()
    {
        // TODO: Implement close() method.

        $this -> mysql -> close();
        return true;
    }

    public function destroy($session_id)
    {
        // TODO: Implement destroy() method.

        $delete_sql = 'delete * from t_session where session_id="'.$session_id.'"';
        $delete_result = $this -> mysql -> query($delete_sql);

        if ($delete_result){
            return true;
        }else{
            return false;
        }

    }

    public function gc($maxlifetime)
    {
        // TODO: Implement gc() method.

        # 手动清理过期的sesion，就不需要删除过期的key

        $gc_sql = 'delete * from t_session where expire <'.time();

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
    [$redis_session,'open'],
    [$redis_session,'close'],
    [$redis_session,'read'],
    [$redis_session,'write'],
    [$redis_session,'destroy'],
    [$redis_session,'gc']
);

session_start();

$_SESSION['user_info'] = [
    'user_id' => 1,
    'user_name' => '暗无天日'
];
?>