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
		<h4 class="left" style="display:block">编辑角色</h4>
		<div class="right">
			<a class="btn btn-default" href="{{ route('setting.roles.index') }}"><i class="fa fa-reply"></i></a>
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
    <form class="form-horizontal" name="roles" action="{{ route('setting.roles.store') }}" method="post">
        {!! csrf_field() !!}
        <div class="form-group">
            <label class="control-label col-sm-2" >角色名称</label>
            <div class="col-sm-8"><input name="name" value="{{ $role->name }}" type="text" class="form-control" autocomplete="off"></div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" >角色ID(唯一)</label>
            <div class="col-sm-8"><input name="code" value="{{ $role->code }}" type="text" class="form-control" autocomplete="off"></div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2">拥有权限</label>
            <div class="col-sm-8">
                <select class="form-control" multiple="multiple" name="permissions[]">
                @foreach($permissions as $permission)
                    @if($current_permissions->contains('id',$permission->id))
                        <option value="{{ $permission->id }}" selected="selected">{{ $permission->name }}</option>
                    @else
                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
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
	$('form[name=roles]').submit();
}
</script>


	
@endsection
