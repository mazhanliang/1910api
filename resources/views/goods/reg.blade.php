<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token()}}">
</head>
<body>
<form action="">
        <table>
            <tr>
                <td>用户名</td>
                <td><input type="text" name="user_name" id="user_name"><br></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="email" name="email" id="email"><br></td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input type="password" name="pwd" id="pwd"><br></td>
            </tr>
            <tr>
                <td>确认密码</td>
                <td><input type="password" name="pwdad" id="pwdad"><br></td>
            </tr>
            <tr>
                <td><input type="button" value="注册" id="but" ></td>
            </tr>
        </table>
</form>
</body>
</html>
<script src="/js/jquery.min.js"></script>
<script>
    $.ajaxSetup({headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}});
    $(document).on('click','#but',function(){
         var name=$('#user_name').val();
         var email=$('#email').val();
         var pwd=$('#pwd').val();
         var pwdad=$('#pwdad').val();

        if(pwd!=pwdad){
            alert('两次密码输入的不一致');
        }

        $.ajax({
            url:'{{url('user/regad')}}',
            data:{"name":name,"email":email,'pwd':pwd},
            type:'post',
            dataType:'json',
            success:function(res){
                if(res.code==00000){
                    alert(res.message);
                    location.href="{{url('user/login')}}"
                }else{
                    alert(res.message);
                }
            }
        })
    })
</script>