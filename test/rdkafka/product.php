<?php
// // //include "./vendor/autoload.php";
// require __DIR__ . '/../..//src/db/Kafka.php';

// use \Gongju\Db\Kafka;
// $config = [
//     'group'      => 'mytest',
//     'brokerList' => "192.168.33.10:9092", // 192.168.33.10
//     'topic'      => 'mytest',
//     'maxNum'     => 5,
// ];
// $kafkaMod = new Kafka($config);

 
// $arr = [
//     'id'      => '11111111',
//     'content' => (string) $argv[1],
// ];
// $kafkaMod->product(json_encode($arr));



// function test1(){

//     $conf = new RdKafka\Conf();
//     $conf->set('metadata.broker.list', '192.168.33.10:9092'); 
//     //$conf->set('enable.idempotence', 'true');

//     $producer = new RdKafka\Producer($conf);

//     $topic = $producer->newTopic("mytest");

//     for ($i = 0; $i < 10; $i++) {
//         $topic->produce(RD_KAFKA_PARTITION_UA, 0, "Message $i");
//         $producer->poll(0);
//     }

//     for ($flushRetries = 0; $flushRetries < 10; $flushRetries++) {
//         $result = $producer->flush(10000);
//         if (RD_KAFKA_RESP_ERR_NO_ERROR === $result) {
//             break;
//         }
//     }

//     if (RD_KAFKA_RESP_ERR_NO_ERROR !== $result) {
//         throw new \RuntimeException('Was unable to flush, messages might be lost!');
//     }
// }


