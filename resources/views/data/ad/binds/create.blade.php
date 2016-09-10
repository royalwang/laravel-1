@extends('layouts.app3')

@section('htmlheader_title')
    Setting AD
@endsection

@section('subsidebar_title')
    广告数据管理
@endsection

@section('form_title')
    绑定新账号
@endsection

@section('style')
@parent
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('form-content')


<form class="form-horizontal" name="form" action="{{ route($path.'.store') }}" method="post">
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-2">广告账号</label>
        <div class="col-sm-8"><select class="form-control ajax-select-accounts" name="accounts_id" data-ajax--url="{{ route('data.ad.accounts.ajax.index') }}">
            <option value="-1" selected="selected">账号ID</option>
        </select></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">广告VPS</label>
        <div class="col-sm-8"><select class="form-control ajax-select-vps" name="vps_id" data-ajax--url="{{ route('data.ad.vps.ajax.index') }}">
            <option value="-1" selected="selected">VPS-IP</option>
        </select></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">网站</label>
        <div class="col-sm-8"><select class="form-control ajax-select-sites" name="sites_id" data-ajax--url="{{ route('data.site.sites.ajax.index') }}">
            <option value="-1" selected="selected">Url</option>
        </select></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">状态</label>
        <div class="col-sm-8">
            <select class="form-control disable" name="status" disabled="disable">
                <option value='0' selected="select">未投放</option>
                <option value='1'>已投放</option>
                <option value='-1'>已封</option>
            </select>
        </div>
    </div>
</form>


<script type="text/javascript" src="{{ asset('plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript">
$.fn.select2.defaults.set("ajax--cache", false);

var defalut_value =  {
    ajax: {
        data: function (params) {
            if(params != undefined){
                if(params.term == undefined){
                    return {page: params.page};
                }else{
                    return {
                        q: params.term, 
                        page: params.page
                    };
                }
            }
        },
        processResults: function (data) {
            return {
                results: data.item,
                pagination: {
                  more: data.more
                }
            };
        }
    }
};

$(".ajax-select-vps").select2(defalut_value);
$('.ajax-select-accounts').select2(defalut_value);
$('.ajax-select-sites').select2(defalut_value);


</script>

@endsection

	
