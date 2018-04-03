<?php
include './Rsa.php';
/* 
 * 黎明互联
 * https://www.liminghulian.com/
 */

class Base extends RSA
{
    /**
     * 以下信息需要根据自己实际情况修改
     */
    const PID = '支付宝后台获取';//合作伙伴ID
    const REURL = './alipay/return.php';//同步通知地址
    const NOURL = './alipay/notify.php';//异步通知地址
    const KEY = '支付宝后台获取';
    const PAYGAGEWAY = 'https://mapi.alipay.com/gateway.do';
    const CHECKURL = 'https://mapi.alipay.com/gateway.do?service=notify_verify&partner=' . self::PID . '&notify_id=';
    const APPPRIKEY = 'MIIEpAIBAAKCAQEA7xCFR+0kqbqXccvJ1W6b7hAFJj93LZ8fnhx1hhrAxjMyxEyS4U35X11D9M2w/2WLOgjIOUpKoqkEZcMmhUVpf0WzLa1DW0rNj/b3NAE65z+rTjDoqQ3zTHuH91crPXmX5Fsf2QGQyvscKKsYVRLmMdxc/GAZYmBApEMbjt5jJZ4lQlwPigrF6i4Y9E9LePUPu5yGFR3NdQP5lVRyeSaYOWfg3XTQvD3hBg6jax2XI1z2WUtmU9O18D9wXOvcb5DUGO/JUB401dGO01+KLcwwt0NoHAyZH8YOfZ3Bl/xghwqIXHAEV9iDDPjhoEgmWSrck0eaC7XHkMNQGMq4Yb1zIwIDAQABAoIBABZ5Vh5B4+101iHjh5Dh+hSyOtmyo7CNQfqqMD4wK6k2TPJ5RGGb4/KcIPRVlescj68f/jqsikGqY/hxFSD4Ooe1dLe5jxh4+sQq8mhYKUJuENuj62thHVs2Tbzp2+3GjYnxKxhKdmMuoiIMm5f709oiHje3jQtbgxguGtweefGiMtP7vFc5IqyrdFwgqLKOmj3DWq238eKyfhca+KhkeQ32+MU8s/EaRLwEieKz8+qYprJAb2L0+LpCQ+At61h0OlivRT5D3BuSF2hZjvWcYLbWzEyWl1cjlfXqCBdW64YYxKLwPYXgO7s00bwZZ+ZjHaTz/genJjAyc39loZIM0skCgYEA/rUTF21HLyw52J8nb/8BUUzOtnO0CvcCQp7+Qd24DvKN0ZixCq2jLH4s/RQrd1B4MdWn7U0/hV+FtDuSFEIKILbBfuM0E+PlFIBWCNsQisCTP39C7Dvk+GDkSVqtK4QkJWbY4XKcrZbr3mLMBqUxLWsQPt4S6damY7OPC3c04N0CgYEA8EcfUigWfRzaUmIpHHRJ45CaL3y9FlvAnK0+o9CczmaN/U9B9W8ew2T3d+qV79mvPKTqf+gwj9VzzDvehI7GXb/FatBCqO0DKnw3XYpGCyIL+24BUOfprvXKds+yEHH0m7ssftgyVbaEJNE8ogSLHSQ+C/Q0TbxpzoatR3XMY/8CgYEAhQOpGbXe09rDxsWuwcUpOfzjgtK/tm4yhvojC+CvC1dOCqQz6MCvE0A9XFkZLfEfI99RGBMcVhmBaJMngV7PjTADsrESdESyUFeJFozYga15+FIMb/QDalanQUuSXcRfYAzqvCmvetPzD6sGo33HRdHApSQyOl33fN+7lyBExB0CgYALx6DceUSo+5okgdV8JKNeub8lZtsqVnM5+zBf/aFCaTq62YDlVH5QnAmZ4nFZYfW6Zmdsv+hplNBpieHd49YL0JQQKYerGnuWQKLCPj4y24d02y7LVaNaRYiYjJQxRDT20ZVb3qORGjKeT3fGhayAUD+OfHl3+i3Bx06Fe1v65wKBgQD2sUnVBrvZ6bQ/nBrCw2GyWPZ/lfWLyyHa2Pt5l0+Abce1FB6TjIW+k3jZ0JbSqWDOALDH7tM6IEopFo+FMHcwNglk1UFRedoB83HcBZcPGNaDr1EfRb9BKfFTFCFECnkyx556p7Ui9NKW6uuM6uVwiuKOdssboSp3NQu5oWp7FA==';
    const ALIPUBKEY = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCnxj/9qwVfgoUh/y2W89L6BkRAFljhNhgPdyPuBV64bfQNN1PjbCzkIM6qRdKBoLPXmKKMiFYnkd6rAoprih3/PrQEB/VsW8OoM8fxn67UDYuyBTqA23MML9q1+ilIZwBC2AQ2UBVOrFXfFl75p6/B5KsiNG9zpgmLCUYuLkxpLQIDAQAB';
    const APPID = '2016091100484352';
    const NEW_ALIPUBKE = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA1cCuz/gCGmvRIJss60u/AZym1zf1qubP2QRHC8EVeQ57uFYItbXkmKjT4dPriuJwWP0wJWul+ZF8vT3aYFpcs7VTq8rT/K0iEveW4jBRGWG/oTRzKVuX9cxZI5Go5v2XiujbqeMtGa8xVm0+frqBXi4tSKSBF5+0+dh2l5qeXxX2zmmz8qPvnejVwuIazKquSCftHuTRH+W7hixJkLvMJ++NErw6zgoM+9zgxmh8TGltjS6Iob/XHGmwj+hX4XgIpPEabjT2cnPSIJv0GWFdOCmIkoySWuHkWpoNJiX6/4JnhOCUhr/uWJWslveicr/JpdTx+oXUOvRJbBhd9TLlGwIDAQAB';
    const NEW_PAYGATEWAY = 'https://openapi.alipaydev.com/gateway.do';

