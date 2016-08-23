@extends('setting.app')

@section('htmlheader_title')
	权限编辑
@endsection

@section('style')
@parent
<link href="{{ asset('/css/user.css') }}" rel="stylesheet">
@endsection

@section('setting-content')
	
	
<div class="row">
	<div class="col-md-12">
		<h4 class="left" style="display:block">编辑权限</h4>
		<div class="right">
			<a class="btn btn-default" href="{{ route('setting.permissions.index') }}"><i class="fa fa-reply"></i></a>
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
	<form class="form-horizontal" name="permissions" action="{{ route('setting.permissions.update', $permission->id ) }}" method="post">
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
	</div>
</div>	


<script type="text/javascript">
function update(){
    swal("Good job!", "You clicked the button!", "success");
	$('form[name=permissions]').submit();
}
</script>


	
@endsection
