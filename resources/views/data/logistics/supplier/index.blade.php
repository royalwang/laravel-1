@extends('layouts.app')

@section('htmlheader_title')
	订货调货页面
@endsection


@section('main-content')
<link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
<link href="{{ asset('/plugins/jquery-ui-1.12.0/jquery-ui.min.css')}}" rel="stylesheet">

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
	.sortable-test{
		width: 50px;
		height: 50px;
		display: block;
		float: left;
		margin: 5px;
		border: 1px solid #ccc;
		line-height: 50px;
		text-align: center;
	}
	.ui-selectable-helper{
		z-index: 557;
	}


	#wrapper-cover{
		display: none;
	}
	#wrapper {
		position: absolute;
	    width: 100%;
	    left: 0;
	    top: 0;
	    height: 100%;
	    z-index: 555;
		background: rgba(0,0,0,.4);
		opacity: 1;
	}
	#wrapper{
		z-index: 556;
	}
	#example1_wrapper{
		width: 1400px;
	    margin: 161px auto 0;
	    border: 1px solid #ccc;
	    background: #fff;
	    padding: 50px;
    }

    #example1_wrapper .content{
    	height: 500px;
    	overflow-y: scroll;
    	margin: 0;
    	padding:0;
    }

    #example1_wrapper .content > ul{
    	display:block;
		float: left;
		padding:30px;
		min-height: 100%;
		width: 100%;
    }

    #example1_wrapper .content > ul li { float: left;  padding: 0.4em; margin: 0 0.4em 0.4em 0; text-align: center; }
	#example1_wrapper .content > ul li h5 { margin: 0 0 0.4em; cursor: move;  text-overflow:ellipsis;white-space:nowrap;overflow: hidden;}
	#example1_wrapper .content > ul li a { float: right; }
	#example1_wrapper .content > ul li a.ui-icon-zoomin { float: left; }
	#example1_wrapper .content > ul li img { width: 100%; cursor: move; }
	#example1_wrapper .content > ul li.ui-selected , .gallery li.ui-selecting{border: 1px solid red}

	ul#products li{ width:150px; }
	ul#sproducts li{ width:80px; }

	ul#products li h5{ font-size: 11px }
	ul#sproducts li h5{ font-size: 10px }
    

    td{
    	vertical-align:inherit!important;
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
	            <div class="pull-left">
	                <div class="has-feedback">
	                <input type="text" class="form-control input-sm" placeholder="Search Mail">
	                <span class="glyphicon glyphicon-search form-control-feedback"></span>
	                </div>
	            </div>
	            <div class="pull-right">
	                <div class="btn-group btn-status-group">
	                	<button id="btn-free">未处理产品 (<span class="free num"><i class="fa fa-spinner fa-spin"></i></span>)</button>
	                	<button class="">待确认单子 (<span class="unlocked num"><i class="fa fa-spinner fa-spin"></i></span>)</button>
	                	<button class="">已确认单子 (<span class="locked num"><i class="fa fa-spinner fa-spin"></i></span>)</button>
	                	<button class="">已调货单子 (<span class="confim num"><i class="fa fa-spinner fa-spin"></i></span>)</button>
	                </div>
	            </div>
	        </div>
	        <!-- /.box-header -->
	        <div class="box-body" id="selectable-body">
	        	<table class="table">
	        		<thead>
	        			<tr>
	        				<td width="150px">日期</td>
	        				<td width="250px">商家</td>
	        				<td>链接</td>
	        				<td width="150px">状态</td>
	        				<td style="width: 200px;">操作</td>
	        			</tr>
	        		</thead>
	        		<tbody id="supplier_link">
	        			
	        		</tbody>
	        	</table>
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
            <a class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" title="删除"><i class="fa fa-trash-o"></i></a>
            <a class="btn btn-info btn-sm btn-qq" data-toggle="tooltip" title="联系" href="tencent://message/?uin={qq}&Site=&Menu=yes"><i class="fa fa-qq"></i></a>
            <a class="btn btn-primary btn-sm btn-do" data-toggle="tooltip" title="订货"><i class="fa fa-image"></i></a>
            <a class="btn btn-primary btn-sm btn-edit" data-toggle="tooltip" title="编辑"><i class="fa fa-pencil-square-o"></i></a>
         </div>
        </span>
	</div>
</script>


<script type="text/template" name="products-form">
    <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
		<div class="row">

			<div class="col-sm-4">
			  	<div class="title">商家名称：<select class="supplier" name="supplier_id"></select></div>
			  	<div class="content"><ul id="sproducts"><i class="fa fa-spinner fa-pulse fa-5x"></i></ul></div>
			</div>
			 
			<div class="col-sm-8">
				<div class="title">未处理产品</div>
				<div class="content"><ul id="products"><i class="fa fa-spinner fa-pulse fa-5x"></i></ul></div>
			</div>
		</div>
		<div class="row" style="margin: 20px;">
			<div class="btn-group pull-right ">
				<button class="btn btn-default btn-cancel">取消</button>
				<button class="btn btn-danger btn-submit disabled">确定</button>
			</div>
		</div>
    </div>
</script>

<script type="text/template" name="products-list">
<li class="pull-left ui-corner-tr ui-widget-content" data-id="{id}">
	<h5 class="ui-widget-header">{products_name}</h5>
	<img src="{products_image}" width="96" height="72">
	<i href="images/high_tatras.jpg" title="查看" class="ui-icon ui-icon-zoomin">查看</i>
	<i href="images/high_tatras.jpg" title="询问" class="ui-icon ui-icon-trash">发送</i>
</li>
</script>

<script type="text/template" name="sproducts-list">
<li class="pull-left ui-corner-tr ui-widget-content" data-id="{id}">
	<h5 class="ui-widget-header">{products_name}</h5>
	<img src="{products_image}">
	<i href="images/high_tatras.jpg" title="View larger image" class="ui-icon ui-icon-zoomin">查看</i>
	<i href="images/high_tatras.jpg" title="View larger image" class="ui-icon ui-icon-trash">取回</i>
</li>
</script>


<script type="text/template" name="supplierlink-list">
<tr>
	<td>{updated_at}</td>
	<td class="supplier_name" data-supplier-id="{supplier_id}"></td>
	<td><input class="form-control disabled" name="link" disabled style="width:100%" value="{{ url('supplierapi') }}/{code}"></td>
	<td class="type"><i class="fa fa-spinner fa-spin"></i></td>
	<td>
		<div class="pull-right btn-group">
			<button class="btn btn-default btn-edit">查看</button>
			<button class="btn btn-default btn-delete">删除</button>
			<button class="btn btn-default btn-send">发送</button>
		</div>
	</td>
</tr>
</script>

<div id="wrapper-cover">
	<div id="wrapper"></div>
</div>

<script type="text/javascript" src="{{ asset('/plugins/jquery-ui-1.12.0/jquery-ui.min.js')}}"></script>
<script>


function loadJs(option) {

	var defaultValue = {
		type: 'add',
		link : {
			supplier_id : '',
			code : ''
		}
	};

	$.extend(defaultValue,option); 

	var addSupplier = function(){
		var html = '';
		$('#external-events1').children('.external-event').each(function(index, el) {
			var data = $(el).data();
			if(defaultValue.link.supplier_id == data.id)
				html += '<option value="'+ data.id +'" selected>'+ data.name + '</option>';
			else
				html += '<option value="'+ data.id +'">'+ data.name + '</option>';
		});
		$('#wrapper').find('select.supplier').html(html);
	};

	var addSProduct = function(){
		if(defaultValue.type == 'add'){
			$('#wrapper').find('ul#sproducts').html('');
		}else{
			$.ajax({
				url: '',
				type: 'get',
				dataType: 'json',
				data: {code: defaultValue.code},
				success:function(r){
				}
			});	
		}
	};

	var addProduct = function(){
		$.ajax({
			url: '{{ route('data.logistics.ordersproducts.index') }}',
			type: 'get',
			dataType: 'json',
			data: {type: 1,locked :0},
			success:function(r){
				var data = r.data;
				var html = '';
				for(var i in data){
					html += formatTemplate(data[i],$('script[name="products-list"]').html())
				}
				$('#wrapper').find('ul#products').html(html);
				addProductEvent();
			}
		});	
	};

	var close = function(){
    	$('#wrapper').html('');
		$('#wrapper-cover').hide();
    }

	$('#wrapper').html($('script[name="products-form"]').html());
	$('#wrapper-cover').show();

	addSupplier();
	addSProduct();
	addProduct();

	
	$('#example1_wrapper .btn-cancel').click(function() {
		close();
	});

	
 	$(document).keydown(function(event){
		if(event.keyCode == 27){
			close();
		}
	});

	function addProductEvent(){

	    var $products = $( "#products" ),
	        $selected = $([]) ,
	    	$sproducts = $( "#sproducts" );
	 
	 	$("#example1_wrapper .content > ul").selectable({filter:'.ui-corner-tr'});

	    $('#example1_wrapper li.ui-corner-tr').draggable({
			cancel: "a.ui-icon", 
			revert: "invalid", 
			containment: "document",
			cursor: "move",
			helper: "clone",
			start:function(event , ui){
				$(ui.helper).css({'z-index':558});
				if(!$(this).hasClass('ui-selected')) return false;
				$selected = $('.ui-selected').not(ui.helper);
				//console.log($selected);
			}
	    });

	    $('#example1_wrapper .btn-submit').removeClass('disabled');
	    $('#example1_wrapper .btn-submit').click(function() {
			getLoading();
			var ids = [];
			$("#sproducts > li").each(function() {
				ids.push($(this).data('id'));
			});
			Rbac.ajax.request({
		        href: '{{ route('data.logistics.supplierlink.index') }}',
		        data:  {id: ids , 'supplier_id': $('#wrapper').find('select.supplier').val()},
		        successFnc:function(r){
		        	addSupplierLink(r.datas);
		        	updateSupplier();
		        	close();
		        }
		    });
		});

	 
	    $products.droppable({
	      	accept: "#sproducts li.ui-corner-tr",
	      	classes: {
	        	"ui-droppable-active": "ui-state-highlight"
	      	},
	      	drop: function( event, ui ) {
	      	  	back( $selected );
	     	}
	    });
	 
	    $sproducts.droppable({
			accept: "#products li.ui-corner-tr",
			classes: {
				"ui-droppable-active": "custom-state-active"
			},
			drop: function( event, ui ) {
				send( $selected );
			}
	    });

	    $( "#example1_wrapper .ui-corner-tr" ).click( function(e){

	    	var $item = $( this ),
				$target = $( event.target );

	    	if ( $target.is( "i.ui-icon-trash" ) ) {
				return send( $item );
			} else if ( $target.is( "i.ui-icon-zoomin" ) ) {
				return viewLargerImage( $target );
			} else if ( $target.is( "i.ui-icon-refresh" ) ) {
				return back( $item );
			}


		    if (e.ctrlKey == false) {
		        $( "#example1_wrapper .ui-corner-tr" ).removeClass("ui-selected");
		        $(this).addClass("ui-selected");
		    }else {
		        if ($(this).hasClass("ui-selected")) {
		            $(this).removeClass("ui-selected");
		        }else {
		            $(this).addClass("ui-selected");
		        }
		    }
		    return false;
		});
	 
	    // Image deletion function
	    var recycle_icon = "<i href='link/to/recycle/script/when/we/have/js/off' title='Recycle this image' class='ui-icon ui-icon-refresh'>Recycle image</i>";
	    function send( $item ) {
			$item.fadeOut(function() {
				$(this).removeAttr('style').removeClass('ui-selected');
				$(this).find( "i.ui-icon-trash" ).remove();
				$(this).append( recycle_icon ).appendTo( $sproducts ).fadeIn(function() {
					$(this).animate({ width: "90px" }).find( "img" ).animate({ height: "36px" });
				});
			});
	    }
	 
	    // Image recycle function
	    var trash_icon = "<i href='link/to/trash/script/when/we/have/js/off' title='Delete this image' class='ui-icon ui-icon-trash'>Delete image</i>";
	    function back( $item ) {
	      	$item.fadeOut(function() {
	      		$(this).removeAttr('style').removeClass('ui-selected');
	        	$(this).find( "i.ui-icon-refresh" ).remove();
	        	$(this).css( "width", "150px").append( trash_icon ).find( "img" ).css( "height", "72px" );
	        	$(this).appendTo( $products ).fadeIn();
	      	});
	    }
	 
	    // Image preview function, demonstrating the ui.dialog used as a modal window
	    function viewLargerImage( $link ) {
	      var src = $link.attr( "href" ),
	        title = $link.siblings( "img" ).attr( "alt" ),
	        $modal = $( "img[src$='" + src + "']" );
	 
	      if ( $modal.length ) {
	        $modal.dialog( "open" );
	      } else {
	        var img = $( "<img alt='" + title + "' width='384' height='288' style='display: none; padding: 8px;' />" )
	          .attr( "src", src ).appendTo( "body" );
	        setTimeout(function() {
	          img.dialog({
	            title: title,
	            width: 400,
	            modal: true
	          });
	        }, 1 );
	      }
	    }

    }


 }
</script>

<script type="text/javascript" src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/ajax.js') }}"></script>
<script type="text/javascript">
    function longPolling(url,data,doit,i) {
    	if(i == undefined) i = 0;
    	if(i == 20){
    		window.location.reload();
    	}
    	setTimeout(function(){
    		$.ajax({
	            url: url,
	            data: data,
	            type: 'get',
	            dataType: 'json',
	            timeout: 10000,
	            headers: { 
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
				},
				error:function(){
					i++;
					longPolling(url,data,doit,i);
				},
	            success: function (json) {
	                doit(json);
	                i = 0;
	                longPolling(url,data,doit,i); 
	            }
	        });
    	},5000);
        
    }
</script>

<script type="text/javascript">


function copyToClipboard(text) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    target = document.getElementById(targetId);
    if (!target) {
        var target = document.createElement("textarea");
        target.style.position = "absolute";
        target.style.left = "-9999px";
        target.style.top = "0";
        target.id = targetId;
        document.body.appendChild(target);
    }
    target.textContent = text;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    var succeed;
    try {
    	succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }

    return succeed;
}

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



