@extends('layouts.app2')

@section('htmlheader_title')
	Setting ad
@endsection

@section('subsidebar_title')
	广告数据管理
@endsection

@section('table_title')
	已绑定账号列表
@endsection

@section('table-content')
	

<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
<thead>
	<tr>
		<th width="35"><input type="checkbox" /></th>
		<th>编号</th>
		<th>VPS</th>
		<th>网站</th>
		<th width="100">操作</th>
	</tr>
</thead>
<tbody class="user-form">
	@foreach($tables as $bind)
	<tr>
		<td width="35"><input type="checkbox" /></td>
		<td>{{ $bind->account->code }}</td>
		<td>{{ $bind->vps->ip }}</td>
		<td>{{ $bind->site->host }}</td>
		<td>
			<div class="btn-group">
			<a class="btn btn-default" href="{{ route($path.'.show' , $bind->id) }}"><i class="fa fa-eye"></i></a>
			<a class="btn btn-default" href="{{ route($path.'.edit' , $bind->id) }}"><i class="fa fa-ban"></i></a>
			<a class="btn btn-default" href="{{ route($path.'.edit' , $bind->id) }}"><i class="fa fa-edit"></i></a>
			</div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>

@endsection
