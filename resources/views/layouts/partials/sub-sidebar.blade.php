<div class="col-md-2">
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">@yield('subsidebar_title')</h3>
            <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body no-padding" style="display: block;">
            <ul class="nav nav-pills nav-stacked">
                @foreach($sidebar_setting as $value)
                @if(isset($value['visable']) && !empty($value['visable']))
                <li class="{{ (isset($value['active'])?'active':'') }}">
                    <a href="{{ route($value['url']) }}">
                        <i class="fa {{ $value['icon'] }}"></i> {{ $value['name'] }}
                        <span class="badge pull-right"></span>
                    </a>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </div>

    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">批处理</h3>
            <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body no-padding" style="display: block;">
            <ul class="nav nav-pills nav-stacked">
                <li class="">
                    <a href=""><i class="fa fa-upload"></i> 导入 <span class="badge pull-right"></span> </a>
                </li>
                <li class="">
                    <a href=""><i class="fa fa-download"></i> 导出 <span class="badge pull-right"></span> </a>
                </li>
            </ul>
        </div>
    </div>
</div>



