<?php

    #
    $mysql  = new Mysqli('127.0.0.1','root','root','aaa');

    $redis = new Redis();
    $redis -> connect('127.0.0.1',6379);

    

?>