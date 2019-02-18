<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">

    <title>登录</title>

    <link href="{{ asset('static/admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/style-responsive.css') }}" rel="stylesheet">
    <script src="{{ asset('static/admin/js/html5shiv.js') }}"></script>
    <script src="{{ asset('static/admin/js/respond.min.js') }}"></script>
</head>

<body class="login-body">

<div class="container">

    <form class="form-signin" id="loginForm">
        <div class="form-signin-heading text-center">
            <h1 class="sign-title">登录</h1>
            <img src="{{ asset('static/admin/images/login-logo.png') }}" alt=""/>
        </div>
        <div class="login-wrap">
            <input type="text" class="form-control" name="user" placeholder="用户名" autofocus>
            <input type="password" class="form-control" name="password" placeholder="密码">

            <button class="btn btn-lg btn-login btn-block" type="button" style="font-size: 16px;">
                <i class="fa fa-check"></i>登录
            </button>

        </div>

    </form>

</div>


<script src="{{ asset('static/admin/js/jquery-1.10.2.min.js') }}"></script>
<script src="{{ asset('static/admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('static/admin/js/modernizr.min.js') }}"></script>
<script src="{{ asset('/static/admin/js/layer.js') }}"></script>
<script>
    $(function(){
        function checkForm(){
            var user = $('input[name=user]').val();
            var password = $('input[name=password]').val();
            if(!user){
                layer.msg('请输入用户名',{icon:0,time:1500});
                return false;
            }
            if(!password){
                layer.msg('请输入密码',{icon:0,time:1500});
                return false;
            }
            return true;
        }
        $('.btn-login').click(function(){
            var data = $('#loginForm').serialize();
            if(checkForm()){
                $.ajax({
                    type:'POST',
                    dataType:'json',
                    url:'{{ route('admin.login.login') }}',
                    data:data,
                    async: true,
                    success(data){
                        if(data.status){
                            location.href = "{{ route('admin.index.index') }}";
                        }else{
                            layer.open({
                                title: '提示',
                                icon: 2,
                                content: data.msg
                            });
                        }
                    }
                })
            }
        })
    })
</script>
</body>
</html>
