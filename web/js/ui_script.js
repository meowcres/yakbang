/*********************************

The default action script , 2019
user interface (jquery)
developer p.KIM 

**********************************/
$(document).ready(function(){

	$('.chkbox .closeTbtn').on('click', function(e){
		e.preventDefault();
		$(this).parents('.htop').slideUp();
		
		if($('.hamMenu').css('display') == 'block'){
			$('.header').css({
				top : '0'
			});
			$('.hamMenu').css({
				top : '27px'
			});
		}

	});
	if($('.htop').css('display') == 'block'){
		$(window).scroll(function(){
			if ($(window).scrollTop() > 20) {
				$('.header').css({
					top : '0'
				});
				$('.hamMenu').css({
					top : '27px'
				});
			}else if($('.htop').css('display') == 'none'){
				$('.header').css({
					top : '0'
				});
				$('.hamMenu').css({
					top : '27px'
				});
			}else{
				$('.header').css({
					top : '68px'
				});
				$('.hamMenu').css({
					top : '95px'
				});
				if($(window).outerWidth() >= 1025){
					$('.header').css({
						top : '0'
					});
				}
			}
		});
	}

	// 개인정보취급정보 / 이용약관 / 위치기반서비스 레이어

	var e_Tab = $('ul.eTabMenu > li.open > a').attr('href')
	$('#' + e_Tab).show();

	var $etabClass = $('ul.eTabMenu > li > a')
	$etabClass.off('click').on('click', function(event){
		var $etabTarget = $(this).attr('href')
		event.preventDefault();
		$(this).parent().siblings().removeClass('open');
		$('.showfield').hide();
		$(this).parent().addClass('open');
		$('#' + $etabTarget).show();

	});
	
	$('a.showLayer').off('click').on('click', function(event){
		event.preventDefault();
		var etargetname = $(this).attr('href')
		$('.modal_fbody').show();
		$('#' + etargetname).trigger('click');
	});

	$('a.close_modal').on('click', function(clc){
		clc.preventDefault();
		$('.modal_fbody').hide();
	});

	var modalhei = $(window).outerHeight() - 120;
	var modalhead = $('.eTabMenu').outerHeight();
	var totalcNt = modalhei - modalhead

	$('.showfield').height(totalcNt);

	$(window).resize(function(){
		if($('.htop').css('display') == 'block'){
			$('.header').css({
				top : '68px'
			});
			$('.hamMenu').css({
				top : '95px'
			});
			if($(window).outerWidth() >= 1025){
				$('.header').css({
					top : '0'
				});
			}
		}else if($('.htop').css('display') == 'none'){
			$('.header').css({
				top : '0'
			});
			$('.hamMenu').css({
				top : '27px'
			});
		}else{
			$('.header').css({
				top : '0'
			});
			$('.hamMenu').css({
				top : '27px'
			});
		}
		if($(window).scrollTop() > 0){
			$('.header').css({
				top : '0'
			});
			$('.hamMenu').css({
				top : '27px'
			});
		}

		var modalhei = $(window).outerHeight() - 120;
		var modalhead = $('.eTabMenu').outerHeight();
		var totalcNt = modalhei - modalhead

		$('.showfield').height(totalcNt);
	});

		if($(window).width() <= 767){
			$('.htop').css({
				'display' : 'none'
			});
		}else{
			$('.htop').css({
				'display' : 'block'
			});
		}

		$(window).resize(function(){
			if($(window).width() <= 767){
				$('.htop').css({
					'display' : 'none'
				});
			}
		});

	$('a.hamMenu').off('click').on('click', function(e){
	    e.preventDefault();
	    if($(this).hasClass('acTive')){
	        $('.gnb').stop().animate({
	            right:'-280px'
	        }, 250);
	        $(this).removeClass('acTive');
	        $('.gnb_mask').remove();
	    }else{
	    	$('.gnb').stop().animate({
	            right:0
	        }, 250);
	        $('<div class="gnb_mask"></div>').show().prependTo('.header');
	        $(this).addClass('acTive');
	    }
	});

	function mainSlider(){
		var swiper = new Swiper('.main_slide', {
			pagination: {
				el: '.main_nav',
				clickable: true,
			},
			autoplay: {
				delay: 4500,
				disableOnInteraction: false,
		    },
			stop: true,
			loop: true,
			paginationBulletRender: function(index, className){
				return '<li class="'+className+'">'+(index)+'</li>'
			}
		});

		$('.stopSlide_btn').off('click').on('click', function(){
			if($(this).hasClass('on')){
				$('.stopSlide_btn').removeClass('on');
				swiper.autoplay.start();
			}else{
				$('.stopSlide_btn').addClass('on');
				swiper.autoplay.stop();
			}
		});

	}
	if($('.main_slide').length > 0 ){
		mainSlider();
	}

	function epSlider(){
		var swiper = new Swiper('.ep_slide', {
			pagination: {
				el: '.swiper-pagination',
				clickable: true,
			},
			autoplay: {
				delay: 4500,
				disableOnInteraction: false,
		    },
			loop: true
		});
	}
	if($('.ep_slide').length > 0 ){
		epSlider();
	}

	//숫자 카운팅
	$('.counter').counterUp({
		delay: 25,
		time: 2000
	});

	$(window).scroll(function(){
		var scrollTop = $(window).scrollTop();
		$('.content section').each(function(index){
			if ($(this).position().top - 150  <= scrollTop) {
                $(this).next().addClass('animate');
            }
		});

	});

	$('ul.slideMenu > li > a.showclick').on('click', function(event){
	    event.preventDefault();
	    if($(this).hasClass('on')){
	        $(this).removeClass('on');
	        $(this).next('div').slideUp(200);
	    }else{
	        $(this).parent().siblings().find('a').removeClass('on').next('div').slideUp(200);
	        $(this).addClass('on');
	        $(this).next('div').slideDown(200);
	    }
	});

});