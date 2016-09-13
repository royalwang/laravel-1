@extends('layouts.app2')

@section('htmlheader_title')
	Setting Site
@endsection

@section('subsidebar_title')
	网站数据限管理
@endsection

@section('table_title')
	品牌列表
@endsection


@section('select_status')
	<label>&nbsp;状态&nbsp;&nbsp;
		<select name="status" class="url-parameter">
			<option value=''>全部</option>
			<option value='1' {{ (($status == 1)?'selected':'' ) }}>未发</option>
			<option value='0' {{ (($status !='' && $status == 0)?'selected':'' ) }}>已发</option>
			<option value='-1' {{ (($status == -1)?'selected':'' ) }}>已收</option>
		</select>
	</label>
@endsection	


@section('table-content')
	

<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
	<thead>
		<tr>
			<th width="35"><input type="checkbox" /></th>
			<th>日期</th>
			<th>通道</th>
			<th>订单号</th>
			<th>网站</th>
			<th>收货人邮箱</th>
			<th width="156">操作</th>
		</tr>
	</thead>
	<tbody class="user-form">
		@foreach($tables as $order)
		<tr>
			<td width="35"><input type="checkbox" /></td>
			<td>{{ $order->info['date'] }}</td>
			<td>{{ $order->site->paychannel->name }}</td>
			<td>{{ $order->info['order_id'] }}</td>
			<td>{{ $order->site->name }}</td>
			<td>{{ $order->info['email'] }}</td>
			<td>
				<div class="btn-group">
				@pcan($path . '.show')
				<a class="btn btn-default" href="{{ route($path . '.show' , $banner->id) }}"><i class="fa fa-eye"></i></a>
				@endpcan
				<div class="dropdown btn btn-default">
				<span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-reorder"></i></span>
				<ul class="dropdown-menu status" role="menu" aria-labelledby="dLabel">
					<li class="{{ (($bind->status == 0)?'active':'' ) }}"><a data-value="0">未投放</a></li>
					<li class="{{ (($bind->status == 1)?'active':'' ) }}"><a data-value="1">已投放</a></li>
					<li class="{{ (($bind->status == -1)?'active':'' ) }}"><a data-value="-1">已被封</a></li>
				</ul>
				</div>
				@pcan($path . '.destroy')
				<button class="btn btn-danger table-delete" data-href="{{ route( $path . '.destroy' , $banner->id ) }}"><i class="fa fa-trash"></i></button>
				@endpcan
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection

