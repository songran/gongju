<?php
// //include "./vendor/autoload.php";
// require __DIR__ . '/../..//src/db/Kafka.php';

// use \Gongju\Db\Kafka;
// $config = [
//     'group'      => 'mygroup',
//     'brokerList' => "192.168.33.10", // 192.168.33.10
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


// function test1(){
//     $conf = new RdKafka\Conf();
//     // Set a rebalance callback to log partition assignments (optional)
//     $conf->setRebalanceCb(function (RdKafka\KafkaConsumer $kafka, $err, array $partitions = null) {
//         switch ($err) {
//             case RD_KAFKA_RESP_ERR__ASSIGN_PARTITIONS:
//                 echo "Assign: ";
//                 var_dump($partitions);
//                 $kafka->assign($partitions);
//                 break;

//              case RD_KAFKA_RESP_ERR__REVOKE_PARTITIONS:
//                  echo "Revoke: ";
//                  var_dump($partitions);
//                  $kafka->assign(NULL);
//                  break;

//              default:
//                 throw new \Exception($err);
//         }
//     });

//     $conf->set('group.id', 'myConsumerGroup');
//     $conf->set('metadata.broker.list', '192.168.33.10');
//     $conf->set('auto.offset.reset', 'earliest');
//     $conf->set('enable.partition.eof', 'true');

//     $consumer = new RdKafka\KafkaConsumer($conf);
//     $consumer->subscribe(['mytest']);

//     echo "Waiting for partition assignment... (make take some time when\n";
//     echo "quickly re-joining the group after leaving it.)\n";

//     while (true) {
//         $message = $consumer->consume(1000);
//         switch ($message->err) {
//             case RD_KAFKA_RESP_ERR_NO_ERROR:
//                 var_dump($message);
//                 break;
//             case RD_KAFKA_RESP_ERR__PARTITION_EOF:
//                 echo "No more messages; will wait for more\n";
//                 break;
//             case RD_KAFKA_RESP_ERR__TIMED_OUT:
//                 echo "Timed out\n";
//                 break;
//             default:
//                 throw new \Exception($message->errstr(), $message->err);
//                 break;
//         }
//     }
// }



