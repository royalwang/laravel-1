@extends('layouts.app')

@section('htmlheader_title')
	财务管理
@endsection


@section('main-content')
<link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
<link rel="stylesheet" href="{{ asset('/plugins/fullcalendar/fullcalendar.min.css') }}">

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
	.fc-view-container *{
		-webkit-box-sizing:border-box;
		box-sizing:border-box;
	}
</style>

<div class="row">
	<div class="col-md-3">
		<div class="box box-solid">
			<div class="box-header with-border">
				<div class="pull-right box-tools">
	                <a class="btn btn-primary btn-sm pull-right" id="add_account">新增账户</a>
	             </div>
				<h4 class="box-title">我的账户</h4>
			</div>
			<div class="box-body">
				<div id="external-events">
				</div>
			</div>
		</div>



		<div class="box box-solid">
			<div class="box-header with-border">
				<div class="pull-right box-tools">
	                <a class="btn btn-primary btn-sm pull-right" id="add_rev_type">新增类别</a>
	             </div>
				<h4 class="box-title">收入来源</h4>
			</div>
			<div class="box-body">
				<div id="external-events1">
				</div>
			</div>
		</div>

		<div class="box box-solid">
			<div class="box-header with-border">
				<div class="pull-right box-tools">
	                <a class="btn btn-primary btn-sm pull-right" id="add_use_type">新增类别</a>
	             </div>
				<h4 class="box-title">支出用途</h4>
			</div>
			<div class="box-body">
				<div id="external-events2">
				</div>
			</div>
		</div>
    </div>

    <div class="col-md-6">
		<div class="box box-solid">
			<div class="box-header with-border">
				<h4 class="box-title">我的账单</h4>
			</div>
			<div class="box-body">
				<div id="calendar"></div>
			</div>
		</div>

    </div>

    <div class="col-md-3">
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              	<li class="active col-md-3"><a href="#tab_1" data-toggle="tab">收入</a></li>
              	<li class="col-md-3"><a href="#tab_2" data-toggle="tab">支出</a></li>
              	<li class="col-md-4"><a href="#tab_3" data-toggle="tab">转账/提现</a></li>
            </ul>
            <div class="tab-content">
              	<div class="tab-pane active" id="tab_1">
              		<form class="form-horizontal">
              			<input type="hidden" name="type" value="1">
              			<div class="form-group">
              				<label class="col-sm-3 control-label">金额</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-money"></i>
				                </div>
              					<input name="value" value="0" class="form-control" placeholder="0">
              				</div>
              			</div>

              			<div class="form-group">
              				<label class="col-sm-3 control-label">时间</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                </div>
              					<input name="date" value="{{ date('Y/m/d') }}" class="form-control datepicker" placeholder="">
              				</div>
              			</div>

              			<div class="form-group">
              				<label class="col-sm-3 control-label">账户</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-credit-card"></i>
				                </div>
              					<select class="money_accounts_select form-control" name="money_accounts_id"></select>
              				</div>
              			</div>

              			<div class="form-group">
              				<label class="col-sm-3 control-label">收入来源</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-suitcase"></i>
				                </div>
              					<select class="money_rev_select form-control" name="money_type_id"></select>
              				</div>
              			</div>

              			<div class="form-group">
              				<label class="col-sm-3 control-label">说明</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-file-text"></i>
				                </div>
              					<textarea name="note" class="form-control"></textarea>
              				</div>
              			</div>
              			<div class="form-group">
							<button class="btn btn-default pull-right record-submit">提交</button>
              			</div>
              		</form>
              	</div>
	            <div class="tab-pane" id="tab_2">
              		<form class="form-horizontal">
              			<input type="hidden" name="type" value="-1">
              			<div class="form-group">
              				<label class="col-sm-3 control-label">金额</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-money"></i>
				                </div>
              					<input name="value" value="0" class="form-control" placeholder="0">
              				</div>
              			</div>

              			<div class="form-group">
              				<label class="col-sm-3 control-label">时间</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                </div>
              					<input name="date" value="{{ date('Y/m/d') }}" class="form-control datepicker" placeholder="">
              				</div>
              			</div>

              			<div class="form-group">
              				<label class="col-sm-3 control-label">账户</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-credit-card"></i>
				                </div>
              					<select class="money_accounts_select form-control" name="money_accounts_id"></select>
              				</div>
              			</div>

              			<div class="form-group">
              				<label class="col-sm-3 control-label">支出用途</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-suitcase"></i>
				                </div>
              					<select class="money_use_select form-control" name="money_type_id"></select>
              				</div>
              			</div>

              			<div class="form-group">
              				<label class="col-sm-3 control-label">说明</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-file-text"></i>
				                </div>
              					<textarea name="note" class="form-control"></textarea>
              				</div>
              			</div>

              			<div class="form-group">
							<button class="btn btn-default pull-right record-submit">提交</button>
              			</div>
              		</form>
	            </div>
				<div class="tab-pane" id="tab_3">
              		<form class="form-horizontal">
              			<input type="hidden" name="type" value="0">
              			<div class="form-group">
              				<label class="col-sm-3 control-label">金额</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-money"></i>
				                </div>
              					<input name="value" value="0" class="form-control" placeholder="0">
              				</div>
              			</div>

              			<div class="form-group">
              				<label class="col-sm-3 control-label">时间</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                </div>
              					<input name="date" value="{{ date('Y/m/d') }}" class="form-control datepicker" placeholder="">
              				</div>
              			</div>

              			<div class="form-group">
              				<label class="col-sm-3 control-label">转出账户</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-credit-card"></i>
				                </div>
              					<select class="money_accounts_select form-control" name="money_accounts_id"></select>
              				</div>
              			</div>

              			<div class="form-group">
              				<label class="col-sm-3 control-label">转入账户</label>
              				<div class="col-sm-9 input-group">
              					<div class="input-group-addon">
				                    <i class="fa fa-credit-card"></i>
				                </div>
              					<select class="money_accounts_select form-control" name="money_accounts_to_id"></select>
              				</div>
              			</div>

              			<div class="form-group">
							<button class="btn btn-default pull-right record-submit">提交</button>
              			</div>
              		</form>
				</div>
			</div>	
        </div>

		<div class="box box-solid">
			<div class="box-header with-border">
				<h4 class="box-title">总计</h4>
			</div>
			<div class="box-body">
				<div id="external-total"></div>
			</div>
		</div>

    </div>
