@extends('layouts.app2')

@section('htmlheader_title')
	Setting User
@endsection

@section('subsidebar_title')
	子用户权限管理
@endsection

@section('table_title')
	角色列表
@endsection

@section('table-content')
	
<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
<thead>
	<tr>
		<th width="35"><input type="checkbox" /></th>
		<th class="sorting" class="sorting">角色名称</th>
		<th class="sorting">角色ID</th>
		<th class="sorting">默认页面</th>
		<th width="156">操作</th>
	</tr>
</thead>
<tbody class="user-form">
	@foreach($tables as $table)
	<tr>
		<td width="35"><input type="checkbox" /></td>
		<td>{{ $table->name }}</td>
		<td>{{ $table->code }}</td>
		<td>{{ $table->default_page }}</td>
		<td>
			<div class="btn-group">
			@pcan($path . '.edit')
			<a class="btn btn-default" href="{{ route($path . '.edit' , $table->id) }}"><i class="fa fa-edit"></i></a>
			@endpcan
			@pcan($path . '.destroy')
			<button class="btn btn-danger table-delete" data-href="{{ route( $path . '.destroy' , $table->id ) }}"><i class="fa fa-trash"></i></button>
			@endpcan
			</div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>


	
@endsection

	
