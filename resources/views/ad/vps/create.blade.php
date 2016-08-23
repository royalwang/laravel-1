@extends('ad.list')

@section('htmlheader_title')
	创建新账号
@endsection


@section('list-content')
	
	
<div class="row">
	<div class="col-md-12">
		<h4 class="left" style="display:block">新建账号</h4>
		<div class="right">
			<a class="btn btn-default" href="{{ route('ad.accounts.index') }}"><i class="fa fa-reply"></i></a>
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
	<form class="form-horizontal" name="accounts" action="{{ route('ad.accounts.store') }}" method="post">
	    {{ method_field('PUT') }}
	    {!! csrf_field() !!}
	    <div class="form-group">
	        <label class="control-label col-sm-2" >用户名</label>
	        <div class="col-sm-8"><input name="username" type="text" placeholder="用户名" class="form-control" autocomplete="off"></div>
	    </div>

	    <div class="form-group">
	        <label class="control-label col-sm-2" >密码</label>
	        <div class="col-sm-8"><input name="password" type="text" placeholder="输入密码" class="form-control" autocomplete="off"></div>
	    </div>

	    <div class="form-group">
	        <label class="control-label col-sm-2" >ID</label>
	        <div class="col-sm-8"><input name="idkey" type="text" placeholder="Id key" class="form-control"  autocomplete="off"></div>
	    </div>

	    <div class="form-group">
	        <label class="control-label col-sm-2" >初始金额</label>
	        <div class="col-sm-8"><input name="money" type="text" placeholder="Money" class="form-control"  autocomplete="off"></div>
	    </div>

	</form>
	</div>
</div>	
<script type="text/javascript">
function update(){
    swal("Good job!", "You clicked the button!", "success");
	$('form[name=accounts]').submit();
}
</script>



	
@endsection
