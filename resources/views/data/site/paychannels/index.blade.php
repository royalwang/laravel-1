@extends('layouts.app2')

@section('htmlheader_title')
	Setting Site
@endsection

@section('subsidebar_title')
	网站数据限管理
@endsection

@section('table_title')
	通道列表
@endsection

@section('table-content')
	
<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
	<thead>
		<tr>
			<th width="35"><input type="checkbox" /></th>
			<th>名称</th>
			<th width="156">操作</th>
		</tr>
	</thead>
	<tbody class="user-form">
		@foreach($tables as $channel)
		<tr>
			<td width="35"><input type="checkbox" /></td>
			<td>{{ $channel->name }}</td>
			<td>
				<div class='btn-group'>
				@pcan($path . '.edit')
				<a class="btn btn-default" href="{{ route($path . '.edit' , $channel->id) }}"><i class="fa fa-edit"></i></a>
				@endpcan
				@pcan($path . '.destroy')
				<button class="btn btn-danger table-delete" data-href="{{ route( $path . '.destroy' , $channel->id ) }}"><i class="fa fa-trash"></i></button>
				@endpcan
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@endsection


