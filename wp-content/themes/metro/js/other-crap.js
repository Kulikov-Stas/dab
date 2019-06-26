var android = (navigator.platform.indexOf('android' >=0));

if(navigator.userAgent.match(/(iPhone|iPod|iPad)/i) || android == true) {
	setTimeout(function(){
		$('.logo').animate({
			left:0
		},400);
		$('.contacts').animate({
			right:20
		},400);
		$('.nav').animate({
			opacity:1
		},400);
	},350);	
} 


else {
	$(window).on('load', function () { 
	    $('#preloader').delay(200).fadeOut('fast');	
	    $('.fon').fadeOut('fast')
		var	offset = 55,
			widthStock =25,
			tapeHeight = Math.round(($(window).height()-offset)/3),
			wWidth = $(window).width(),
			widthArr = []  
	    // $('.fon').fadeOut('fast')
	  	$('.scrolling-tape').each(function(){
			$(this).children('.img-holder').children('a').children('img').height(tapeHeight);
			$(this).children('.img-holder').children('a').height(tapeHeight);		
			var _this = this;
			var summWidth = 0;		
			$(this).children('.img-holder').children('a').children('img').each(function(){
				summWidth += $(this).width()
				$(_this).width(summWidth+widthStock);
				if ($(this).offset().left < wWidth) {
					$(this).addClass('showIt')
				}
			});
			getMaxWidth.apply(summWidth)
		});  

	  	function getMaxWidth () {
	  		widthArr.push(this);
	  		var max = Math.max.apply(0,widthArr);
	  		$('.content').width(max) 
	  	}

		function showIt(){
			var v = $(".img-holder img.showIt"), cur = 0;
			for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
			function fadeInNextImg() {
			  v.eq(cur++).animate({
			  	opacity:1
			  },300)
			  if(cur != v.length) setTimeout(fadeInNextImg, 40);
			}
			fadeInNextImg();	
		}	
		setTimeout(function(){
			showIt()
		},600)

	});

	$(function(){
		setTimeout(function(){
			showIt();
		},450);

		var time = 350,
			offset = 70,
			widthStock =700,
			tapeHeight = Math.round(($(window).height()-offset)/3),
			wWidth = $(window).width();

		//resize func
		$(window).resize(function(){
			var offset = 63,
			wWidth = $(window).width(),
			tapeHeight = Math.round(($(window).height()-offset)/3);

			$('.scrolling-tape').each(function(){
				$(this).children('.img-holder').children('a').height(tapeHeight);			
				$(this).height(tapeHeight);
				$(this).children('.img-holder').children('a').children('img').height(tapeHeight);
			});
	 		var b = $(window).scrollLeft();
	        $('.scrolling-tape .img-holder').not('.showIt').each(function(){
	        	var offsetRight = $(this).offset().left + $(this).outerWidth();
	        	if  (wWidth+b+300 > offsetRight ) {
	        		$(this).children('a').children('img').addClass('govisible')
	        	}
	        });			

		});

		var lastScrollLeft = 0;
		$(window).scroll(function() {
		    var documentScrollLeft = $(document).scrollLeft();
		    if (lastScrollLeft != documentScrollLeft) {
		        lastScrollLeft = documentScrollLeft;
		 		var b = $(window).scrollLeft();
		        $('.scrolling-tape .img-holder').not('.showIt').each(function(){
		        	var offsetRight = $(this).offset().left + $(this).outerWidth();
		        	if  (wWidth+b+500 > offsetRight ) {
		        		$(this).children('a').children('img').addClass('govisible')
		        	}
		        });	
		    }
			var scroll = $(window).scrollTop();	
			if ($('.content-inner').length) {
				if (scroll >= $('.official').offset().top) {
					$('.scroll-up').fadeIn('fast')
				} else {
					$('.scroll-up').fadeOut('fast')
				}			
			}

		});

		//timeFunction
		setTimeout(function(){
			$('.logo').animate({
				left:0
			},400);
			$('.contacts').animate({
				right:20
			},400);
			$('.nav').animate({
				opacity:1
			},400);
		},time);

		function getScrollX() {
			return (window.pageXOffset != null) ? window.pageXOffset : (document.documentElement.scrollLeft != null) ? document.documentElement.scrollLeft : document.body.scrollLeft;
		}
		function getScrollY() {
			return (window.pageYOffset != null) ? window.pageYOffset : (document.documentElement.scrollTop != null) ? document.documentElement.scrollTop : document.body.scrollTop;
		}

		var c = $('.scrolling-tape').width()+widthStock; 
		//scroll
		if ($('.index-page').length) {
	 		$(window).mousewheel(function(event, delta) {
				if(Math.abs(delta)>=20)
					delta/=80;

				event.preventDefault();
				var curScroll = {
					x:getScrollX(),
					y:getScrollY()
				};
				TweenMax.to(curScroll, 0.6, {
					x:curScroll.x-(delta * 500),
					onUpdate:function() {
						window.scrollTo(curScroll.x, curScroll.y);
					}
				});
			});   		
		}

		//random func
		function showIt(){
			var v = $(".img-holder img.showIt"), cur = 0;
			for(var j, x, i = v.length; i; j = parseInt(Math.random() * i), x = v[--i], v[i] = v[j], v[j] = x);
			function fadeInNextImg() {
			  v.eq(cur++).animate({
			  	opacity:1
			  },300)
			  if(cur != v.length) setTimeout(fadeInNextImg, 30);
			}
			fadeInNextImg();	
		}

		$('.scroll-up').click(function(){
			$('html,body').animate({
				scrollTop:0
			},'slow');
			return false
		})
	});
}
