

<div class="col-md-10">
    <div class="box box box-solid">
        <div class="box-header with-border" style="line-height:34px;">
            <a class="btn btn-default pull-left" href="{{ route($path .'.index') }}"><i class="fa fa-reply"></i>返回</a>
        </div>
        <div class="clearfix">
            <div class="col-md-12">
                @yield('form-content')
            </div>
        </div>
        <div class="box-footer">
            <a class="btn btn-default pull-left" href="{{ route($path .'.index') }}"><i class="fa fa-reply"></i>返回</a>
        </div>
    </div>
</div>
