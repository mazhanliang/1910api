<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="{{url('/user/loginadd')}}" method="post">
        <table>
            <tr>
                <td>用户名</td>
                <td><input type="text" name="user_name" ><br></td>
            </tr>

            <tr>
                <td>密码</td>
                <td><input type="password" name="pwd" ><br></td>
            </tr>

            <tr>
                <td><input type="submit" value="登录" ></td>
            </tr>
        </table>
</form>
</body>
</html>
