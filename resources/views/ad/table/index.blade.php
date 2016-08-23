@extends('ad.app')

@section('htmlheader_title')
	Home
@endsection

@section('style')
@parent
<link href="{{ asset('/css/home.css') }}" rel="stylesheet">
@endsection


@section('main-content')

<div class="adtable">
	<div id="fixed-header"><div id="fixed-header-content"></div></div>
	<div id="fixed-footer"><div id="fixed-footer-content"></div></div>
	<table class="form-table">
		<thead>
			<th class="current_date" width="">
				<input class="year" type="text" name="year" > 
				<input class="month" type="text" name="month" >
			</th>
		@foreach($table_column_name as $key=>$v)
			<th class="db-{{ $key }}">{{ $v['name'] }}</th>
		@endforeach
		</thead>

		<tbody class="adtable-content-center">
		@for ($i=1;$i<=31;$i++)
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
		<tfoot class="adtable-content-foot">
			<tr data-date="-1" data-id="-1">
				<td class="current_date">统计</td>
				@foreach($table_column_name as $key=>$v)
				<td class="db-{{ $key }}" data-name="{{ $v['key'] }}" data-total="{{ $v['total'] }}">
					<div></div>
				</td>
				@endforeach
			</tr>
		</tfoot>
	</table>
	
	<ul class="adtable-footer-header clearfix">
		@foreach ($switch_tab as $v) 
			<li data-id="{{ $v->id }}" class="status status-{{ $v->ad_account_status_id }}"><a>{{ isset($v->name)?$v->name:$v->code }}</a>	
			</li>
		@endforeach
		<li><span id="add-account"><i class="fa fa-plus fa-2x"></i></span></li>
	</ul>
</div>	

<script type="text/template" name="add-account">  
<div class="add-account clearfix">
	<div class="left">
		<h3>广告账户</h3>
		<ul class="ad-account">
			@for( $i=1;$i<100;$i++ )
			<li>12</li>
			@endfor
		</ul>
	</div>
	<div class="left">
		<h3>广告VPS</h3>
		<ul class="ad-vps">
			@for( $i=1;$i<100;$i++ )
			<li>12</li>
			@endfor
		</ul>
	</div>
	<div class="left">
		<h3>网站</h3>
		<ul class="ad-site">
			@for( $i=1;$i<100;$i++ )
			<li>12</li>
			@endfor
		</ul>
	</div>
	<button class="btn btn-inverse">{{ trans('message.btn_save')}}</button>
	<button class="btn btn-inverse" onclick="return addAccountCancel();">{{ trans('message.btn_cancel')}}</button>
</div>	
</script>

<script type="text/javascript">


$('#add-account').click(function(event) {
	var html = $('script[name=add-account]').html();
	$(this).covermask({text:html,cstyle:{width:730,position:'fixed',top:'100'}});
});


function addAccountCancel(){
	$('#add-account').hidemask();
	return false;
}

var $ajax_btn = $('.adtable-footer-header li a');
var $body = $('.adtable-content-center');
var $foot = $('.adtable tfoot');
var $first_load = $ajax_btn.parent('li').eq(0);

var table_edit = {{ $table_edit }};
var current_data = [];
var current_switch_id = $first_load.attr('data-id');
var current_eidt_row = -1;

var current_date ;
var head_status = false;
var tfoot_status = false;
var time = new Date();

var window_height = $(window).height();
var th_top = $('.form-table thead').offset().top;
var tf_top = $('.form-table tfoot').offset().top;
var ft_top = $('.adtable-footer-header').offset().top;

setDate(time.getFullYear(),time.getMonth()+1);
getDte();


if(current_switch_id == undefined){
	$('.adtable').covermask({text:'{{ trans('adtable.no_show') }}'});
}else{
	$first_load.addClass('active');
	getTableData();

	if(table_edit == 1) $body.find('td[class^="db-"]').on('dblclick',editTable);
	bindTab();
}

$(window).resize(function(){
	window_height = $(window).height();
	headShow();
	tfootShow();
});


$('.adtable-footer-header li.status').hover(function() {
	$(this).children('div').show();
}, function() {
	$(this).children('div').hide();
});


$('.current_date').bind('keyup',function(event){
	if(event.keyCode == "13"){
		setDate($(this).find('input[name=year]').val(),$(this).find('input[name=month]').val());
		getDte();

		var time1 = new Date(current_date);
		var time2 = new Date();
		if(time1.getTime() > time2.getTime()){
			$body.covermask({text:'error time'});
			return false;
		}else{
			$body.hidemask();
			getTableData();
			return false;
		}		
	}
});

function getDays(){
	var date = new Date(current_date);
	var y = date.getFullYear();
	var m = date.getMonth() + 1;
	if(m == 2){
		return y % 4 == 0 ? 29 : 28;
	}else if(m == 1 || m == 3 || m == 5 || m == 7 || m == 8 || m == 10 || m == 12){
		return 31;
	}else{
		return 30;
	}
}

function getDte(){
	current_date = $('.current_date').children('input').eq(0).val() + "/" + $('.current_date').children('input').eq(1).val();
}

function setDate(year,month){
	$('.current_date').find('input[name=year]').val(year); 
	$('.current_date').find('input[name=month]').val(month); 
}

function removeEdit(){
	$body.find('tr[class="edit"]').removeClass('edit');
}

