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
						if($.isFunction(cfun))
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