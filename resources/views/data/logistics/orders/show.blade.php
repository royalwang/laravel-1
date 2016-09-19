@extends('layouts.app')






@section('style')
@parent
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('main-content')
	

<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">通道返回信息</h3></div>
            <form class="form-horizontal">
            <div class="box-body">

                <?php $pay_info = unserialize($order->pay_info); ?>

                <div class="form-group">
                    <label class="col-sm-3 control-label">流水号</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $pay_info['pay_id'] }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">订单号</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $pay_info['order_id'] }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">金额</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span type="text" style="width:60px" class="" >{{ $pay_info['currency'] }}</span>
                            </div>    
                            <input type="text" class="form-control disabled" value="{{ $pay_info['money'] }}" disabled="disable">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">卡种</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $pay_info['card_type'] }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">交易日期</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $pay_info['trade_date'] }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">批次号</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $pay_info['batch_id'] }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">网站</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $pay_info['host'] }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">持卡人姓名</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $pay_info['card_name'] }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">电话</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $pay_info['telephone'] }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">邮编</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $pay_info['post_code'] }}" disabled="disable">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">持卡人邮箱</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control disabled" value="{{ $pay_info['card_email'] }}" disabled="disable">
                    </div>
                </div>

            </div>
            </form>
            <div class="box-footer"></div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">网站后台订单信息</h3></div>
            <form class="form-horizontal">
            <div class="box-body">
            <?php 

            echo file_get_contents('http://' . $pay_info['host'] . '/sibangh.order.php?funaction=getorderdetails&id='. $pay_info['order_id']);

            ?>
                    
            </div>
            </form>
            <div class="box-footer"></div>
        </div>
    </div>

    <div class="col-md-1">
        @if($prev_id != -1)
        <a href="{{ route($path .'.show',$prev_id) }}" class="btn btn-app"><i class="fa fa-arrow-left"></i>上一单</a>
        @endif
        @if($next_id != -1)
        <a href="{{ route($path .'.show',$next_id) }}" class="btn btn-app"><i class="fa fa-arrow-right"></i>下一单</a>
        @endif
        <a class="btn btn-app"><i class="fa fa-truck"></i>发货</a>
    </div>

</div>





@endsection

	
