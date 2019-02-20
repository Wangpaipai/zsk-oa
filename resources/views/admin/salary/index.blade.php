@extends('admin.public.app')

@section('css')
    <style>
        .target:hover{
            cursor:pointer;
        }
    </style>
@endsection

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading custom-tab dark-tab">
                    <ul class="nav nav-tabs">
                        @foreach($letter as $value)
                            <li class="{{ $param['type'] == $value['name'] ? 'active' : '' }}">
                                <a data-href="{{ route('admin.salary.index',['type' => $value['name']]) }}" class="target" data-toggle="tab">{{ $value['title'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </header>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane active">
                            <div class="row">
                                <div class="col-lg-12">
                                    <section class="panel">
                                        <header class="panel-heading">
                                            筛选
                                        </header>
                                        <div class="panel-body">
                                            <form class="form-inline" role="form">
                                                <input type="hidden" name="type" value="{{ $param['type'] }}">
                                                <div class="form-group">
                                                    <label class="sr-only" for="exampleInputEmail2">合同号</label>
                                                    <input type="text" class="form-control" name="contract_no" id="" placeholder="请输入合同编号" value="{{ $param['contract_no'] ?? '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="exampleInputEmail2">批次</label>
                                                    <input type="text" class="form-control" name="batch" id="" placeholder="请输入批次" value="{{ $param['batch'] ?? '' }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="sr-only" for="exampleInputPassword2">时间范围</label>
                                                    <input type="text" class="form-control"  name="start_time" autocomplete="off" id="start" placeholder="请输入起始时间" value="{{ $param['start_time'] ?? '' }}">
                                                    -
                                                    <input type="text" class="form-control"  name="end_time" autocomplete="off" id="end" placeholder="请输入终止时间" value="{{ $param['end_time'] ?? '' }}">
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
                                                    @if(in_array('admin.salary.excelDown',$jur))
                                                        <a href="{{ route('admin.salary.excelDown',$param) }}">
                                                            <button id="editable-sample_new" class="btn btn-success">
                                                                Excel下载 <i class="fa fa-cloud-download"></i>
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
                                                        <th>合同编号</th>
                                                        <th>月份</th>
                                                        <th>批号</th>
                                                        <th>金额</th>
                                                        <th>工序生产日期</th>
                                                        <th>操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($salary as $value)
                                                        <tr>
                                                            <td>{{ $value->contract_no }}</td>
                                                            <td>{{ date('n月',$value->receipt_time) }}</td>
                                                            <td>{{ $value->batch }}</td>
                                                            <td>{{ $value->money }}</td>
                                                            <td>
                                                                @if($value->produce_time)
                                                                    {{ date('Y-m-d',$value->produce_time) }}
                                                                @else
                                                                    @if(in_array('admin.salary.setData',$jur))
                                                                        <a href="javascript:;" class="label label-info setData" data-id="{{ $value->id }}" data-type="time" data-key="produce_time">设置</a>
                                                                    @else
                                                                        未
                                                                    @endif
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(in_array('admin.salary.createDetail',$jur))
                                                                    <a href="#myModal" data-toggle="modal" data-id="{{ $value->id }}" data-no="{{ $value->contract_no }}" class="btn btn-info btn-xs createDetail" style="color: #fff">
                                                                        <i class="fa fa-pencil">&nbsp;</i>价格
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <div style="text-align: right">
                                                    {{ $salary->appends($param)->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    @include('admin.salary.public.hide')
</div>
@endsection


@section('js')
    <script src="{{ asset('/static/admin/js/laydate/laydate.js') }}"></script>
    <script>
        $(function(){
            $('.createAccount').click(function(){
                var data = [];
                $('.account tr').each(function(){
                    var arr = {};
                    arr.number = $(this).find('.num').val();
                    arr.price = $(this).find('.price').val();
                    arr.total = $(this).find('.money').val();
                    if(arr.number && arr.price && arr.total){
                        data.push(arr);
                    }
                });
                var id = $('#salary_id').val();
                var index = layer.load(4,{time:10000});
                $.ajax({
                    type:'POST',
                    dataType:'json',
                    url:'{{ route('admin.salary.createDetail') }}',
                    data:{
                        id:id,
                        data:data
                    },
                    async: true,
                    success(data){
                        if(data.status){
                            layer.close(index);
                            layer.msg(data.msg,{icon:1,time:1000});
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

            $('.createDetail').click(function(){
                var no = $(this).attr('data-no');
                var id = $(this).attr('data-id');

                $('#contract_no').text(no);
                $('#salary_id').val(id);
                $('.account').html('');

                $.ajax({
                    type:'POST',
                    dataType:'json',
                    url:'{{ route('admin.salary.getAccount') }}',
                    data:{
                        id:id
                    },
                    async: true,
                    success(data){
                        var html = '';
                        if(data.status){
                            var datas = data.data;
                            for(var item in datas){
                                html += '<tr>'
                                        + '<td>'
                                        + '<input class=" form-control num change" type="number" placeholder="" value="'+datas[item]['number']+'" />'
                                        + '</td>'
                                        + '<td>'
                                        + '<input class=" form-control price change" type="number" placeholder="" value="'+datas[item]['price']+'" />'
                                        + '</td>'
                                        + '<td>'
                                        + '<input class=" form-control money" type="number" placeholder="" value="'+datas[item]['total']+'" />'
                                        + '</td>'
                                        + '<td>'
                                        + '<button class="btn btn-default btn-xs delAccount" type="button">×</button>'
                                        + '</td>'
                                        + '</tr>';
                            }
                        }else{
                            html = '<tr>'
                                    + '<td>'
                                    + '<input class=" form-control num change" type="number" placeholder="" value="" />'
                                    + '</td>'
                                    + '<td>'
                                    + '<input class=" form-control price change" type="number" placeholder="" value="" />'
                                    + '</td>'
                                    + '<td>'
                                    + '<input class=" form-control money" type="number" placeholder="" value="" />'
                                    + '</td>'
                                    + '<td>'
                                    + '<button class="btn btn-default btn-xs delAccount" type="button">×</button>'
                                    + '</td>'
                                    + '</tr>';
                        }
                        $('.account').html(html);
                    }
                })
            })

            $('.addAccount').click(function(){
                var html = '<tr>'
                        + '<td>'
                        + '<input class=" form-control num change" type="number" placeholder="" value="" />'
                        + '</td>'
                        + '<td>'
                        + '<input class=" form-control price change" type="number" placeholder="" value="" />'
                        + '</td>'
                        + '<td>'
                        + '<input class=" form-control money" type="number" placeholder="" value="" />'
                        + '</td>'
                        + '<td>'
                        + '<button class="btn btn-default btn-xs delAccount" type="button">×</button>'
                        + '</td>'
                        + '</tr>';
                $('.account').append(html);
            })

            $('.account').on('click','.delAccount',function(){
                $(this).parent().parent().remove();
            })

            $('.account').on('input propertychange','.change',function(){
                var parent = $(this).parent().parent();
                var num = parent.find('.num').val();
                var price = parent.find('.price').val();
                parent.find('.money').val(num * price);
            })

            laydate.render({
                elem: '#start'
            });
            laydate.render({
                elem: '#end'
            });

            $('.target').click(function(){
                var href = $(this).attr('data-href');
                location.href = href;
            })

            $('.setData').click(function(){
                var key = $(this).attr('data-key');
                var type = $(this).attr('data-type');
                var id = $(this).attr('data-id');

                var val = '';
                var time = getTime();
                switch(type){
                    case 'time':
                        val = time.y + '-' + time.m + '-' + time.d;
                        break;
                    case 'batch':
                        val = time.m + '-';
                        break;
                }

                var data = {};
                data.key = key;
                data.type = type;
                data.id = id;
                layer.prompt({
                    formType: 0,
                    value: val,
                    title: '请输入值'
                }, function(value, index, elem){
                    layer.close(index);
                    data.val = value;
                    $.ajax({
                        type:'POST',
                        dataType:'json',
                        url:'{{ route('admin.salary.setData') }}',
                        data:data,
                        async: true,
                        success(data){
                            layer.close(index);
                            if(data.status){
                                location.reload();
                            }else{
                                layer.open({
                                    title: '提示',
                                    icon: 2,
                                    content: data.msg
                                });
                            }
                        }
                    })
                });
            });
            function getTime(){
                var data = {};
                var myDate = new Date();
                data.y = myDate.getFullYear();
                data.m = myDate.getMonth() + 1;
                data.d = myDate.getDate();
                return data;
            }
        })
    </script>
@endsection