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

@section('form-content')


<form class="form-horizontal" name="form" action="{{ route($path.'.update' , $record->id) }}" method="post">
    {{ method_field('PUT') }}
    {!! csrf_field() !!}
    
    <div class="form-group">
        <label class="control-label col-sm-2">绑定账号</label>
        <div class="col-sm-8"><input name="ad_binds_id" value="{{ $record->binds->account->code .' - ' . $record->binds->vps->ip .' - ' . $record->binds->site->host }}" class="form-control disable" disabled="disable"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">时间</label>
        <div class="col-sm-8"><input name="date" value="{{ date('Y/m/d', $record->date ) }}" type="text" class="form-control disable"  disabled="disable" ></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">消费</label>
        <div class="col-sm-8"><input name="cost" value="{{ $record->cost }}" type="text" class="form-control" id="datepicker"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">点击量</label>
        <div class="col-sm-8"><input name="click_amount" value="{{ $record->click_amount }}" type="text" class="form-control" id="datepicker"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">充值</label>
        <div class="col-sm-8"><input name="recharge" value="{{ $record->recharge }}" type="text" class="form-control" id="datepicker"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">成交订单</label>
        <div class="col-sm-8"><input name="orders_amount" value="{{ $record->orders_amount }}" type="text" class="form-control" id="datepicker"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">成交金额</label>
        <div class="col-sm-8"><input name="orders_money" value="{{ $record->orders_money }}" type="text" class="form-control" id="datepicker"></div>
    </div>

</form>



@endsection
