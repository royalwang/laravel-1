@extends('layouts.app')

@section('htmlheader_title')
	订货调货页面
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
	                <a class="btn btn-primary btn-sm pull-right" id="add_supplier">新增商家</a>
	             </div>
				<h4 class="box-title">商家名称</h4>
			</div>
			<div class="box-body">
				<div id="external-events1">
				</div>
			</div>
		</div>

    </div>

	<div class="col-md-9">
	    <div class="box box-primary">
	        <div class="box-header">
	            <h3 class="box-title"></h3>
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

	                    </div>
	                    <div class="col-sm-6">

	                    </div>
	                </div>
	                <div class="row">
	                    <div id="progress" class="progress col-sm-12 xxs">
	                        <div class="progress-bar progress-bar-success progress-bar-striped"></div>
	                    </div>
	                </div>
	                <div class="row">

	                </div>

	                <div class="row">

	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>


<script type="text/template" name="sidebar-form">
	<form class="form-horizontal" name="swal-form">
		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">商家名</label>
			<div class="col-sm-9">
				<input name="name" class="form-control" value="{name}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">QQ</label>
			<div class="col-sm-9">
				<input name="qq" class="form-control" value="{qq}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">电话</label>
			<div class="col-sm-9">
				<input name="telephone" class="form-control" value="{telephone}">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">地址</label>
			<div class="col-sm-9">
				<input name="address" class="form-control" value="{address}">
			</div>
		</div>
	</form>
</script>

<script type="text/template" name="sidebar-list">
	<div class="external-event">
		<span>{name}
		<div class="pull-right btn-group">
            <a class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" data-href="{url}/{id}" title="删除"><i class="fa fa-trash-o"></i></a>
            <a class="btn btn-primary btn-sm btn-edit" data-toggle="tooltip" title="编辑"><i class="fa fa-pencil-square-o"></i></a>
         </div>
        </span>
	</div>
</script>


<script type="text/template" name="sites-form">
<form class="form-horizontal" name="swal-form">
	<select>
		<option>{orders}</option>
	</select>
</form>
</script>

<script type="text/template" name="sites-list">
<tr>
	<td width="35"><input type="checkbox" /></td>
	<td>{created_at}</td>
	<td>{code}</td>
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

var supplier = <?php echo $supplier->toJson() ?>;

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

if(supplier.length > 0){
	for(var i in supplier){
		addSupplier(supplier[i]);
	}
}


function addSupplier(data){
	$('#external-events1').append(supplierEvent(data, 1));
}

function supplierEvent(data){
	var obj = $(formatTemplate(data,$('script[name="sidebar-list"]').html()));
	var url =  '{{ route('data.logistics.supplier.index') }}';
	obj.data(data);
	obj.find('.btn-delete').click(function() {
		Rbac.ajax.delete({
            confirmTitle: '确定删除商家?',
            href: url + '/' + data.id,
            successTitle: '删除成功',
            successFnc:function(){
            	obj.remove();
            }
        });
	});

	obj.find('.btn-edit').click(function() {
		var data = obj.data();
		swal({
			title: '供货商信息' ,
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



$('#add_supplier').click(function(event) {
	var data = {title:'商家名称'};
	swal({
		title: '新增商家',
		html: formatTemplate(data,$('script[name="sidebar-form"]').html()),
		showCloseButton: true,
		showCancelButton: true,
		cancelButtonText:'取消',
		confirmButtonText: '提交',
	}).then(function(){
		Rbac.ajax.request({
	        href: '{{ route('data.logistics.supplier.store') }}',
	        data: $('form[name="swal-form"]').serialize(),
	        successFnc:function(r){
	        	addSupplier(r.datas);
	        }
	    });	
	}, function(dismiss) {});
});



</script>





@endsection

