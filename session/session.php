<?php

// session_set_save_handler — 设置用户自定义会话存储函数

class  MyRedisSession implements SessionHandlerInterface
{
    public $redis;
    public $expire = 1440; // 设置时间
    public $key_prefix = "phpredis-session:";// key的前缀

    public function open($save_path, $session_id)
    {
        // TODO: Implement open() method.
        // var_dump(__METHOD__);// 打印当前方法

        $this -> redis = new Redis();
        $this -> redis ->connect('127.0.0.1',6379);

        return true;
    }


    public function read($session_id)
    {
        // TODO: Implement read() method.
        // var_dump(__METHOD__);// 打印当前方法

        $key = $this -> key_prefix.$session_id;

        $session_data = $this -> redis -> get($key);

        $this -> redis ->expire($key,$this->expire);// 延长时间

        if ($session_data){
            return $session_data;
        }else{
            return serialize([]);
        }
    }

    public function write($session_id, $session_data)
    {
        // TODO: Implement write() method.

        $key = $this -> key_prefix.$session_id;

        $add = $this -> redis -> set($key,$session_data,$this->expire);

        if ($add){
            return true;
        }else{
            return false;
        }
    }

    public function close()
    {
        // TODO: Implement close() method.

        $this -> redis -> close();
        return true;
    }

    public function destroy($session_id)
    {
        // TODO: Implement destroy() method.

        $key = $this -> key_prefix.$session_id;

        $this -> redis -> del($key);

        return true;
    }

    public function gc($maxlifetime)
    {
        // TODO: Implement gc() method.

        # 因为redis会自动清理过期的key，就不需要删除过期的key
        return true;
    }
}


$redis_session  = new MyRedisSession();

session_set_save_handler(
    [$redis_session,'open'],
    [$redis_session,'close'],
    [$redis_session,'write'],
    [$redis_session,'destroy'],
    [$redis_session,'gc']
);

echo "<hr /><br />输入数据为<br />";

session_start();

$_SESSION['user_info'] = [
    'user_id' => 1,
    'user_name' => '一叶之秋'
];
echo 'session_data:<br />';

var_dump($_SESSION);

echo "<hr />";
?>