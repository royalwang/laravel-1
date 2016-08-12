@extends('layouts.app')

@section('htmlheader_title')
	Manger User
@endsection

@section('style')
@parent
<link href="{{ asset('/css/adaccountstly.css') }}" rel="stylesheet">
<script type="text/javascript" src="{{ asset('/js/jquery.dragsort-0.5.2.min.js') }}"></script>
@endsection

@section('main-content')
	
	
<div class="cover">
	<div class="cover-bg"></div>
	<div class="cover-content">
		<span></span>
	</div>
</div>	
<div class="container">


	<style type="text/css">

		.drag-bg{
			width: 100%;
		    list-style-type: none;
		    margin: 0px;
		    padding: 0;
		    min-height: 350px;
		    background-color: #fff;
		    padding: 10px;
		}
		#show.drag-bg{
			border: 1px solid #71c361;
		}
		#hidden.drag-bg{
			border: 1px solid #bb1f1f;
		}		
		.drag-bg li{ float:left; padding:5px; } 

		.drag-bg li div {
			padding: 0px 18px;
		    height: 31px;
		    background-color: #000;
		    text-align: center;
		    color: #fff;
		    line-height: 31px;  
		    font-size: 14px;
    		letter-spacing: 0.5px;
		}
		.placeHolder div { background-color:white !important; border:dashed 1px gray !important; }
	</style>
	<div class="row">
		<div class="col-md-12"><h2>{{ trans('adtable.ad_account_style_title') }}</h2></div>
	</div>
	<div class="row">
		<div class="col-md-12">
			@foreach($ad_account_status as $account_statu)
				<div class="account-status-bg status status-{{ $account_statu->id }}" data-id="{{ $account_statu->id }}">{{ $account_statu->name }}</div>
			@endforeach
		</div>
	</div>
	<div class="row">
		<div class="col-md-6"><h4>{{ trans('adtable.ad_account_show') }}</h4></div>
		<div class="col-md-6"><h4>{{ trans('adtable.ad_account_hidden') }}</h4></div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<ul id="show" class="drag-bg clearfix">
				@foreach($show_accounts as $account)
				<li data-id="{{ $account->id }}" data-status-id="{{ $account->ad_account_status_id }}"><div class="status status-{{ $account->ad_account_status_id }}">{{ $account->code }}</div></li>
				@endforeach
			</ul>
		</div>
		<div class="col-md-6">
			<ul id="hidden" class="drag-bg clearfix">
				@foreach($hidden_accounts as $account)
				<li data-id="{{ $account->id }}" data-status-id="{{ $account->ad_account_status_id }}"><div class="status status-{{ $account->ad_account_status_id }}">{{ $account->code }}</div></li>
				@endforeach
			</ul>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<button class="right">submit</button>
		</div>
	</div>
	<script type="text/javascript">
		$("#show, #hidden").dragsort({ dragSelector: "div", dragBetween: true, dragEnd: saveOrder, placeHolderTemplate: "<li class='placeHolder'><div></div></li>" });
		function saveOrder() {
			var data = $("#show li").map(function() { return $(this).children().html(); }).get();
			$("input[name=list1SortOrder]").val(data.join("|"));
		};

		var json;
		function getAccountStyle() {
			json = {};
			$('#show li').each(function(index) {
				var str = {
					'id':$(this).attr('id'),
					'hidden':0,
					'sort':index,
				};
				json.push(str);
			});
			$('#hidden li').each(function(index) {
				var str = {
					'id':$(this).attr('id'),
					'hidden':1,
				};
				json.push(str);
			});
		};
		function saveAccountStyle(){

		}
	</script>

</div>




<script type="text/javascript">
;(function($){
	var D = $(document).data("func", {});
	document.onclick = function(){
		$.contentMenu.remove();
	};

	document.oncontextmenu = function(){
		$.contentMenu.remove();
	};


	$.contentMenu = $.noop;
	$.fn.contentMenu = function(dataarray,options) {
		var defaults = {
			beforeShow: $.noop,
			afterShow: $.noop,
		};

		var cfun = options;

		var menuhtml = '<div class="page_menu"><ul class="clearfix"></ul></div>';

		var createMenu = function(){
			return $(menuhtml);
		}
		var addMenuItem = function($menu,obj){
			var array = dataarray;
			if($.isArray(array)){
				for (var i=0,n= array.length; i < n; i++) {
					var $item  = $('<li><a><span class="img"><i data-id="'+ array[i][0]+'"></i></span>'+
								'<span class="content">' + array[i][1] + '</span></a></li>');
					$item.click(function(){
						cfun(obj,$(this).find('i').attr('data-id'));
					});
					$menu.children('ul').append($item);
				}
			}
			return $menu;
		}

		var showMenu = function(obj){
			$menu = addMenuItem(createMenu(),obj);
			$('body').append($menu);
			return $menu;
		};

	

		return this.each(function(index, el) {
			el.oncontextmenu = function(e){

				e = e || window.event;
				e.cancelBubble = true;
				if (e.stopPropagation) {
					e.stopPropagation();
				}
		
				$.contentMenu.remove();

				var $menu = showMenu(this);
				$menu.css({
					left: e.clientX ,
					top: e.clientY + D.scrollTop(),
				});
				$menu.find('i[data-id = '+ $(this).attr('data-status-id') +']').addClass('fa fa-check');

				D.data("target", $menu);

				return false;
			};

		});
	};

	$.extend($.contentMenu, {
		hide: function() {
			var target = D.data("target");
			if (target && target.css("display") === "block") {
				target.hide();
			}		
		},
		remove: function() {
			var target = D.data("target");
			if (target) {
				target.remove();
			}
		}
	});
	
})(jQuery);

var data =  [];
@foreach($ad_account_status as $account_statu)
data.push(['{{ $account_statu->id }}','{{ $account_statu->name }}']);
@endforeach


$("#show li").contentMenu(data,function(obj,id){
	$(obj).attr('data-status-id',id);
	$(obj).children('div').attr('class','status status-'+id);
});


</script>
	
@endsection
