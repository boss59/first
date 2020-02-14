<?php
/**
 * Created by PhpStorm.
 * User: 王
 * Date: 2020/2/13
 * Time: 17:01
 */

# session 入mysql

class MyMysqlSession implements SessionHandlerInterface
{
    private $mysql;
    private $expire = 1440;

    public function open($save_path, $name)
    {
        // TODO: Implement open() method.
        $this -> mysql =new mysqli(
            '127.0.0.1',
            'root',
            'root',
            'aaa'
        );
        var_dump(__METHOD__);
        echo '<br>/';
        return true;
    }

    public function close()
    {
        // TODO: Implement close() method.
        var_dump(__METHOD__);
        echo '<br>/';
        $this ->mysql -> close();
        return true;
    }
    # 查询 数据库中的数据
    public function read($session_id)
    {
        // TODO: Implement read() method.
        var_dump(__METHOD__);
        echo '<br>/';
        $sql = 'select * from t_session where session_id = " '.$session_id.'"';

        $session_info = $this -> mysql ->query( $sql ) -> fetch_assoc();

        if( $session_info ){
            # 过期的session不能被取到
            if( $session_info['expire'] < time() ){
                # 删除过期的session
                $delete_sql = 'delete from t_session where session_id="'.$session_id.'"';
                $delete_result = $this -> mysql -> query( $delete_sql );
                if( $delete_result ){
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
    # 添加到 数据库中
    public function write($session_id, $session_data)
    {
        // TODO: Implement write() method.
        var_dump(__METHOD__);
        echo '<br>/';
        # 查询 session_id 是否 存在
        $sql_count = 'select * from t_session where session_id="'.$session_id.'"';
        $result = $this -> mysql -> query( $sql_count ) -> fetch_all(MYSQLI_ASSOC);
        if( empty( $result ) ){
            $inser_sql = 'insert into t_session values (
              NULL ,"'.$session_id.'","'.addslashes($session_data).'",'.(time()+$this -> expire).')';
            echo '<hr/>';
            var_dump( $inser_sql );
            echo '<br/>';
            $insert = $this -> mysql -> query( $inser_sql );
            var_dump( $insert );
            echo '<hr/>';
            if( $insert ){
                return true;
            }else{
                return false;
            }
        }else{
            $update_sql = 'update t_session set session_data="'.addslashes($session_data).'
            ",expire='.(time() + $this ->expire).' where session_id="'.$session_id.'"';

            $insert =$this -> mysql -> query( $update_sql );
            if( $insert ){
                return true;
            }else{
                return false;
            }
        }
    }
    # 删除 当前 session_id 的数据
    public function destroy($session_id)
    {
        // TODO: Implement destroy() method.
        var_dump(__METHOD__);
        echo '<br>/';
        $delete_sql = 'delete from t_session where session_id="'.$session_id.'"';
        $delete_result = $this -> mysql -> query( $delete_sql );

        if ( $delete_result ){
            return true;
        }else{
            return false;
        }
    }
    # 全局 清理过期的session数据
    public function gc($maxlifetime)
    {
        // TODO: Implement gc() method.
        var_dump(__METHOD__);
        echo '<br>/';
        var_dump('gc');
        $gc_sql = 'delete from t_session where expire <'.time();
        $gc_result = $this -> mysql -> query( $gc_sql );

        if ( $gc_result ){
            return true;
        }else{
            return false;
        }
    }
}

# 使用自定义的session入库类 按照自带的 PHP session机制
$mysql_session = new  MyMysqlSession();
session_set_save_handler(
        array($mysql_session,'open'),
        array($mysql_session,'close'),
        array($mysql_session,'read'),
        array($mysql_session,'write'),
        array($mysql_session,'destroy'),
        array($mysql_session,'gc')
);

session_start();
$_SESSION['user_info'] =[
    'user_id' => 10,
    'user_name' => 'zhangsan'
];

var_dump($_SESSION);