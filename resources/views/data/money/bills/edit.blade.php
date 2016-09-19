@extends('layouts.app3')

@section('htmlheader_title')
    Setting Site
@endsection

@section('subsidebar_title')
    网站数据管理
@endsection

@section('form_title')
    品牌编辑
@endsection

@section('form-content')
	
<form class="form-horizontal" name="banner" action="{{ route($path.'.update', $banner->id) }}" method="post">
    {{ method_field('PUT') }}
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-2" >网址</label>
        <div class="col-sm-8"><input name="name" type="text" value="{{ $banner->name }}" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >缩写</label>
        <div class="col-sm-8"><input name="code" type="text" value="{{ $banner->code }}" class="form-control" autocomplete="off"></div>
    </div>

</form>

@endsection


