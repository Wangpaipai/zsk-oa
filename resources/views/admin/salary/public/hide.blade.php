<div class="panel-body" style="display: inline-block">
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">设置价格 &nbsp;&nbsp;&nbsp; 订单编号:<span id="contract_no"></span></h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="salary_id" value="">
                    <div class="form-group">
                        <div class="col-sm-12 icheck ch1 ">
                            <button class="btn btn-default addAccount" type="button" style="margin-bottom: 20px;"><i class="fa fa-plus">&nbsp;</i>添加一行</button>
                            <table class="table table-striped table-hover table-bordered" id="editable-sample">
                                <thead>
                                <tr>
                                    <th>数量</th>
                                    <th>单价</th>
                                    <th>金额</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody class="account">
                                    <tr>
                                        <td>
                                            <input class=" form-control num change" type="number" placeholder="" value="" />
                                        </td>
                                        <td>
                                            <input class=" form-control price change" type="number" placeholder="" value="" />
                                        </td>
                                        <td>
                                            <input class=" form-control money change" type="number" placeholder="" value="" />
                                        </td>
                                        <td>
                                            <button class="btn btn-default btn-xs delAccount" type="button">×</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-success createAccount" data-dismiss="modal">确认</button>
                </div>
            </div>
        </div>
    </div>
</div>