</div>


<script type="text/template" name="account-form">
	<form class="form-horizontal" name="add-account">
		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">账户名称</label>
			<div class="col-sm-9">
				<input name="name" class="form-control" placeholder="我的钱包" value="{name}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">初始金额</label>
			<div class="col-sm-9">
				<input name="money" class="form-control" placeholder="数值" value="{money}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">说&nbsp;&nbsp;明</label>
			<div class="col-sm-9">
				<input name="note" class="form-control" placeholder="备注" value="{note}">
			</div>
		</div>
	</form>
</script>

<script type="text/template" name="account-list">
	<div class="external-event">
		<span><input type="checkbox" name="account" value="{id}">&nbsp;&nbsp;{name}
		<div class="pull-right btn-group">
			<div class="pull-left btn-sm"><i class="fa fa-rmb"></i><span class="account_money">{money}</span></div>
            <a class="btn btn-danger btn-sm delete" data-toggle="tooltip" data-href="{{ route('data.money.accounts.index') }}/{id}" title="删除"><i class="fa fa-trash-o"></i></a>
            <a class="btn btn-primary btn-sm bill" data-toggle="tooltip" title="对账"><i class="fa fa-paste"></i></a>
            <a class="btn btn-primary btn-sm edit" data-toggle="tooltip" title="编辑"><i class="fa fa-pencil-square-o"></i></a>
         </div>
        </span>
	</div>
</script>


<script type="text/template" name="money-type-form">
	<form class="form-horizontal" name="add-type">
		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">列别名称</label>
			<div class="col-sm-9">
				<input name="name" class="form-control" placeholder="名称" value="{name}">
				<input name="parent_id" tpye="hidden" value="{parent_id}" style="display:none">
			</div>
		</div>
	</form>
</script>

