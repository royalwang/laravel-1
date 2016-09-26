@extends('layouts.app2')

@section('htmlheader_title')
	Setting User
@endsection

@section('subsidebar_title')
	子用户权限管理
@endsection

@section('table_title')
	角色列表
@endsection

@section('table-content')
	
<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
<thead>
	<tr>
		<th width="35"><input type="checkbox" /></th>
		<th class="sorting" class="sorting">角色名称</th>
		<th class="sorting">角色ID</th>
		<th class="sorting">默认页面</th>
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
		<td>{default_page}</td>
		<td>
			<div class="btn-group">
			@pcan($path . '.edit')
			<a class="btn btn-default" onclick=" return editSwalHtml();"><i class="fa fa-edit"></i></a>
			@endpcan
			@pcan($path . '.destroy')
			<button class="btn btn-danger" onclick="return delSwalHtml();"><i class="fa fa-trash"></i></button>
			@endpcan
			</div>
		</td>
	</tr>
@endsection

	
@section('form-content')
	
    <div class="form-group">
        <label class="control-label col-sm-2" >角色名称</label>
        <div class="col-sm-8"><input name="name" value="{name}" type="text" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >角色ID(唯一)</label>
        <div class="col-sm-8"><input name="code" value="{code}" type="text" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">拥有权限</label>
        <div class="col-sm-8">
            <select class="form-control permissions-select" multiple="multiple" name="permissions[]">
            @foreach($permissions as $permission)
                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
            @endforeach
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >默认页面</label>
        <div class="col-sm-8"><input name="default_page" value="{ default_page }" type="text" class="form-control" autocomplete="off"></div>
    </div>

    
	
@endsection
	