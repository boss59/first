<?php

    header('content-type:text/html;charset=utf-8');
    $mysql  = new Mysqli('127.0.0.1','root','root','order');
    $mysql->query('set names utf8');

    # 判断 文件是否存在
    $sync_file = __DIR__.'/order_sync.log';
    if (!file_exists($sync_file)){
        file_put_contents($sync_file,'');
    }

    $fp =fopen($sync_file,'a+');
    $file_size = filesize($sync_file);
    fseek($fp,$file_size);

    while (fgetc($fp) != "\r\n"){
        $file_size --;
        fseek($fp,$file_size);
    }



?>