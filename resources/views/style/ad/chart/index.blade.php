@extends('layouts.app')

@section('htmlheader_title')
	Manger User
@endsection

@section('style')
@parent
<link href="{{ asset('/css/adtablestyle.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/jquery-ui-1.12.0/jquery-ui.min.css')}}" rel="stylesheet">

@endsection

@section('main-content')
	


<div class="col-md-2">	
	<div class="box box-primary">	
		<div class="box-header">
			<i class="fa fa-arrows"></i><h3 class="box-title">样式设定</h3>
		</div>
		<div class="box-body">
			<div class="default-col">
				@foreach($style as $k=>$v)
				<span style="cursor:all-scroll" class="draggable" data-value="{{ trans('adtable.'.$v) }}" data-key="A{{ $k }}">{{ trans('adtable.'.$v) }}<div>A{{ $k }}:</div></span>
				@endforeach
			</div>

			<div style="height:20px;width:100%;float:left;"></div>

			<div class="default-col">
				@foreach($total as $v)
				<span style="cursor:all-scroll" class="draggable2" data-value='{{ $v }}'>{{ trans('adtable.ad_table_total_'.$v) }}<div>{{ $v }}:</div></span>
				@endforeach
			</div>
			
		</div>
	</div>	
</div>

<div class="col-md-10">
	<div class="col-md-6 chart-bg" style="min-height:100px;">
		<div class="box box-primary">	
			<div class="box-header">
				<div class="pull-right box-tools">
                	<button type="button" class="btn bg-teal btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
                  	<i class="fa fa-minus"></i></button>
              	</div>
				<i class="fa fa-edit"></i><h3 class="box-title">表格列自定义</h3>
			</div>
			<div class="box-body">
				<div class="table_style">
					<form data-key="ad.table">
						<input type="hidden" name="type" value="ad.table">
						<table class="form-table">
							<thead>
								<tr>
									<th>自定义名称</th>
									<th>自定义值</th>
									<th>统计函数</th>
									<th width="60">{{ trans('adtable.ad_table_style_colsort') }}</th>
								</tr>
							</thead>
							<tbody class="style-col-body">	
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4">
										<a class="help"><i class="fa fa fa-info"></i></a>
										<button class="form-save">{{ trans('adtable.ad_table_style_save') }}</button>
										<button class="col-add">{{ trans('adtable.ad_table_style_add') }}</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</form>	
				</div>
			</div>
		</div>	
		
		<div class="box box-primary">	
			<div class="box-header">
				<div class="pull-right box-tools">
                	<button type="button" class="btn bg-teal btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
                  	<i class="fa fa-minus"></i></button>
              	</div>
				<i class="fa fa-edit"></i><h3 class="box-title">曲线图Y轴自定义</h3>
			</div>
			<div class="box-body">
				<div class="table_style">
					<form data-key="ad.lines">
						<input type="hidden" name="type" value="ad.lines">
						<table class="form-table">
							<thead>
								<tr>
									<th>自定义名称</th>
									<th>自定义值</th>
									<th>使用函数</th>
									<th width="60">{{ trans('adtable.ad_table_style_colsort') }}</th>
								</tr>
							</thead>
							<tbody class="style-col-body">	
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4">
										<a class="help"><i class="fa fa fa-info"></i></a>
										<button class="form-save">{{ trans('adtable.ad_table_style_save') }}</button>
										<button class="col-add">{{ trans('adtable.ad_table_style_add') }}</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</form>	
				</div>
			</div>
		</div>	
	</div>
	
	<div class="col-md-6 chart-bg" style="min-height:100px;">
		<div class="box box-primary">	
			<div class="box-header">
				<div class="pull-right box-tools">
                	<button type="button" class="btn bg-teal btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse">
                  	<i class="fa fa-minus"></i></button>
              	</div>
				<i class="fa fa-edit"></i><h3 class="box-title">统计图Y轴自定义</h3>
			</div>
			<div class="box-body">
				<div class="table_style">
					<form data-key="ad.bars">
						<input type="hidden" name="type" value="ad.bars">
						<table class="form-table">
							<thead>
								<tr>
									<th>自定义名称</th>
									<th>自定义值</th>
									<th>使用函数</th>
									<th width="60">{{ trans('adtable.ad_table_style_colsort') }}</th>
								</tr>
							</thead>
							<tbody class="style-col-body">	
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4">
										<a class="help"><i class="fa fa fa-info"></i></a>
										<button class="form-save">{{ trans('adtable.ad_table_style_save') }}</button>
										<button class="col-add">{{ trans('adtable.ad_table_style_add') }}</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</form>	
				</div>
			</div>
		</div>	
	</div>
