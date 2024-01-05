<?php
 //放到最外层
require_once __DIR__ . '/../vendor/autoload.php';  
use Safe\Verification;  

$mod    = new Verification('hooLi2017', 60); //秘钥和过期时间



//1  php生成验签名
$time = time();
echo '<pre>';
//echo $time ;

$arr = array(
	'id'    =>123,
	'name'  =>'hello',
	'sex'   =>'boy',
	'age'   =>23, 
	'timeStamp' =>$time,
	'arr'   =>array(1,2,3,4),
 );
 
// $arr = array(
// 	'token'     =>'a1hxUUFYaWhqRGNCTHdKMW5QQ2p',
// 	'timeStamp' =>$time
//  );
$sign = $mod->getSign($arr);
//echo $sign;

$arr['sign'] = $sign;

$str = '';
foreach($arr as $k=>$v){
	$str.=$k.'='.$v.'&';
}
echo $str.'<br>';
print_r($arr);
echo '<hr>';
echo $str.'<br>';

print_r($mod->checkData($arr));


 