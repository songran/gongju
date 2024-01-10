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
$kafkaMod->isConnect(); //监测kafka 是否连接
// print_r($kafkaMod);
// exit;
//执行消费部分
$count = 0;
$arr   = [];
while (true) {
    $msg = $kafkaMod->consumer->consume(1000);

    echo $msg->payload . "\n";
    $count++;
}
