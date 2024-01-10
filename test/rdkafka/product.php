<?php
//include "./vendor/autoload.php";
require __DIR__ . '/../..//src/db/kafka.php';

use \Gongju\Db\kafka;
$config = [
    'group'      => 'mygroup',
    'brokerList' => "192.168.33.10:9092,", //39.105.50.68:9092
    'topic'      => 'hell123',
    'maxNum'     => 5,
];

$kafkaMod = new kafka($config);

$arr = [
    'id'      => '11111111',
    'content' => (string) $argv[1],
];
$kafkaMod->product(json_encode($arr));
