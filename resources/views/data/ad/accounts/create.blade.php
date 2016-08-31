@extends('layouts.app3')

@section('htmlheader_title')
    Setting AD
@endsection

@section('subsidebar_title')
    广告数据管理
@endsection

@section('form_title')
    新建账号
@endsection

@section('form-content')
	

<form class="form-horizontal" name="form" action="{{ route($path.'.store') }}" method="post">
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-2" >编号</label>
        <div class="col-sm-8"><input name="code" type="text" placeholder="编号" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >用户名</label>
        <div class="col-sm-8"><input name="username" type="text" placeholder="用户名" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >密码</label>
        <div class="col-sm-8"><input name="password" type="text" placeholder="输入密码" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >生日</label>
        <div class="col-sm-8"><input name="birthday" type="text" placeholder="生日" class="form-control" autocomplete="off"></div>
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

@endsection

	

