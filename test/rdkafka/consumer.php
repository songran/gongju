<?php
// //include "./vendor/autoload.php";
// require __DIR__ . '/../..//src/db/Kafka.php';

// use \Gongju\Db\Kafka;
// $config = [
//     'group'      => 'mygroup',
//     'brokerList' => "192.168.33.10:9092,", // 192.168.33.10
//     'topic'      => 'hell123',
//     'maxNum'     => 5,
// ];

// $kafkaMod = new Kafka($config);
// $kafkaMod->isConnect(); //监测kafka 是否连接
// // print_r($kafkaMod);
// // exit;
// //执行消费部分
// $count = 0;
// $arr   = [];
// while (true) {
//     $msg = $kafkaMod->consumer->consume(1000);

//     echo $msg->payload . "\n";
//     $count++;
// }

$rk = new RdKafka\Consumer();
$rk->setLogLevel(LOG_DEBUG); // 设置日志级别
$rk->addBrokers("192.168.33.10:9002"); // 添加经纪人，就是ip地址

$topic = $rk->newTopic("hell123"); // 这里的$rk和生产者是不同的类哦

// 第一个参数分区ID
// 第二个参数是开始消费的偏移量，有效值
$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);

while (true) {
    // 第一个参数是要消耗的分区
    // 第二个参数是等待收到消息的最长时间，1000是一秒
    $msg = $topic->consume(0, 1000);
    if (@$msg->err) {
        echo $msg->errstr(), "\n"; // 输出错误
        //break;
    } else {
        echo @$msg->payload, "\n"; // 输出消息
    }
}









