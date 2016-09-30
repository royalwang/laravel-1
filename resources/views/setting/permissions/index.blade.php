@extends('layouts.app2')

@section('htmlheader_title')
	Setting User
@endsection

@section('subsidebar_title')
	子用户权限管理
@endsection

@section('table_title')
	权限列表
@endsection

@section('table-content')
	
<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
<thead>
	<tr>
		<th width="35"><input type="checkbox" /></th>
		<th>权限名称</th>
		<th>权限ID</th>
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
		<td>{code}</td>
		<td>
			<div class="btn-group">
			@pcan($path . '.edit')
			<a class="btn btn-default btn-edit"><i class="fa fa-edit"></i></a>
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
        <label class="control-label col-sm-2" >权限名称</label>
        <div class="col-sm-8"><input name="name" type="text" class="form-control" value="{name}" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >权限ID（唯一）</label>
        <div class="col-sm-8"><input name="code" type="text" class="form-control" value="{code}" autocomplete="off"></div>
    </div>
@endsection
	
