<div class="col-md-2">
    <div class="box box-solid">
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
</div>



