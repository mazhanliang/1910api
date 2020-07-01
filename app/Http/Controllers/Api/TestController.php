<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Model\TokenModel;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function sendA(){
        $data=$_GET['data'];
        $enc_data=base64_decode($data);
        $key=openssl_get_privatekey(file_get_contents(storage_path('keys/b_priv.key')));
        openssl_private_decrypt($enc_data,$dec_data,$key);
         //echo '解密的结果：'.$dec_data;

        $data2='宝塔镇河妖';
        $key2=openssl_get_publickey(file_get_contents(storage_path('keys/a_pub.key')));
        openssl_public_encrypt($data2,$enc_data2,$key2);
        $base64_data=base64_encode($enc_data2);
        $response=[
            'errno'=>0,
            'msg'=>'ok',
            'data'=>$base64_data
        ];
        return $response;
    }

    public function sign(){
        $data=base64_decode($_GET['data']);
        $name=$_GET['name'];
        $key=openssl_get_publickey(file_get_contents(storage_path('keys/a_pub.key')));
        $res=openssl_verify($name,$data,$key,OPENSSL_ALGO_SHA1);
        if($res){
            echo '验签通过';
        }else{
            echo '验签失败';
        }
    }
}