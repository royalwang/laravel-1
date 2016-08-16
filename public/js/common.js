//右键菜单
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


//罩子
;(function($){
	var copyLoaction = function(obj1,obj2){
		var mask_w = $(obj2).outerWidth(),
			mask_h = $(obj2).outerHeight(),
			mask_t = $(obj2).offset().top ,
			mask_l = $(obj2).offset().left ;

		obj1.css({
			'position': 'absolute',
			'width':  mask_w,
			'height': mask_h,
			'top':    mask_t,
			'left' :  mask_l,
		});	

		var content = obj1.find('.covermask-content').eq(0);
		content.css({
			'position': 'absolute',
			'top':    (mask_h - content.height() - 100) / 2,
			'left' :  (mask_w - content.width()) / 2,
		});
		return obj1;
	};

	$.fn.extend({
		covermask:function(options){
			var defaluts = {
				text : 'loading' ,
				bstyle : {

				},
				cstyle : {
					width:380,
				},
			};

			var opt = $.extend(defaluts , options || false );
			
			var createMask = function(obj){
				var container  = '<div class="covermask">';
					container += '<div class="covermask-bg"></div>';
					container += '<div class="covermask-content">';
					container += '<div class="covermask-text">';
					container +=  opt.text;
					container += '</div>';
					container += '</div>';
					container += '</div>';

				$mask = $(container);
				$mask.css(opt.bstyle);
				$mask.find('.covermask-content').css(opt.cstyle);

				return copyLoaction($mask,obj);	

			};

			var init = function(obj){
				return obj.each(function(index) {

					var $key = $(this).attr('data-covermask-key');
					var $mask = $('body').children('div[data-covermask-key='+$key+']');	
					if($key!=undefined  &&  $mask && $mask != undefined) {
						$mask.show();
					}else{
						$mask = createMask($(this));
						var key = Math.random().toString().replace(".", "");
						$(this).attr({'data-covermask-key': key});
						$mask.attr('data-covermask-key', key);
						$('body').append($mask);
					}				
				});
			};

			return init(this);
			
		},
		changeMask:function(){
			var init = function(obj){
				return obj.each(function(index, el) {
					var $key = $(this).attr('data-covermask-key');
					var $mask = $('body').children('div[data-covermask-key='+$key+']');		
					if($mask) {
						copyLoaction($mask,$(el));
					}	
				});
			};

			return init(this);
		},
		hidemask:function(){
			return this.each(function(index, el) {
				var $key = $(el).attr('data-covermask-key');
				var $mask = $('body').children('div[data-covermask-key='+$key+']');	
				if($mask && $mask != undefined) $mask.hide();
			});
		},
	});
})(jQuery);