<script type="text/template" name="money-type-list">
	<div class="external-event">
		<span><input type="checkbox" name="type" value="{id}">&nbsp;&nbsp;{name}
		<div class="pull-right btn-group">
			<div class="pull-left btn-sm">(<span class="records_type_count">0</span>) 笔</div>
            <a class="btn btn-danger btn-sm delete" data-toggle="tooltip" data-href="{{ route('data.money.type.index') }}/{id}" title="删除"><i class="fa fa-trash-o"></i></a>
            <a class="btn btn-primary btn-sm edit" data-toggle="tooltip" title="编辑"><i class="fa fa-pencil-square-o"></i></a>
         </div>
        </span>
	</div>
</script>

<script type="text/template" name="records-form">
	<form class="form-horizontal" name="records">
		<input name="type" value="{type}" type="hidde" style="display:none;" >
		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">账号</label>
			<div class="col-sm-9">
				<input name="" disabled class="form-control" placeholder="我的钱包" value="{account_name}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">收支类型</label>
			<div class="col-sm-9">
				<select name="money_type_id" class="form-control money_type_select">{type_html}</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">金额</label>
			<div class="col-sm-9">
				<input name="money" class="form-control" placeholder="数值" value="{value}">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" style="font-size:12px;">说&nbsp;&nbsp;明</label>
			<div class="col-sm-9">
				<input name="note" class="form-control" placeholder="备注" value="{note}">
			</div>
		</div>
	</form>
</script>

<script type="text/template" name="total-list">
	<div class="external-event">
		<div class="row">
			<div class="col-sm-4">{name}</div>
			<div class="col-sm-4">支出：</div>
			<div class="col-sm-4">收入：</div>
		</div>	
	</div>
</script>


<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/ajax.js') }}"></script>
<script type="text/javascript">

var accounts  = <?php echo $accounts->toJson() ?>;
var money_use = <?php echo $money_use->toJson() ?>;
var money_rev = <?php echo $money_rev->toJson() ?>;


function formatTemplate(dta, tmpl) {  
    return tmpl.replace(/{(\w+)}/g, function(m1, m2) {  
        return dta[m2];  
    });  
}

if(accounts.length > 0){
	for(var i in accounts){
		addAccount(accounts[i]);
		addAccountTotal(accounts[i]);
	}
	updateAccountSelect();
}

if(money_rev.length > 0){
	for(var i in money_rev){
		addMoneyRev(money_rev[i],1);
	}
	updateMoneyRevSelect();
}

if(money_use.length > 0){
	for(var i in money_use){
		addMoneyUse(money_use[i],2);
	}
	updateMoneyUseSelect();
}


function accountEvent(data){
	var obj = $(formatTemplate(data,$('script[name="account-list"]').html()));
	obj.data(data);
	obj.find('.delete').click(function() {
		Rbac.ajax.delete({
            confirmTitle: '确定删除用户?',
            href: $(this).data('href'),
            successTitle: '用户删除成功',
            successFnc:function(){
            	obj.remove();
            	updateAccountSelect();
            }
        });
	});
	obj.find('.bill').click(function() {
	});
	obj.find('.edit').click(function() {
		var data = obj.data();
		swal({
			title: '修改账户',
			html: formatTemplate(data,$('script[name="account-form"]').html()),
			showCloseButton: true,
			showCancelButton: true,
			cancelButtonText:'取消',
			confirmButtonText: '提交',
		}).then(function(){
			Rbac.ajax.request({
		        href: '{{ route('data.money.accounts.store') }}' + '/' + data.id,
		        data: $('form[name="add-account"]').serialize(),
		        type:'put',
		        successFnc:function(r){
	        		var new_obj = accountEvent(r.datas);
		        	if(obj.find('input[type=checkbox]').is(':checked')){
		        		new_obj.find('input[type=checkbox]').attr('checked',true);
		        		new_obj.find('.account_money').html(r.datas.money);
		        	}
		        	obj.before(new_obj);
		        	obj.remove();
		        	updateAccountSelect();
		        }
		    });	
		},function(){});
	});
	obj.find('input[type=checkbox]').click(function() {
		$('#calendar').fullCalendar( 'refetchEvents' );
	});
	return obj;
}

