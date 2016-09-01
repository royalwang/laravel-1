@extends('layouts.app3')

@section('htmlheader_title')
    Setting AD
@endsection

@section('subsidebar_title')
    广告数据管理
@endsection

@section('form_title')
    Vps编辑
@endsection

@section('form-content')

<form class="form-horizontal" name="form" action="{{ route($path.'.update',$vps->id) }}" method="post">
    {{ method_field('PUT') }}
    {!! csrf_field() !!}

    <div class="form-group">
        <label class="control-label col-sm-2" >Ip地址</label>
        <div class="col-sm-8"><input name="ip" type="text" value="{{ $vps->ip }}" class="form-control" data-inputmask="'alias': 'ip'" data-mask></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" >用户名</label>
        <div class="col-sm-8"><input name="username" type="text" value="{{ $vps->username }}" class="form-control" autocomplete="off"></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2" >密码</label>
        <div class="col-sm-8"><input name="password" type="text" value="{{ $vps->password }}" class="form-control" autocomplete="off"></div>
    </div>
</form>
    
<script src="{{ asset('plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
<script type="text/javascript">
$("input[name=ip]").inputmask();
</script>


@endsection


