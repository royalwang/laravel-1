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
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                	<option>退款</option>
                                </select></label>
                            </div>
                            <div class="dataTables_length pull-left" style="margin-left:20px;">
                                <label>&nbsp;下单日期&nbsp;&nbsp;
                                <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                                    <span><i class="fa fa-calendar"></i> 下单日期选择</span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                                <input name="dstart" type="hidden">
                                <input name="dend" type="hidden">
                                </label>
                            </div>
                            <div class="dataTables_length pull-left" style="margin-left:20px;">
                                <button class="btn btn-info" style="line-height:22px;padding:2px 5px;">筛选</button>
                            </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="example1_filter" class="dataTables_filter pull-right">
                                    <div class="btn-group">
                                        @pcan($path .'.sync')
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
									<th>日期</th>
                                    @foreach($orders_type as $type)
                                    <th>{{ $type->name }}</th>
                                    @endforeach
								</tr>
							</thead>
							<tbody class="user-form">
								@foreach($tables as $date=>$order)
								<tr>
									<td><a href="{{ route('data.logistics.list.index') }}?dstart={{ $date }}&dend={{ $date }}" style="text-decoration:underline;padding:0 5px;">{{ $date }}</a></td>
	                                @foreach($orders_type as $type)
                                    <td>
                                    @if(isset($order[$type->id]))
                                    <a href="{{ route('data.logistics.list.index') }}?dstart={{ $date }}&dend={{ $date }}&orders_type_id={{$type->id}}" style="text-decoration:underline;padding:0 5px;">{{ $order[$type->id] }}</a>
                                    @else
                                    0
                                    @endif
                                    </td>
                                    @endforeach
								</tr>
								@endforeach
							</tbody>
						</table>
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
        console.log(1);
    }).each(function() {
        if(this.complete) {
            console.log(2)
            $(this).load();
        }else{
            console.log(124);
        }
            
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


