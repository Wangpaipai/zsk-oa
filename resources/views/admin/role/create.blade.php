@extends('admin.public.app')

@section('css')
@endsection

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    新增角色
                </header>
                <div class="panel-body">
                    <div class=" form">
                        <form class="cmxform form-horizontal adminex-form" id="commentForm">
                            <div class="form-group">
                                <label class="control-label col-lg-1">角色名:</label>
                                <div class="col-lg-4">
                                    <input type="hidden" placeholder="" name="_token" value="{{ csrf_token() }}">
                                    <input class=" form-control" name="name" autocomplete="off" type="text" placeholder="请输入角色名" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">启用状态:</label>
                                <div class="col-lg-4 ">
                                    <div class="slide-toggle">
                                        <div>
                                            <input type="checkbox" name="status" value="1" class="js-switch" checked/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">备注:</label>
                                <div class="col-lg-4">
                                    <input class=" form-control" name="remark" type="text" placeholder="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">排序:</label>
                                <div class="col-lg-4">
                                    <input class=" form-control" name="sort" type="number" placeholder="请输入排序数值" value="10" />
                                    <p class="help-block">升序排列</p>
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
                        url:'{{ route('admin.role.create') }}',
                        data:data,
                        async: true,
                        success(data){
                            layer.close(index);
                            if(data.status){
                                location.href = "{{ route('admin.role.index') }}";
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

                if(!name){
                    layer.msg('请输入角色名称',{icon:0,time:1500});
                    return false;
                }
                return true;
            }
        })
    </script>
@endsection