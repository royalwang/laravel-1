<style type="text/css">
ul.side-setting{

}
ul.side-setting li{
    position: relative;
    display: block;
    margin: 5px 0;
}    

.side-setting .active > a, .side-setting .active > a:hover {
    background: #8a6d3b;
    color: #fff;
    border-radius: 3px; 
}

.side-setting  a:hover {
    background: #000;
    color: #fff;
    border-radius: 3px; 
}

.side-setting > li > a {
    position: relative;
    display: block;
    line-height: 35px;
    padding: 0px 15px 0 60px;
    color: #000;
}

.side-setting a > i {
    position: absolute;
    left: 27px;
    line-height: 35px;
}
</style>



<ul class="side-setting">
    @foreach($sidebar_setting as $value)
    <li class="{{ (isset($value['active'])?'active':'') }}">
        <a href="{{ route($value['url']) }}">
            <span class="badge pull-right"></span>
            <i class="fa {{ $value['icon'] }}"></i> {{ $value['name'] }}
        </a>
    </li>
    @endforeach
</ul>
