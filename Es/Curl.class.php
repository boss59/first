<?php
class Curl
{
    private static $ch;
    private static function initCurl()
    {
        # 初始化CURL
        Curl::$ch = curl_init();
        # 设置直接返回，不输出
        curl_setopt( CURL::$ch,CURLOPT_RETURNTRANSFER,1);
    }

    public static function get($url,$data = [],$header=[])
    {
        Curl::initCurl();
        curl_setopt(CURL::$ch,CURLOPT_URL,$url);
        # 设置头信息 [Es数据格式为Content-Type:application/json]
        if (!empty($header)) {
            curl_setopt(Curl::$ch,CURLOPT_HEADER,false);
            curl_setopt(Curl::$ch,CURLOPT_HTTPHEADER,$header);
        }

        # 设置请求方式为GET请求
        curl_setopt(Curl::$ch,CURLOPT_CUSTOMREQUEST,"GET");
        curl_setopt(Curl::$ch,CURLOPT_POSTFIELDS,$data);
        $result = curl_exec(Curl::$ch);
        Curl::CloseCurl();
        return $result;
    }

    public function post($url,$data=[],$header=[])
    {
        Curl::initCurl();
        # 设置post提交
        curl_setopt(Curl::$ch,CURLOPT_POST,1);
        # 设置请求的地址
        curl_setopt(Curl::$ch,CURLOPT_URL,$url);
        # 设置头信息 [Es数据格式为Content-Type:application/json]
        if (!empty($header)) {
            curl_setopt(Curl::$ch,CURLOPT_HEADER,false);
            curl_setopt(Curl::$ch,CURLOPT_HTTPHEADER,$header);
        }
        # 设置请求的信息
        curl_setopt(Curl::$ch,CURLOPT_POSTFIELDS,$data);
        $result = curl_exec(Curl::$ch);
        Curl::CloseCurl();
        return $result;
    }

    public static function delete($url,$data=[],$header=[])
    {
        Curl::initCurl();
        # 设置post提交
        curl_setopt(Curl::$ch,CURLOPT_POST,1);
        # 设置请求的地址
        curl_setopt(Curl::$ch,CURLOPT_URL,$url);
        # 设置请求方式为delete请求
        curl_setopt(Curl::$ch,CURLOPT_CUSTOMREQUEST,"DELETE");

        $result = curl_exec(Curl::$ch);
        Curl::CloseCurl();
        return $result;
    }

    public static function CloseCurl()
    {
        curl_close(CURL::$ch);
    }
}