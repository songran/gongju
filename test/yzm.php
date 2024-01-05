<?php
/**
 * 生成验证码
 */
include "./vendor/autoload.php";
use Gongju\Qrcode\QRcode;

$obj                  = new QRcode();
$errorCorrectionLevel = 'L';
$matrixPointSize      = 6;
$text                 = 'id=' . md5(time());
$s                    = $obj->png($text, false, $errorCorrectionLevel, $matrixPointSize, 2);
