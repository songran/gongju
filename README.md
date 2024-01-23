# php 工具箱
安装方法：
/usr/local/php81/bin/php composer.phar require songran/gongju dev-main

composer require songran/gongju dev-main

功能：

1.mysqli，redis，mongodb，数据库链接类 

2.消息队列 rdkafka (依赖rdkafka扩展) 

3.api 接口安全， 加解密

	api_verifycation
	描述：api接口安全 验证接口 1.实现业务验签 签名秘钥 2.实现防刷 时间戳

	api_encryption
	RSA密钥生成命令 （后期使用）
	1、生成RSA私钥 openssl>genrsa -out rsa_private_key.pem 1024 得到exponent: 65537
	2、生成modulus: openssl>rsa -in rsa_private_key.pem -modulus -out rsa_moules.pem
	3、生成RSA公钥 openssl>rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem
	注意：“>”符号后面的才是需要输入的命令。


4.阿里云 发送短信

5.生成二维码图片 （验证码）扫码登录使用

6.生成 微信登录二维码

