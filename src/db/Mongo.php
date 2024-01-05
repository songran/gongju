<?php
namespace Gongju\Db;
class Mongo {

    private $config         = NULL; //配置
    private $connection     = NULL; //链接
    private $writeConcern   = NULL;
    private $bluk           = NULL;
    private $readPreference = NULL;

    /**
     * 初始化类，得到mongo的实例对象
     * @Author   SongRan
     * $config = [
    "host"       => "xxxx",
    "port"       => 27017,
    "username"   => "root",
    "password"   => "root123",
    ];
     * @DateTime 2024-01-05
     * @param    [type]     $config [description]
     */
    public function __construct($config = null) {
        if ($config == null) {
            return false;
        }
        $this->config = $config;
        $this->bulk();
        $this->writeConcern();
        $this->readPreference();
        $this->connect();
    }

    public function bulk() {
        $this->bulk = new MongoDB\Driver\BulkWrite;
    }
    public function writeConcern() {
        $this->writeConcern = new MongoDB\Driver\WriteConcern(0, 1000);
    }
    public function readPreference() {
        $this->readPreference = new MongoDB\Driver\ReadPreference(MongoDB\Driver\ReadPreference::RP_PRIMARY);
    }

    /**
     * 连接数据库
     */
    public function connect() {
        try {
            if (empty($this->config['username']) || empty($this->config['password'])) {

                $this->connection = new MongoDB\Driver\Manager(sprintf('mongodb://%s:%d', $this->config['host'], $this->config['port']));
            } else {

                $this->connection = new MongoDB\Driver\Manager(sprintf('mongodb://%s:%d', $this->config['host'], $this->config['port']),
                    [
                        'username' => $this->config['username'],
                        'password' => $this->config['password'],
                    ]);
            }
        } catch (Exception $e) {
            $this->showError($e);
        }
    }

    /**
     * 单个插入数据方法
     *$table = '库.表'例:db.a
     *$document  插入的数组 例如：['time'=>'123','name=>'xxx']
     */

    public function insert($table, $document = []) {
        try {
            $this->bulk->insert($document);
            return $this->connection->executeBulkWrite($table, $this->bulk, $this->writeConcern);
        } catch (\Exception $e) {
            $this->showError($e);
        }
    }
    /**
     * 批量插入数据方法
     *$table = '库.表'例:db.a
     *$documents 三维数组  插入的数组[['time'=>'123','name'=>'xxx'],['time'=>'456','name'=>'abc']]
     */
    public function batchInsert($table, $documents = []) {
        try {
            foreach ($documents as $key => $value) {
                $this->bulk->insert($value);
            }
            return $this->connection->executeBulkWrite($table, $this->bulk, $this->writeConcern);
        } catch (\Exception $e) {
            $this->showError($e);
        }
    }

    /**
     *修改方法
     *$table  库.表
     *array $filter  where条件 例如：['_id' => 4]
     *array $options 要修改的内容 例如：['name' => '132','time'=>456]
     *array $condition  全局改变条件   ['multi' => true,'upsert' => false]
     */
    public function update($table, $filter = [], $options = [], $condition = ['multi' => true, 'upsert' => false]) {
        try {
            $this->bulk->update($filter, ['$set' => $options], $condition);
            return $this->connection->executeBulkWrite($table, $this->bulk, $this->writeConcern);
        } catch (\Exception $e) {
            $this->showError($e);
        }
    }

    /*
     *删除方法
     *$table 库.表
     *$options 条件
     */
    public function delete($table, $options = []) {
        try {
            $this->bulk->delete($options);
            return $this->connection->executeBulkWrite($table, $this->bulk, $this->writeConcern);
        } catch (\Exception $e) {
            $this->showError($e);
        }
    }

    /**
     *查询数据
     * $table 库.表 如db.a
     * array  $filter   where 条件  ['time' => '20170711']
     * array  $options  查找的内容排序   例：
     *  $options = array(
     *       "projection" => array("title" => 1,"time" => 1,  ),
     *       "sort"       => array("views" => -1,  ),
     *       "modifiers"  => array('$comment'  => "This is a query comment",'$maxTimeMS' => 100,
     *       ),);
     */
    public function select($table, $filter = [], $options = []) {
        try {
            $query  = $this->query($filter, $options);
            $cursor = $this->connection->executeQuery($table, $query, $this->readPreference);
            $return = [];
            foreach ($cursor as $document) {
                $return[] = (array) $document;
            }

        } catch (\Exception $e) {
            $this->showError($e);
        }
        return $return;
    }

    /**
     *query 方法
     */
    public function query($filter, $options) {
        return new MongoDB\Driver\Query($filter, $options);
    }
    /**
     * 抛出异常
     * @param $e
     */
    public function showError($e) {
        exit('mongodb:' . $e->getMessage());
    }

}