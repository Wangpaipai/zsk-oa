<div class="panel-body" style="display: inline-block">
    <a href="#myModal" data-toggle="modal" class="btn btn-default">设置隐藏列</a>
    <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">请设置要隐藏的列</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="margin-bottom: 10px;">
                        <button class="btn btn-success checkAll" type="button">全选</button>
                        <button class="btn btn-default checkClose" type="button">全不选</button>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 icheck ch1">
                            @foreach($letter as $item)
                                <div class="minimal-green checkd" style="width: 30%">
                                    <div class="checkbox">
                                        @if(isset($param['hide']))
                                            <input name="hide[]" class="table-hide" id="check-{{ $item['name'] }}"
                                                   type="checkbox" value="{{ $item['name'] }}" {{ in_array($item['name'],$param['hide']) ? 'checked' : '' }}>
                                        @else
                                            <input name="hide[]" class="table-hide" id="check-{{ $item['name'] }}" type="checkbox" value="{{ $item['name'] }}" checked>
                                        @endif
                                        <label for="check-{{ $item['name'] }}">{{ $item['title'] }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-success">确认</button>
                </div>
            </div>
        </div>
    </div>
</div>