</div>





<script type="text/template" name="style-form">  
<tr>
	<td><input name="name[]" value="{name}"></td>
	<td><input name="value[]" value="{value}"></td>
	<td><input class="droppable2" name="total[]" value="{total}"></td>
	<td>
		<a onclick="colDel(this)"><i class="fa fa-close"></i></a>
		<a class="handle"><i class="fa fa-arrows"></i></a>
	</td>
</tr>
</script> 

<script type="text/javascript" src="{{ asset('/plugins/jquery-ui-1.12.0/jquery-ui.min.js')}}"></script>
<script type="text/javascript">

	

var styleColhtml = $('script[name=style-form]').html();


getForm('ad.lines');
getForm('ad.table');
getForm('ad.bars');



var fixHelper = function(e, ui) {  
    //console.log(ui)  
    ui.children().each(function() {  
        $(this).width($(this).width());     //在拖动时，拖动行的cell（单元格）宽度会发生改变。在这里做了处理就没问题了  
    });  
    return ui;  
};  

function formatTemplate(dta, tmpl) {  
    var format = {  
        toKey : function(x){
        	if(keyJson[x] != undefined ){
        		return keyJson[x];
        	}
        	return x;
        },
        status : function(x){
        	alert(x);
        }
    };  

    return tmpl.replace(/{(.*)}/g, function(m1, m2) {  

        if(!m2) return "";  
        return dta[m2]; 

    });  
} 


function colDel(obj){
	var $objTr = $(obj).parents('tr').remove();
}

$('.col-add').click(function(event) {
	var html = $(styleColhtml);
	html.find(".droppable2").droppable({
		accept: ".draggable2",
      	drop: function( event, ui ) {
      		$(this).val(ui.draggable.attr('data-value'));
      	}
    });
	$(this).parents('tfoot').prev('tbody').append(html);
	return false;
});


function fillTable(obj,$data){
	var html = $('script[name="style-form"]').html();  
	obj.html('');
    var arr = [];  
    $.each($data, function(i, o) {   
        var html = $(formatTemplate(o, styleColhtml));
   		obj.append(html);
   		html.find(".droppable2").droppable({
			accept: ".draggable2",
	      	drop: function( event, ui ) {
	      		console.log(123);
	      		$(this).val(ui.draggable.attr('data-value'));
	      	}
   		});	
    });  

   

}

$('.form-save').click(function(){
	window.sessionStorage.removeItem('tableorder');
	var _this = $(this).parents('.table_style');
	_this.covermask({text:loading_img});
	$.ajax({
		url: "{{ route($path.'.store') }}",
		data: _this.find('form').serialize(),
		type: "post",
		dataType: "json",
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
		success: function(d){
			if(!d  || d['e'] == 1) return false;
			fillTable(_this.find('.style-col-body'),d['d']);
		},
		complete:function(){
			_this.hidemask();
		}
	});
	return false;
});

function getForm(form){
	$('.table_style').covermask({text:loading_img});
	var $body = $('.chart-bg').find('form[data-key="'+ form +'"]').find('.style-col-body');
	$.ajax({
		url: "{{ route($path.'.show',1) }}",
		data: {'table':form},
		type: "get",
		dataType: "json",
		success: function(d){
			if(!d  || d['e'] == 1) return false;
			fillTable($body,d['d']);
			$body.sortable({
				helper: fixHelper,
				handle: ".handle",
				axis: "y",
				receive:function(event,ui){
					var o = {
						'value':ui.helper.attr('data-key'),
						'name':ui.helper.attr('data-value'),
						'total':''
					};
					var html = $(formatTemplate(o, styleColhtml));
					html.find(".droppable2").droppable({
		    			accept: ".draggable2",
				      	drop: function( event, ui ) {
				      		$(this).val(ui.draggable.attr('data-value'));
				      	}
				    });
					ui.helper.before(html);
					ui.helper.remove();
				}
			});
    		$('.style-col-body').disableSelection();

		},
		complete:function(){
			$('.table_style').hidemask();
		}
	});
}

$( ".draggable" ).draggable({
	revert: "invalid",
	helper: "clone",
	connectToSortable: ".style-col-body",
});	

$( ".draggable" ).disableSelection();

$('.draggable2').draggable({
	revert: "invalid",
	helper: "clone",
});	


$('.chart-bg').sortable({
	connectWith: ".chart-bg",
	handle: ".box-header",
    cancel: "button",
    placeholder: "sort-highlight",
});


</script>


	
@endsection
