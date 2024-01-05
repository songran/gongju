<?php
include "./vendor/autoload.php";
use \Gongju\Db\Rdkafka;
$config = [
    'group'      => 'mygroup',
    'brokerList' => "127.0.0.1:9092,", //39.105.50.68:9092
    'topic'      => 'hell123',
    'maxNum'     => 5,
];

$kafkaMod = new Rdkafka($config);
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
