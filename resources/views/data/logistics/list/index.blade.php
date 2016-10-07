@extends('layouts.app')

@section('htmlheader_title')
	Setting Site
@endsection


@section('main-content')

<link rel="stylesheet" href="{{ asset('plugins/file-upload/css/jquery.fileupload.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/jquery-ui-1.12.0/jquery-ui.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
<style type="text/css">
    table{
        text-align: center;
    }
    table th{
        text-align: center;
    }
</style>
<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">订单管理</h3>
            <div class="box-tools pull-right">
                <div class="has-feedback">
                <input type="text" class="form-control input-sm" placeholder="Order Id">
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6" style="line-height:35px;">
                        <form action="{{ route('data.logistics.list.index') }}">
                            <div class="dataTables_length pull-left" style="margin-left:20px;">
                                <label>&nbsp;状态&nbsp;&nbsp;
                                <select name="orders_type_id">
                                    <option value="0">全部</option>
                                	@foreach($orders_type as $type)
                                    @if($current_type_id == $type->id)
                                    <option value="{{ $type->id }}" selected>{{ $type->name }}</option>
                                    @else
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endif
                                    @endforeach
                                </select></label>
                            </div>
                            <div class="dataTables_length pull-left" style="margin-left:20px;">
                                <label>&nbsp;下单日期&nbsp;&nbsp;
                                <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                    <span>{{ isset(request()->dstart)?request()->dstart:'' }} / {{ isset(request()->dend)?request()->dend:'' }}</span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <input name="dstart" type="hidden" value="{{ isset(request()->dstart)?request()->dstart:'' }}">
                                <input name="dend" type="hidden" value="{{ isset(request()->dend)?request()->dend:'' }}">
                                </label>
                            </div>
                            <div class="dataTables_length pull-left" style="margin-left:20px;">
                                <button class="btn btn-info" style="line-height:22px;padding:2px 5px;">筛选</button>
                            </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="example1_filter" class="dataTables_filter pull-right">
                                    <div class="btn-group">
                                        @pcan($path .'.upload')
                                        <span class="btn btn-default fileinput-button" ><i class="fa fa-chain"></i><input id="fileupload" type="file" data-href="{{ route('data.logistics.orders.upload') }}"></span>
                                            @endpcan
                                        @pcan($path .'.destroy')
                                        <button class="btn btn-danger" onclick=""><i class="fa fa-trash"></i></button>
                                        @endpcan                                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>    
                </div>
                <div class="row">
                    <div id="progress" class="progress col-sm-12 xxs">
                        <div class="progress-bar progress-bar-success progress-bar-striped"></div>
                    </div>
                </div>
                <div class="row">
	                <div class="col-sm-12">           	
						<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
							<thead>
								<tr>
                                    <th>下单日期</th>
                                    <th>通道订单号</th>
                                    <th>网站订单号</th>
                                    <th>客户名字 <br> 客户电话</th>
                                    <th style="min-width: 200px;">产品</th>
                                    <th>操作</th>
								</tr>
							</thead>
							<tbody class="user-form">
								@foreach($orders as $order)
								<tr>
                                    <td>{{ $order->trade_date}}</td>
                                    <td>{{ $order->pay_id}}</td>
                                    <td>{{ $order->order_id}}</td>
                                    <td><?php $payinfo = unserialize($order->pay_info); ?>
                                    {{ $payinfo['card_name'] }} <br> {{ $payinfo['telephone'] }}
                                    </td>
                                    <td>
                                    <ul>
                                    @foreach($order->products as $product)
                                    <li class="row">
                                        <div class="col-sm-5"><img class="product" src="{{ $order->site->banner->name}}/{{ $product['products_image'] }}"></div>
                                        <div class="col-sm-7" style="text-align:left;display:block;line-height:20px;">
                                            <div class="col-sm-12"><span>{{ $product['products_name'] }}</span></div>
                                            @if(!empty($product['products_options_values']))
                                            <div class="col-sm-12">{{ $product['products_options'] }} : {{ $product['products_options_values'] }}</div>
                                            @endif
                                        </div>
                                    </li>
                                    @endforeach
                                    </ul>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                        @pcan($path . '.show')
                                        <a class="btn btn-default" href="{{ route('data.logistics.orders.show',$order->id) }}"><i class="fa fa-eye"></i></a>
                                        @endpcan
                                        @pcan($path . '.edit')
                                        <button class="btn btn-default"><i class="fa fa-edit"></i></button>
                                        @endpcan
                                        @pcan($path . '.destroy')
                                        <button class="btn btn-danger table-delete" data-href="{{ route( $path . '.destroy' , $order->id ) }}"><i class="fa fa-trash"></i></button>
                                        @endpcan
                                        </div>
                                    </td>
								</tr>
								@endforeach
							</tbody>
						</table>
	                </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                            Showing {{ ($orders->currentPage()-1) * $show +1 }} to {{ $orders->currentPage() * $show }} of {{ $orders->total() }} entries</div>
                    </div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                            {!! $orders->appends([
                                'show' => $show ,
                                'orders_type_id' => request()->orders_type_id ,
                                'dstart' => request()->dstart ,
                                'dend' => request()->dend ,
                                ])->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('plugins/jquery-ui-1.12.0/jquery-ui.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('js/ajax.js') }}"></script>






<script type="text/javascript">
    $('#daterange-btn').daterangepicker(
        {
            ranges: {
                '今天': [moment(), moment()],
                '昨天': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                '最近七天': [moment().subtract(6, 'days'), moment()],
                '最近30天': [moment().subtract(29, 'days'), moment()],
                '这个月': [moment().startOf('month'), moment().endOf('month')],
                '上个月': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            startDate: moment().subtract(29, 'days'),
            endDate: moment()
        },
        function (start, end) {
            $('#daterange-btn span').html(start.format('YYYY-MM-DD') + ' / ' + end.format('YYYY-MM-DD'));
            $('#daterange-btn').next().val(start.format('YYYY-MM-DD')).next().val(end.format('YYYY-MM-DD'));
        }
    );


    $("img.product").one('load', function() {
        console.log(123);
    }).each(function() {
        if(this.complete) 
            $(this).load();
        else
            console.log(124);
    });



</script>

<script src="{{ asset('plugins/file-upload/js/vendor/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('plugins/file-upload/js/jquery.fileupload.js') }}"></script>
<script src="{{ asset('plugins/file-upload/js/jquery.iframe-transport.js') }}"></script>

<script>

/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    $('#fileupload').fileupload({
        url: $('#fileupload').data('href'),
        dataType: 'json',
        type:'post',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).bind('fileuploadstart', function (e) {
        getLoading();
    }).bind('fileuploaddone', function (e , data) {
        swal({
            title: '文件上传成功',
            text: "是否同步上传数据",
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText:'取消',
            confirmButtonText: '提交',
        }).then(function(){
            getLoading();
            Rbac.ajax.request({
                href: '{{ route('data.logistics.orders.sync') }}',
                data: data.result.files[0],
                successFnc: function(r){
                    console.log(r);
                    var html = '<ul style="height:35px;padding-right:20px;"><li class="col-sm-6">网站</li><li class="col-sm-3">订单号</li><li class="col-sm-3">状态</li></ul>';
                    if(r.msg){
                        var msg = r.msg;
                        html += '<div style="max-height:200px;overflow-y:scroll;">';
                        for (var host in msg) {
                            for(var id in msg[host]){
                                html += '<ul>';
                                html += '<li class="col-sm-6">' + host +'</li>';
                                html += '<li class="col-sm-3">' + id +'</li>';
                                html += '<li class="col-sm-3">';
                                switch(msg[host][id]){
                                    case 0:
                                        html += '已存在';
                                    break;
                                    case -1:
                                        html += '添加失败';
                                    break;
                                    case 1:
                                        html += '添加成功';
                                    break;
                                }
                                html += '</li>';
                                html += '</ul>';
                            }
                        }
                        html += '</div>';
                    }else{
                        html +='<ul><li class="col-sm-12">没有更新内容</li></ul>';
                    }

                    swal({html:html});
                    
                }
            }); 
        },function(){});
    }).bind('fileuploadfail', function (e) {
        swal({
            title: '文件上传失败',
            text: "是否同步上传数据",
            showCloseButton: true,
        });
    });
    
});
</script>







@endsection	