    public function getStr($arr,$type = 'RSA'){
        //筛选  
        if(isset($arr['sign'])){
            unset($arr['sign']);
        }
        if(isset($arr['sign_type']) && $type == 'RSA'){
            unset($arr['sign_type']);
        }
        //排序  
        ksort($arr);
        //拼接
       return  $this->getUrl($arr,false);
    }
    //将数组转换为url格式的字符串
    public function getUrl($arr,$encode = true){
       if($encode){
            return http_build_query($arr);
       }else{
            return urldecode(http_build_query($arr));
       }
    }
    //获取签名MD5
    public function getSign($arr){
       return  md5($this->getStr($arr) . self::KEY );
    }
    //获取含有签名的数组MD5
    public function setSign($arr){
        $arr['sign'] = $this->getSign($arr);
        return $arr;
    }
    //获取签名RSA
    public function getRsaSign($arr){
       return $this->rsaSign($this->getStr($arr), self::APPPRIKEY) ;
    }
    //获取含有签名的数组RSA
    public function setRsaSign($arr){
        $arr['sign'] = $this->getRsaSign($arr);
        return $arr;
    }
    //获取签名RSA2
    public function getRsa2Sign($arr){
       return $this->rsaSign($this->getStr($arr,'RSA2'), self::APPPRIKEY,'RSA2') ;
    }
    //获取含有签名的数组RSA
    public function setRsa2Sign($arr){
        $arr['sign'] = $this->getRsa2Sign($arr);
        return $arr;
    }
    //记录日志
    public function logs($filename,$data){
        file_put_contents('./logs/' . $filename, $data . "\r\n",FILE_APPEND);
    }
    //2.验证签名
    public function checkSign($arr){
        $sign = $this->getSign($arr);
        if($sign == $arr['sign']){
            return true;
        }else{
            return false;
        }
    }
     
    //验证是否来之支付宝的通知
    public function isAlipay($arr){
        $str = file_get_contents(self::CHECKURL . $arr['notify_id']);
        if($str == 'true'){
            return true;
        }else{
            return false;
        }
    }
    // 4.验证交易状态
    public function checkOrderStatus($arr){
        if($arr['trade_status'] == 'TRADE_SUCCESS' || $arr['trade_status'] == 'TRADE_FINISHED'){
            return true;
        } else {
            return false;
        }
    }
}