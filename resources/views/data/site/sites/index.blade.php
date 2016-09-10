@extends('layouts.app2')

@section('htmlheader_title')
	Setting Site
@endsection

@section('subsidebar_title')
	网站数据限管理
@endsection

@section('table_title')
	网站列表
@endsection

@section('table-content')
	

<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
<thead>
	<tr>
		<th width="35"><input type="checkbox" /></th>
		<th>日期</th>
		<th>网址</th>
		<th>品牌</th>
		<th>程序员</th>
		<th>通道</th>
		<th width="156">操作</th>
	</tr>
</thead>
<tbody class="user-form">
	@foreach($tables as $site)
	<tr>
		<td width="35"><input type="checkbox" /></td>
		<td>{{ $site->created_at }}</td>
		<td>{{ $site->host }}</td>
		<td>{{ isset($site->banner->name) ? $site->banner->name : 'null'  }}</td>
		<td>{{ isset($site->user->name) ? $site->user->name : 'null' }}</td>
		<td>{{ isset($site->pay_channel->name) ? $site->pay_channel->name : 'null' }}</td>
		<td>
			<div class="btn-group">
			@pcan($path . '.edit')
			<a class="btn btn-default" href="{{ route($path . '.edit' , $site->id) }}"><i class="fa fa-edit"></i></a>
			@endpcan
			@pcan($path . '.destroy')
			<button class="btn btn-danger table-delete" data-href="{{ route( $path . '.destroy' , $site->id ) }}"><i class="fa fa-trash"></i></button>
			@endpcan
			</div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>

@endsection


