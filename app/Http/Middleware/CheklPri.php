<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CheklPri
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token=$request->input('token');
        $uid=Redis::get($token);
        if(!$uid){
            $response = [
                'error'=> 50000,
                'msg' => '鉴权失败'
            ];
            echo json_encode($response,JSON_UNESCAPED_UNICODE);
            die;
        }
        $request_uri=$_SERVER['REQUEST_URI'];
        $url_hash=substr(md5($request_uri),5,10);
        $key='fangshua_'.$url_hash;
        $total=Redis::get($key);
        if($total>=10){
            echo '请求过于频繁，请10秒后再试';
            Redis::expire($key,10);
            die;
        }else{
            $num=Redis::incr($key);
            echo  '当前访问次数为'.$num;
            Redis::expire($key,60);
        }
        return $next($request);
    }
}
