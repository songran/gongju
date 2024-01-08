<?php

namespace Gongju\Aliyun;
use Gongju\Aliyun\SignatureHelper;

/**
 * 阿里发短信接口
 */
class SendSms {
    private $accessKeyId;
    private $accessKeySecret;
    private $SignName; //短信签名

    public function __construct($params) {
        $this->accessKeyId     = $params['accessKeyId'];
        $this->accessKeySecret = $params['accessKeySecret'];
        $this->SignName        = $params['SignName'];
    }

    /**
     * 一键申请提醒缴费
     * @Author   SongRan
     * @DateTime 2018-06-14
     * @param    [type]     $tel [手机号]
     * @param    [type]     $user[用户名]
     * @return   [type]          [description]
     */
    public function onePayfee($tel, $user) {
        $TemplateCode  = 'SMS_137426777';
        $TemplateParam = [
            'userName' => $user,
        ];
        return $this->sendSms($tel, $TemplateCode, $TemplateParam);
    }
    /**
     * 国际-港澳台 发验证码
     * @Author   SongRan
     * @DateTime 2018-06-14
     * @param    [type]     $tel  [description]
     * @param    [type]     $code [description]
     * @return   [type]           [description]
     */
    public function internationalVcode($tel, $code) {
        $TemplateCode  = 'SMS_137426611';
        $TemplateParam = [
            'verificationCode' => $code,
        ];
        return $this->sendSms($tel, $TemplateCode, $TemplateParam);
    }
    /**
     * 国内 发验证码
     * @Author   SongRan
     * @DateTime 2018-06-14
     * @param    [type]     $tel  [description]
     * @param    [type]     $code [description]
     * @return   [type]           [description]
     */
    public function domesticVcode($tel, $code) {
        $TemplateCode  = 'SMS_137426608';
        $TemplateParam = [
            'verificationCode' => $code,
        ];
        return $this->sendSms($tel, $TemplateCode, $TemplateParam);
    }
    /**
     * 发短信通用方法
     * @Author   SongRan
     * @DateTime 2018-06-14
     * @param    [type]     $tel           [手机号]
     * @param    [type]     $TemplateCode  [短信模板]
     * @param    array      $TemplateParam [膜拜变量]
     * @param    array      $ext           [扩展]
     * @return   [type]                    []
     */
    public function sendSms($tel, $TemplateCode, $TemplateParam = [], $ext = []) {

        $params = [];
        // *** 需用户填写部分 ***
        $accessKeyId     = $this->accessKeyId;
        $accessKeySecret = $this->accessKeySecret;
        $params          = [
            'PhoneNumbers'  => $tel, //手机号
            'SignName'      => $this->SignName, //短信签名
            'TemplateCode'  => $TemplateCode, //模板
            'TemplateParam' => $TemplateParam, //设置模板参数 变量
        ];
        //选填
        $params['OutId'] = isset($ext['OutId']) ? $ext['OutId'] : ""; //设置发送短信流水号
        // 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        $params['SmsUpExtendCode'] = isset($ext['SmsUpExtendCode']) ? $ext['SmsUpExtendCode'] : "";

        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if (!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }
        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new SignatureHelper();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, [
                "RegionId" => "cn-hangzhou",
                "Action"   => "SendSms",
                "Version"  => "2017-05-25",
            ])
            // fixme 选填: 启用https
            // ,true
        );
        return $content;
    }

}