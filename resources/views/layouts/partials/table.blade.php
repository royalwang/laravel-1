<link rel="stylesheet" type="text/css" href="{{ asset('css/dataTables.bootstrap.css') }}">
<div class="col-md-10">
    <div class="box">
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
                    <div class="col-sm-6">
                        <div class="dataTables_length" id="example1_length">
                                <label>Show 
                                    <select name="example1_length" aria-controls="example1" class="form-control input-sm">
                                        <option value="20">20</option>
                                        <option value="25">30</option>
                                        <option value="50">50</option>
                                    </select> entries</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="example1_filter" class="dataTables_filter">
                            <div class="btn-group">
                            <a class="btn btn-default" href="{{ route($path .'.create') }}"><i class="fa fa-plus"></i></a>
                            <button class="btn btn-danger" onclick=""><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
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
</script>