var supplier = <?php echo $supplier->toJson() ?>;
var supplier_link = <?php echo $supplier_link->toJson() ?>;

if(supplier_link.length > 0){
	for(var i in supplier_link){
		addSupplierLink(supplier_link[i]);
	}
}

if(supplier.length > 0){
	for(var i in supplier){
		addSupplier(supplier[i]);
	}
}

updateSupplier();

longPolling('{{ url()->current().'/longpolling' }}' , '', function(data){
	var link = data['link'];
	$('tbody#supplier_link').children().each(function(index, el) {
		var id = $(this).data('id');
		if(link[id] && link[id] == 1){
			$(this).find('.type').html('商家已确认')
		}else{
			$(this).find('.type').html('商家未处理')
		}
	});

	var btn = data['btn'];
	
	for(var i in btn){
		$('.btn-status-group').find('span.'+i).html(btn[i]);
	}

});


function updateSupplier(){
	$('#external-events1').children('.external-event').each(function(index, el) {
		var data = $(el).data();
		$('#supplier_link').find('td.supplier_name').each(function() {
			if( $(this).data('supplier-id') == data.id )
				$(this).html(data.name);		
		});
	});
}

function addSupplier(data){
	$('#external-events1').append(supplierEvent(data));
}

function addSupplierLink(data){
	$('tbody#supplier_link').append(supplierLinkEvent(data));
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
            	updateSupplier();
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
	        		var new_obj = supplierEvent(r.datas);
		        	obj.before(new_obj);
		        	obj.remove();  	
		        	updateSupplier();
		        }
		    });	
		},function(){});
	});

	obj.find('.btn-do').click(function() {
		loadJs({link : { supplier_id : obj.data('id') } });
	});

	return obj;
}

function supplierLinkEvent(data){
	var obj = $(formatTemplate(data,$('script[name="supplierlink-list"]').html()));
	var url =  '{{ route('data.logistics.supplierlink.index') }}';
	obj.data(data);
	obj.find('.btn-delete').click(function() {
		Rbac.ajax.delete({
            confirmTitle: '确定删除?',
            href: url + '/' + data.id,
            successTitle: '删除成功',
            successFnc:function(){
            	obj.remove();
            }
        });
	});

	obj.find('.btn-edit').click(function() {
		loadJs({type:'update',link:obj.data()});
	});

	obj.find('.btn-send').click(function(event) {
		var data = obj.data();
		copyToClipboard('{{ url('supplierapi') }}/' + data.code);
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


$('#btn-free').click(function(event) {
	loadJs();
});



</script>




@endsection

