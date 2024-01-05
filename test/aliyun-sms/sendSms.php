<?php
//放到最外层
require_once __DIR__ . '/../vendor/autoload.php';  
use Aliyun\SendSms;  
 
$params  =array(
	'accessKeyId'		=>'xxx',
	'accessKeySecret'	=>'xxx',
	'SignName'			=>'xxx',
);
$SendSms = new SendSms($params);
$res = $SendSms->domesticVcode(手机号,验证码); //发送国内验证码
echo '<pre>';
print_r($res);