@extends('layouts.app3')

@section('htmlheader_title')
    Setting AD
@endsection

@section('subsidebar_title')
    广告数据管理
@endsection

@section('form_title')
    修改信息
@endsection

@section('style')
@parent
<link href="{{ asset('/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('form-content')
	
<form class="form-horizontal" name="form" action="{{ route($path.'.update' , $bind->id) }}" method="post">
    {{ method_field('PUT') }}
    {!! csrf_field() !!}
    <div class="form-group">
        <label class="control-label col-sm-2">广告账号</label>
        <div class="col-sm-8"><select class="form-control ajax-select-accounts disabled" disabled="disable">
            <option value="{{ $bind->accounts_id }}" selected="selected">{{ $bind->account->code }}</option>
        </select>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">广告VPS</label>
        <div class="col-sm-8"><select class="form-control ajax-select-vps">
            <option value="{{ $bind->vps_id }}" selected="selected">{{ $bind->vps->ip }}</option>
        </select></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2">网站</label>
        <div class="col-sm-8"><select class="form-control ajax-select-sites">
            <option value="{{ $bind->sites_id }}" selected="selected">{{ $bind->site->host }}</option>
        </select></div>
    </div>

    <div class="form-group">
        <label class="control-label col-sm-2">状态</label>
        <div class="col-sm-8">
            <select class="form-control disable" name="status">
                <option value='1' {{ (($bind->status == 1)?'selected':'' ) }}>已投放</option>
                <option value='0' {{ (($bind->status == 0)?'selected':'' ) }}>未投放</option>
                <option value='-1' {{ (($bind->status == -1)?'selected':'' ) }}>已封</option>   
            </select>
        </div>
    </div>
</form>


<script type="text/javascript" src="{{ asset('plugins/select2/select2.min.js')}}"></script>
<script type="text/javascript">
$.fn.select2.defaults.set("ajax--cache", false);

$(".ajax-select-vps").select2({
    ajax: {
        url: '{{ route('data.ad.vps.ajax.index') }}',
        data: function (params) {
            return {
                q: params.term, // search term
                page: params.page
            };
        },
        processResults: function (data) {
            return {
                results: data
            };
        }
    }
});

$('.ajax-select-sites').select2({
  ajax: {
    url: '{{ route('data.site.sites.ajax.index') }}',
    data: function (params) {
            return {
                q: params.term, // search term
                page: params.page
            };
        },
    processResults: function (data) {
      return {
        results: data
      };
    }
  }
});


</script>

@endsection

	
