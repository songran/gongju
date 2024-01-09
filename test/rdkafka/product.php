<?php
//include "./vendor/autoload.php";
require __DIR__ . '/../..//src/db/Rdkafka.php';

use \Gongju\Db\Rdkafka;
$config = [
    'group'      => 'mygroup',
    'brokerList' => "127.0.0.1:9092,", //39.105.50.68:9092
    'topic'      => 'hell123',
    'maxNum'     => 5,
];

$kafkaMod = new Rdkafka($config);

$arr = [
    'id'      => '11111111',
    'content' => (string) $argv[1],
];
$kafkaMod->product(json_encode($arr));
