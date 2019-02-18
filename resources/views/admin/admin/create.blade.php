@extends('admin.public.app')

@section('css')
@endsection

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    新增管理员
                </header>
                <div class="panel-body">
                    <div class=" form">
                        <form class="cmxform form-horizontal adminex-form" id="commentForm" method="get" action="">
                            <div class="form-group">
                                <label class="control-label col-lg-1">用户名:</label>
                                <div class="col-lg-4">
                                    <input class=" form-control" name="name" type="text" placeholder="请输入用户名" />
                                    <p class="help-block">4到16位（字母，数字，下划线，减号）</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">登录密码:</label>
                                <div class="col-lg-2">
                                    <input class=" form-control" name="password" type="password" placeholder="请输入密码" />
                                </div>
                                <div class="col-lg-2">
                                    <input class=" form-control" name="pwd" type="password" placeholder=" 请再次输入密码" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">身份名称:</label>
                                <div class="col-lg-4">
                                    <input class=" form-control" name="realname" type="text" placeholder="请输入身份名称" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">是否启用:</label>
                                <div class="col-lg-4 ">
                                    <div class="slide-toggle">
                                        <div>
                                            <input type="checkbox" name="status" value="1" class="js-switch" checked/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">邮箱:</label>
                                <div class="col-lg-4">
                                    <input class="form-control" name="email" type="text" placeholder="请输入电子邮箱" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">手机号码:</label>
                                <div class="col-lg-4">
                                    <input class=" form-control" name="phone" type="number" placeholder="请输入手机号码" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-1">角色分配:</label>
                                <div class="col-sm-10 icheck ch1">
                                    @foreach($role as $item)
                                        <div class="minimal-green checkd">
                                            <div class="checkbox">
                                                <input name="role[]" id="check-{{ $item->id }}" type="checkbox" value="{{ $item->id }}">
                                                <label for="check-{{ $item->id }}">{{ $item->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
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
                        url:'{{ route('admin.admin.create') }}',
                        data:data,
                        async: true,
                        success(data){
                            layer.close(index);
                            if(data.status){
                                location.href = "{{ route('admin.admin.index') }}";
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
                var name = $('input[name=name]').val();
                var password = $('input[name=password]').val();
                var pwd = $('input[name=pwd]').val();
                var realname = $('input[name=realname]').val();
                var phone = $('input[name=phone]').val();
                var email = $('input[name=email]').val();

                var uPattern = /^[a-zA-Z0-9_-]{4,16}$/;
                if(!name || !uPattern.test(name)){
                    layer.msg('请输入正确的用户名',{icon:0,time:1500});
                    return false;
                }

                if(!pwd || !password){
                    layer.msg('请输入密码',{icon:0,time:1500});
                    return false;
                }
                if(pwd != password){
                    layer.msg('两次密码不一致',{icon:0,time:1500});
                    return false;
                }
                if(pwd.length < 6 || pwd.length > 16){
                    layer.msg('密码长度必须为6-16位',{icon:0,time:1500});
                    return false;
                }
                if(!realname){
                    layer.msg('请输入用户身份',{icon:0,time:1500});
                    return false;
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