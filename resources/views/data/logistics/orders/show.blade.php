@extends('layouts.app')






@section('style')
@parent
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('main-content')
	

<div class="row">
    <div class="col-md-3">
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

    <div class="col-md-8">
        <div class="box box-primary">
            <div class="box-header with-border"><h3 class="box-title">网站后台订单信息</h3></div>
            <form class="form-horizontal">
            <div class="box-body">

            <div class="row">
                <div class="col-md-12">
                      public 'orders_id' => string '2' (length=1)
                      public 'customers_id' => string '1' (length=1)
                      public 'customers_name' => string 'nanafjs lin' (length=11)
                      public 'customers_company' => string '' (length=0)
                      public 'customers_street_address' => string 'Shanghai' (length=8)
                      public 'customers_suburb' => string 'Shanghai' (length=8)
                      public 'customers_city' => string 'Shanghai' (length=8)
                      public 'customers_postcode' => string '200000' (length=6)
                      public 'customers_state' => string 'Shanghai' (length=8)
                      public 'customers_country' => string 'China' (length=5)
                      public 'customers_telephone' => string '150111111111' (length=12)
                      public 'customers_email_address' => string 'nanafjs@outlook.com' (length=19)
                      public 'customers_address_format_id' => string '1' (length=1)
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">客户信息</div>
                <div class="col-md-4">
                账单地址</div>
                <div class="col-md-4">
                送货地址</div>
            </div>

            <?php 

            $data = file_get_contents('http://127.0.0.1/zencart3/sibangh.order.php?funaction=getorderdetails&id=2');
            function decrypt2($data, $key)  {  
                $key = md5($key);  
                $x = 0;  
                $data = base64_decode($data);  
                $len = strlen($data);  
                $l = strlen($key);  
                $char = '';
                for ($i = 0; $i < $len; $i++){  
                    if ($x == $l){  
                        $x = 0;  
                    }  
                    $char .= substr($key, $x, 1);  
                    $x++;  
                }  
                $str = '';
                for ($i = 0; $i < $len; $i++){  
                    if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))){  
                        $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));  
                    }  
                    else{  
                        $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));  
                    }  
                }  
                return $str;  
            }  

            var_dump(json_decode(decrypt2($data,'pGeezBunDNK1X53y')));

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
        <a class="btn btn-app" id="shipping"><i class="fa fa-truck"></i>发货</a>
        <a class="btn btn-app"><i class="fa fa-print"></i>发货</a>
    </div>

</div>

<script type="text/javascript">
    $("#shipping").click(function(event) {
        swal({
            title:'快递信息',
            html:'<label>快递单号: </label> <input value="" name="shipping_id">',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText:'取消',
            confirmButtonText: '提交',
        }).then(function(){

        },function(){})
    });
</script>



@endsection

	
