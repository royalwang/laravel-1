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
		<h4 class="left" style="display:block">用户列表</h4>
		<div class="right">
			<a class="btn btn-default" href="{{ route('setting.users.create') }}"><i class="fa fa-plus"></i></a>
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
					<th>用户名</th>
					<th>拥有角色</th>
					<th>创建时间</th>
					<th width="100">操作</th>
				</tr>
			</thead>
			<tbody class="user-form">
				@foreach($users as $user)
				<tr>
					<td width="35"><input type="checkbox" /></td>
					<td>{{ $user->name }}</td>
					<td>
						@foreach($user->roles()->get() as $role)
						{{ $role->name }};
						@endforeach
					</td>
					<td>{{ $user->date }}</td>
					<td>
						<a class="btn btn-default" href="{{ route('setting.users.edit' , $user->id) }}"><i class="fa fa-edit"></i></a>
						<button class="btn btn-danger user-delete" data-href="{{ route('setting.users.destroy' , $user->id ) }}"><i class="fa fa-trash"></i></button>
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
