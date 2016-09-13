@extends('layouts.app')

@section('htmlheader_title')
	广告走势图
@endsection

@section('style')
<link href="{{ asset('/css/home.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/morris/morris.css') }}" rel="stylesheet">
<style>
    canvas{
      -moz-user-select: none;
      -webkit-user-select: none;
      -ms-user-select: none;
    }
    #chartjs-tooltip {
      opacity: 1;
      position: absolute;
      background: rgba(0, 0, 0, .7);
      color: white;
      border-radius: 3px;
      -webkit-transition: all .1s ease;
      transition: all .1s ease;
      pointer-events: none;
      -webkit-transform: translate(-50%, 0);
      transform: translate(-50%, 0);
    }
    .chartjs-tooltip-key {
      display: inline-block;
      width: 10px;
      height: 10px;
    }
  </style>
@endsection



@section('main-content')
 
<div class="row"> 

<div class="col-md-2">
<div class="box box-solid">
	<div class="box-header with-border">
		<h3 class="box-title">设置</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<div class="box-group" id="accordion">
		<!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
		<div class="panel box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse0">类型</a></h4>
			</div>
			<div id="collapse0" class="panel-collapse collapse in">
			<div class="box-body">
				<div class="form-group">
					<label>
						<input type="radio" name="t1" class="minimal" checked value="total">
						总和
					</label>
				</div>
				<div class="form-group">
					<label>
						<input type="radio" name="t1" class="minimal" value="user">
						个人
					</label>
				</div>
				<div class="form-group">
					<label>
						<input type="radio" name="t1" class="minimal" value="banner">
						品牌
					</label>
				</div>
			</div>
			</div>
		</div>
		<div class="panel box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1">x轴</a></h4>
			</div>
			<div id="collapse1" class="panel-collapse collapse">
			<div class="box-body">
				<div class="form-group">
					<div class="form-group">
						<label>
							<input type="radio" name="x1" class="minimal" checked value="day" data-name="最近四周">
							按天统计
						</label>
					</div>
					<div class="form-group">
						<label>
							<input type="radio" name="x1" class="minimal" value="week" data-name="最近四个月">
							按周统计
						</label>
					</div>
					<div class="form-group">
						<label>
							<input type="radio" name="x1" class="minimal" value="month" data-name="最近四个月">
							按月统计
						</label>
					</div>
				 </div>
			</div>
			</div>
		</div>
		<div class="panel box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Y轴</a></h4>
			</div>
			<div id="collapse2" class="panel-collapse collapse">
			<div class="box-body">
				@foreach($y1 as $key=>$y)
				<div class="form-group">
					<label>
						<input <?php echo ($key==0)?'checked ':''; ?>type="radio" name="y1" class="minimal" value="{{$y['key']}}" data-key="{{$y['key']}}" data-value="{{$y['value']}}" data-total="{{$y['total']}}" data-name="{{ $y['name'] }}">
						{{ $y['name'] }}
					</label>
				</div>
				@endforeach
				<div class="form-group">
					<label><a href="{{ route('style.ad.chart.index') }}">自定义</a></label>
				</div>
			</div>
			</div>
		</div>		
		<!-- /.box-group -->
		</div>
	</div>
	<!-- /.box-body -->
</div>

<div class="box box-solid">
	<div class="box-header with-border">
		<h3 class="box-title">筛选</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
		<div class="box-group" id="accordion2">
		<div class="panel box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title"><a data-toggle="collapse" data-parent="#accordion2" href="#collapse3">广告手</a></h4>
			</div>
			<div id="collapse3" class="panel-collapse collapse">
			<div class="box-body">
				@foreach($users as $user)
				<div class="form-group">
					<label><input type="checkbox" name="users" checked class="minimal" data-id="{{ $user['id'] }}" data-binds="<?php echo json_encode($user['binds_id']) ?>" value="{{ $user['name'] }}">{{ $user['name'] }}</label>
				</div>
				@endforeach
			</div>
			</div>
		</div>
		<div class="panel box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title"><a data-toggle="collapse" data-parent="#accordion2" href="#collapse4">品牌</a></h4>
			</div>
			<div id="collapse4" class="panel-collapse collapse">
			<div class="box-body">
				@foreach($banners as $banner)
				<div class="form-group">
					<label><input type="checkbox" name="banners" checked class="minimal" data-id="{{ $banner['id'] }}" data-binds="<?php echo json_encode($banner['binds_id']) ?>" value="{{ $banner['name'] }}">{{ $banner['name'] }}</label>
				</div>
				@endforeach
			</div>
			</div>
		</div>			
		<!-- /.box-group -->
		</div>
	</div>
	<!-- /.box-body -->
