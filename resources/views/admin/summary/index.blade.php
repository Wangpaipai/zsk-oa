@extends('admin.public.app')

@section('css')
    <style type='text/css'>
        table{empty-cells:show;border-collapse:collapse;border-spacing:0}
        table{font-size:10pt;border:1px green solid;background-color:white;}
        table td{height:20px;text-align:center;border:1px green solid;}
        table .tabTh{font-weight:bold;background-color:#f1faee;}
        #oTableLH_tab_Test,#oDivH_tab_Test{
            top: 0 !important;
            left: 0 !important;
        }
        #oDivL_tab_Test .tabTh{
            height: 38px !important;
        }
        #oDivL_tab_Test{
            top: -3px !important;
            left: 0 !important;
        }
        #oDivL_tab_Test>table{
            width: auto !important;
        }
        .label{
            color: #fff !important;
        }
    </style>
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
                                <label class="sr-only" for="exampleInputEmail2">合同号</label>
                                <input type="text" class="form-control" name="contract_no" id="" placeholder="请输入合同编号" value="{{ $param['contract_no'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputPassword2">经销商</label>
                                <input type="text" class="form-control"  name="dealer" id="" placeholder="请输入经销商姓名" value="{{ $param['dealer'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputPassword2">业务经理</label>
                                <input type="text" class="form-control"  name="manager" id="" placeholder="请输入业务经理姓名" value="{{ $param['manager'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="exampleInputPassword2">时间范围</label>
                                <input type="text" class="form-control"  name="start_time" id="start" placeholder="请输入起始时间" value="{{ $param['start_time'] ?? '' }}">
                                -
                                <input type="text" class="form-control"  name="end_time" id="end" placeholder="请输入终止时间" value="{{ $param['end_time'] ?? '' }}">
                            </div>
                            <button type="submit" class="btn btn-primary">确定</button>
                            @include('admin.summary.public.hide')
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
                                @if(in_array('admin.summary.create',$jur))
                                    <a href="{{ route('admin.summary.create') }}">
                                        <button id="editable-sample_new" class="btn btn-info">
                                            新增汇总表记录 <i class="fa fa-plus"></i>
                                        </button>
                                    </a>
                                @endif
                                @if(in_array('admin.summary.excelDown',$jur))
                                    <a href="{{ route('admin.summary.excelDown',$param) }}">
                                        <button id="editable-sample_new" class="btn btn-success">
                                            Excel下载 <i class="fa fa-cloud-download"></i>
                                        </button>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </header>

                    <div class="panel-body">
                        <div class="adv-table editable-table " style="position: relative;overflow: hidden;">
                            <div style="OVERFLOW: auto;width:100%;height:0;">
                                <table id="tab_Test" class="table table-striped table-hover table-bordered">
                                    <tr class='tabTh'>
                                        <td class="id">序号</td>
                                        <td class="contract_no">合同编号</td>
                                        <td class="receipt_time">接单日期</td>
                                        <td class="order_time">下单日期</td>
                                        <td class="batch">批次</td>
                                        <td class="order_inside_outside">内外单</td>
                                        <td class="manager">业务经理</td>
                                        <td class="dealer">经销商</td>
                                        <td class="payment">本厂计算货款</td>
                                        <td class="deposit">定金</td>
                                        <td class="fixed_deposit">固定定金</td>
                                        <td class="amount">全款</td>
                                        <td class="color">颜色</td>
                                        <td class="address">发货地址</td>
                                        <td class="stuff">材质</td>
                                        <td class="sample">样品套</td>
                                        <td class="single_sample">单开门套</td>
                                        <td class="fan_sample">单开门扇</td>
                                        <td class="double_slide">对开双滑套</td>
                                        <td class="offspring">子母门套</td>
                                        <td class="double_sleeve">双套套</td>
                                        <td class="single_sleeve">单套套</td>
                                        <td class="double_block">双套块</td>
                                        <td class="single_block">单套块</td>
                                        <td class="support">线条墙板踢脚支</td>
                                        <td class="discount">折扣</td>
                                        <td class="balance_payable">应收余款</td>
                                        <td class="balance_time">实收余款日期</td>
                                        <td class="balance">实收余款</td>
                                        <td class="deduction">大货样品扣款</td>
                                        <td class="difference">货款差额</td>
                                        <td class="pack_time">包装完成日期</td>
                                        <td class="door_number">包装件数-门</td>
                                        <td class="set_number">包装件数-套</td>
                                        <td class="door_total">包装件数-总数</td>
                                        <td class="depot">仓存位置</td>
                                        <td class="deliver_time">发货日期</td>
                                        <td class="logistics_company">物流公司</td>
                                        <td class="logistics_no">重庆运输合同号</td>
                                        <td class="remark">备注及质量反馈</td>
                                        <td class="">操作</td>
                                    </tr>
                                    @foreach($summary as $value)
                                        <tr>
                                            <td class="id">{{ $value->id }}</td>
                                            <td class="contract_no">{{ $value->contract_no }}</td>
                                            <td class="receipt_time">
                                                {{ $value->receipt_time ? date('m/d',$value->order_time) : '未' }}
                                            </td>
                                            <td class="order_time">
                                                @if($value->order_time)
                                                    {{ date('m/d',$value->order_time) }}
                                                @else
                                                    <a href="javascript:;" class="label label-info">设置</a>
                                                @endif
                                            </td>
                                            <td class="batch">
                                                @if($value->batch)
                                                    {{ $value->batch }}
                                                @else
                                                    <a href="javascript:;" class="label label-info">设置</a>
                                                @endif
                                            </td>
                                            <td class="order_inside_outside">{{ $value->order_inside_outside == 1 ? '内' : '外' }}</td>
                                            <td class="manager">{{ $value->manager }}</td>
                                            <td class="dealer">{{ $value->dealer }}</td>
                                            <td class="payment">{{ $value->payment }}</td>
                                            <td class="deposit"></td>
                                            <td class="fixed_deposit"></td>
                                            <td class="amount"></td>
                                            <td class="color">{{ $value->color }}</td>
                                            <td class="address">{{ $value->address }}</td>
                                            <td class="stuff">{{ $value->stuff }}</td>
                                            <td class="sample">{{ $value->sample }}</td>
                                            <td class="single_sample">{{ $value->single_sample }}</td>
                                            <td class="fan_sample">{{ $value->fan_sample }}</td>
                                            <td class="double_slide">{{ $value->double_slide }}</td>
                                            <td class="offspring">{{ $value->offspring }}</td>
                                            <td class="double_sleeve">{{ $value->double_sleeve }}</td>
                                            <td class="single_sleeve">{{ $value->single_sleeve }}</td>
                                            <td class="double_block">{{ $value->double_block }}</td>
                                            <td class="single_block">{{ $value->single_block }}</td>
                                            <td class="support">{{ $value->support }}</td>
                                            <td class="discount">{{ $value->discount }}</td>
                                            <td class="balance_payable">{{ $value->balance_payable }}</td>
                                            <td class="balance_time"></td>
                                            <td class="balance"></td>
                                            <td class="deduction">{{ $value->deduction }}</td>
                                            <td class="difference"></td>
                                            <td class="pack_time">{{ $value->pack_time ? date('m/d',$value->pack_time) : '未' }}</td>
                                            <td class="door_number">{{ $value->door_number }}</td>
                                            <td class="set_number">{{ $value->set_number }}</td>
                                            <td class="door_total">{{ $value->door_number + $value->set_number }}</td>
                                            <td class="depot">{{ $value->depot }}</td>
                                            <td class="deliver_time">{{ $value->deliver_time ? date('m/d',$value->deliver_time) : '未' }}</td>
                                            <td class="logistics_company">{{ $value->logistics_company }}</td>
                                            <td class="logistics_no">{{ $value->logistics_no }}</td>
                                            <td class="remark">{{ $value->remark }}</td>
                                            <td>
                                                @if(in_array('admin.summary.update',$jur))
                                                    <a href="{{ route('admin.summary.update',['id'=>$value->id]) }}">
                                                        <button class="btn btn-info btn-xs" type="button"><i class="fa fa-pencil">&nbsp;</i>编辑</button>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div style="text-align: right">
                                {{ $summary->appends($param)->links() }}
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
        var height = $(document.body).height();
        var winHeight = $(window).height();
        var tableHeight = winHeight - height;

        $('#tab_Test').parent().css('height',tableHeight + 'px');
    </script>
    @if(!isset($param['hide']) || (isset($param['hide']) && count($param['hide']) >= 15))
        <script>
            $(document).ready(function(){
                $("#tab_Test").FrozenTable(1,0,14);
            });
        </script>
    @endif
    <script src="{{ asset('/static/admin/js/laydate/laydate.js') }}"></script>
    <script src="{{ asset('/static/admin/js/jquery-migrate-1.2.1.js') }}"></script>
    <script src="{{ asset('/static/admin/js/TableFreeze.js') }}"></script>
    <script>

        $(function(){
            $('.table-hide').each(function(){
                if(!$(this).is(':checked')){
                    var val = $(this).val();
                    $('.' + val).addClass('hide');
                }
            })

            $('.checkAll').click(function(){
                $('.ch1').iCheck('check');
                $('.ch1').iCheck('enable');
            });
            $('.checkClose').click(function(){
                $('.ch1').iCheck('uncheck');
                $('.ch1').iCheck('enable');
            });

            laydate.render({
                elem: '#start'
            });
            laydate.render({
                elem: '#end'
            });
        })
    </script>
@endsection