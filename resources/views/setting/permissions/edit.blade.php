@extends('layouts.app3')

@section('htmlheader_title')
    Setting User
@endsection

@section('subsidebar_title')
    用户权限管理
@endsection

@section('form_title')
    权限编辑
@endsection

@section('form-content')
    
<form class="form-horizontal" name="form" action="{{ route($path.'.update', $permission->id ) }}" method="post">
    {{ method_field('PUT') }}
    {!! csrf_field() !!}
    {{ method_field('PUT') }}
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-2" >权限名称</label>
        <div class="col-sm-8"><input name="name" type="text" class="form-control" value="{{ $permission->name }}" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >权限ID（唯一）</label>
        <div class="col-sm-8"><input name="code" type="text" class="form-control" value="{{ $permission->code }}" autocomplete="off"></div>
    </div>
</form>
    
    
@endsection

	
	