</div>


</div>
<style>
	.chart-add > i:hover{
		box-shadow: 0px 0px 5px #555!important;
	}
</style>
<div class="col-md-10 connectedSortable">
	<div class="col-md-6 line-chart-bg">
        <div class="chart-add sort-highlight" style="text-align:center;line-height:200px;"><i style="cursor:pointer;box-shadow: 0px 0px 5px #ccc; padding: 5px 9px;border-radius: 10px;" class="fa fa-plus fa-4x"></i></div>
	</div>
	<div class="col-md-6 line-chart-bg"></div>
</div>

</div>

<script type="text/template">
	<div class="box box-info">
        <div class="box-header nav-tabs">
          <i class="fa fa-bar-chart"></i><h3 class="box-title">{$title}统计图</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <div class="box-body chart" style="min-height:300px;"></div>
    </div>
</script>

<script type="text/javascript" src="{{ asset('/plugins/jQueryUi/jquery-ui.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/raphael/raphael.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/morris/morris.js')}}"></script>
<script type="text/javascript">
var data = <?php echo json_encode($dataJson) ?>;

function inArray(_value , _array){
	for(var i in _array){
		if(_array[i] == _value){
			return true;
		}
	}
	return false;
}

$('.chart-add > i').click(function(event) {
	var addObj = $(this).parent('.chart-add').clone(true);
	var _binds  = [], _users  = [], _banners = [];
	var ykeys = [] , labels =[];

	$('input[name="users"]').each(function(index, el) {
		if($(this).is(':checked')){
			var ids = eval($(this).attr('data-binds'));
			var user = {};
			_binds = _binds.concat(ids);
			user.id = $(this).attr('data-id');
			user.name = $(this).val();
			user.binds_id = ids;
			_users.push(user);
		}
	});

	$('input[name="banners"]').each(function(index, el) {
		if($(this).is(':checked')){
			var ids = eval($(this).attr('data-binds'));
			var banner = {};
			_binds = _binds.concat(ids);
			banner.id = $(this).attr('data-id');
			banner.binds_id = ids;
			banner.name = $(this).val();
			_banners.push(banner);
		}
	});

	var id = getRanNum();
	var html = $($('script[type="text/template"]').html());
	html.find('.chart').attr('id',id);
	$(this).parent('.chart-add').before(html);
	$(this).parent('.chart-add').remove();

	if($('.line-chart-bg').eq(0).children().length <= $('.line-chart-bg').eq(1).children().length){
		$('.line-chart-bg').eq(0).append(addObj)
	}else{
		$('.line-chart-bg').eq(1).append(addObj)
	}


	var x = $('input:radio[name=x1]:checked').val();
	var y = $('input:radio[name=y1]:checked').val();
	var t = $('input:radio[name=y1]:checked').attr('data-total');
	var line_data = [];
	
	switch ($('input[name=t1]:checked').val()) {
		case 'total':
			for(var i in data){
				var row_data = {};
				row_data['date'] = i;
				var total = 0;

				for(var o in data[i]){
					if($.inArray(o, _binds) ){
						total = getTotal(total,data[i][o][y],t);
					}
				}
				row_data.total = total;
				line_data.push(row_data);
			}
			
			ykeys.push('total');
			labels.push('总计');
			html.html(html.html().replace('{$title}','总'+$('input:radio[name=y1]:checked').attr('data-name')));
			break;
		case 'user':
			for(var i in data){
				var row_data = {};
				row_data['date'] = i;
				var total = 0;
				for(var c in _users){
					var total = 0;
					for(var o in data[i]){
						if(inArray(parseInt(o), _users[c].binds_id) ){
							total = getTotal(total,data[i][o][y],t);
						}
					}
					row_data[_users[c].id] = total;
				}
				line_data.push(row_data);
			}
			for(var c in _users){
				ykeys.push(_users[c].id);
				labels.push(_users[c].name);
			}
			html.html(html.html().replace('{$title}','各个广告手-'+$('input:radio[name=y1]:checked').attr('data-name')));
			break;
		case 'banner':
			for(var i in data){
				var row_data = {};
				row_data['date'] = i;
				var total = 0;
				for(var c in _banners){
					var total = 0;
					for(var o in data[i]){
						if( inArray(parseInt(o), _banners[c].binds_id) ){
							total = getTotal(total,data[i][o][y],t);
						}
					}
					row_data[_banners[c].id] = total;
				}
				line_data.push(row_data);
			}
			for(var c in _banners){
				ykeys.push(_banners[c].id);
				labels.push(_banners[c].name);
			};
			html.html(html.html().replace('{$title}','各个品牌-'+$('input:radio[name=y1]:checked').attr('data-name')));
			break;		
		default:
			break;
	}

	console.log(line_data);

	switch(x){
		case 'day':
		line_data = totalByDay(line_data);
		break;
		case 'week':
		line_data = totalByWeek(line_data,t);
		break;
		case 'month':
		line_data = totalByMonth(line_data,t);
		break;
	}


	Morris.Bar({
		element: id,
		data: line_data,
		xkey: 'date',
		ykeys: ykeys,
		labels: labels,
		resize:true,
		parseTime:false,
	});	

});

