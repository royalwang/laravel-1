@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection

@section('style')
@parent
<link href="{{ asset('/css/home.css') }}" rel="stylesheet">
@endsection


@section('main-content')

<div id="fixed-header"><div id="fixed-header-content"></div></div>
<div class="cover">
	<div class="cover-bg"></div>
	<div class="cover-content">
		<span></span>
	</div>
</div>	
<div class="adtable">
	<table class="form-table">
		<thead>
			<th class="current_date" width="">
				<input class="year" type="" name="year" value="{{ $date['year'] }}" maxlength="4"> 
				<input class="month" type="" name="month" value="{{ $date['month'] }}" maxlength="2">
			</th>
		@foreach($table_column_name as $key=>$v)
			<th class="db-{{ $key }}">{{ $v['name'] }}</th>
		@endforeach
		</thead>

		<tbody class="adtable-content-center">
		@for ($i=1;$i<=$date['num'];$i++)
			<tr data-date="{{ $i }}" data-id="0">
				<td class="current_date">{{ $i }}</td>
				@foreach($table_column_name as $key=>$v)
				<td class="db-{{ $key }}" data-name="{{ $v['key'] }}">
					<div></div>
					@if ( $v['edit'] == true )
					<input autocomplete="off" name="{{ $v['key'] }}" value="" />
					@else
					<input name="{{ $v['key'] }}" value="" disabled="disabled" />
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

var $cover = $('.cover');
var $cover_bg = $('.cover-bg');
var $cover_content = $('.cover-content');

var $ajax_btn = $('.adtable-footer-header li');
var $body = $('.adtable-content-center');
var $foot = $('.adtable tfoot');
var $first_load = $ajax_btn.eq(0);

var table_edit = {{ $table_edit }};
var loading_img = '<img src="{{ asset('img/loading.gif') }}">';
var current_data = [];
var current_switch_id = $first_load.attr('data-id');
var current_eidt_row = -1;
var current_date = getDate();
var head_status = false;


if(current_switch_id == undefined){
	coverShow('{{ trans('adtable.no_account') }}')
}else{
	$first_load.addClass('active');
	getTableData();

	if(table_edit == 1) bindDBclick();
	bindTab();
}

coverInit();

$(window).resize(coverInit);
$(window).resize(headShow);


function coverShow(html ='',sw = true){
    if(sw == true)
        $cover.addClass('show');
    else
        $cover.removeClass('show');
    $cover_content.children('span').html(html);
}

function coverInit(){
    

    var cover_width = $cover.next().outerWidth();
    var cover_height = $cover.next().outerHeight();

    var content_width = $('.cover-content').outerWidth();
    var content_height = $('.cover-content').outerHeight();

    $cover_bg.css({
        'width':cover_width,
        'height':cover_height,
    });

    $cover_content.css({
        'left': (cover_width-content_width)/2 + 'px',
        'top': (cover_height-content_height)/2-100 + 'px',
    })

}

$('.current_date').unbind('keyup');
$('.current_date').bind('keyup',function(event){
	if(event.keyCode == "13"){
		current_date = $(this).find('input[name=year]').val() + "/" + $(this).find('input[name=month]').val();
		getTableData();

	}
});

function getDate(){
	return $('.current_date').find('input[name=year]').val() + "/" + $('.current_date').find('input[name=month]').val();
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
	if(! d.id) return;
	obj.attr('data-id',d.id);
	@foreach($table_column_name as $key=>$v)
	obj.find('td[data-name="{{ $v['key'] }}"]').children('div').html(d['{{ $v['key'] }}']);
	@endforeach
}

function getTableData(){
	coverShow(loading_img);
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
		},
		complete:function(){
			coverShow('',false);
			headShow();
		}
	});
	
}

function updateTableData(obj,new_data){
	coverShow(loading_img);
	$.ajax({
		url: "{{ asset('/ajax/adtable/update') }}",
		data: new_data,
		type: "post",
		dataType: "json",
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
		success: function(e){
			if(e['e'] != 1 || e != undefined){
				addToTableRow(obj,e['d']);
			}
		},
		complete: function(){
			current_eidt_row = -1;
			coverShow('',false);
			headShow();
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
        	if(o != n) {
        		update_data[$(this).attr('data-name')] = $(this).children('input').val();
        		status = true;
        	}

        	
         		
        	
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

function headShow(){
	$('#fixed-header-content').html('');
	$('#fixed-header-content').css({
		width:$('.form-table thead').outerWidth() + 'px',
	});

	$('.form-table thead tr th').each(function(index, el) {
		var div = $(this).clone();
		div.css({
			width: $(this).outerWidth(),
		});

		$('#fixed-header-content').append(div);
	});
	$('#fixed-header-content').show();

}

function headHide(){
	$('#fixed-header-content').html('').hide();
}

$(window).trigger('resize');


$(document).bind('mousewheel DOMMouseScroll', function(event, delta) {

	var top = $('.form-table thead').offset().top;
	var stop = $(document).scrollTop();

	if(stop > top ){
		
		if(head_status != true){
			headShow();
		}
		
	}else{
		head_status = false;
		headHide();	
	}
});



</script>
	
@endsection
