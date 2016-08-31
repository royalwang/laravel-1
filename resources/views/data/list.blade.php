@extends('layouts.app')


@section('main-content')
	
	<div style="padding:40px;">
		<div style="margin:40px; padding: 20px; background: #fff; border-radius: 5px; box-shadow: 1px 1px 4px #ccc;">
		@yield('list-content')
		</div>
	</div>	
	
@endsection
