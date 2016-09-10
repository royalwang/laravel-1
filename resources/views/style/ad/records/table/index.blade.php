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
	
	
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h2 class="title"> {{ trans('adtable.ad_table_style_title') }}</h2>
		</div>	
	</div>
	<div class="row">
		<div class="col-md-12">
			<h4> {{ trans('adtable.ad_table_style_col') }}</h4>
		</div>	

		<div class="col-md-2">
			<div class="default-col">
				@foreach($style as $k=>$v)
				<span class="draggable" data-value="{{ trans('adtable.'.$v) }}" data-key="A{{ $k }}">{{ trans('adtable.'.$v) }}<div>A{{ $k }}:</div></span>
				@endforeach
			</div>
		</div>
		<div class="col-md-2">
			<div class="default-col">
				@foreach($total as $v)
				<span class="draggable2" data-value='{{ $v }}'>{{ trans('adtable.ad_table_total_'.$v) }}<div>{{ $v }}:</div></span>
				@endforeach
			</div>
		</div>
		<div class="col-md-8">
			
			<div class="table_style">
				<form name="col_table">
					<table class="form-table">
						<thead>
							<tr>
								<th>{{ trans('adtable.ad_table_style_colname') }}</th>
								<th>{{ trans('adtable.ad_table_style_colvalue') }}</th>
								<th>{{ trans('adtable.ad_table_style_coltotal') }}</th>
								<th width="60">{{ trans('adtable.ad_table_style_colsort') }}</th>
							</tr>
						</thead>
						<tbody id="style-col-body">	
						</tbody>
						<tfoot>
							<tr>
								<td colspan="4">
									<a class="help"><i class="fa fa fa-info"></i></a>
									<button onclick="return saveForm();">{{ trans('adtable.ad_table_style_save') }}</button>
									<button onclick="return colAdd();">{{ trans('adtable.ad_table_style_add') }}</button>
								</td>
							</tr>
						</tfoot>
					</table>
				</form>	
			</div>
		</div>
		
	</div>


	<div class="row">
		<div class="col-md-12">
			<div class="line1"></div>
		</div>

		<div class="col-md-2">
			<h4> {{ trans('adtable.ad_table_style_sum') }}</h4>
		</div>	
		<div class="col-md-10">

			<div class="col-md-4">
				<div class="col-md-6">
					<label style="line-height: 41px;">是否显示</label>
				</div>	
				<div class="col-md-6">
					<div class="controls">
					<label class="radio"><input type="radio" value="True" name="show" checked="checked">
					True</label>
					<label class="radio"><input type="radio" value="False" name="show">False</label>
					</div>
				</div>	
			</div>

			<div class="col-md-4">
				<div class="col-md-6">
					<label style="line-height: 41px;">显示位置</label>
				</div>	
				<div class="col-md-6">	
					<div class="controls">
					<label class="checkbox"><input type="checkbox" value="Top">Top</label>
					<label class="checkbox"><input type="checkbox" value="Bottom">Bottom</label>
					</div>
				</div>
			</div>

			<div class="col-md-4">
			<div class="control-group">
				<label class="control-label"></label>
				<div class="controls"><button class="btn btn-inverse">Sumbit</button></div>
			</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="line1"></div>
		</div>
		<div class="col-md-3">
			<h4> {{ trans('adtable.ad_table_style_account') }}</h4>
		</div>	
		<div class="col-md-9">
			show , hidden , top , bottom , left , right
		</div>			
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="line1"></div>
		</div>	
		<div class="col-md-3">
			<h4> {{ trans('adtable.ad_table_style_sort') }}</h4>
		</div>	
		<div class="col-md-9">
			asc , desc
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

	

var $styleColBody = $('#style-col-body');
var styleColhtml = $('script[name=style-form]').html();

getForm();


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

function colAdd(){
	var html = $(styleColhtml);
	html.find(".droppable2").droppable({
		accept: ".draggable2",
      	drop: function( event, ui ) {
      		$(this).val(ui.draggable.attr('data-value'));
      	}
    });
	$styleColBody.append(html);
	return false;
}

function fillTable($data){
	var html = $('script[name="style-form"]').html();  
	$styleColBody.html('');
    var arr = [];  
    $.each($data, function(i, o) {   
        var html = $(formatTemplate(o, styleColhtml));
        html.find(".droppable2").droppable({
			accept: ".draggable2",
	      	drop: function( event, ui ) {
	      		$(this).val(ui.draggable.attr('data-value'));
	      	}
   		});
   		$styleColBody.append(html);
    });  

   

}

function getForm(){
	ajaxForm();
	return false;
}

function saveForm(){
	window.sessionStorage.removeItem('tableorder');
	$('.table_style').covermask({text:loading_img});
	$.ajax({
		url: "{{ route($path.'.store') }}",
		data: $("form[name=col_table]").serialize(),
		type: "post",
		dataType: "json",
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
		success: function(d){
			if(!d  || d['e'] == 1) return false;
			fillTable(d['d']);
		},
		complete:function(){
			$('.table_style').hidemask();
		}
	});
	return false;
}

function ajaxForm($data = ''){
	$('.table_style').covermask({text:loading_img});
	$.ajax({
		url: "{{ route($path.'.show',1) }}",
		data: $data,
		type: "get",
		dataType: "json",
		success: function(d){
			if(!d  || d['e'] == 1) return false;
			fillTable(d['d']);
			$('#style-col-body').sortable({
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
    		$('#style-col-body').disableSelection();

		},
		complete:function(){
			$('.table_style').hidemask();
		}
	});
}

var left_to_right = 0;
var current_drag = $([]);

$( ".draggable" ).draggable({
	revert: "invalid",
	helper: "clone",
	connectToSortable: "#style-col-body",
});	

$( ".draggable" ).disableSelection();

$('.draggable2').draggable({
	revert: "invalid",
	helper: "clone",
});	




</script>


	
@endsection
