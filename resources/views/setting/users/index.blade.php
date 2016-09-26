@extends('layouts.app2')

@section('htmlheader_title')
	Setting User
@endsection

@section('subsidebar_title')
	子用户权限管理
@endsection

@section('table_title')
	用户列表
@endsection

@section('table-content')
	

<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
<thead>
	<tr>
		<th width="35"><input type="checkbox" /></th>
		<th class="sorting">用户名</th>
		<th class="sorting">对应角色</th>
		<th class="sorting">创建时间</th>
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
		<td>{self_roles.name}</td>
		<td>{created_at}</td>
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
        <label class="control-label col-sm-2" >姓名</label>
        <div class="col-sm-8"><input name="name" type="text" class="form-control" value="{name}" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >登录名</label>
        <div class="col-sm-8"><input name="username" type="text" class="form-control" value="{username}" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >密码</label>
        <div class="col-sm-8"><input name="password" type="password" class="form-control" value="{password}" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >确认</label>
        <div class="col-sm-8"><input name="password_confirmation" type="password" class="form-control" value="{password}" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">角色名</label>
        <div class="col-sm-8">
            <select class="form-control roles-select" multiple="multiple" name="roles[]" data-name="self_roles">
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
            </select>
        </div>
    </div>

@endsection
