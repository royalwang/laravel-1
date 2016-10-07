@extends('layouts.app')






@section('style')
@parent
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('main-content')


<style>
tbody tr{
    cursor: pointer;
}
tbody tr.active,tbody tr.active > td{
    background-color: #eaffc0!important;
}
tbody td.product{
    position: relative;
}
tbody td.product > span.status{
    background-color: #fff;
    opacity:0.7;
    transform: rotate(-30deg);
    color: red;
    width: 183px;
    position: absolute;
    right: 56px;
    text-align: center;
    line-height: 44px;
    top: 55px;
    font-size: 29px;
    border: 1px solid red;
} 

</style>
	

<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">通道返回信息</h3></div>
            <form class="form-horizontal">
            <div class="box-body">

                <?php $pay_info = unserialize($order->pay_info); ?>
                <?php $site_info = unserialize($order->site_info); ?>

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

    <div class="col-md-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">产品信息</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">客户信息</a></li>
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">记录&备注</a></li>
            </ul>
            <div class="tab-content" style="min-height: 600px;">
                <div class="tab-pane active" id="tab_1">
                    <div class="row" style="padding-top:10px;padding-bottom: 10px; ">
                        <div class="col-sm-12">
                            <div class="btn-group col-sm-6">
                                <button id="wait-do" class="btn btn-warning">待调货</button>
                                <button id="wait-send" class="btn btn-warning">待发货</button>
                                <button id="wait-confirm" class="btn btn-warning">待确认</button>
                                <button id="wait-back" class="btn btn-warning">待退款</button>
                            </div>

                            <div class="col-sm-6">
                                <div class="btn-group pull-right ">
                                    <button id="already-send" class="btn btn-default">已发货</button>
                                    <button id="already-back" class="btn btn-default">已退款</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped dataTable">
                    <thead>
                        <tr><th colspan="2">图片</th><th width="150px" style="text-align: center;">当前状态</th></tr>
                    </thead>
                    <tbody>
                    @foreach($order->products as $product)
                    <tr>
                            <td><img width="150px" height="150px" src="{{ $order->site->banner->name }}/{{ $product->products_image }}"></td>
                            <td class="product">
                                <div class="col-sm-12">名称 ：{{ $product->products_name }}</div>
                                <div class="col-sm-12">个数 ：<span class="products_quantity">{{ $product->products_quantity }}</span></div>
                                <div class="col-sm-12">属性 ：{{ $product->products_attribute }}</div>
                                <div class="col-sm-12">
                                    <button class="btn btn-danger btn-sm">下架</button> 
                                    <button class="btn btn-primary btn-sm disabled products_split">拆分</button>
                                </div>
                                <span class="status">{{ $product->type->name }}</span>
                            </td>
                            <td  style="text-align: center;"><select name="orders_products_type_id">
                                @foreach($products_types as $ptype)
                                <option value="{{ $ptype->id }}" {{ ($ptype->id == $product->orders_products_type_id)?'selected ':'' }}data-key="{{ $ptype->code }}">{{ $ptype->name }}</option>
                                @endforeach
                            </select></td>
                    </tr>    
                    @endforeach 
                    </tbody>
                    </table>
                </div>

                <div class="tab-pane" id="tab_2">
                    <form class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-4">
                            <h4>注册信息</h4>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">姓名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control disabled" value="{{ $site_info['customers_name'] }}" disabled="disable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">公司</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control disabled" value="{{ $site_info['customers_company'] }}" disabled="disable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">地址</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control disabled" disabled="disable" style="resize:vertical;min-height: 150px">{{ $site_info['customers_street_address'] ."\n". $site_info['customers_city'] ."\n". $site_info['customers_state'] ."\n".  $site_info['customers_country'] }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">邮编</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control disabled" value="{{ $site_info['customers_postcode'] }}" disabled="disable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">电话</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control disabled" value="{{ $site_info['customers_telephone'] }}" disabled="disable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">邮箱</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control disabled" value="{{ $site_info['customers_email_address'] }}" disabled="disable">
                                </div>
                            </div>
                        </div>    
                    

                        <div class="col-sm-4">
                            <h4>账单地址</h4>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">姓名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control disabled" value="{{ $site_info['billing_name'] }}" disabled="disable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">公司</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control disabled" value="{{ $site_info['billing_company'] }}" disabled="disable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">地址</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control disabled" disabled="disable" style="resize:vertical;min-height: 150px">{{ $site_info['billing_street_address'] ."\n". $site_info['billing_city'] ."\n". $site_info['billing_state'] ."\n". $site_info['billing_country'] }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">邮编</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control disabled" value="{{ $site_info['billing_postcode'] }}" disabled="disable">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h4>送货地址</h4>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">姓名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control disabled" value="{{ $site_info['delivery_name'] }}" disabled="disable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">公司</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control disabled" value="{{ $site_info['delivery_company'] }}" disabled="disable">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">地址</label>
                                <div class="col-sm-9">
                                    <textarea type="text" class="form-control disabled" disabled="disable" style="resize:vertical;min-height: 150px">{{ $site_info['delivery_street_address'] ."\n". $site_info['delivery_city'] ."\n". $site_info['delivery_state'] ."\n". $site_info['delivery_country'] }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">邮编</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control disabled" value="{{ $site_info['delivery_postcode'] }}" disabled="disable">
                                </div>
                            </div> 
                        </div>
                    </div>
                    </form>    
                </div>

                <div class="tab-pane" id="tab_3">
                    <div class="col-sm-12">
                        <textarea style="resize: none; min-height: 300px; width :100%"></textarea>
                    </div>
                    <div class="col-sm-12">
                        <button class="btn btn-default">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-md-1">
        <a class="btn btn-app" href="{{ URL::previous() }}"><i class="fa fa-reply-all"></i>返回</a>
        <a class="btn btn-app" id="shipping"><i class="fa fa-truck"></i>发货</a>
        <a class="btn btn-app"><i class="fa fa-print"></i>打印</a>
    </div>

</div>

<script type="text/javascript">
    $("#shipping").click(function(event) {
        swal({
            title:'快递信息',
            html:'<label>快递类型: </label> <input value="" name="shipping_id">'+
                 '<label>快递单号: </label> <input value="" name="shipping_id">',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText:'取消',
            confirmButtonText: '提交',
        }).then(function(){

        },function(){})
    });



checkType();
checkQuantity();

$('select[name=orders_products_type_id]').change(function(event) {
    checkType();
});

function checkQuantity(){
    $('.products_quantity').each(function(index, el) {
        if(parseInt($(this).text()) > 1) 
            $(this).parents('tr').find('.products_split').removeClass('disabled');
    });
}

function checkType(){
    var already_get = true;
    var lack_goods = true;
    var back_money = true;

    $('#wait-do').addClass('disabled');
    $('#wait-send').addClass('disabled');
    $('#wait-confirm').addClass('disabled');
    $('#wait-back').addClass('disabled');

    $('tbody tr').each(function() {
        if($(this).hasClass('active')){
            $(this).find('select[name=orders_products_type_id]').each(function(){
                var code = $(this).find('option:selected').data('key'); 
                if(code != 'already-get') already_get = false;
                if(code != 'lack-goods') lack_goods = false;
                if(code != 'back-money') back_money = false;
            });  
        }
    });

    if(already_get == true) $('#wait-send').removeClass('disabled');
    if(lack_goods == true) $('#wait-confirm').removeClass('disabled');
    if(back_money == true) $('#wait-back').removeClass('disabled');
 
}

function changeGoodsStatus(data){
    $('tbody tr').each(function() {
        if($(this).hasClass('active')){
            $(this).find('span.status').html(data.title).css(data.css);
        }
        $(this).removeClass('active');
    });
}

$('tbody tr').click(function(event) {
    $(this).toggleClass('active');
    checkType();
});


$('select').click(function() {
    return false;
});

$('#wait-do').click(function(){
    var data = {
        title : $(this).text(),
        css : {
            'border-color': 'red',
            color : 'red',
        }
    }
    changeGoodsStatus(data);
});

$('#wait-send').click(function(){
    var data = {
        title : $(this).text(),
        css : {
            'border-color': '#258008',
            color : '#258008',
        }
    }
    changeGoodsStatus(data)
});

$('#wait-confirm').click(function(){
    var data = {
        title : $(this).text(),
        css : {
            'border-color': '#9e9b0c',
            color : '#9e9b0c',
        }
    }
    changeGoodsStatus(data)
});

$('#wait-back').click(function(){
    var data = {
        title : $(this).text(),
        css : {
            'border-color': '#5d5656',
            color : '#5d5656',
        }
    }
    changeGoodsStatus(data)
});



</script>



@endsection

	
