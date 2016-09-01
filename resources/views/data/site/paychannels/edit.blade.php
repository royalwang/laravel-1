@extends('layouts.app3')

@section('htmlheader_title')
    Setting User
@endsection

@section('subsidebar_title')
    网站数据管理
@endsection

@section('form_title')
    通道编辑
@endsection

@section('form-content')
	
<form class="form-horizontal" name="paychannel" action="{{ route($path.'.update', $paychannel->id) }}" method="post">
    {{ method_field('PUT') }}
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-2" >名称</label>
        <div class="col-sm-8"><input name="name" type="text" value="{{ $paychannel->name }}" class="form-control" autocomplete="off"></div>
    </div>


</form>

@endsection


	
