@extends('layouts.app')


@section('main-content')
    

<div class="row" style="padding:20px;">

    <style type="text/css">
    .setting-content{
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        box-shadow: 1px 1px 4px #ccc;
    }
    </style>


    <div class="col-md-2">

        @include('setting.sidebar')

    </div>

    <div class="col-md-10">

        <div class="setting-content">

            @yield('setting-content')

        </div>
    </div>
</div>

@endsection
