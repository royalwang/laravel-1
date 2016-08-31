@extends('layouts.app3')

@section('htmlheader_title')
    Setting User
@endsection

@section('subsidebar_title')
    用户权限管理
@endsection

@section('form_title')
    用户编辑
@endsection

@section('form-content')
    
<form class="form-horizontal" name="form" action="{{ route($path.'.update', $user->id ) }}" method="post">
    {{ method_field('PUT') }}
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-2" >用户名</label>
        <div class="col-sm-8"><input name="name" type="text" placeholder="用户名" class="form-control" value="{{ $user->name }}" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >密码</label>
        <div class="col-sm-8"><input name="password" type="password" placeholder="输入密码" class="form-control" value="********" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >确认</label>
        <div class="col-sm-8"><input name="password_confirmation" type="password" placeholder="确认密码" class="form-control" value="********" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">角色名</label>
        <div class="col-sm-8">
            <select class="form-control" multiple="multiple" name="roles[]">
            @foreach($roles as $role)
                @if($current_roles->contains('id',$role->id))
                <option value="{{ $role->id }}"  selected="selected">{{ $role->name }}</option>
                @else
                <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endif
            @endforeach
            </select>
        </div>
    </div>
</form>
    


    
@endsection

	
	
