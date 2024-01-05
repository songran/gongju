<?php
/**
 * mysqli 链接方法
 */
include "./vendor/autoload.php";
use \Gongju\Db\Mysqli;

$db = new Mysqli('192.168.33.10:3306', 'root', 'root12345', 'app_songran', 'utf8');

$sql = "select id,title from s_code limit 10 ";
$res = $db->select($sql);

echo '<pre>';
print_r($res);
exit;
