<?php

include "./vendor/autoload.php";
use \Gongju\Db\Redisclient;
$config = [
    'host'     => '192.168.1.110',
    'port'     => '6379',
    'auth'     => '',
    'timeout'  => 60,
];
$redis = new Redisclient($config);

//设置
$res = $redis->set('log-master', 11111, 0, 0, $time = 10);

var_dump($res);
//获取
$res = $redis->get('log-master');
if ($res) {
    echo 33333333;
}