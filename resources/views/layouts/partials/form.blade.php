

<div class="col-md-10">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">@yield('form_title')</h3>
        </div>
        <div class="clearfix">
            <div class="col-md-12">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="{{ route($path .'.index') }}"><i class="fa fa-reply"></i>取消</a>
                    <button type="submit" class="btn btn-info" onclick="return update();">保存</button>
                </div>
            </div>
            <div class="col-md-12">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('form-content')
            </div>
            <div class="col-md-12">
                <div class="btn-group pull-right">
                    <a class="btn btn-default" href="{{ route($path .'.index') }}"><i class="fa fa-reply"></i>取消</a>
                    <button type="submit" class="btn btn-info" onclick="return update();">保存</button>
                </div>
            </div>
        </div>
        <div class="box-header with-border">
            <h3 class="box-title"></h3>
        </div>
    </div>
</div>

<script type="text/javascript">

$('form[name="form"]').bind('keyup', function(event) {
    if(event.keyCode == 13)
        update();
});

function update(){
    swal("Good job!", "You clicked the button!", "success");
    $('form[name=form]').submit();
    return false;
}
</script>