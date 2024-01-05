<?php
namespace Gongju\Wx;
/**
 * 微信小程序 的二维码图片
 */
class Qrcode {
    public $app_id;
    public $secret;

    public function __construct($config) {
        $this->app_id = $config['app_id'];
        $this->secret = $config['secret'];
    }

    /**
     * 第一步  获取access_token
     * @Author   SongRan
     * @DateTime 2019-07-19
     * @param    [type]     $APPID     [description]
     * @param    [type]     $APPSECRET [description]
     * @return   [type]                [description]
     */
    public function getAccessToken() {
        $access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->app_id}&secret={$this->secret}";
        $json         = self::httpRequest($access_token);
        $res          = json_decode($json, true);
        return $res["access_token"];
    }

    /**
     * 获得小程序二维码图片  方形 base64格式
     * @Author   SongRan
     * @DateTime 2019-07-19
     * @param    [type]     $path  [要传的参数] eq: pages/index/index?qrcode=helloworld
     * @param    integer    $width [图片宽度]
     * @return   [type]            [description]
     */
    public function squareImg($path, $width = 150, $other = []) {
        $file = self::squareImgFile($path, $width, $other);
        return self::getBase64($file);
    }
    /**
     * 获得小程序二维码图片  方形 原形状
     * @Author   SongRan
     * @DateTime 2019-07-19
     * @param    [type]     $path  [要传的参数] eq: pages/index/index?qrcode=helloworld
     * @param    integer    $width [图片宽度]
     * @return   [type]            [description]
     */
    public function squareImgFile($path, $width = 150, $other = []) {

        $ACCESS_TOKEN = self::getAccessToken();
        $url          = "https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=$ACCESS_TOKEN";
        $arr          = ["path" => $path, "width" => $width];
        $param        = json_encode(array_merge($arr, $other));
        return self::httpRequest($url, $param, "POST");
    }

    /**
     * 获得小程序二维码图片  圆形 base64格式
     * @Author   SongRan
     * @DateTime 2019-07-19
     * @param    [type]     $path  [要传的参数] eq: pages/index/index?qrcode=helloworld
     * @param    integer    $width [图片宽度]
     * @return   [type]            [description]
     */
    public function circularImg($path, $width = 150, $other = []) {
        $file = self::circularImgFile($path, $width, $other);
        return self::getBase64($file);

    }
    /**
     * 图片 流文件 圆形
     * @Author   SongRan
     * @DateTime 2024-01-05
     */
    public function circularImgFile($path, $width = 150, $other = []) {
        $ACCESS_TOKEN = self::getAccessToken();
        $url          = "https://api.weixin.qq.com/wxa/getwxacode?access_token=$ACCESS_TOKEN";
        $arr          = ["path" => $path, "width" => $width];
        $param        = json_encode(array_merge($arr, $other));
        return self::httpRequest($url, $param, "POST");
    }
    /*
     * 流文件转 base64
     */
    public function getBase64($file) {
        return "data:image/jpeg;base64," . base64_encode($file);
    }

    /**
     * curl 公共方法
     * @Author   SongRan
     * @DateTime 2019-07-19
     * @param    [type]     $url    [链接地址]
     * @param    string     $data   [post 数据]
     * @param    string     $method [方式]
     * @return   [type]             [返回数据]
     */
    public function httpRequest($url, $data = '', $method = 'GET') {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data != '') {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }

}