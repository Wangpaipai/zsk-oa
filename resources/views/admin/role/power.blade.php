@extends('admin.public.app')

@section('css')
    <style>
        .allCheck , .allCheckd{
            display: inline-block;
            margin-left: 12px;
        }
        .allCheck .checkbox{
            margin: 0 !important;
        }
    </style>
@endsection

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    配置权限
                </header>
                <div class="panel-body">
                    <div class=" form">
                        <form class="cmxform form-horizontal adminex-form" id="commentForm">
                            <input type="hidden" placeholder="" name="role_id" value="{{ $param['r'] }}">

                            <div class="form-group">
                                <label class="col-sm-1 control-label"></label>
                                <div class="allCheckd icheck">
                                    <div class="minimal-green single-row">
                                        <div class="checkbox ">
                                            <input id="check" type="checkbox">
                                            <label for="check">全选 </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @foreach($node as $value)
                                <div class="form-group">
                                    <label class="col-sm-1 control-label">{{ $value->name }}:</label>
                                    <div class="allCheck icheck">
                                        <div class="minimal-green single-row">
                                            <div class="checkbox ">
                                                <input id="check-{{ $value->id }}" type="checkbox">
                                                <label for="check-{{ $value->id }}">全选 </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 icheck ch1">
                                        <label class="col-sm-1 control-label"></label>
                                        @foreach($value->child as $item)
                                            <div class="minimal-green checkd">
                                                <div class="checkbox">
                                                    <input name="node_id[]" id="check-{{ $value->id }}-{{ $item->id }}" type="checkbox" value="{{ $item->id }}" {{ in_array($item->id,$role_node) ? 'checked' : '' }}>
                                                    <label for="check-{{ $value->id }}-{{ $item->id }}">{{ $item->name }}</label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
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
            $('.allCheck').on('ifChanged',function(){
                var is_checked = $(this).find('input').is(':checked');
                if(is_checked){
                    $(this).next().iCheck('check');
                    $(this).next().iCheck('enable');
                }else{
                    $(this).next().iCheck('uncheck');
                    $(this).next().iCheck('enable');
                }
            });
            $('.allCheckd').on('ifChanged',function(){
                var is_checked = $(this).find('input').is(':checked');
                if(is_checked){
                    $('.ch1').iCheck('check');
                    $('.allCheck').iCheck('check');
                }else{
                    $('.ch1').iCheck('uncheck');
                    $('.allCheck').iCheck('uncheck');
                }
            });
            $('.btn').click(function(){
                if(checkForm()){
                    var data = $("#commentForm").serialize();
                    var index = layer.load(4,{time:10000});
                    $.ajax({
                        type:'POST',
                        dataType:'json',
                        url:'{{ route('admin.role.power') }}',
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
                return true;
            }
        })
    </script>
@endsection