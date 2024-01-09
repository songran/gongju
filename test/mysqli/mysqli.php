<?php
/**
 * mysqli 链接方法
 */
//include "./vendor/autoload.php";

//mysqli_report(MYSQLI_REPORT_STRICT);
require __DIR__ . '/../..//src/db/mysqli.php';
use \Gongju\Db\Mysqli;

$config =[
	'dbhost'	=>'192.168.33.10:3306', 
	'dbuser'	=>'root', 
	'dbpw'		=>'root12345',
	'dbname'	=>'app_songran1', 
	'charset'	=>'utf8', 
	'pconnect'  => 0,
	'logfile'   =>__DIR__ . '/db.log',
	'debug'		=>1,
];
$db = new Mysqli($config);

$sql = "select id,title from s_code where 1 ";
$res = $db->select($sql);

echo '<pre>';
print_r($res);
exit;
