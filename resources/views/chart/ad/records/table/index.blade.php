@extends('layouts.app')

@section('htmlheader_title')
	每月数据报表
@endsection

@section('style')
@parent
<link href="{{ asset('/css/home.css') }}" rel="stylesheet">
<link href="{{ asset('plugins/dragtable/css/dragtable.css') }}" rel="stylesheet">

@endsection

@section('control-sidebar-settings')
<style>
	.ui-state-highlight{
		height:25px;
		background: #fff;
	}
	.disabled.btn{
		cursor: not-allowed;
	}
</style>
<div class="form-group">
	<label>已绑定的账号</label>
	<ul style="max-height:800px;overflow-y:scroll" class="float-account">
	@foreach ($switch_tab as $v) 
	<li style="padding:2px;"><span class="btn btn-block btn-danger btn-sm" data-value="{{ $v->id }}" data-id="{{ $v->id }}">{{ $v->account->code }} - {{ $v->vps->ip }}</span></li>
	@endforeach
	</ul>
</div>
<script type="text/javascript">
	$(document).ready(function($) {
		$('.control-sidebar-tabs > li').eq(2).children('a').trigger('click');
	});
	

	$('.float-account').sortable({
		placeholder: "ui-state-highlight",
		helper : "clone",
	});

	$('.float-account').disableSelection();
	$('.form-table').droppable({
		accept:'.float-account > li',
		drop:function(event, ui){
			ui.draggable.find('span').addClass('disabled')
			ui.draggable.siblings('li').find('span').removeClass('disabled');
			current_switch_id = ui.draggable.find('span').attr('data-id');
			getTableData();
		}
	});
</script>
@endsection

@section('main-content')

<style type="text/css">
section.content{
	padding: 0;
}
.fixed{
  top:0;
  position:fixed;
  width:auto;
  display:none;
  border:none;
}

.scrollMore{
  margin-top:600px;
}
.bind-information{
	border: 1px solid #000;
	background-color:#fff;
	height: 36px;
	line-height: 35px;
}
.bind-information > .information{
}
.red{
	padding:0 3px;
	color: red;
	font-size: 10px;
}
</style>

<div class="adtable">
	<div id="fixed-header"><div id="fixed-header-content"></div></div>
	<div id="fixed-footer"><div id="fixed-footer-content"></div></div>
	<table class="form-table">
		<thead>
			<tr>
			<th id="A-1" class="current_date" width="">
				<input class="year" type="text" name="year" > 
				<input class="month" type="text" name="month" >
			</th>
			@foreach($table_column_name as $key=>$v)
			<th id="{{ $v['key'] }}" class="db-{{ $key }} accept">{{ $v['name'] }}</th>
			@endforeach
			</tr>
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
	<div class="bind-information">
		<div class="col-md-5 information">
			<label>账号信息:</label><span class="red" data-key="account"></span>
		</div>	
		<div class="col-md-3 information">
			<label>vps信息:</label><span class="red" data-key="vps"></span>
		</div>	
		<div class="col-md-3 information">
			<label>网站信息:</label><span class="red" data-key="site"></span>
		</div>	
		<div class="col-md-1 information">
			<label>余额:</label><span class="red" data-key="money"></span>
		</div>
	</div>
	
</div>	


<script type="text/javascript">


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
var tf_top = $('.form-table tfoot').offset().top;

setDate(time.getFullYear(),time.getMonth()+1);
getDte();
$body.find('td[class^="db-"]').on('dblclick',editTable);



$('.adtable').covermask({text:'{{ trans('adtable.no_show') }}'});


$(window).resize(function(){
	window_height = $(window).height();
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

function addInformation(data){
	$('.bind-information').find('span[data-key=account]').html(data.account);
	$('.bind-information').find('span[data-key=vps]').html(data.vps);
	$('.bind-information').find('span[data-key=site]').html(data.site);
	$('.bind-information').find('span[data-key=money]').html(data.money);
}

function updateMoney(data){
	$('.bind-information').find('span[data-key=money]').html(data.money);
}

function getTableData(){
	$('.adtable').covermask({text:loading_img});
	clearTable();
	removeEdit();
	$.ajax({
		url: "{{ route('data.ad.records.ajax.index') }}",
		data: {'account_id': current_switch_id ,'date':current_date},
		type: "get",
		dataType: "json",
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
		success: function(e){
			if(e['e'] == 1 || e == undefined){
				clearTable();
			}else{
				addToTable(e['d']);	
				addInformation(e['i']);	
				getTotal();			
			}
		},
		complete:function(){
			$('.adtable').hidemask();
			tfootShow();
		}
	});
	
}

function updateTableData(obj,new_data){
	$('.adtable').covermask({text:loading_img});
	$.ajax({
		url: "{{ route('data.ad.records.ajax.store') }}",
		data: new_data,
		type: "post",
		dataType: "json",
		headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
		success: function(e){
			if(e['e'] != 1 || e != undefined){
				addToTableRow(obj,e['d']);
				getTotal();
				updateMoney(e['i']);
			}
		},
		complete: function(){
			current_eidt_row = -1;
			$('.adtable').hidemask();
			tfootShow();
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


function tfootShow(){
	var stop = $(document).scrollTop();
	if(stop > (tf_top-window_height) ||  tfoot_status == true) return tfootHide();
		

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


$(window).trigger('resize');


$(document).scroll(function() {
	tfootShow();
});


$('.bind-information').scrollFixed(0,'scroll');

</script>
<script type="text/javascript" src="{{ asset('plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/dragtable/js/jquery.dragtable.js') }}"></script>
<script type="text/javascript">

	$('.form-table').dragtable({
		dragaccept:'.accept',
		persistState: function(table) { 
			if (!window.sessionStorage) return; 
			var ss = window.sessionStorage; 
			table.el.find('th').each(function(i) { 
				if(this.id != '') {table.sortOrder[this.id]=i;} 
			}); 
			ss.setItem('tableorder',JSON.stringify(table.sortOrder)); 
	    }, 
	    restoreState: eval('(' + window.sessionStorage.getItem('tableorder') + ')') ,
	});

</script>


<script type="text/javascript">
  
  ;(function($) {
   $.fn.fixMe = function() {
      return this.each(function() {
         var $this = $(this),
            $t_fixed;
         function init() {	
            $t_fixed = $this.clone(true);
            $t_fixed.css({width:'auto'});
            $t_fixed.find("tbody").remove().end().find("tfoot").remove().end().addClass("fixed").insertBefore($this);
            resizeFixed();
         }
         function resizeFixed() {
            $t_fixed.find("th").each(function(index) {
               $(this).css({
               	"width": $this.find("th").eq(index).outerWidth()+"px"
               });
            });
         }
         function scrollFixed() {
         	resizeFixed();
            var offset = $(this).scrollTop(),
            tableOffsetTop = $this.offset().top,
            tableOffsetBottom = tableOffsetTop + $this.height() - $this.find("thead").height();
            if(offset < tableOffsetTop || offset > tableOffsetBottom)
               $t_fixed.hide();
            else if(offset >= tableOffsetTop && offset <= tableOffsetBottom && $t_fixed.is(":hidden"))
               $t_fixed.show();
         }
         $(window).resize();
         $(window).scroll(scrollFixed);
         $(this).find('td').resize(resizeFixed);
         init();
      });
   };
})(jQuery);

$('.form-table').fixMe();
</script>


	
@endsection