function moneyTypeEvent(data){
	var obj = $(formatTemplate(data,$('script[name="money-type-list"]').html()));
	obj.data(data);
	if(data.parent_id == 0){
		obj.find('.delete').css('visibility','hidden');
		obj.find('.edit').css('visibility','hidden');
	}else{
		obj.find('.delete').click(function() {
			Rbac.ajax.delete({
	            confirmTitle: '确定删除类别?',
	            href: $(this).data('href'),
	            successTitle: '删除成功',
	            successFnc:function(){
	            	obj.remove();
	            	updateMoneyRevSelect();
					updateMoneyUseSelect();
	            }
	        });
		});
		obj.find('.edit').click(function() {
			swal({
				title: '修改名称',
				html: formatTemplate(data,$('script[name="money-type-form"]').html()),
				showCloseButton: true,
				showCancelButton: true,
				cancelButtonText:'取消',
				confirmButtonText: '提交',
			}).then(function(){
				Rbac.ajax.request({
			        href: '{{ route('data.money.type.store') }}' + '/' + data.id,
			        data: $('form[name="add-type"]').serialize(),
			        type:'put',
			        successFnc:function(r){
			        	r.datas.count = obj.data('count');
			        	var new_obj = moneyTypeEvent(r.datas);
			        	if(obj.find('input[type=checkbox]').is(':checked')){
			        		new_obj.find('input[type=checkbox]').attr('checked',true);
			        		new_obj.find('.records_type_count').html(r.datas.count);
			        	}
			        	obj.before(new_obj);
			        	obj.remove();
						if(r.datas.parent_id == 2){
			        		updateMoneyUseSelect();
			        	}else{
			        		updateMoneyRevSelect();
			        	}
			        }
			    });	
			},function(){});
		});
		obj.find('input[type=checkbox]').click(function() {
			$('#calendar').fullCalendar( 'refetchEvents' );
		});
	}

	return obj;
}

function updateAccountSelect(){
	$('.money_accounts_select').html(getDataOptionFromDiv($('#external-events')));
}

function updateMoneyRevSelect(){
	$('.money_rev_select').html(getDataOptionFromDiv($('#external-events1')));
}

function updateMoneyUseSelect(){
	$('.money_use_select').html(getDataOptionFromDiv($('#external-events2')));
}

function getDataOptionFromDiv(obj){
	var html = '';
	obj.find('.external-event').each(function(index, el) {
		var data = $(this).data();
		html += '<option value="'+ data.id +'">' + data.name + '</option>' +'\n';
	});
	return html;
}

function updateAccountMoney(rev){
	$('#external-events').find('.external-event').each(function(index, el) {
		var data = $(this).data();
		if(data.id == rev.id){
			data = rev;
			$(this).find('.account_money').html(rev.money);
			return;
		}
	});
}

function addAccount(data){
	$('#external-events').append(accountEvent(data));
}

function addMoneyRev(data){
	$('#external-events1').append(moneyTypeEvent(data));
}

function addMoneyUse(data){
	$('#external-events2').append(moneyTypeEvent(data));
}

function addAccountTotal(data){
	$('#external-total').append(formatTemplate(data,$('script[name="total-list"]').html()));
}

function addMoneyType(parent_id){
	var data = {'name':'','parent_id':parent_id};
	swal({
		title: '新增类别',
		html: formatTemplate(data,$('script[name="money-type-form"]').html()),
		showCloseButton: true,
		showCancelButton: true,
		cancelButtonText:'取消',
		confirmButtonText: '提交',
	}).then(function(){
		Rbac.ajax.request({
	        href: '{{ route('data.money.type.store') }}',
	        data: $('form[name="add-type"]').serialize(),
	        successFnc:function(r){
	        	if(parent_id == 2){
	        		addMoneyUse(r.datas);
	        		updateMoneyUseSelect();
	        	}else{
	        		addMoneyRev(r.datas);
	        		updateMoneyRevSelect();
	        	}
	        }
	    });	
	}, function(dismiss){});
}

