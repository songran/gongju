<?php
//include "./vendor/autoload.php";
// require __DIR__ . '/../..//src/db/Kafka.php';

// use \Gongju\Db\Kafka;
// $config = [
//     'group'      => 'mygroup',
//     'brokerList' => "192.168.33.10:9092,", // 192.168.33.10
//     'topic'      => 'hell123',
//     'maxNum'     => 5,
// ];
// $kafkaMod = new Kafka($config);

 
// $arr = [
//     'id'      => '11111111',
//     'content' => (string) $argv[1],
// ];
// $kafkaMod->product(json_encode($arr));


$rk = new RdKafka\Producer();

$rk->setLogLevel(LOG_DEBUG);      // 设置日志级别
$rk->addBrokers('192.168.33.10:9002'); // 添加经纪人，就是ip地址

$topic = $rk->newTopic("hell123"); // 新建主题

// 第一个参数：是分区。RD_KAFKA_PARTITION_UA代表未分配，并让librdkafka选择分区
// 第二个参数：是消息标志，必须为0
// 第三个参数：消息，如果不为NULL，它将被传递给主题分区程序
$topic->produce(RD_KAFKA_PARTITION_UA, 0, 'Message'); // 生成并发送单个消息