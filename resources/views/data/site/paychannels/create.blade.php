@extends('layouts.app3')

@section('htmlheader_title')
    Setting Site
@endsection

@section('subsidebar_title')
    网站数据管理
@endsection

@section('form_title')
    添加通道
@endsection

@section('form-content')
	
<form class="form-horizontal" name="users" action="{{ route($path .'.store') }}" method="post">
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-2" >名称</label>
        <div class="col-sm-8"><input name="name" type="text" placeholder="Name" class="form-control" autocomplete="off"></div>
    </div>
</form>

@endsection

	

