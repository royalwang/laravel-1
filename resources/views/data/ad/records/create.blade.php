@extends('layouts.app3')

@section('htmlheader_title')
    Setting AD
@endsection

@section('subsidebar_title')
    广告数据管理
@endsection

@section('form_title')
    添加新记录
@endsection

@section('style')
@parent
<link href="{{ asset('/plugins/datepicker/datepicker3.css') }}" rel="stylesheet">
@endsection

@section('form-content')


<form class="form-horizontal" name="form" action="{{ route($path.'.store') }}" method="post">
    {!! csrf_field() !!}
    
    <div class="form-group">
        <label class="control-label col-sm-2">绑定账号</label>
        <div class="col-sm-8">
            <select class="form-control ajax-select-vps" name="ad_binds_id">
            @foreach($binds as $bind)
                <option value="{{ $bind->id }}">{{ $bind->account->code }} - {{ $bind->vps->ip }} - {{ $bind->site->host }}</option>
            @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">时间</label>
        <div class="col-sm-8"><input name="date" value="{{ date('Y/m/d') }}" type="text" class="form-control" id="datepicker"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">消费</label>
        <div class="col-sm-8"><input name="cost" placeholder="$ 00.00" type="text" class="form-control" id="datepicker"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">点击量</label>
        <div class="col-sm-8"><input name="click_amount" placeholder="0" type="text" class="form-control" id="datepicker"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">充值</label>
        <div class="col-sm-8"><input name="recharge" placeholder="$ 00.00" type="text" class="form-control" id="datepicker"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">成交订单</label>
        <div class="col-sm-8"><input name="orders_amount" placeholder="0" type="text" class="form-control" id="datepicker"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">成交金额</label>
        <div class="col-sm-8"><input name="orders_money" placeholder="￥ 00.00" type="text" class="form-control" id="datepicker"></div>
    </div>

</form>


<script type="text/javascript" src="{{ asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript">

$( "#datepicker" ).datepicker({
    format: 'yyyy/mm/dd',
});
</script>

@endsection

    
