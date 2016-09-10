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
		

		var content = obj1.find('.covermask-content').eq(0);
		if(content.css('position') == 'fixed'){
			var mask_w = $(window).width(),
				mask_h = $(window).height();

			obj1.css({
				'position' : 'fixed',
				'width':  mask_w,
				'height': mask_h,
				'top':    0,
				'left' :  0,
			});	
			content.css({
				'top':    (mask_h - content.height()) / 2,
				'left' :  (mask_w - content.width()) / 2,
			});
		}else{
			var mask_w = $(obj2).outerWidth(),
				mask_h = $(obj2).outerHeight(),
				mask_t = $(obj2).position().top ,
				mask_l = $(obj2).position().left ;

			obj1.css({
				'position' : 'absolute',
				'width':  mask_w,
				'height': mask_h,
				'top':    mask_t,
				'left' :  mask_l,
			});	
			content.css({
				'top':    (mask_h - content.height()) / 2,
				'left' :  (mask_w - content.width()) / 2,
			});
		}
		
		return obj1;
	};

	$.fn.extend({
		covermask:function(options){
			var defaluts = {
				text : 'loading' ,
				bstyle : {
					position:'absolute',
				},
				cstyle : {
					width:380,
					position:'absolute',
				},
			};

			var opt = $.extend(defaluts , options || false );
			
			var createMask = function(){
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

				return $mask;

			};

			var init = function(obj){
				return obj.each(function(index) {

					var $key = $(this).attr('data-covermask-key');
					var $mask = $('body').find('div.covermask[data-covermask-key='+$key+']');	
					if($key!=undefined && $mask && $mask != undefined) {
						$mask.css('display','block');
					}else{
						$mask = createMask();
						var key = Math.random().toString().replace(".", "");
						$(this).attr({'data-covermask-key': key});
						$mask.attr('data-covermask-key', key);
						var obj = $(this);
						if(opt.cstyle.position == 'fixed'){
							obj = $('body');
							$('body').append($mask);
						}else{
							obj = $(this);
							$(this).before($mask);
						}
						copyLoaction($mask,obj);
						$(window).resize(function(){
							copyLoaction($mask,obj);
						});
					}				
				});
			};

			return init(this);
			
		},
		hidemask:function(){
			return this.each(function(index, el) {
				var $key = $(el).attr('data-covermask-key');
				var $mask = $('body').find('div.covermask[data-covermask-key='+$key+']').eq(0);	
				if($mask && $mask != undefined) $mask.hide();
			});
		},
		removemask:function(){
			return this.each(function(index, el) {
				var $key = $(el).attr('data-covermask-key');
				var $mask = $('body').find('div[data-covermask-key='+$key+']').eq(0);	
				if($mask && $mask != undefined) $mask.remove();
			});
		},
	});
})(jQuery);


//scroll fixed
;(function($){

	$.fn.extend({
		scrollFixed:function(bottom,addclass){

			var scroll = function(obj,clone){
				clone.css({
					width: obj.outerWidth(),
					left: obj.offset().left,
				});
				var stop = $(document).scrollTop();
				if(stop > (obj.offset().top - window_height + obj.height() )){
					clone.css({display:'none'});
				}else{
					clone.css({display:'block'});
				}
			}

			return this.each(function(index) {			
				
				var this_clone = $(this).clone();
				this_clone.addClass(addclass);
				this_clone.css({
					width: $(this).outerWidth(),
					height: $(this).height(),
					left: $(this).offset().left,
					position : 'fixed',
					display:'none',
					zIndex : '999' ,
					bottom: bottom,
				});

				var that = $(this);
				$(this).after(this_clone);

				scroll(that,this_clone);
				$(document).scroll(function() {
					scroll(that,this_clone);
				});		

				$(window).resize(function(event) {
					scroll(that,this_clone);
				});
			});
			
		},
	});
})(jQuery);