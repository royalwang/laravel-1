@extends('layouts.app2')

@section('htmlheader_title')
	Setting ad
@endsection

@section('subsidebar_title')
	广告数据管理
@endsection

@section('table_title')
	已绑定账号列表
@endsection


@section('select_status')
	<label>&nbsp;状态&nbsp;&nbsp;
		<select name="status" class="url-parameter">
			<option value=''>全部</option>
			<option value='1' {{ (($status == 1)?'selected':'' ) }}>已投放</option>
			<option value='0' {{ (($status !='' && $status == 0)?'selected':'' ) }}>未投放</option>
			<option value='-1' {{ (($status == -1)?'selected':'' ) }}>已封</option>
		</select>
	</label>
@endsection	



@section('table-content')
	


<table class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
<thead>
	<tr>
		<th width="35"><input type="checkbox" /></th>
		<th>编号</th>
		<th>VPS</th>
		<th>网站</th>
		<th width="100">操作</th>
	</tr>
</thead>
<tbody class="user-form">
	@foreach($tables as $bind)
	<tr>
		<td width="35"><input type="checkbox" /></td>
		<td>{{ $bind->account->code }}</td>
		<td>{{ $bind->vps->ip }}</td>
		<td>{{ $bind->site->host }}</td>
		<td width="156">
			<div class="btn-group">
			<a class="btn btn-default" href="{{ route($path.'.show' , $bind->id) }}"><i class="fa fa-eye"></i></a>

			<div class="dropdown btn btn-default">
				<span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ><i class="fa fa-reorder"></i></span>
				<ul class="dropdown-menu status" role="menu" aria-labelledby="dLabel">
					<li class="{{ (($bind->status == 0)?'active':'' ) }}"><a data-value="0">未投放</a></li>
					<li class="{{ (($bind->status == 1)?'active':'' ) }}"><a data-value="1">已投放</a></li>
					<li class="{{ (($bind->status == -1)?'active':'' ) }}"><a data-value="-1">已被封</a></li>
				</ul>
			</div>
			@pcan($path . '.edit')
			<a class="btn btn-default" href="{{ route($path . '.edit' , $bind->id) }}"><i class="fa fa-edit"></i></a>
			@endpcan
			</div>
		</td>
	</tr>
	@endforeach
</tbody>
</table>



@endsection