$('#add_account').click(function(event) {
	var data = {'name':'','money':'','note':''};
	swal({
		title: '新增账户',
		html: formatTemplate(data,$('script[name="account-form"]').html()),
		showCloseButton: true,
		showCancelButton: true,
		cancelButtonText:'取消',
		confirmButtonText: '提交',
	}).then(function(){
		Rbac.ajax.request({
	        href: '{{ route('data.money.accounts.store') }}',
	        data: $('form[name="add-account"]').serialize(),
	        successFnc:function(r){
	        	addAccount(r.datas);
	        	updateAccountSelect();
	        }
	    });	
	}, function(dismiss) {});
});

$('#add_use_type').click(function(event) {
	addMoneyType(2);
});

$('#add_rev_type').click(function(event) {
	addMoneyType(1);
});


$('.datepicker').datepicker({
  autoclose: true,
  format:"yyyy/mm/dd"
});
</script>

<script src="{{ asset('/plugins/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('/plugins/fullcalendar/locale-all.js') }}"></script>

<script type="text/javascript">
var initialLocaleCode = 'zh-cn';

$('input[type=checkbox]').attr({'checked':true});

function getCheckboxByName(name){
	var ids = [];
	$('input[type=checkbox][name='+ name +']:checked').each(function(index, el) {
		ids.push($(this).val());
	});
	return ids;
}

function updateRecordCount(data){
	$('.records_type_count').each(function(index, el) {
		var id = $(this).parents('.external-event').data('id');
		if(data[id] != undefined){
			$(this).html(data[id].count);
			$(this).parents('.external-event').data('count',data[id].count);
			$(this).parents('.external-event').find('input').removeAttr('disabled');
		}else{
			$(this).html(0);
			$(this).parents('.external-event').data('count',0);
			$(this).parents('.external-event').find('input').attr('disabled',true);
		}
	});
}


