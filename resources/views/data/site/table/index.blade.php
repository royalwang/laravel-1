@extends('layouts.app')

@section('htmlheader_title')
	网站管理
@endsection


@section('main-content')
<link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">

<style>
	.external-event{
		cursor: default;
		background: #d4deaa;
		color: #422828;
	}
	.external-event > span{
		line-height: 30px;
	}
	.form-horizontal .form-group{
		margin-right: 0;
		margin-left: 0;
	}
	.input-group .input-group-addon{
		background-color:#d4deaa;
		border-color:#d4deaa;
		
	}
	.input-group-addon i{
		min-width: 15px;
	}
	.datepicker{
		padding: 6px 12px;
	}
	textarea{
		resize: none;
		min-height: 100px;
	}

</style>

<div class="row">
	<div class="col-md-3">
		<div class="box box-solid">
			<div class="box-header with-border">
				<div class="pull-right box-tools">
	                <a class="btn btn-primary btn-sm pull-right" id="add_banner">新增数据</a>
	             </div>
				<h4 class="box-title">产品数据包</h4>
			</div>
			<div class="box-body">
				<div id="external-events1">
				</div>
			</div>
		</div>



		<div class="box box-solid">
			<div class="box-header with-border">
				<div class="pull-right box-tools">
	                <a class="btn btn-primary btn-sm pull-right" id="add_paychanal">新增通道</a>
	             </div>
				<h4 class="box-title">网站通道</h4>
			</div>
			<div class="box-body">
				<div id="external-events2">
				</div>
			</div>
		</div>

    </div>

	<div class="col-md-9">
	    <div class="box box-primary">
	        <div class="box-header">
	            <h3 class="box-title">@yield('table_title')</h3>
	            <div class="box-tools pull-right">
	                <div class="has-feedback">
	                <input type="text" class="form-control input-sm" placeholder="Search Mail">
	                <span class="glyphicon glyphicon-search form-control-feedback"></span>
	                </div>
	            </div>
	        </div>
	        <!-- /.box-header -->
	        <div class="box-body">
	            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	                <div class="row">
	                    <div class="col-sm-6" style="line-height:35px;">
	                        <div class="dataTables_length pull-left">
	                            <label>&nbsp;显示&nbsp;&nbsp;
	                                <select name="show" aria-controls="example1" class="url-parameter" data-href="{{ route($path .'.index') }}">
	                                    <option value="20" {{ (isset(request()->show) &&  request()->show==20)?'selected':'' }}>20 条</option>
	                                    <option value="30" {{ (isset(request()->show) &&  request()->show==30)?'selected':'' }}>30 条</option>
	                                    <option value="50" {{ (isset(request()->show) &&  request()->show==50)?'selected':'' }}>50 条</option>
	                                </select></label>    
	                        </div>
	                        <div class="dataTables_length pull-left" style="margin-left:20px;">
	                            @yield('select_status')   
	                        </div>
	                    </div>
	                    <div class="col-sm-6">
	                        <div id="example1_filter" class="dataTables_filter pull-right">
	                            <div class="btn-group">
	                                @pcan($path .'.create')
	                                <button class="btn btn-default" id="add_site"><i class="fa fa-plus"></i></button>
	                                @endpcan

	                                @pcan($path .'.destroy')
	                                <button class="btn btn-danger" onclick=""><i class="fa fa-trash"></i></button>
	                                @endpcan
	                                                         
	                            </div>
	                        </div>
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
									<th width="35"><input type="checkbox" /></th>
									<th>日期</th>
									<th>网址</th>
									<th>数据包</th>
									<th>通道</th>
									<th width="156">操作</th>
								</tr>
							</thead>
							<tbody class="list-form">
							</tbody>
							</table>
		                </div>
	                </div>

	                <div class="row">
	                	<div class="col-sm-5">
	                		<div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
	                            Showing {{ ($tables->currentPage()-1) * $show +1 }} to {{ $tables->currentPage() * $show }} of {{ $tables->count() }} entries</div>
	                	</div>
	                	<div class="col-sm-7">
	                		<div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
	                			{!! $tables->appends(['show' => $show])->render() !!}
	                		</div>
	                	</div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>


<script type="text/template" name="sidebar-form">
	<form class="form-horizontal" name="swal-form">
		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">{title}</label>
			<div class="col-sm-9">
				<input name="name" class="form-control" value="{name}">
			</div>
		</div>
	</form>
</script>

<script type="text/template" name="sidebar-list">
	<div class="external-event">
		<span>{name}
		<div class="pull-right btn-group">
            <a class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-href="{{ route('data.money.accounts.index') }}/{id}" title="删除"><i class="fa fa-trash-o"></i></a>
            <a class="btn btn-primary btn-sm btn-edit" data-toggle="tooltip" title="编辑"><i class="fa fa-pencil-square-o"></i></a>
         </div>
        </span>
	</div>
</script>


