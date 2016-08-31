@extends('layouts.app2')

@section('htmlheader_title')
	Setting ad
@endsection

@section('subsidebar_title')
	广告数据管理
@endsection

@section('table_title')
	广告账号列表
@endsection

@section('table-content')
	

<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
	<thead>
		<tr>
			<th width="35"><input type="checkbox" /></th>
			<th>编号</th>
			<th>账号</th>
			<th>余额</th>
			<th>状态</th>
			<th>创建时间</th>
			<th width="100">操作</th>
		</tr>
	</thead>
	<tbody class="user-form">
		@foreach($tables as $account)
		<tr>
			<td width="35"><input type="checkbox" /></td>
			<td>{{ $account->code }}</td>
			<td>{{ $account->username }}</td>
			<td>{{ $account->money }}</td>
			<td>{{ ($account->binded)?'已使用':'未使用' }}</td>
			<td>{{ $account->created_at }}</td>
			<td>
				<div class="btn-group">
				@if(!$account->binded)
				<a class="btn btn-default" href="{{ route($path . '.edit' , $account->id) }}"><i class="fa fa-edit"></i></a>
				<button class="btn btn-danger table-delete" data-href="{{ route($path .'.destroy' , $account->id ) }}"><i class="fa fa-trash"></i></button>
				@endif
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection




