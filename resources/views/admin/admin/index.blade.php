@extends('admin.public.app')

@section('css')
@endsection

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    筛选
                </header>
                <div class="panel-body">
                    <form class="form-inline" role="form">
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputEmail2">用户名</label>
                            <input type="text" class="form-control" name="user" id="exampleInputEmail2" placeholder="请输入用户名" value="{{ $param['user'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputPassword2">邮箱</label>
                            <input type="text" class="form-control"  name="email" id="exampleInputPassword2" placeholder="请输入邮箱" value="{{ $param['email'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputPassword2">电话</label>
                            <input type="text" class="form-control"  name="phone" id="exampleInputPassword2" placeholder="请输入电话" value="{{ $param['phone'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="exampleInputPassword2">身份名称</label>
                            <input type="text" class="form-control"  name="realname" id="exampleInputPassword2" placeholder="请输入身份名称" value="{{ $param['realname'] ?? '' }}">
                        </div>
                        <button type="submit" class="btn btn-primary">确定</button>
                    </form>

                </div>
            </section>

        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="clearfix">
                        <div class="btn-group">
                            @if(in_array('admin.admin.create',$jur))
                                <a href="{{ route('admin.admin.create') }}">
                                    <button id="editable-sample_new" class="btn btn-info">
                                        新增管理员 <i class="fa fa-plus"></i>
                                    </button>
                                </a>
                            @endif
                        </div>
                    </div>
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">
                        <div class="space15"></div>
                        <table class="table table-striped table-hover table-bordered" id="editable-sample">
                            <thead>
                            <tr>
                                <th>用户ID</th>
                                <th>用户名</th>
                                <th>用户身份</th>
                                <th>手机号</th>
                                <th>邮箱</th>
                                <th>状态</th>
                                <th>最后登录时间</th>
                                <th>最后登录IP</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user as $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->user }}</td>
                                    <td>{{ $value->realname }}</td>
                                    <td>{{ $value->phone }}</td>
                                    <td>{{ $value->email }}</td>
                                    <td>
                                        <div class="slide-toggle">
                                            @if(in_array('admin.admin.setStatus',$jur))
                                                <div data-id="{{ $value->id }}" data-status="{{ $value->status }}">
                                                    <input type="checkbox" name="status" value="1" class="js-switch" {{ $value->status ? 'checked' : '' }}/>
                                                </div>
                                            @else
                                                <div>
                                                    <input type="checkbox" name="status" value="1" class="js-switch" {{ $value->status ? 'checked' : '' }}/>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $value->last_login_time ? date('Y-m-d H:i:s',$value->last_login_time) : '/' }}</td>
                                    <td>{{ $value->last_login_ip ?: '/' }}</td>
                                    <td>
                                        @if(in_array('admin.admin.update',$jur))
                                            <a href="{{ route('admin.admin.update',['u'=>$value->id]) }}">
                                                <button class="btn btn-info btn-xs" type="button"><i class="fa fa-pencil">&nbsp;</i>编辑</button>
                                            </a>
                                        @endif
                                        @if(in_array('admin.admin.delete',$jur))
                                            <button class="btn btn-danger btn-xs delBtn" type="button" data-id="{{ $value->id }}"><i class="fa fa-trash-o">&nbsp;</i>删除</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: right">
                            {{ $user->links() }}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection


@section('js')
    <script>
        $(function(){
            //点击状态
            $('.panel-body').on('click','.switchery',function(){
                var that = $(this);
                var id = that.parent().attr('data-id');
                var status = that.parent().attr('data-status');
                if(!id && !status){
                    return layer.msg('无权限操作此项',{icon:0,time:1500});
                }

                if(status == 1){
                    status = 0;
                    msg = '帐号禁用后将无法操作系统任何项';
                }else{
                    status = 1;
                    msg = '帐号启用后将恢复帐号操作权限';
                }
                layer.open({
                    content: msg + '，是否继续？',
                    icon:0,
                    yes: function(index, layero){
                        layer.close(index);
                        $.ajax({
                            type:'GET',
                            dataType:'json',
                            url:'{{ route('admin.admin.setStatus') }}',
                            data:{
                                user:id,
                                status:status
                            },
                            async: true,
                            success(data){
                                if(!data.status){
                                    if(status == 0){
                                        that.prev().attr("checked",true);
                                    }else{
                                        that.prev().removeAttr("checked");
                                    }
                                    switcheryRender(false);
                                    layer.open({
                                        title: '提示',
                                        icon: 2,
                                        content: data.msg
                                    });
                                }else{
                                    layer.msg(data.msg,{icon:1,time:1500});
                                    that.parent().attr('data-status',status);
                                }
                            }
                        })
                    },
                    cancel:function(){
                        if(status == 0){
                            that.prev().attr("checked",true);
                        }else{
                            that.prev().removeAttr("checked");
                        }
                        switcheryRender(false);
                    }
                });
            });

            @if(!in_array('admin.admin.setStatus',$jur))
                switcheryRender(true);
            @endif

            //重新加载选项框  disabled是否禁止点击
            function switcheryRender(disabled){
                var elem = document.querySelectorAll('.switchery');
                for (var i = 0; i < elem.length; i++) {
                    elem[i].remove();
                }

                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                elems.forEach(function(html) {
                    if(disabled){
                        var switchery = new Switchery(html,{disabled: true});
                    }else{
                        var switchery = new Switchery(html);
                    }
                });
            }
            //点击删除
            $('.delBtn').click(function(){
                var that = $(this);
                var id = $(this).attr('data-id');
                layer.open({
                    content: '删除后不可恢复,是否继续?',
                    icon:0,
                    yes: function(index, layero){
                        layer.close(index);
                        $.ajax({
                            type:'GET',
                            dataType:'json',
                            url:'{{ route('admin.admin.delete') }}',
                            data:{
                                user:id
                            },
                            async: true,
                            success(data){
                                layer.close(index);
                                if(data.status){
                                    layer.msg(data.msg,{icon:1,time:1500});
                                    that.parent().parent().remove();
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
            })
        })
    </script>
@endsection