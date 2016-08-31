@extends('layouts.app2')

@section('htmlheader_title')
	Setting ad
@endsection

@section('subsidebar_title')
	广告数据管理
@endsection

@section('table_title')
	广告录入数据
@endsection

@section('table-content')
	

<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
<thead>
	<tr>
		<th width="35"><input type="checkbox" /></th>
		<th>时间</th>
		<th>广告账号</th>
		<th>广告消费</th>
		<th>广告充值</th>
		<th width="100">操作</th>
	</tr>
</thead>
<tbody class="user-form">
	@foreach($tables as $record)
	<tr>
		<td width="35"><input type="checkbox" /></td>
		<td>{{ date('Y-m-d',$record->date) }}</td>
		<td>{{ $record->binds->account->code }}</td>
		<td>$ {{ $record->cost }}</td>
		<td>$ {{ $record->recharge }}</td>
		<td>
			<div class="btn-group">
			<a class="btn btn-default" href="{{ route($path.'.edit' , $record->id) }}"><i class="fa fa-edit"></i></a>
			<button class="btn btn-danger table-delete" data-href="{{ route($path.'.destroy' , $record->id ) }}"><i class="fa fa-trash"></i></button>
			</div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>

@endsection
