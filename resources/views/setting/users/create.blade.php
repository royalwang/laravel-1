@extends('layouts.app3')

@section('htmlheader_title')
    Setting User
@endsection

@section('subsidebar_title')
    子用户权限管理
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
        <label class="control-label col-sm-2" >姓名</label>
        <div class="col-sm-8"><input name="name" type="text" placeholder="姓名" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >登录名</label>
        <div class="col-sm-8"><input name="username" type="text" placeholder="登录名" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >密码</label>
        <div class="col-sm-8"><input name="password" type="password" placeholder="输入密码" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >确认</label>
        <div class="col-sm-8"><input name="password_confirmation" type="password" placeholder="确认密码" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">角色名</label>
        <div class="col-sm-8">
            <select class="form-control roles-select" multiple="multiple" name="roles[]">
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
            </select>
        </div>
    </div>


</form>
   
<script type="text/javascript" src="{{ asset('plugins/select2/select2.min.js')}}"></script>    
<script type="text/javascript">
$(".roles-select").select2();
</script>

	
@endsection
