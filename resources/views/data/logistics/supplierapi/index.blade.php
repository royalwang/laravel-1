@extends('layouts.empty')

@section('htmlheader_title')
	钦点货物
@endsection


@section('main-content')

<style>
.products{
	z-index: 5;
	width: auto;
	height: auto;
	padding:20px;
	position: relative;
}
.disabled-bg{
	display: none;
	position: absolute;
	width: 100%;
	height: 100%;
	left: 0;top: 0;
	z-index: 7;
}
.products.disabled .disabled-bg{
	display: block;
}
.product{ 
	padding:5px;
	position: relative;
	border: 1px solid #888;
	border-radius: 3px;
	box-shadow: 1px 1px 3px #ccc;
	margin-bottom: 20px;
}
.products.disabled .product{
	box-shadow:none;
}
.attribute{
	font-size:12px;
	margin-bottom:10px; 
}
.attribute span{
	color:red;
}
.image{
	height: 150px;
	margin: 0 auto;
}
.bottom{
}
.btn-save{
	box-shadow: 1px 1px 2px #aaa;
}
.btn-save:hover{
	border-color: red;color:red;background-color:#fff;
}
.products.disabled .btn{
	color: #ccc;
}
</style>

<div class="container">

	<div class="products row {{ ($link->type==1)?' disabled':'' }}">
		<div class="disabled-bg"></div>
		@foreach($products as $product)
		<div class="col-lg-2 col-md-3 col-sm-4 col-xs-6">
			<div class="product">
				<div class="image" title="{{ $product->info->products_name }}"><img style="max-height: 100%;max-width: 100%" src="{{ $product->info->products_image }}" /></div>
				<div class="attribute row">
					<div class="col-xs-6">尺寸: <span>{{ $product->info->products_attribute }}</span></div>
					<div class="col-xs-6">数量: <span>{{ $product->info->products_quantity }}</span></div>
				</div>
				<div class="bottom">
					<div class="btn-group" style="width: 100%">
						<button class="btn btn-exit btn-default{{ ($product->type==1)?' active':'' }}" data-id="{{ $product->id }}" data-value="1">有货</button>
						<button class="btn btn-lack btn-default{{ ($product->type==-1)?' active':'' }}" data-id="{{ $product->id }}" data-value="-1">没货</button>
					</div>
				</div>
			</div>
		</div>
		@endforeach
	</div>


	<div style="position: fixed; top: 50px;right:50px; z-index: 6">
		@if($link->type==1)
		<button class="btn btn-save disabled">已锁定</button>
		@else
		<button class="btn btn-save">确认锁定</button>
		@endif
	</div>

</div>

<script type="text/javascript">
	$('.btn-exit,.btn-lack').click(function(event) {
		var _this = $(this);
		var _text = _this.text();
		_this.addClass('disabled');
		_this.text('...doing');
		if(_this.hasClass('active')) return;
		$.ajax({
			url: '{{ url('supplierapi') }}',
			type: 'PUT',
			dataType: 'json',
			data: {
				code : '{{ $code }}',
				id: _this.data('id') ,
				type: _this.data('value') 
			},
			headers: { 
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
			},
			complete :function(){
				_this.text(_text);
				_this.removeClass('disabled');
			},
			success:function(data){
				if(data.status == 0){
					console.log(data.msg);
				}else{
					_this.addClass('active').siblings().removeClass('active');
				}
			},
			error:function(){
				alert('error');
			}
		});
	});

	$('.btn-save').click(function(event) {
		var _btn = $('.btn-save');
		var _text = _btn.text();
		if( _btn.hasClass('disabled') ) return;

		_btn.addClass('disabled');
		_btn.text('..loading');

		var i = 0;
		$('.product').each(function(index, el) {
			if( $(this).has( $('button.active') ).length == 0 ){
				$(this).css({
					'border-color':'red',
				});
				i++;
			}
		});
		if(i > 0){
			swal({
			  title: '警告',
			  text: "还有" + i + "个产品还没有处理!",
			  confirmButtonText: '关闭'
			});
		}else{
			swal({
			  title: '警告',
			  text: "单子将会锁定",
			  showCancelButton: true,
			  cancelButtonText: '取消',
			  confirmButtonText: '确定'
			}).then(function(){
				$.ajax({
					url: '{{ url('supplierapi/lock') }}',
					type: 'post',
					dataType: 'json',
					data: {
						code : '{{ $code }}'
					},
					headers: { 
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
					},
					success:function(data){
						if(data.status == 1){
							$('.products').addClass('disabled');	
							_btn.text('已锁单');
						}else{
							_btn.text(_text);
							_btn.removeClass('disabled');
						}
					},
					error:function(){
						window.location.reload();
					}
				});	
			},function(){});
		}
		

	});
</script>

@endsection

