@extends('layouts.app2')

@section('htmlheader_title')
	Setting Site
@endsection

@section('subsidebar_title')
	网站数据限管理
@endsection

@section('table_title')
	品牌列表
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
	<tbody class="list-form">
	</tbody>
</table>

@endsection

@section('list-content')
<tr>
	<td width="35"><input type="checkbox" /></td>
	<td>{name}</td>
	<td>
		<div class="btn-group">
		@pcan($path . '.edit')
		<button class="btn btn-default btn-edit"><i class="fa fa-edit"></i></button>
		@endpcan
		@pcan($path . '.destroy')
		<button class="btn btn-danger btn-delete"><i class="fa fa-trash"></i></button>
		@endpcan
		</div>
	</td>
</tr>
@endsection

@section('form-content')
	
<div class="form-group">
    <label class="control-label col-sm-2" >网址</label>
    <div class="col-sm-8"><input name="name" type="text" value="{name}" class="form-control" autocomplete="off"></div>
</div>


@endsection


