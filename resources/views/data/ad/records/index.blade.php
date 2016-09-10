@extends('layouts.app2')

@section('htmlheader_title')
	Setting ad
@endsection

@section('subsidebar_title')
	广告数据管理
@endsection

@section('table_title')
	广告录入数据
@endsection

@section('style')
@parent
<link href="{{ asset('/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('select_status')
	<label>&nbsp;账号&nbsp;&nbsp;
		<select name="bind_id" class="url-parameter">
			<option value=''>全部</option>
			@foreach($binds as $bind)
			<option value='{{ $bind->id }}' {{ ($bind->id == $bind_id) ? 'selected' :'' }}>{{ $bind->account->code }} - {{ $bind->vps->ip }}</option>
			@endforeach
		</select>
	</label>

	<label>&nbsp;时间&nbsp;&nbsp;
		<input name='date' style="height:21px;width:180px" type="text" id="reservation" class="url-parameter" value="{{ isset(request()->date)? request()->date :'' }}">
	</label>


	<script type="text/javascript" src="{{ asset('plugins/daterangepicker/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
	<script type="text/javascript">

    $(function() {

        $('#reservation').daterangepicker({
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('#reservation').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY/MM/DD') + '-' + picker.endDate.format('YYYY/MM/DD'));
            $(this).trigger('change');
        });

        $('#reservation').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $(this).trigger('change');
        });

    });

	</script>
@endsection	



@section('table-content')
<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
<thead>
	<tr>
		<th width="35"><input type="checkbox" /></th>
		<th>时间</th>
		<th>广告账号</th>
		<th>广告消费</th>
		<th>广告充值</th>
		<th width="156">操作</th>
	</tr>
</thead>
<tbody class="user-form">
	@foreach($tables as $record)
	<tr>
		<td width="35"><input type="checkbox" /></td>
		<td>{{ date('Y-m-d',$record->date) }}</td>
		<td>{{ $record->binds->account->code }} - {{ $record->binds->vps->ip }}</td>
		<td>$ {{ $record->cost }}</td>
		<td>$ {{ $record->recharge }}</td>
		<td>
			<div class="btn-group">
				@pcan($path . '.edit')
				<a class="btn btn-default" href="{{ route($path . '.edit' , $record->id) }}"><i class="fa fa-edit"></i></a>
				@endpcan
				@pcan($path . '.destroy')
				<button class="btn btn-danger table-delete" data-href="{{ route( $path . '.destroy' , $record->id ) }}"><i class="fa fa-trash"></i></button>
				@endpcan
			</div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>

@endsection
