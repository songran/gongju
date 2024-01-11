<?php
//include "./vendor/autoload.php";
require __DIR__ . '/../..//src/db/Kafka.php';

use \Gongju\Db\Kafka;
$config = [
    'group'      => 'mygroup',
    'brokerList' => "192.168.33.10:9092,", // 192.168.33.10
    'topic'      => 'hell123',
    'maxNum'     => 5,
];
$kafkaMod = new Kafka($config);

 
$arr = [
    'id'      => '11111111',
    'content' => (string) $argv[1],
];
$kafkaMod->product(json_encode($arr));
