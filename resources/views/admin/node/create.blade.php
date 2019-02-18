@extends('admin.public.app')

@section('css')
@endsection

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    新增节点
                </header>
                <div class="panel-body">
                    <div class=" form">
                        <form class="cmxform form-horizontal adminex-form" id="commentForm" method="get" action="">
                            <div class="form-group">
                                <label class="control-label col-lg-1">节点名:</label>
                                <div class="col-lg-4">
                                    <input type="hidden" placeholder="" name="_token" value="{{ csrf_token() }}">
                                    <input class=" form-control" name="name" type="text" placeholder="请输入节点名" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">路由名:</label>
                                <div class="col-lg-4">
                                    <input class=" form-control" name="route" type="text" placeholder="请输入路由名" />
                                    <p class="help-block">Laravel路由名称</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">备注:</label>
                                <div class="col-lg-4">
                                    <input class=" form-control" name="remark" type="text" placeholder="" />
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
                                <label class="control-label col-lg-1">排序:</label>
                                <div class="col-lg-4">
                                    <input class="form-control" name="sort" type="text" placeholder="请输入排序数值" value="10"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">节点等级:</label>
                                <div class="col-lg-4 icheck">
                                    <div class="minimal-green">
                                        <div class="radio level">
                                            <input tabindex="3" value="1" type="radio"  name="level">
                                            <label>一级</label>
                                        </div>
                                    </div>
                                    <div class="minimal-green">
                                        <div class="radio level">
                                            <input tabindex="3" value="2" type="radio"  name="level" checked>
                                            <label>二级</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group p_level show">
                                <label class="control-label col-lg-1">所属节点:</label>
                                <div class="col-lg-4">
                                    <select name="pid" class="form-control m-bot15">
                                        @foreach($node_menu as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">是否菜单:</label>
                                <div class="col-lg-4 icheck">
                                    <div class="minimal-green">
                                        <div class="radio is_menu">
                                            <input tabindex="3" value="1" type="radio"  name="is_menu">
                                            <label>是</label>
                                        </div>
                                    </div>
                                    <div class="minimal-green">
                                        <div class="radio is_menu">
                                            <input tabindex="3" value="0" type="radio"  name="is_menu" checked>
                                            <label>否</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group menu-select hide">
                                <label class="control-label col-lg-1">所属菜单:</label>
                                <div class="col-lg-4">
                                    <select name="menu_id" class="form-control m-bot15">
                                        @foreach($menu as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
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
            $('.is_menu .iCheck-helper').click(function(){
                event.stopPropagation();
                var is_menu = $('input[name=is_menu]:checked').val();
                if(is_menu == 0){
                    $('.menu-select').removeClass('show').addClass('hide');
                }else{
                    $('.menu-select').removeClass('hide').addClass('show');
                }
            });

            $('.level .iCheck-helper').click(function(){
                event.stopPropagation();
                var level = $('input[name=level]:checked').val();
                if(level == 1){
                    $('.p_level').removeClass('show').addClass('hide');
                }else{
                    $('.p_level').removeClass('hide').addClass('show');
                }
            });

            $('.btn').click(function(){
                if(checkForm()){
                    var data = $("#commentForm").serialize();
                    var index = layer.load(4,{time:10000});
                    $.ajax({
                        type:'POST',
                        dataType:'json',
                        url:'{{ route('admin.node.create') }}',
                        data:data,
                        async: true,
                        success(data){
                            layer.close(index);
                            if(data.status){
                                location.href = "{{ route('admin.node.index') }}";
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
                var route = $('input[name=route]').val();
                if(!name){
                    layer.msg('请输入节点名',{icon:0,time:1500});
                    return false;
                }
                if(!route){
                    layer.msg('请输入路由',{icon:0,time:1500});
                    return false;
                }
                return true;
            }
        })
    </script>
@endsection