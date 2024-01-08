<?php
include "./vendor/autoload.php";
use \Gongju\Aliyun\CheckEnvirement;  
//自定义 函数
$arr =[
 	'mysqli_select_db'=>'缺少mysqli扩展',
 	'openssl_pkey_get_private'		  =>'缺少openssl',
 	'mb_substr'=>null,
 	'iconv'   =>null		
];
CheckEnvirement::getHanshuArr($arr);
 
CheckEnvirement::result();