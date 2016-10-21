@extends('layouts.empty')

@section('htmlheader_title')
	钦点货物
@endsection


@section('main-content')


<div class="">
	
@foreach($products as $product)
<div class="product pull-left" style="padding:20px;width: 300px;height:300px;">
	<div class="name">{{ $product->products_name }}</div>
	<img style="width:100%" src="{{ $product->products_image }}" />
	<div class="bottom">
		<div class="num"></div>
		<div class="btn-group pull-right">
			<button class="btn btn-default">有货</button>
			<button class="btn btn-default">没货</button>
		</div>
	</div>
</div>
@endforeach

</div>


@endsection

