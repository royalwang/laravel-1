@extends('layouts.app2')

@section('htmlheader_title')
	Setting ad
@endsection

@section('subsidebar_title')
	广告数据管理
@endsection

@section('table_title')
	广告VPS列表
@endsection

@section('table-content')
	

<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
<thead>
	<tr>
		<th width="35"><input type="checkbox" /></th>
		<th>IP</th>
		<th>账号</th>
		<th>密码</th>
		<th>状态</th>
		<th width="156">操作</th>
	</tr>
</thead>
<tbody class="user-form">
	@foreach($tables as $vps)
	<tr>
		<td width="35"><input type="checkbox" /></td>
		<td>{{ $vps->ip }}</td>
		<td>{{ $vps->username }}</td>
		<td>{{ $vps->password }}</td>
		<td>{{ ($vps->binded?'已使用':'空闲') }}</td>
		<td>
			<div class="btn-group">
			@pcan($path . '.edit')
			<a class="btn btn-default" href="{{ route($path . '.edit' , $vps->id) }}"><i class="fa fa-edit"></i></a>
			@endpcan
			@pcan($path . '.destroy')
			@if($vps->binded == 0)
			<button class="btn btn-danger table-delete" data-href="{{ route($path.'.destroy' , $vps->id ) }}"><i class="fa fa-trash"></i></button>
			@endif
			@endpcan
			</div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>

@endsection


