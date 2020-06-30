<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use App\Model\GoodsModel;
use App\Model\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class GoodsController extends Controller
{
    //前台注册
        public function reg(){
            return view('goods.reg');
        }

    //后台注册
        public function regad(){
            $model=new UserModel();
            $name=request()->post('name');
            $names=$model->where('user_name',$name)->first();
            if($names){
                return[
                    'code'=>000003,
                    'message'=>'名称已存在'
                ];
            }
            $email=request()->post('email');
            $emails=$model->where('email',$email)->first();
            if($emails){
                return[
                    'code'=>000003,
                    'message'=>'邮箱已存在'
                ];
            }
            $pwd=request()->input('pwd');

            if(strlen($pwd)<6){
                return[
                    'code'=>000003,
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

    //前台登录
        public function login(){
            return view('goods.login');
        }
        public function loginadd(){
           $name=request()->post('user_name');
            $pwd=request()->post('pwd');
            $usermodel=new UserModel();
            $where=[
                'user_name'=>$name,
            ];
           $info= $usermodel->where($where)->first();
            $res=password_verify($pwd,$info->password);
            if($res){
                setcookie('uid',$info->user_id,time()+3600,'/');
                setcookie('name',$info->user_name,time()+3600,'/');
                //Cookie::queue('uid',$info->user_id,10);
                header('Refresh:2;url=/user/conter');
                echo '登录成功';
            }else{
                header('Refresh:2;url=/user/login');
                echo '登录失败';
            }
        }

    //个人中心
    public function conter(){
        $usermodel=new UserModel();
        $aa=$usermodel->get();
        if(isset($_COOKIE['uid']) && isset($_COOKIE['name'])){
            return view('goods.conter',['data'=>$aa]);
        }else{
            return redirect('/user/login');
        }

    }
}