$('#calendar').fullCalendar({
	locale: initialLocaleCode,
	header: {
		left: 'prev,next today',
		center: 'title',
		right: 'month,listSeason,listMonth,listWeek,listDay'
	},
	buttonText:{
		month: '表',
		listMonth: '月',
		listWeek: '周',
		listDay: '天',
	},
	viewRender: function(view, element){
		console.log(view);
	},
	views:{
		listSeason:{
			type:'list',
			buttonText:'季度',
			duration: { months: 3 },
		}
	},
	
	defaultDate: '{{ date('Y-m-d') }}',
	defaultView: 'month',
	eventLimit: true,
	eventBorderColor:'#fff',
	navLinks: true,
    events: function(start, end, timezone, callback) {

    	swal({
    		title:'Loading',
    		text:'正在加载数据',
    		allowOutsideClick:false,
    		showConfirmButton:false,
    	});

    	$('#calendar').fullCalendar('removeEvents');
    	
    	$.ajax({
	        url: '{{ route('data.money.records.index') }}',
	        type: 'get',
	        dataType:'json',
	        data:{
	        	start: start.unix(),
                end: end.unix(),
                type: getCheckboxByName('type'),
                account: getCheckboxByName('account'),
	        },
	        success:function(r){
	        	var data = r.datas;
	        	var events = [];
                for(var i in data){
                	var temp = {};
                	temp.title =  data[i].type.name + ' : ' + Math.abs(data[i].value) ;
                	temp.start = data[i].date;
                	temp.backgroundColor = (data[i].value > 0) ? '#4bc771' :'#da3232';
                	temp.d = data[i];
                	events.push(temp);
                }
                updateRecordCount(r.count);
                callback(events);
	        },
	        complete:function(){
	        	swal.close();	
	        }
	    });
    	//loading.close();
    	
    },
    eventRender: function(event, element , obj) {
    	if(obj.type != 'month'){
    		var html = '<td colspan="3"><div class="row">';
    		if(event.d.value > 0){
    			html += '<div class="col-sm-2">收入</div>';
    			//element.find('.fc-list-item-time.fc-widget-content').html('收入');
    			//element.find('.fc-list-item-marker.fc-widget-content').html('<i class="fa fa-plus"></i>');
    		}else{
    			html += '<div class="col-sm-2">支出</div>';
    			//element.find('.fc-list-item-time.fc-widget-content').html('支出');
    			//element.find('.fc-list-item-marker.fc-widget-content').html('<i class="fa fa-minus"></i>');
    		}
    		html += '<div class="col-sm-2">'+ event.d.value +'</i></div>';
    		html += '<div class="col-sm-2">'+ event.d.account.name+'</i></div>';
    		html += '<div class="col-sm-2">'+ event.d.type.name+'</i></div>';
    		html += '<div class="col-sm-4">'+ event.d.note+'</i></div>';
    		html += '</div></td>';

    		//element.find('.fc-list-item-title.fc-widget-content').html(event.account.name + '&nbsp;&nbsp;' + event.value + '&nbsp;&nbsp;' + event.type.name);
    		element.html(html);
    	}else{

    		element.attr({"data-toggle":"tooltip","title":event.d.account.name});
    		if(event.d.value < 0){
				element.css('backgroundColor','#da3232');
	    	}else{
	    		element.css('backgroundColor','#4bc771');
	    	}
    	}
    	
    },
    eventClick: function(event, element) {
    	//$('#calendar').fullCalendar('removeEvents',[event._id]);
    	var data = {
    		value:event.d.value,
    		account_name:event.d.account.name,
    		type_id : event.d.type.id,
    		note: event.d.note,
    	}; 

    	var obj = $('<select></select>');
    	var select_html = '';
    	var title = '';
    	
    	if(data.value > 0){
    		data.type = 1;
    		title += '收入';
    		select_html = getDataOptionFromDiv($('#external-events1'));
    	}else{
    		data.type = -1;
    		title += '支出';
    		select_html = getDataOptionFromDiv($('#external-events2'));
    	}

    	obj.html(select_html);
    	obj.find('option').each(function(index, el) {
    		if( $(this).attr('value') == data.type_id){
    			$(this).attr('selected',true);
    		}
    	});

    	data.value = Math.abs(data.value);
    	data.type_html = obj.html();
    	obj.remove();

    	var showConfirmButton = true;
    	if(data.type_id == 1 || data.type_id == 2){
    		showConfirmButton = false;
    	}

    	swal({
    		title: title+'详细信息',
    		html: formatTemplate(data,$('script[name="records-form"]').html()),
    		showConfirmButton: showConfirmButton,
    		showCancelButton: true,
    		confirmButtonText : '修改',
    		cancelButton : '取消',
    	}).then(function(){
    		var put_data = $('form[name="records"]').serialize();

    		swal({
	    		title:'Loading',
	    		text:'正在加载数据',
	    		allowOutsideClick:false,
	    		showConfirmButton:false,
	    	});
	    	
	    	$.ajax({
		        url: '{{ route('data.money.records.index') }}/'+event.d.id,
		        type: 'put',
		        dataType:'json',
		        data: put_data,
		        headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		        success:function(r){
		        	if(r == undefined || r.status == undefined || r.status == 1){		 
		        		event.title = r.datas.type.name + ' : ' + Math.abs(r.datas.value) ;
		        		console.log(event.d.account);
		        		console.log(r.datas.account);
		        		if(event.d.account.money != r.datas.account.money){
		        			updateAccountMoney(r.datas.account);
		        		}
		        		event.d = r.datas;
		        		$('#calendar').fullCalendar('updateEvent', event);
		        	}
		        },
		        complete:function(){
		        	swal.close();	
		        }
		    });
    	},function(){});

    	data = {};

    }
});
</script>


<script type="text/javascript">
$('.record-submit').click(function(event) {
    swal({
		title:'Loading',
		text:'正在提交数据',
		allowOutsideClick:false,
		showConfirmButton:false,
	});

	$.ajax({
        url: '{{ route('data.money.records.store') }}',
        dataType:'json',
        type:'post',
        headers:{ 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:$(this).parents('form').serialize(),
        success:function(r){
        	var data = r.datas;
        	var events = [];
            for(var i in data){
            	var temp = {};
            	temp.title = ((data[i].value > 0) ? '收入':'支出')+ Math.abs(data[i].value);
            	temp.start = data[i].date;
            	temp.backgroundColor = (data[i].value > 0) ? '#4bc771' :'#da3232';
            	temp.d = data[i];

            	updateAccountMoney(data[i].account);

            	$('#calendar').fullCalendar('renderEvent', temp, true); 
            }
        	
        },complete:function(){
	        swal.close();	
	    }
    });
	return false;
});
</script>

@endsection

