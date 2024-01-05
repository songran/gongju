<?php
/**
 *mongodb 操作方法
 */
include "./vendor/autoload.php";
$config = [
    "log_master" => [
        "host"     => "xxxx",
        "port"     => 27017,
        "username" => "root",
        "password" => "root123",
    ],
];
$mon = new Gongju\Db\Mongo($config['log_master']);

//1  新增
$insert = [
    'ip'    => '192.168.0.11',
    'code'  => 30001,
    'info'  => 'wrong,wrong,wrong',
    'level' => 'info',
    'time'  => '20170712',
];
$res = $mon->insert('longzhu-log.api_log_201707', $insert);

print_r($res);
exit;
//2 修改
/*
$options = array(
'info' =>'44444'
);
$res  = $mon->update('longzhu-log.api_log_201707',['time'=>'20170712'],$options);
 */

//3 删除
//$res  = $mon->delete('longzhu-log.api_log_201707',['time'  =>  '20170712']);

/*
//4 查询
$options = array(

"projection" => array(
"time" => 1,
"info" => 1,
),
"sort" => array(
"views" => -1,
),
"limit" =>5,
"modifiers" => array(
'$comment'   => "This is a query comment",
'$maxTimeMS' => 100,
),
);
$filter = array(
'time' => '20170711',
);

$res  = $mon->select('longzhu-log.api_log_201707',$filter,$options);
 */
// $res  = $mon->select('longzhu-log.api_log_201707');
// print_r($res);
