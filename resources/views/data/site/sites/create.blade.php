@extends('layouts.app3')

@section('htmlheader_title')
    Setting Site
@endsection

@section('subsidebar_title')
    网站数据管理
@endsection

@section('form_title')
    添加网址
@endsection

@section('form-content')
	
<form class="form-horizontal" name="form" action="{{ route($path .'.store') }}" method="post">
    {!! csrf_field() !!}

    <div class="form-group">
        <label class="control-label col-sm-2" >网址</label>
        <div class="col-sm-8"><input name="host" type="text" placeholder="网址" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >品牌</label>
        <div class="col-sm-8">
        	<select name="banners_id" class="form-control">
        		@foreach($banners as $banner)
        			<option value="{{ $banner->id }}">{{ $banner->name }}</option>
        		@endforeach
        	</select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >通道</label>
        <div class="col-sm-8">
        	<select name="pay_channel_id" class="form-control">
        		@foreach($pay_channel as $channel)
        			<option value="{{ $channel->id }}">{{ $channel->name }}</option>
        		@endforeach
        	</select>
        </div>
    </div>
</form>

@endsection

