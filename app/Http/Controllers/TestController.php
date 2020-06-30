<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function hello(){
        $a=time();
        echo $a;
    }
    public function redis(){
       $key='name1';
        $val=Redis::get($key);
        echo '$val:'.$val;
    }
}
