<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
</head>
<body>
    欢迎 {{$_COOKIE['name']}} 登录
 <table border="1">
     <tr>
         <th>用户名</th>
         <th>Email</th>
         <th>注册时间</th>
         <th>最后一次登录时间</th>
     </tr>
     @foreach($data as $k=>$v)
        <tr>
            <td>{{$v->user_name}}</td>
            <td>{{$v->email}}</td>
            <td>{{$v->reg_time}}</td>
            <td>{{$v->last_login}}</td>
        </tr>
         @endforeach
 </table>
</body>
</html>
