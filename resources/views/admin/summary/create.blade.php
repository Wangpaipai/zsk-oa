@extends('admin.public.app')

@section('css')
@endsection

@section('content')
<div class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading" style="margin-bottom: 15px;">新增生产资料汇总信息</header>
                <form class="form-horizontal" role="form" id="commentForm">
                    <div class="col-lg-6">
                        <section class="panel">
                            {{--<header class="panel-heading">--}}
                                {{--Horizontal Forms--}}
                            {{--</header>--}}
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">订单编号:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="contract_no" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">接单日期:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control receipt_time" name="receipt_time" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">下单日期:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control order_time" name="order_time" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">批次:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="batch" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-2">内外单:</label>
                                    <div class="col-lg-4 icheck">
                                        <div class="minimal-green">
                                            <div class="radio is_menu">
                                                <input tabindex="3" value="1" type="radio"  name="order_inside_outside" checked>
                                                <label>内</label>
                                            </div>
                                        </div>
                                        <div class="minimal-green">
                                            <div class="radio is_menu">
                                                <input tabindex="3" value="2" type="radio"  name="order_inside_outside">
                                                <label>外</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">业务经理:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="manager" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">经销商:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="dealer" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">本厂计算货款:</label>
                                    <div class="col-lg-10">
                                        <input type="number" class="form-control" name="payment" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">颜色:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="color" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">发货地址:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="address" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">材质:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="stuff" placeholder="">
                                        <p class="help-block">复合/贴皮/集成实木/橡木/其他.</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">样品套:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="sample" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">单开门套:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="single_sample" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">单开门扇:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="fan_sample" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">对开双滑套:</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="double_slide" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-offset-1 col-lg-10">
                                        <label for="inputEmail1" class="col-lg-1 col-sm-1 control-label"></label>
                                        <button class="btn btn-success" type="button">提交</button>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="col-lg-6">
                    <section class="panel">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">子母门套:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="offspring" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">双套套:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="double_sleeve" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">单套套:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="single_sleeve" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">双套块:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="double_block" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">单套块:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="single_block" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">线条墙板踢脚支:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="support" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">折扣:</label>
                                <div class="col-lg-10">
                                    <input type="number" class="form-control" name="discount" placeholder="" value="1">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">应收余款:</label>
                                <div class="col-lg-10">
                                    <input type="number" class="form-control" name="balance_payable" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">大货样品扣款:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="deduction" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">包装完成日期:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control pack_time" name="pack_time" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">包装件数-门:</label>
                                <div class="col-lg-10">
                                    <input type="number" class="form-control" name="door_number" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">包装件数-套:</label>
                                <div class="col-lg-10">
                                    <input type="number" class="form-control" name="set_number" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">仓存位置:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="depot" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">发货时间:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control deliver_time" name="deliver_time" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">物流公司:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="logistics_company" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">物流单号:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="logistics_no" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">备注:</label>
                                <div class="col-lg-10">
                                    <input type="text" class="form-control" name="remark" placeholder="">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection


@section('js')
    <script src="{{ asset('/static/admin/js/laydate/laydate.js') }}"></script>
    <script>
        $(function (){
            laydate.render({
                elem: '.receipt_time'
            });
            laydate.render({
                elem: '.order_time'
            });
            laydate.render({
                elem: '.pack_time'
            });
            laydate.render({
                elem: '.deliver_time'
            });

            $('.btn').click(function(){
                if(checkForm()){
                    var data = $("#commentForm").serialize();
                    var index = layer.load(4,{time:10000});
                    $.ajax({
                        type:'POST',
                        dataType:'json',
                        url:'{{ route('admin.summary.create') }}',
                        data:data,
                        async: true,
                        success(data){
                            layer.close(index);
                            if(data.status){
                                layer.msg(data.msg,{icon:1,time:1500});
                                setTimeout(function(){
                                    location.href = "{{ route('admin.summary.index') }}";
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
                }
            });
            function checkForm(){
                var contract_no = $('input[name=contract_no]').val();
                if(!contract_no){
                    layer.msg('请输入合同编号',{icon:0,time:1500});
                    return false;
                }
                return true;
            }
        })
    </script>
@endsection