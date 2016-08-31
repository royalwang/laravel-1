@extends('layouts.app3')

@section('htmlheader_title')
    Setting User
@endsection

@section('subsidebar_title')
    用户权限管理
@endsection

@section('form_title')
    创建新角色
@endsection

@section('style')
@parent
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('form-content')
    
<form class="form-horizontal" name="form" action="{{ route($path .'.store') }}" method="post">
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-2" >角色名称</label>
        <div class="col-sm-8"><input name="name" type="text" placeholder="角色名称" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >角色ID(唯一)</label>
        <div class="col-sm-8"><input name="code" type="text" placeholder="Id Key" class="form-control" autocomplete="off"></div>
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
        <div class="col-sm-8"><input name="default_page" placeholder="默认页面" type="text" class="form-control" autocomplete="off"></div>
    </div>
</form>
    
<script type="text/javascript" src="{{ asset('plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript">
$(".permissions-select").select2();
</script>
    
@endsection