function bindDBclick(){
	
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

function getTotal(){
	$('.adtable-content-foot').find('td[class^="db-"]').each(function(index, el) {
		$type = $(this).attr('data-total');
		$key = $(this).attr('data-name');
		if($type == undefined || !$key || !$type) return '';
        switch ($type) {
            case 'sum':
            	var sum = 0;
            	$body.find('td[data-name="'+ $key +'"]').each(function(index, el) {
            		var v = $(this).find('div').html();
            		if(v==undefined || !v ) v = 0;
            		sum += parseFloat(v*100000);
            	});
            	sum = sum / 100000;
            	$(this).html('Sum : '+sum);
                break;
            case 'avg':
                var sum = 0;
                var i =0;
            	$body.find('td[data-name="'+ $key +'"]').each(function(index, el) {
            		var v = $(this).find('div').html();
            		if(v==undefined || !v ) v = 0;
            		sum += parseFloat(v*100000);
            		i++;
            	});
            	sum = sum / 100000;
            	var avg = sum/i;
            	$(this).html('Avg : '+avg.toFixed(4));
                break;
            case 'max':
            	var max = 0;
            	$body.find('td[data-name="'+ $key +'"]').each(function(index, el) {
            		var v = $(this).find('div').html();
            		if( v==undefined || !v ) v = 0;
            		v = parseFloat(v);
            		if(v > max) max = v;
            	});
                $(this).html('Max : '+max);
                break;
            case 'min':
                var min = 99999999;
            	$body.find('td[data-name="'+ $key +'"]').each(function(index, el) {
            		var v = $(this).find('div').html();
            		if( v==undefined || !v ) v = 0;
            		v = parseFloat(v);
            		if(v < min) min = v;
            	});
                $(this).html('Min : '+min);
                break;    
            default:
                $(this).html('');
                break;
        }
	});
}


function classToggle(){
	$parent = $(this).parent('li');
	if($parent== 'active') return;
	$parent.siblings().removeClass('active');
	$parent.addClass('active');
	unbindTab();
	current_switch_id = $parent.attr('data-id');
	getTableData();	
	bindTab();
}

function clearTable(){
	var num = getDays();
	$body.find('tr').each(function(index) {
		$(this).attr('data-id',0);
		if(index >= num) 
			$(this).addClass('hidden');
		else
			$(this).removeClass('hidden');
	});
	$body.find('td[class^="db-"]').each(function(index) {
		$(this).children('div').html('');
		$(this).children('input').val('');
	});
}

function addToTable(obj){
	for(var d in obj){
		var jdate = new Date(obj[d].date * 1000);
		var date_num = jdate.getDate();
		var current_tr = $body.find('tr[data-date='+ date_num +']').eq(0);
		addToTableRow(current_tr,obj[d]);
	}
}

function addToTableRow(obj,d){
	obj.attr('data-id',d.id);
	@foreach($table_column_name as $key=>$v)
	obj.find('td[data-name="{{ $v['key'] }}"]').children('div').html(d['{{ $v['key'] }}']);
	@endforeach
}

function getTableData(){
	$('.adtable table').covermask({text:loading_img});
	clearTable();
	removeEdit();
	$.ajax({
		url: "{{ asset('/a/adtable') }}",
		data: {'id': current_switch_id ,'date':current_date},
		type: "get",
		dataType: "json",
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
		success: function(e){
			if(e['e'] == 1 || e == undefined){
				clearTable();
			}else{
				addToTable(e['d']);	
				getTotal();			
			}
		},
		complete:function(){
			$('.adtable table').hidemask();
			tfootShow();
			headShow();
		}
	});
	
}

function updateTableData(obj,new_data){
	$('.adtable table').covermask({text:loading_img});
	$.ajax({
		url: "{{ asset('/a/adtable') }}",
		data: new_data,
		type: "post",
		dataType: "json",
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
		success: function(e){
			//console.log(e);
			if(e['e'] != 1 || e != undefined){
				addToTableRow(obj,e['d']);
				getTotal();
			}
		},
		complete: function(){
			current_eidt_row = -1;
			$('.adtable table').hidemask();
			tfootShow();
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
	var stop = $(document).scrollTop();
	if(stop < th_top ||  head_status == true) return headHide();
		

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
	$('#fixed-header').show();
}

function headHide(){
	head_status = false;
	$('#fixed-header').hide();
}

function tfootShow(){
	var stop = $(document).scrollTop();
	if(stop > (tf_top-window_height+20) ||  tfoot_status == true) return tfootHide();
		

	$('#fixed-footer-content').html('');
	$('#fixed-footer-content').css({
		width:$('.form-table tfoot').outerWidth() + 'px',
	});

	$('.form-table tfoot tr td').each(function(index, el) {
		var div = $(this).clone();
		div.css({
			width: $(this).outerWidth(),
		});

		$('#fixed-footer-content').append(div);
	});
	$('#fixed-footer').show();
}

function tfootHide(){
	tfoot_status = false;
	$('#fixed-footer').hide();
}

function footShow(){
	var stop = $(document).scrollTop();
	if(stop > (ft_top-window_height+20)) return footHide();
	$('.adtable-footer-header').addClass('scroll');
}

function footHide(){
	$('.adtable-footer-header').removeClass('scroll');
}

$(window).trigger('resize');


$('.adtable-footer-header').scrollFixed();

$(document).scroll(function() {
	headShow();
	tfootShow();
});



</script>
	
@endsection
