<?php
namespace Gongju\Db;
class kafka {

    public $kafkaConf;
    public $topicConf;
    public $consumer;
    public $logfile ;
    public $isLog   ;

    /**
      $config=[
        'group'             => 'mygroup',
        'brokerList'        => "127.0.0.1:9092,",//39.105.50.68:9092
        'topic'             => 'hell123',
        'maxNum'            => 5,
    ];
    */
    public function __construct($config) {
        $this->kafkaConf = $config;
        $this->logfile   = isset($conf['logfile']) && $conf['logfile']!=''?$conf['logfile']:'';
        $this->isLog     = $this->logfile ?1:0;
        $this->getConsumer();
    }
    /**
     * 初始化 链接
     * @Author   SongRan
     * @DateTime 2024-01-09
     * @return   [type]     [description]
     */
    public function getConsumer() {
        $conf = new \RdKafka\Conf();
        $conf->set('group.id', $this->kafkaConf['group']);
        $conf->set('metadata.broker.list', $this->kafkaConf['brokerList']);
        $topicConf = new \RdKafka\TopicConf();
        $topicConf->set('auto.offset.reset', 'smallest');
        $conf->setDefaultTopicConf($topicConf);
        $consumer = new \RdKafka\KafkaConsumer($conf);
        $consumer->subscribe([$this->kafkaConf['topic']]);

        $this->topicConf = $topicConf;
        $this->consumer  = $consumer;
    }

    /**
     * 查看kafka 是否连接正常
     * @Author   SongRan
     * @DateTime 2024-01-05
     * @return   boolean    [description]
     */
    public function isConnect() {
        try {
            $topic = $this->consumer->newTopic($this->kafkaConf['topic'], $this->topicConf);
            $this->consumer->getMetadata(false, $topic, 1000);
        } catch (\Exception $e) {
            $this->writeLog($e->getMessage());
        }
    }

    /**
     * 生产者
     * @Author   SongRan
     * @DateTime 2024-01-05
     * @param    [type]     $msg [description]
     * @return   [type]          [description]
     */
    public function product($msg) {
        $rk = new \RdKafka\Producer();
        $rk->setLogLevel(LOG_DEBUG);
        $rk->addBrokers($this->kafkaConf['brokerList']);
        $topic = $rk->newTopic($this->kafkaConf['topic']);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0, $msg);
    }
    /**
     * 写入日志
     * @Author   SongRan
     * @DateTime 2024-01-08
     * @param    [type]     $msg [description]
     * @return   [type]          [description]
     */
    public function writeLog($msg){
        if($this->isLog){
            $info = date('Y/m/d H:i:s', time()) . ' ' . $msg . "\n";
            file_put_contents($this->logfile, $msg, FILE_APPEND);
        }
        return true; 
    }

}