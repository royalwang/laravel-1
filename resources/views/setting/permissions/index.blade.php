@extends('setting.app')

@section('htmlheader_title')
	权限管理
@endsection


@section('setting-content')
	
	
<div class="row">
	<div class="col-md-12">
		<h4 class="left" style="display:block">权限列表</h4>
		<div class="right">
			<a class="btn btn-default" href="{{ route('setting.permissions.create') }}"><i class="fa fa-plus"></i></a>
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
					<th>权限名称</th>
					<th>权限ID</th>
					<th>权限描述</th>
					<th width="100">操作</th>
				</tr>
			</thead>
			<tbody class="permission-form">
				@foreach($permissions as $permission)
				<tr>
					<td width="35"><input type="checkbox" /></td>
					<td>{{ $permission->name }}</td>
					<td>{{ $permission->code }}</td>
					<td></td>
					<td>
						<a class="btn btn-default" href="{{ route('setting.permissions.edit' , $permission->id) }}"><i class="fa fa-edit"></i></a>
						<button class="btn btn-danger user-delete" data-href="{{ route('setting.permissions.destroy' , $permission->id ) }}"><i class="fa fa-trash"></i></button>
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
            confirmTitle: '确定删除用户?',
            href: $(this).data('href'),
            successTitle: '用户删除成功'
        });
    });

    $(".deleteall").click(function () {
        Rbac.ajax.deleteAll({
            confirmTitle: '确定删除选中的用户?',
            href: $(this).data('href'),
            successTitle: '用户删除成功'
        });
    });
</script>

	
@endsection