function getTotal(data1,data2,t){
	if(data1 == '') return data2;
	console.log(data1 + ':' + data2);
	switch (t) {
		case 'avg':
			return (parseFloat(data1*100000) + parseFloat(data2*100000)) / 200000;
			break;
		case 'max':
			if(data1 > data2){
				return data1;
			}else{
				return data2;
			}
			break;
		case 'min':
			if(data1 > data2){
				return data2;
			}else{
				return data1;
			}
			break;
		default:
			return (parseFloat(data1*100000) +  parseFloat(data2*100000)) / 100000;
			break;
	}
}


function totalByDay(data){
	for(var o in data){
		data[o].date = setDate(data[o].date);
	}
	return data;
}

function totalByMonth(data,t){
	var new_data = [];
	var i= data.length-1;
	var row_data = {};
	var current_month = '';
	while (i >= 0 ) {

		var t = new Date(data[i].date*1000);
		

		if( current_month == t.getMonth()){
			for(var o in data[i]){
				if(o == 'date') continue;
				if(row_data[o] != undefined){
					row_data[o] = getTotal(row_data[o],data[i][o],t);
				}else{
					row_data[o] = parseFloat(data[i][o]); 
				}	
			}
			if(i == 0){
				row_data['date'] = parseInt(current_month+1) +'月';
				new_data.push(row_data);
			}
			i--;
		}else{
			current_month = t.getMonth();
			if(i == data.length-1) continue;

			row_data['date'] = parseInt(current_month+2) +'月';
			new_data.push(row_data);
			var row_data = {};
		}
		
	}
	return new_data;
}

function totalByWeek(data,t){
	var new_data = [];
	var i= data.length-1;
	var row_data = {};

	var current_time = <?php echo strtotime(date('Y-m-d',time())); ?>;
	while (i >= 0 ) {
		if( data[i].date >= current_time) {i--;continue;}
		if( data[i].date >= (current_time - 60*60*24*7) ){
			for(var o in data[i]){
				if(o == 'date') continue;
				if(row_data[o] != undefined){
					row_data[o] = getTotal(row_data[o],data[i][o],t);
				}else{
					row_data[o] = parseFloat(data[i][o]); 
				}	
			}
			if(i == 0){
				row_data['date'] = setDate(current_time - 60*60*24*7+1) + ' - ' + setDate(current_time - 1 );
				new_data.push(row_data);
			}
			i--;
		}else{
			row_data['date'] = setDate(current_time - 60*60*24*7+1) + ' - ' + setDate(current_time - 1 );
			new_data.push(row_data);
			var row_data = {};
			current_time = current_time - 60*60*24*7;
		}
		
	}
	return new_data;
}

function setDate(time1){
	var t = new Date(time1*1000);
	var y = t.getFullYear();
	var m = t.getMonth()+1;
	var d = t.getDate();
	return y+'/'+m+'/'+d;
}

$('.line-chart-bg').sortable({
	connectWith: ".line-chart-bg",
	handle: ".box-header",
    cancel: "button",
    placeholder: "sort-highlight",
});


function getRanNum(){
    result = [];
    for(var i=0;i<18;i++){
       var ranNum = Math.ceil(Math.random() * 50); //生成一个0到25的数字
        //大写字母'A'的ASCII是65,A~Z的ASCII码就是65 + 0~25;然后调用String.fromCharCode()传入ASCII值返回相应的字符并push进数组里
        result.push(String.fromCharCode(65+ranNum));
    }
    return result.join('');
}    


</script>
	
@endsection