<script type="text/template" name="sites-form">
<form class="form-horizontal" name="swal-form">

    <div class="form-group">
        <label class="control-label col-sm-2" >网址</label>
        <div class="col-sm-8"><input name="host" type="text" value="{host}" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >数据源</label>
        <div class="col-sm-8">
        	<select name="banners_id" class="form-control">{banner_select}</select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >通道</label>
        <div class="col-sm-8">
        	<select name="pay_channel_id" class="form-control">{channel_select}</select>
        </div>
    </div>
</form>
</script>

<script type="text/template" name="sites-list">
<tr>
	<td width="35"><input type="checkbox" /></td>
	<td>{created_at}</td>
	<td>{host}</td>
	<td class="banner-name" data-id="{banners_id}"></td>
	<td class="channel-name" data-id="{pay_channel_id}"></td>
	<td>
		<div class="btn-group">
		@pcan($path . '.create')
		<button class="btn btn-default btn-paste" data-toggle="tooltip" title="复制"><i class="fa fa-paste"></i></button>
		@endpcan
		@pcan($path . '.edit')
		<button class="btn btn-default btn-edit" data-toggle="tooltip" title="编辑"><i class="fa fa-edit"></i></button>
		@endpcan
		@pcan($path . '.destroy')
		<button class="btn btn-danger btn-delete" data-toggle="tooltip" title="删除"><i class="fa fa-trash"></i></button>
		@endpcan
		</div>
	</td>
</tr>	
</script>




<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/ajax.js') }}"></script>
<script type="text/javascript">

var tables  = <?php echo $tables->toJson() ?>;
var sites = tables.data;
var banners = <?php echo $banners->toJson() ?>;
var channels = <?php echo $channels->toJson() ?>;


function formatTemplate(dta, tmpl) { 
    function _getData(data,key){
        var s = key.indexOf('.');
        if(s > -1){
            var ss = key.substr(0,s);
            return (data[ss])?_getData(data[ss] , key.substr(s+1)) : '';
        }else{
            if($.isArray(data)){
                var html = '';
                $.each(data,function(index,e) {
                    if(e[key]){
                        html += e[key] + ';';
                    }
                });
                return html;
            }else{
                return (data[key])? data[key]:'';
            }
        }
        
    }
    return tmpl.replace(/{([a-zA-Z0-9_.]+)}/g, function(m1, m2) {
        return _getData(dta,m2);
    });  
}

if(banners.length > 0){
	for(var i in banners){
		addBanners(banners[i]);
	}
}

if(channels.length > 0){
	for(var i in channels){
		addChannels(channels[i]);
	}
}

if(sites.length > 0){
	for(var i in sites){
		addSite(sites[i]);
	}
}

function addSite(data){
	$('tbody.list-form').append(siteEvent(data));
}

function addBanners(data){
	$('#external-events1').append(sidebarEvent(data, 1));
}

function addChannels(data){
	$('#external-events2').append(sidebarEvent(data, 0));
}

function updateBanners(){
	var banners = getDataFromDiv($('#external-events1'));
	$('tbody.list-form').find('.banner-name').each(function(index, el) {
		for(var i in banners){
			if(banners[i].id == $(this).data('id')){
				$(this).html(banners[i].name);
				break;
			}
		}
	});
}

function updateChannels(){
	var channels = getDataFromDiv($('#external-events2'));
	$('tbody.list-form').find('.channel-name').each(function(index, el) {
		for(var i in channels){
			if(channels[i].id == $(this).data('id')){
				$(this).html(channels[i].name);
				break;
			}
		}
	});
}

function getDataOptionFromDiv(obj,id){
	var html = '';
	obj.find('.external-event').each(function(index, el) {
		var data = $(this).data();
		if(id == data.id)
			html += '<option value="'+ data.id +'" selected>' + data.name + '</option>' +'\n';
		else
			html += '<option value="'+ data.id +'">' + data.name + '</option>' +'\n';
	});
	return html;
}

function getDataFromDiv(obj){
	var data = [];
	obj.find('.external-event').each(function(index, el) {
		data.push($(this).data());
	});
	return data;
}

function getDataFromDivById(obj , id){
	var data = '';
	obj.find('.external-event').each(function(index, el) {
		if($(this).data('id') == id){
			data = $(this).data('name');
		}
	});
	return data;
}

function sidebarEvent(data , type){
	var obj = $(formatTemplate(data,$('script[name="sidebar-list"]').html()));
	var title = type ? '品牌':'数据包';
	var url = type ? '{{ route('data.site.banners.index') }}':'{{ route('data.site.paychannels.index') }}';
	obj.data(data);
	obj.find('.btn-delete').click(function() {
		Rbac.ajax.delete({
            confirmTitle: '确定删除'+ title  +'?',
            href: url + '/' + data.id,
            successTitle: '删除' + title + '成功',
            successFnc:function(){
            	obj.remove();
            }
        });
	});

	obj.find('.btn-edit').click(function() {
		var data = obj.data();
		data.title = title + "名称";
		swal({
			title: '修改' + title,
			html: formatTemplate(data,$('script[name="sidebar-form"]').html()),
			showCloseButton: true,
			showCancelButton: true,
			cancelButtonText:'取消',
			confirmButtonText: '提交',
		}).then(function(){
			Rbac.ajax.request({
		        href: url + '/' + data.id,
		        data: $('form[name="swal-form"]').serialize(),
		        type:'put',
		        successFnc:function(r){
	        		var new_obj = sidebarEvent(r.datas , title);
		        	obj.before(new_obj);
		        	obj.remove();
		        	type ? updateBanners() : updateChannels();
		        	
		        }
		    });	
		},function(){});
	});

	return obj;
}

