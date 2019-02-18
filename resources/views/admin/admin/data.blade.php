@extends('admin.public.app')

@section('css')
@endsection

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    修改个人资料
                </header>
                <div class="panel-body">
                    <div class=" form">
                        <form class="cmxform form-horizontal adminex-form" id="commentForm" method="get" action="">
                            <div class="form-group">
                                <label class="control-label col-lg-1">用户名:</label>
                                <div class="col-lg-4">
                                    <input class=" form-control" name="name" disabled type="text" placeholder="请输入用户名" value="{{ $admin_user->user }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">原密码:</label>
                                <div class="col-lg-4">
                                    <input class=" form-control" name="pwd" type="password" placeholder="请输入原密码" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">重复密码:</label>
                                <div class="col-lg-2">
                                    <input class=" form-control" name="password" type="password" placeholder="请输入新密码" />
                                </div>
                                <div class="col-lg-2">
                                    <input class=" form-control" name="pwd_copy" type="password" placeholder=" 请再次输入新密码" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">邮箱:</label>
                                <div class="col-lg-4">
                                    <input class="form-control" name="email" type="text" placeholder="请输入电子邮箱"  value="{{ $admin_user->email }}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">手机号码:</label>
                                <div class="col-lg-4">
                                    <input class=" form-control" name="phone" type="number" placeholder="请输入手机号码" value="{{ $admin_user->phone }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-1 col-lg-10">
                                    <button class="btn btn-success" type="button">提交</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    </div>
</div>
@endsection


@section('js')
    <script>
        $(function (){
            $('.btn').click(function(){
                if(checkForm()){
                    var data = $("#commentForm").serialize();
                    var index = layer.load(4,{time:10000});
                    $.ajax({
                        type:'POST',
                        dataType:'json',
                        url:'{{ route('admin.data.update') }}',
                        data:data,
                        async: true,
                        success(data){
                            layer.close(index);
                            if(data.status){
                                layer.msg(data.msg,{icon:1,time:1500});
                                setTimeout(function(){
                                    location.reload();
                                },1500)
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
            });
            function checkForm(){
                var password = $('input[name=password]').val();
                var pwd = $('input[name=pwd]').val();
                var pwd_copy = $('input[name=pwd_copy]').val();
                var realname = $('input[name=realname]').val();
                var phone = $('input[name=phone]').val();
                var email = $('input[name=email]').val();

                console.log(pwd_copy);
                console.log(password);
                if(pwd_copy || password){
                    if(!pwd){
                        layer.msg('请输入原密码',{icon:0,time:1500});
                        return false;
                    }
                    if(pwd_copy != password){
                        layer.msg('两次密码不一致',{icon:0,time:1500});
                        return false;
                    }
                    if(pwd_copy.length < 6 || pwd.length > 16){
                        layer.msg('密码长度必须为6-16位',{icon:0,time:1500});
                        return false;
                    }
                }
                var mPattern = /^1[3|4|5|7|8|9]\d{9}$/;
                if(phone && !mPattern.test(phone)){
                    layer.msg('请输入正确的手机号码',{icon:0,time:1500});
                    return false;
                }
                var ePattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                if(email && !ePattern.test(email)){
                    layer.msg('请输入正确的邮箱',{icon:0,time:1500});
                    return false;
                }
                return true;
            }
        })
    </script>
@endsection