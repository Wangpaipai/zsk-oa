@extends('admin.public.app')

@section('css')
@endsection

@section('content')
<div class="wrapper">

    <div class="row">
        <div class="col-sm-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="clearfix">
                        @if(in_array('admin.role.create',$jur))
                            <div class="btn-group">
                                <a href="{{ route('admin.role.create') }}">
                                    <button class="btn btn-info">
                                        新增角色 <i class="fa fa-plus"></i>
                                    </button>
                                </a>
                            </div>
                        @endif
                        @if(in_array('admin.role.setSort',$jur))
                            <div class="btn-group">
                                <button id="setSort" class="btn btn-primary" style="margin-right: 20px">
                                    更新排序 <i class="fa fa-refresh"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                </header>
                <div class="panel-body">
                    <div class="adv-table editable-table ">
                        <div class="space15"></div>
                        <table class="table table-striped table-hover table-bordered" id="editable-sample">
                            <thead>
                            <tr>
                                <th>角色ID</th>
                                <th>角色名</th>
                                <th>排序</th>
                                <th>启用状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($role as $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td style="width: 20%">
                                        @if(in_array('admin.role.setSort',$jur))
                                            <div class="col-lg-6">
                                                <input class=" form-control sort" type="text" placeholder="" value="{{ $value->sort }}" />
                                                <input class=" form-control id" type="hidden" placeholder="" value="{{ $value->id }}" />
                                            </div>
                                        @else
                                            {{ $value->sort }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array('admin.role.setStatus',$jur))
                                            <div class="slide-toggle">
                                                <div data-id="{{ $value->id }}" data-status="{{ $value->status }}">
                                                    <input type="checkbox" name="status" value="1" class="js-switch" {{ $value->status ? 'checked' : '' }}/>
                                                </div>
                                            </div>
                                        @else
                                            <div class="slide-toggle">
                                                <div>
                                                    <input type="checkbox" name="status" value="1" class="js-switch" {{ $value->status ? 'checked' : '' }}/>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if(in_array('admin.role.update',$jur))
                                            <a href="{{ route('admin.role.update',['r'=>$value->id]) }}">
                                                <button class="btn btn-info btn-xs" type="button"><i class="fa fa-pencil">&nbsp;</i>编辑</button>
                                            </a>
                                        @endif
                                        @if(in_array('admin.role.power',$jur))
                                            <a href="{{ route('admin.role.power',['r'=>$value->id]) }}">
                                                <button class="btn btn-success btn-xs" type="button"><i class="fa fa-lock">&nbsp;</i>权限</button>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: right">
                            {{ $role->links() }}
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
                    msg = '角色禁用后，拥有该角色的管理员将无法操作此角色下所对应的权限,';
                }else{
                    status = 1;
                    msg = '角色启用后，拥有该角色的管理员将恢复此角色下所对应的权限,';
                }
                layer.open({
                    content: msg + '，是否继续？',
                    icon:0,
                    yes: function(index, layero){
                        layer.close(index);
                        $.ajax({
                            type:'GET',
                            dataType:'json',
                            url:'{{ route('admin.role.setStatus') }}',
                            data:{
                                m:id,
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
                                    layer.msg(data.msg,{icon:1,time:1000});
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
            @if(!in_array('admin.role.setStatus',$jur))
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

            //点击排序
            $('#setSort').click(function(){
                var request = [];
                var sort = $('.sort');
                var id = $('.id');
                for(let i = 0; i < sort.length; i++){
                    let arr = {};
                    arr.sort = sort.eq(i).val();
                    arr.id = id.eq(i).val();
                    request.push(arr);
                }
                var index = layer.load(4,{time:10000});
                $.ajax({
                    type:'POST',
                    dataType:'json',
                    url:'{{ route('admin.role.setSort') }}',
                    data:{
                        _token:'{{ csrf_token() }}',
                        data:request
                    },
                    async: true,
                    success(data){
                        layer.close(index);
                        if(data.status){
                            layer.msg(data.msg,{icon:1,time:1500});
                            setTimeout(function(){
                                location.reload();
                            },1000)
                        }else{
                            layer.open({
                                title: '提示',
                                icon: 2,
                                content: data.msg
                            });
                        }
                    }
                })
            })
        })
    </script>
@endsection