<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Model\TokenModel;
use Illuminate\Support\Facades\Redis;

class SignController extends Controller
{


    public function sign1(){
        $key='1910';
        $data=$_GET['data'];
        $sign=$_GET['sign'];
        $sign1=sha1($data.$key);
        if($sign==$sign1){
            echo '通过';
        }else{
            echo 'no';
        }
    }

    public function signadd(){
        $key='1910';
        $url='http://www.1910.com/api/signadd';
        $data=[
            'user_name'=>'mss',
            'user_age'=>5655
        ];
        $sign=sha1(json_encode($data).$key).json_encode($data);
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$sign);
        //curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_exec($ch);
        $errno=curl_errno($ch);
        $errmsg=curl_error($ch);
        if($errno){
            echo '错误码：'.$errno;echo '</br>';
            var_dump($errmsg);
            die;
        }
        curl_close($ch);


    }

    //加密
    public function encrypt(){
       $enc_data=$_POST['data'];
        $sign=$_POST['sign'];

        $method='AES-256-CBC';
        $key='1910api';
        $iv='hellwohellwosjsj';
        $sign2=sha1($enc_data,$key);
        if($sign==$sign2){
            echo '验签成功';echo '</br>';
        }else{
            echo '验签失败';die;
        }
        $dec_data=openssl_decrypt($enc_data,$method,$key,OPENSSL_RAW_DATA,$iv);
        echo $dec_data;
    }

    //非对称解密
    public function rsaDecrypt(){
        $data=$_POST['data'];
        $key_content=file_get_contents(storage_path('keys/priv.key'));
        $priv_key=openssl_get_privatekey($key_content);
        openssl_private_decrypt($data,$dec_data,$priv_key);
        var_dump($dec_data);
    }
}