function siteEvent(data){
	var obj = $(formatTemplate(data,$('script[name="sites-list"]').html()));
	obj.data(data);
	obj.find('td.banner-name').html(getDataFromDivById($('#external-events1') , data.banners_id));
	obj.find('td.channel-name').html(getDataFromDivById($('#external-events2') , data.pay_channel_id));


	obj.find('.btn-delete').click(function() {
		Rbac.ajax.delete({
            confirmTitle: '确定删除网站?',
            href: '{{ route('data.site.sites.index') }}/' + data.id,
            successTitle: '删除成功',
            successFnc:function(){
            	obj.remove();
            }
        });
	});
	obj.find('.btn-paste').click(function() {
		var data = obj.data();
		data.host = "http://";
		data.banner_select = getDataOptionFromDiv($('#external-events1') , data.banners_id);
		data.channel_select = getDataOptionFromDiv($('#external-events2') ,data.pay_channel_id);
		swal({
			title: '新增账户',
			html: formatTemplate(data,$('script[name="sites-form"]').html()),
			showCloseButton: true,
			showCancelButton: true,
			cancelButtonText:'取消',
			confirmButtonText: '提交',
		}).then(function(){
			Rbac.ajax.request({
		        href: '{{ route('data.site.sites.store') }}',
		        data: $('form[name="swal-form"]').serialize(),
		        successFnc:function(r){
		        	addSite(r.datas);
		        }
		    });	
		}, function(dismiss) {});
	});
	obj.find('.btn-edit').click(function() {
		var data = obj.data();
		data.banner_select = getDataOptionFromDiv($('#external-events1') , data.banners_id);
		data.channel_select = getDataOptionFromDiv($('#external-events2') ,data.pay_channel_id);

		swal({
			title: '修改名称',
			html: formatTemplate(data,$('script[name="sites-form"]').html()),
			showCloseButton: true,
			showCancelButton: true,
			cancelButtonText:'取消',
			confirmButtonText: '提交',
		}).then(function(){
			Rbac.ajax.request({
		        href: '{{ route('data.site.sites.index') }}' + '/' + data.id,
		        data: $('form[name="swal-form"]').serialize(),
		        type:'put',
		        successFnc:function(r){
		        	obj.before(siteEvent(r.datas));
		        	obj.remove();
		        }
		    });	
		},function(){});
	});


	return obj;
}



$('#add_site').click(function(event) {
	var data = {};
	data.host = "http://";
	data.banner_select = getDataOptionFromDiv($('#external-events1'));
	data.channel_select = getDataOptionFromDiv($('#external-events2'));

	swal({
		title: '新增账户',
		html: formatTemplate(data,$('script[name="sites-form"]').html()),
		showCloseButton: true,
		showCancelButton: true,
		cancelButtonText:'取消',
		confirmButtonText: '提交',
	}).then(function(){
		Rbac.ajax.request({
	        href: '{{ route('data.site.sites.store') }}',
	        data: $('form[name="swal-form"]').serialize(),
	        successFnc:function(r){
	        	addSite(r.datas);
	        }
	    });	
	}, function(dismiss) {});
});

$('#add_banner').click(function(event) {
	var data = {title:'数据名称'};
	swal({
		title: '新增数据',
		html: formatTemplate(data,$('script[name="sidebar-form"]').html()),
		showCloseButton: true,
		showCancelButton: true,
		cancelButtonText:'取消',
		confirmButtonText: '提交',
	}).then(function(){
		Rbac.ajax.request({
	        href: '{{ route('data.site.banners.store') }}',
	        data: $('form[name="swal-form"]').serialize(),
	        successFnc:function(r){
	        	addBanners(r.datas);
	        }
	    });	
	}, function(dismiss) {});
});

$('#add_paychanal').click(function(event) {
	var data = {title:'通道名称'};
	swal({
		title: '新增通道',
		html: formatTemplate(data,$('script[name="sidebar-form"]').html()),
		showCloseButton: true,
		showCancelButton: true,
		cancelButtonText:'取消',
		confirmButtonText: '提交',
	}).then(function(){
		Rbac.ajax.request({
	        href: '{{ route('data.site.paychannels.store') }}',
	        data: $('form[name="swal-form"]').serialize(),
	        successFnc:function(r){
	        	addChannels(r.datas);
	        }
	    });	
	}, function(dismiss) {});
});



</script>





@endsection

