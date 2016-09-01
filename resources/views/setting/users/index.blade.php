@extends('layouts.app2')

@section('htmlheader_title')
	Setting User
@endsection

@section('subsidebar_title')
	子用户权限管理
@endsection

@section('table_title')
	用户列表
@endsection

@section('table-content')
	

<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
<thead>
	<tr>
		<th width="35"><input type="checkbox" /></th>
		<th class="sorting">用户名</th>
		<th class="sorting">对应角色</th>
		<th class="sorting">创建时间</th>
		<th width="100">操作</th>
	</tr>
</thead>
<tbody class="user-form">
	@foreach($tables as $user)
	<tr>
		<td width="35"><input type="checkbox" /></td>
		<td>{{ $user->name }}</td>
		<td>
			@foreach($user->selfRoles as $role)
			{{ $role->name }};
			@endforeach
		</td>
		<td>{{ $user->created_at }}</td>
		<td>
			<div class="btn-group">
				<a class="btn btn-default" href="{{ route( $path.'.edit' , $user->id) }}"><i class="fa fa-edit"></i></a>
				<button class="btn btn-danger table-delete" data-href="{{ route($path.'.destroy' , $user->id ) }}"><i class="fa fa-trash"></i></button>
			</div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>


	
@endsection
