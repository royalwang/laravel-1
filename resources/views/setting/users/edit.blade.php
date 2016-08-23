@extends('setting.app')

@section('htmlheader_title')
	Setting User
@endsection

@section('style')
@parent
<link href="{{ asset('/css/user.css') }}" rel="stylesheet">
@endsection

@section('setting-content')
	
	
<div class="row">
	<div class="col-md-12">
		<h4 class="left" style="display:block">编辑用户</h4>
		<div class="right">
			<a class="btn btn-default" href="{{ route('setting.users.index') }}"><i class="fa fa-reply"></i></a>
			<button class="btn btn-danger" onclick="return update();"><i class="fa fa-save"></i></button>
		</div>	
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="line1"></div>
	</div>
</div>

<div class="row">	
	<div class="col-md-12">
	<form class="form-horizontal" name="users" action="{{ route('setting.users.update', $user->id ) }}" method="post">
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
	</div>
</div>	


<script type="text/javascript">
function update(){
    swal("Good job!", "You clicked the button!", "success");
	$('form[name=users]').submit();
}
</script>


	
@endsection
