@extends('layouts.app3')

@section('htmlheader_title')
    Setting AD
@endsection

@section('subsidebar_title')
    广告数据管理
@endsection

@section('form_title')
    账号编辑
@endsection

@section('form-content')
	

<form class="form-horizontal" name="form" action="{{ route($path.'.update',$account->id) }}" method="post">
    {{ method_field('PUT') }}
    {!! csrf_field() !!}

    <div class="form-group">
        <label class="control-label col-sm-2" >编号</label>
        <div class="col-sm-8"><input name="code" type="text" value="{{ $account->code }}" class="form-control" autocomplete="off"></div>
    </div>

	<div class="form-group">
        <label class="control-label col-sm-2" >用户名</label>
        <div class="col-sm-8"><input name="username" type="text" value="{{ $account->username }}" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >密码</label>
        <div class="col-sm-8"><input name="password" type="text" value="{{ $account->password }}" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >生日</label>
        <div class="col-sm-8"><input name="birthday" type="text" value="{{ $account->birthday }}" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >ID</label>
        <div class="col-sm-8"><input name="idkey" type="text" value="{{ $account->idkey }}" class="form-control"  autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >余额</label>
        <div class="col-sm-8"><input name="money" type="text" value="{{ $account->money }}" class="form-control disable"  disabled="disable"></div>
    </div>

</form>

@endsection


