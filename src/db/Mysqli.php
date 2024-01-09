<?php
namespace Gongju\Db;
date_default_timezone_set('Asia/Shanghai');
mysqli_report(MYSQLI_REPORT_OFF);
 
class Mysqli {

    private $link_id = null;//MySQLi链接
    private $dbname; //数据库名
    private $debug ; //调试模式
    private $isLog ; //是否写入日志
    private $logfile;//日志目录

    /**
     * 构造函数
     * 
     * 调用connect方法，返回$link_id
     */
    public function __construct($conf) {
        $dbhost   = $conf['dbhost'];
        $dbuser   = $conf['dbuser'];
        $dbpw     = $conf['dbpw'];
        $dbname   = $conf['dbname']?$conf['dbname']:'';
        $charset  = $conf['charset']?$conf['charset']:'UTF8';
        $pconnect = isset($conf['pconnect']) && $conf['pconnect']==1?1:0;
        $this->debug    = isset($conf['debug'])?$conf['debug']:1;


        $this->logfile = isset($conf['logfile']) && $conf['logfile']!=''?$conf['logfile']:'';
        $this->isLog   = $this->logfile ?1:0;

        $this->connect($dbhost, $dbuser, $dbpw, $dbname, $charset, $pconnect);
        $this->dbname = $dbname;
    }
    /**
     * 打开一个MySql链接
     * $dbhost   数据库地址
     * $dbuse    数据库账号
     * $dbpw     数据库密码
     * $dbname   数据库名
     * $pconnect 1:持久链接;0:普通链接
     * $charset
     * return $link_id
     */
    public function connect($dbhost, $dbuser, $dbpw, $dbname, $charset, $pconnect) {
        $func = $pconnect == 1 ? 'mysqli_pconnect' : 'mysqli_connect';

        $this->link_id = @$func($dbhost, $dbuser, $dbpw);
         if (!$this->link_id ) {
            $this->message('数据库链接失败');
            return false;
        }  
        mysqli_query($this->link_id, "SET NAMES $charset");
        if ($dbname && !@mysqli_select_db($this->link_id, $dbname)) {
            $this->message('数据库错误');
            return false;
        }
     }
    /**
     * 选择数据库
     * return bool
     */
    public function selectDb($dbname) {
        if (!@mysqli_select_db($this->link_id, $dbname)) {
            return false;
        }

        $this->dbname = $dbname;
        return true;
    }
    /**
     * 执行sql
     */
    public function query($sql) {
        $query = mysqli_query($this->link_id, $sql); 
        if($query){
            return $query;
        }else{
            $this->message('执行错误', $sql);
        }
        return $query;
    }
    /**
     * @desc Select
     *
     * @param  $sql
     * @param  $keyfield
     * @return Result
     */
    public function select($sql) {
        $array  = [];
        $result = $this->query($sql);
        while ($r = $this->fetchArray($result)) {
            $array[] = $r;
        }
        $this->freeResult($result);
        return $array;
    }

    /**
     * 获取第一条结果
     */
    public function getfirst($sql) {
        return $this->fetchArray($this->query($sql));
    }

    /**
     * 执行插入sql
     * $tablename  表名
     * $array  需要插入的数据 array('filed=>$value)
     * return bool
     */
    public function insert($tablename, $array) {
        return $this->query("INSERT INTO `$tablename`(`" . implode('`,`', array_keys($array)) . "`) VALUES('" . implode("','", $array) . "')");
    }
    /**
     * 执行更新sql
     * $tablename  表名
     * $array  需要插入的数据  array('filed'=>$value)
     * $where  条件
     * @return bool
     */
    public function update($tablename, $array, $where = '') {
        if ($where) {
            $sql = '';
            foreach ($array as $k => $v) {
                $sql .= ", `$k`='$v'";
            }
            $sql = substr($sql, 1);
            $sql = "UPDATE `$tablename` SET $sql WHERE $where";
        } else {
            $sql = "REPLACE INTO `$tablename`(`" . implode('`,`', array_keys($array)) . "`) VALUES('" . implode("','", $array) . "')";
        }
        return $this->query($sql);
    }
    /**
     * 获取主键
     * $table 表名
     * return Primary  filed
     */
    public function getPrimary($table) {
        $result = $this->query("SHOW COLUMNS FROM $table");
        while ($r = $this->fetchArray($result)) {
            if ($r['Key'] == 'PRI') {
                break;
            }

        }
        $this->freeResult($result);
        return $r['Field'];
    }

    /**
     * @desc  Get a record from database
     *
     * @param String $sql
     * @param String $type    mysql_query  or   mysql_unbuffered_query
     * @return   Result
     */
    public function fetch($sql) {
        $query = $this->query($sql);
        $rs    = $this->fetchArray($query);
        $this->freeResult($query);
        return $rs;
    }
    /**
     *  遍历结果集
     *  $result_type MYSQL_ASSOC 关联索引;MYSQL_NUM 数字索引;MYSQL_BOTH 两者都有
     */
    public function fetchArray($query, $result_type = MYSQLI_ASSOC) {
        return mysqli_fetch_array($query, $result_type);
    }
    /**
     * 从结果集中取得一行作为数组
     */
    public function fetchRow($query) {
        return mysqli_fetch_row($query);
    }
    /**
     *  INSERT，UPDATE 或 DELETE 查询所影响的记录行数
     */
    public function affectedRows() {
        return mysqli_affected_rows($this->link_id);
    }
    /**
     * 获取结果集行数
     */
    public function numRows($result) {
        return mysqli_num_rows($result);
    }
    /**
     * 返回结果集中字段的数目
     */
    public function numFields($result) {
        return mysql_num_fields($result);
    }

    /**
     * 释放所有与结果标识符 result 所关联的内存。
     * return bool
     */
    public function freeResult(&$result) {
        return mysqli_free_result($result);
    }
    /**
     * 获取上步insert产生的自增id
     */
    public function insertId() {
        return mysqli_insert_id($this->link_id);
    }
    /**
     * 获取服务器版本
     */
    public function version() {
        return mysqli_get_server_info($this->link_id);
    }
    /**
     * 关闭MySQL链接
     * @return bool
     */
    public function close() {
        if($this->link_id){
            return mysqli_close($this->link_id);
        }
       
    }
    /**
     * 获取mysql错误信息
     */
    public function error() {
        if($this->link_id){
            return @mysqli_error($this->link_id);   
        } 
    }
    /**
     * 获取mysql错误号码
     */
    public function errno() {
        if($this->link_id){
            return intval(@mysqli_errno($this->link_id));
        }
        
    }
    //析构函数
    public function __destruct()
    {
        $this->close();
    }

    /**
     * 错误信息处理
     * $message  错误信息
     * $sql  错误sql
     */
    public function message($msg = '', $sql = '') {
        $errorMsg = "<b> Sql : </b>$sql <br /><b>  Err : </b>" . $this->error() . " <br /> <b> Errno : </b>" . $this->errno() . " <br /><b> Msg : </b> $msg";
 

        $msg1 ="sql:".$sql." Err:".$this->error()." Errno:".$this->errno()." Msg:$msg";
        $this->writeLog($msg1);
        if ($this->debug) {
            echo '<div style="font-size:12px;text-align:left; border:1px solid #9cc9e0; padding:1px 4px;color:#000000;font-family:Arial, Helvetica,sans-serif;"><span>' . $errorMsg . '</span></div>';
            exit;
        }
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
            file_put_contents($this->logfile, $info, FILE_APPEND);
        }
        return true; 
    }

}
?>