@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection

@section('style')
@parent
<link href="{{ asset('/css/home.css') }}" rel="stylesheet">
@endsection


@section('main-content')
	
	
<div class="adtable">	
	<table class="form-table">
		<thead>
			<td class="current_date">
				<div id="current_date">{{ $date['year'].' / '.$date['month'] }}</div>
				<input class="year" type="" name="year" value="{{ $date['year'] }}" maxlength="4"> 
				<input class="month" type="" name="month" value="{{ $date['month'] }}" maxlength="2">
			</td>
		@foreach($table_column_name as $key=>$v)
			<th class="db-{{ $key }}">{{ trans('adtable.'. $key) }}</th>
		@endforeach
		</thead>

		<tbody class="adtable-content-center">
		@for ($i=1;$i<=$date['num'];$i++)
			<tr data-date="{{ $i }}" data-id="0">
				<td class="current_date">{{ $i }}</td>
				@foreach($table_column_name as $key=>$v)
				<td class="db-{{ $key }}" data-name="{{ $key }}">
					<div></div>
					@if ($v['type'] == 'input')
					<input autocomplete="off" name="{{ $key }}" value="" />
					@else
					<input name="{{ $key }}" value="" disabled="disabled" />
					@endif
				</td>
				@endforeach
			</tr>
		@endfor
		</tbody>

		<tfoot></tfoot>
	</table>
	
	<ul class="adtable-footer-header clearfix">
		@foreach ($switch_tab as $v) 
			<li data-id="{{ $v->id }}"><a>{{ isset($v->name)?$v->name:$v->code }}</a></li>
		@endforeach
	</ul>
</div>	

<script type="text/javascript">



var $ajax_btn = $('.adtable-footer-header li');
var $body = $('.adtable-content-center');
var $foot = $('.adtable tfoot');
var $first_load = $ajax_btn.eq(0);

var table_edit = {{ $table_edit }}
var current_data = [];
var current_switch_id = $first_load.attr('data-id');
var current_eidt_row = -1;
var current_date = $('#current_date').html();


$first_load.addClass('active');
getTableData();
if(table_edit == 1) bindDBclick();
bindTab();
dateClick();

function dateClick(){
	$('.current_date').click(function() {
		$(this).addClass('edit');
		$(this).bind('keyup',function(event){
			$('.current_date').unbind('click');
			if(event.keyCode == "13"){
				window.location.reload();
			}
		})
	});
}

function removeEdit(){
	$body.find('tr[class="edit"]').removeClass('edit');
}

function bindDBclick(){
	unbindDBclick();
	$body.find('td[class^="db-"]').bind('dblclick',editTable);
}

function unbindDBclick(){
	$body.find('td[class^="db-"]').unbind('dblclick');
}

function unbindKeyup(){
	$body.find('tr').unbind('keyup');
}

function bindTab(){
	$ajax_btn.bind('click',classToggle);
}

function unbindTab(){
	$ajax_btn.unbind('click');
}


function classToggle(){
	if($(this).attr('class') == 'active') return;
	$(this).siblings().removeClass('active');
	$(this).addClass('active');
	unbindTab();
	current_switch_id = $(this).attr('data-id');
	getTableData();	
	bindTab();
}

function clearTable(){
	$body.find('tr').attr('data-id',0);
	$body.find('td[class^="db-"]').each(function() {
		$(this).children('div').html('');
		$(this).children('input').val('');
	});
}

function addToTable(obj){
	for(var d in obj){
		var jdate = new Date(obj[d].date * 1000);
		var date_num = jdate.getDate();
		var current_tr = $body.find('tr[data-date='+ date_num +']').eq(0);

		current_tr.attr('data-id',obj[d].id);
		addToTableRow(current_tr,obj[d]);
	}
}

function addToTableRow(obj,d){
	obj.attr('data-id',d.id);
	@foreach($table_column_name as $key=>$v)
	obj.find('td[data-name="{{ $key }}"]').children('div').html(d.{{ $key }});
	@endforeach
}

function getTableData(){
	clearTable();
	removeEdit();

	$.ajax({
		url: "{{ asset('/ajax/adtable') }}",
		data: {'id': current_switch_id ,'date':current_date},
		type: "post",
		dataType: "json",
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
		success: function(e){
			if(e['e'] == 1 || e == undefined){
				clearTable();
			}else{
				addToTable(e['d']);				
			}
		}
	});
}

function updateTableData(obj,new_data){
	$.ajax({
		url: "{{ asset('/ajax/adtable/update') }}",
		data: new_data,
		type: "post",
		dataType: "json",
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
		success: function(e){
			if(e['e'] != 1 || e != undefined){
				addToTableRow(obj,new_data);
			}
		},
		complete: function(){
			current_eidt_row = -1;
		}
	});
}


function editTable(){
	var $parent = $(this).parent('tr');
	
	if(current_eidt_row == $parent.index()) return false;
	current_eidt_row = $parent.index()


	$parent.addClass('edit').siblings().removeClass('edit');
	$parent.children('td[class^="db-"]').each(function() {
		var width = $(this).width()-10;
		$(this).unbind('dblclick');
		$(this).children('input').css({'width': width+'px'});
		$(this).children('input').val($(this).children('div').html());
	});
	
	$(this).children('input').focus().val($(this).children('div').html()); 

	$parent.unbind('keyup');
	$parent.bind('keyup',listernKeyCode);

	return false;
}

function listernKeyCode(){
    if(event.keyCode == "13") {
        var update_data = {};
        var status = false;

        $(this).children('td[class^="db-"]').each(function(){
        	var o = $(this).children('div').html();
        	var n = $(this).children('input').val();
        	if(o != n) status = true;
         	update_data[$(this).attr('data-name')] = $(this).children('input').val();
        });

		update_data['id'] = $(this).attr('data-id');
        update_data['ad_account_id'] = current_switch_id;
        update_data['date'] = current_date + ' / ' + $(this).children('td[class="current_date"]').html();

        if(status) 
        	updateTableData($(this) , update_data); 

		$(this).removeClass('edit');	
    }else if(event.keyCode == "27"){
    	$(this).removeClass('edit');
    	current_eidt_row = -1;    
    }
}

</script>
	
@endsection
