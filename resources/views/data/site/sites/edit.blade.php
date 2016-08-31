@extends('layouts.app3')

@section('htmlheader_title')
    Setting Site
@endsection

@section('subsidebar_title')
    网站数据管理
@endsection

@section('form_title')
    网址编辑
@endsection

@section('form-content')
	
<form class="form-horizontal" name="users" action="{{ route($path.'.update', $site->id ) }}" method="post">
    {{ method_field('PUT') }}
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-2" >编号</label>
        <div class="col-sm-8"><input name="code" type="text" value="{{ $site->code }}" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >日期</label>
        <div class="col-sm-8"><input name="date" type="text" value="{{ $site->date }}" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >网址</label>
        <div class="col-sm-8"><input name="host" type="text" value="{{ $site->host }}" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >品牌</label>
        <div class="col-sm-8">
        	<select name="banners_id" class="form-control">
        		@foreach($banners as $banner)
        		@if($banner->id == $site->banners_id)
        			<option value="{{ $banner->id }}" selected="selected">{{ $banner->name }}</option>
        		@else
        			<option value="{{ $banner->id }}">{{ $banner->name }}</option>
        		@endif
        		@endforeach
        	</select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >程序员</label>
        <div class="col-sm-8">
        	<select name="users_id" class="form-control">
        		@foreach($users as $user)
        		<?php if(!$user->hasRole('site.admin')) continue; ?>
        		@if($user->id == $site->users_id)
        			<option value="{{ $user->id }}" selected="selected">{{ $user->name }}</option>
        		@else
        			<option value="{{ $user->id }}">{{ $user->name }}</option>
        		@endif
        		@endforeach
        	</select>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >通道</label>
        <div class="col-sm-8">
        	<select name="pay_channel_id" class="form-control">
        		@foreach($pay_channel as $channel)
        		@if($channel->id == $site->pay_channel_id)
        			<option value="{{ $channel->id }}" selected="selected">{{ $channel->name }}</option>
        		@else
        			<option value="{{ $channel->id }}">{{ $channel->name }}</option>
        		@endif
        		@endforeach
        	</select>
        </div>
    </div>
</form>

@endsection

