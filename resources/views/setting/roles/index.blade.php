@extends('setting.app')

@section('htmlheader_title')
	Setting User
@endsection

@section('style')
@parent
<link href="{{ asset('/css/user.css') }}" rel="stylesheet">
@endsection

@section('setting-content')
	
	
<div class="row">
	<div class="col-md-12">
		<h4 class="left" style="display:block">角色列表</h4>
		<div class="right">
			<a class="btn btn-default" href="{{ route('setting.roles.create') }}"><i class="fa fa-plus"></i></a>
			<button class="btn btn-danger" onclick=""><i class="fa fa-trash"></i></button>
		</div>
	</div>
</div>


<div class="row">	
	<div class="col-md-12">
		<table class="table">	
			<thead>
				<tr>
					<th width="35"><input type="checkbox" /></th>
					<th>角色名称</th>
					<th>角色ID</th>
					<th>角色绑定的用户</th>
					<th>角色绑定的权限</th>
					<th width="100">操作</th>
				</tr>
			</thead>
			<tbody class="user-form">
				@foreach($roles as $role)
				<tr>
					<td width="35"><input type="checkbox" /></td>
					<td>{{ $role->name }}</td>
					<td>{{ $role->code }}</td>
					<td>
						@foreach($role->users()->get() as $user)
						{{ $user->name }};
						@endforeach
					</td>
					<td>
						@foreach($role->permissions()->get() as $permission)
						{{ $permission->name }};
						@endforeach
					</td>
					<td>
						<a class="btn btn-default" href="{{ route('setting.roles.edit' , $role->id) }}"><i class="fa fa-edit"></i></a>
						<button class="btn btn-danger user-delete" data-href="{{ route('setting.roles.destroy' , $role->id ) }}"><i class="fa fa-trash"></i></button>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>	

<script src="{{ asset('js/ajax.js') }}"></script>
<script type="text/javascript">
    $(".user-delete").click(function () {
        Rbac.ajax.delete({
            confirmTitle: '确定删除角色?',
            href: $(this).data('href'),
            successTitle: '角色删除成功'
        });
    });

    $(".deleteall").click(function () {
        Rbac.ajax.deleteAll({
            confirmTitle: '确定删除选中的角色?',
            href: $(this).data('href'),
            successTitle: '角色删除成功'
        });
    });
</script>

	
@endsection
