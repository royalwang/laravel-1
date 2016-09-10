
<link rel="stylesheet" href="{{ asset('plugins/file-upload/css/jquery.fileupload.css') }}">


<div class="col-md-10">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">@yield('table_title')</h3>
            <div class="box-tools pull-right">
                <div class="has-feedback">
                <input type="text" class="form-control input-sm" placeholder="Search Mail">
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                </div>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6" style="line-height:35px;">
                        <div class="dataTables_length pull-left">
                            <label>&nbsp;显示&nbsp;&nbsp;
                                <select name="show" aria-controls="example1" class="url-parameter" data-href="{{ route($path .'.index') }}">
                                    <option value="20" {{ (isset(request()->show) &&  request()->show==20)?'selected':'' }}>20 条</option>
                                    <option value="30" {{ (isset(request()->show) &&  request()->show==30)?'selected':'' }}>30 条</option>
                                    <option value="50" {{ (isset(request()->show) &&  request()->show==50)?'selected':'' }}>50 条</option>
                                </select></label>    
                        </div>
                        <div class="dataTables_length pull-left" style="margin-left:20px;">
                            @yield('select_status')   
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="example1_filter" class="dataTables_filter pull-right">
                            <div class="btn-group">
                                @pcan($path .'.create')
                                <a class="btn btn-default" href="{{ route($path .'.create') }}"><i class="fa fa-plus"></i></a>
                                @endpcan

                                @pcan($path .'.upload')
                                <span class="btn btn-default fileinput-button" ><i class="fa fa-upload"></i><input id="fileupload" type="file" data-href="{{ route($path .'.upload') }}"></span>
                                @endpcan
                                
                                @pcan($path .'.download')
                                <a class="btn btn-default" href="{{ route($path .'.download') }}"><i class="fa fa-download"></i></a>
                                @endpcan

                                @pcan($path .'.destroy')
                                <button class="btn btn-danger" onclick=""><i class="fa fa-trash"></i></button>
                                @endpcan
                                                         
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="progress" class="progress col-sm-12 xxs">
                        <div class="progress-bar progress-bar-success progress-bar-striped"></div>
                    </div>
                </div>
                <div class="row">
	                <div class="col-sm-12">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

	                	@yield('table-content')
	                </div>
                </div>

                <div class="row">
                	<div class="col-sm-5">
                		<div class="dataTables_info" id="example1_info" role="status" aria-live="polite">
                            Showing {{ ($tables->currentPage()-1) * $show +1 }} to {{ $tables->currentPage() * $show }} of {{ $tables->count() }} entries</div>
                	</div>
                	<div class="col-sm-7">
                		<div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                			{!! $tables->appends(['show' => $show])->render() !!}
                		</div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/ajax.js') }}"></script>
<script type="text/javascript">
    $(".table-delete").click(function () {
        Rbac.ajax.delete({
            confirmTitle: '确定删除用户?',
            href: $(this).data('href'),
            successTitle: '用户删除成功'
        });
    });

    $(".deleteall").click(function () {
        Rbac.ajax.deleteAll({
            confirmTitle: '确定删除选中的用户?',
            href: $(this).data('href'),
            successTitle: '用户删除成功'
        });
    });

    $('.url-parameter').change(function(event) {
        window.location.href = setParam($(this).attr('name'),$(this).val());
    });

    function setParam(param,value){
        var query = location.search.substring(1);
        var p = new RegExp("(^|)" + param + "=([^&]*)(|$)");
        var url = '';
        if(p.test(query)){
            //query = query.replace(p,"$1="+value);
            var firstParam=query.split(param)[0];
            var secondParam=query.split(param)[1];

            if(firstParam.length>0){
                url = '?'+firstParam+param+'='+value;
            }else{
                url = '?'+param+'='+value;
            }
            if(secondParam.indexOf("&")>-1){
                url = url + secondParam.substr(secondParam.indexOf("&"));
            }
        }else{
            if(query == ''){
                url = '?'+param+'='+value;
            }else{
                url = '?'+query+'&'+param+'='+value;
            }
        } 
        return url;
    }

</script>


<script src="{{ asset('plugins/file-upload/js/vendor/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('plugins/file-upload/js/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('plugins/file-upload/js/jquery.fileupload.js') }}"></script>

<script>
/*jslint unparam: true */
/*global window, $ */
$(function () {
    'use strict';
    $('#fileupload').fileupload({
        url: $('#fileupload').data('href'),
        dataType: 'json',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')} ,
        done: function (e, data) {
            if(data.result.error_msg && data.result.error_msg.length > 0)
                console.log(data.result.error_msg);
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});
</script>