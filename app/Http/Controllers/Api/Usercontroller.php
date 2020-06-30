<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Model\TokenModel;
use Illuminate\Support\Facades\Redis;

class Usercontroller extends Controller
{

    //注册接口
    public function regad(){

        $model=new UserModel();
        $name=request()->input('name');
        $email=request()->input('email');
        $pwd=request()->input('pwd');
        $names=$model->where('user_name',$name)->first();
        if($names){
            return[
                'code'=>000003,
                'message'=>'名称已存在'
            ];
        }

        $emails=$model->where('email',$email)->first();
        if($emails){
            return[
                'code'=>000004,
                'message'=>'邮箱已存在'
            ];
        }

        if(strlen($pwd)<6){
            return[
                'code'=>000005,
                'message'=>'密码不能小于6位'
            ];
        }
        $pwd2= password_hash($pwd,PASSWORD_BCRYPT);
        $time=time();
        $model->user_name=$name;
        $model->email=$email;
        $model->password=$pwd2;
        $model->reg_time=$time;
        $add=$model->save();
        if($add){
            return[
                'code'=>00000,
                'message'=>'注册成功'
            ];
        }else{
            return[
                'code'=>00001,
                'message'=>'注册失败'
            ];
        }
    }

    //登录接口
    public function loginadd(){
        $name=request()->input('user_name');
        $pwd=request()->input('pwd');
        $usermodel=new UserModel();
        $where=[
            'user_name'=>$name,
        ];
        $info= $usermodel->where($where)->first();
        $res=password_verify($pwd,$info->password);
        if($res){
           // 生成token
           $str=$info->user_id.$info->user_name.time();
            $token=substr(md5($str),10,16).substr(md5($str),1,15);
            //保存token
//            $data=[
//                'uid'=>$info->user_id,
//                'token'=>$token
//            ];
//            TokenModel::insert($data);
            Redis::set($token,$info->user_id);
            Redis::expire($token,7200);
            return[
                'code'=>00000,
                'message'=>'登录成功',
                'token'=>$token
            ];
        }else{

            return[
                'code'=>00001,
                'message'=>'登录失败'
            ];
        }
    }

    public function center(){
        $token=$_GET['token'];
       // $res=TokenModel::where(['token'=>$token])->first();
        $res=Redis::get($token);
        if($res){
           // $uid=$res->uid;
            $user_info=UserModel::find($res);
            echo $user_info->user_name."欢迎来到个人中心";
        }else{
            echo '请登录.......';
        }
    }
}
