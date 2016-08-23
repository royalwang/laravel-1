@extends('ad.list')

@section('htmlheader_title')
	广告账号管理
@endsection


@section('list-content')
	
<div class="row">
	<div class="col-md-12">
		<h4 class="left" style="display:block">广告账号列表</h4>
		<div class="right">
			<a class="btn btn-default" href="{{ route('ad.accounts.create') }}"><i class="fa fa-plus"></i></a>
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
					<th>账号</th>
					<th>密码</th>
					<th>Key</th>
					<th>余额</th>
					<th>状态</th>
					<th>创建时间</th>
					<th width="100">操作</th>
				</tr>
			</thead>
			<tbody class="user-form">
				@foreach($accounts as $account)
				<tr>
					<td width="35"><input type="checkbox" /></td>
					<td>{{ $account->username }}</td>
					<th>{{ $account->password }}</th>
					<th>{{ $account->idkey }}</th>
					<th>{{ $account->money }}</th>
					<td>{{ ($account->status)?'已使用':'未使用' }}</td>
					<td>{{ $account->created_at }}</td>
					<td>
						<a class="btn btn-default" href="{{ route('ad.accounts.edit' , $account->id) }}"><i class="fa fa-edit"></i></a>
						<button class="btn btn-danger user-delete" data-href="{{ route('ad.accounts.destroy' , $account->id ) }}"><i class="fa fa-trash"></i></button>
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
