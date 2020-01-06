/*********************************
Scripts required for screen composition , 2018
user interface (jquery)
developer p.KIM 
**********************************/
$(document).ready(function(){

	/*
	$('<div class="layer_mask"></div>').prependTo('body');
	$('.layer_mask').html('<div class="loading_wrap"><span class="loader"></span><span class="loading_text">LOADING...</span></div>');
	*/

	//tab swiper slide customer
	if($('.full_Slide').length > 0){
		var myswiper = new Swiper('.full_Slide', {
     		on: {
		      	slideChangeTransitionStart: function(){
					var index = this.activeIndex
					$('.swiper-pagination-switch.on').removeClass('on');
					$('.swiper-pagination-switch').eq(index).addClass('on');
					var actWidth = $('.swiper-pagination-switch.on').width();
					var actPosition = $('.swiper-pagination-switch.on').position();
					var listwid = $(window).width() / 3
					$('.fuls_TabPagbar').css({'left':+ actPosition.left,'width': actWidth});
					$('.scrolling_container').animate({scrollLeft: actPosition.left - listwid});
				}
			}
		});

		$('.fuls_TabPag > ul > li.swiper-pagination-switch > a').on('click', function(event){
			event.preventDefault();
			var position = $(this).parent().position();
		  	var width = $(this).parent().width();
		  	myswiper.slideTo($(this).parent().index());
		  	$('.swiper-pagination-switch').removeClass('on');
			$(this).parent().addClass('on');
			$('.fuls_TabPagbar').css({'left':+ position.left,'width':width});
		});

		var winhei = $(window).height();
		var conTenThei = winhei - 55
		$('.full_Slide').height(conTenThei);

		$(window).resize(function(){
			var winhei = $(window).height();
			var conTenThei = winhei - 55
			$('.full_Slide').height(conTenThei);
		});

		var winWid = $(window).width();
		var listwid = $(window).width() / 4
		var totalwidth = listwid * $('.fuls_TabPag li').length
		$('.scrolling_container').width(winWid);
		$('.fuls_TabPag').width(totalwidth);
		$('.fuls_TabPag li').width(listwid);
		$('.fuls_TabPagbar').width(listwid);

		$(window).resize(function(){
			var winWid = $(window).width();
			var listwid = $(window).width() / 4
			var totalwidth = listwid * $('.fuls_TabPag li').length
			$('.scrolling_container').width(winWid);
			$('.fuls_TabPag').width(totalwidth);
			$('.fuls_TabPag li').width(listwid);
			$('.fuls_TabPagbar').width(listwid);
		});
		
	}
	//순서대로 활성화 스크립트
	$('ol.iNgnum li:first').toggleClass('oN').nextAll().removeClass('oN');
	function ingAddClass(){
		var $off = $('ol.iNgnum li.oN').toggleClass('oN');
		if ($off.next().length) {
			$off.next().toggleClass('oN');
		}else{
			$off.prevAll().last().toggleClass('oN');
		}
	}
	setInterval(ingAddClass, 4000);
	
	var dk_ATab = $('.etAb > li.on > a').attr('href')
	$('#' + dk_ATab).show();
	var $tabAClass = $('.etAb > li > a')
	$tabAClass.off('click').on('click', function(event){
		event.preventDefault();
		$(this).parent().siblings().removeClass('on');
		$('.show_wrap').hide();
		$(this).parent().addClass('on');
		$('#' + $tabATarget).show();
	});

	$('a.mapBtn').off('click').on('click', function(event){
		var src1 = $(this).find('img').attr('src').replace('_on.png','_off.png');
		var src2 = $(this).find('img').attr('src').replace('_off.png','_on.png');
		event.preventDefault();
		if($(this).hasClass('oNactive')){
			$(this).removeClass('oNactive');
			$('.hdendiv').slideUp();
			$(this).find('img').attr('src', src1);
		}else{
			$(this).addClass('oNactive');
			$('.hdendiv').slideDown();
			$(this).find('img').attr('src', src2);
		}
	});

	if($('.pharSlide').length > 0){
	    var swiper1 = new Swiper('.pharSlide', {
     		 on: {
		      	 slideChangeTransitionStart: function(){
					var index = this.activeIndex
					$('.swiper-pagination-switch.on').removeClass('on');
					$('.swiper-pagination-switch').eq(index).addClass('on');
				}
			},
		});

		$('.swiper-pagination-switch').on('click', function(){
			swiper1.slideTo($(this).index());
			$('.swiper-pagination-switch').removeClass('on');
			$(this).addClass('on');
		});
	}

	var dk_BTab = $('.pharTab > li.on > a').attr('href')
	$('#' + dk_BTab).show();

	var $tabBClass = $('.pharTab > li > a')
	$tabBClass.off('click').on('click', function(event){
		var $tabBTarget = $(this).attr('href')
		event.preventDefault();
		$(this).parent().siblings().removeClass('on');
		$('.pamc_show').hide();
		$(this).parent().addClass('on');
		$('#' + $tabBTarget).show();
	});

	var $inpRdo = $('input[type="radio"]')
	var $inpChk = $('input[type="checkbox"]')

	$inpRdo.each(function(){
		$(this).css('display','none');
		$(this).wrap('<span class="radio"/>');
		$('input[type="radio"]:checked').parent().addClass('on');
		$('.radio').off('click').on('click', function(){
			if($(this).hasClass('on')){
				// $(this).removeClass('on').find('input[type="radio"]').removeAttr('checked');
			}else{
				$(this).siblings().removeClass('on').find('input[type="radio"]').removeAttr('checked').prop('checked', false);
				$(this).addClass('on');
				$(this).find('input').attr('checked','true').prop('checked', true);
			}
		});
		$('label[for=' + $(this).attr('id') + ']').html();
	});

	$inpChk.each(function(){
		$(this).css('display','none');
		$(this).wrap('<span class="checkbox"/>');
		$('input[type="checkbox"]:checked').parent().addClass('on');
		$('.checkbox').off('click').on('click', function(){
			if($(this).hasClass('on')){
				$(this).removeClass('on').find('input[type="checkbox"]').removeAttr('checked').prop('checked', false);
			}else{
				$(this).addClass('on');
				$(this).find('input').attr('checked','true').prop('checked', true);
			}
		});
		$('label[for=' + $(this).attr('id') + ']').html();
	});

	// selectBox jquery
	var selectTarget = $('.selectBox select');
	selectTarget.on('blur', function(){
		$(this).parent().removeClass('focus');
	});
	selectTarget.change(function(){
		var select_name = $(this).children('option:selected').text();
		$(this).siblings('label').text(select_name);
	});

	$('.oNoffshow > li > a').off('click').on('click', function(event){
		event.preventDefault();
		if($(this).hasClass('oNshow')){
			$(this).removeClass('oNshow');
			$(this).find('.confirm > em').html('상세보기');
			$(this).next().hide();
		}else{
			$(this).parent().siblings().find('a').removeClass('oNshow').next().hide();
			$(this).parent().siblings().find('.confirm > em').html('상세보기');
			$(this).addClass('oNshow');
			$(this).find('.confirm > em').html('닫기');
			$(this).next().show();
		}
	});


	//input type number maxLength script
	function maxLengthCheck(object){
		if (object.value.length > object.maxLength){
			object.value = object.value.slice(0, object.maxLength);
		}
	}


	var dk_ATab = $('ul[class^="dkTabMenu0"] > li.open > a').attr('href')
	$('#' + dk_ATab).show();

	var $tabAClass = $('ul[class^="dkTabMenu0"] > li > a')
	$tabAClass.off('click').on('click', function(event){
		var $tabATarget = $(this).attr('href')
		event.preventDefault();
		$(this).parent().siblings().removeClass('open');
		$('.showfield').hide();
		$(this).parent().addClass('open');
		$('#' + $tabATarget).show();
		layerhei();
		$(window).resize(function(){
			layerhei();
		});
	});

	$('.showLayerForm').off('click').on('click', function(event){
		event.preventDefault();
		var targetname = $(this).attr('href')
		$('.agreement_layer').stop().show().animate({'right':'0'}, 250);
		$('#' + targetname).trigger('click');
	});

	$('a.preVBTn').on('click', function(clc){
		clc.preventDefault();
		$('.agreement_layer').stop().animate({'right':'-100%'}, 250);
	});

	function layerhei(){
		var windowhei = $('.agreement_layer').outerHeight();
		var toTalHhei = $('.agreement_layer > h2').outerHeight() + $('.agreeMent').outerHeight()
		var scrollhei = windowhei - toTalHhei
		$('.scrollOver').css({'height':scrollhei});
	}


	//풀스크린 레이어 오픈시 footer 영역 복사 구조 변경하는 스크립트
	$(document).ready(function(){
		$('#footer').each(function(){
			var footerhtml = $(this).html()
			$(this).css('display','none');
			$('.login_wrap > form').after('<div id="footer" class="footer_restyle">'+footerhtml+'</div>');
		});
	});


	$('#all_chk').parent().on('click', function(){
		if($(this).hasClass('on')){
			$(this).parent().siblings().find('.agreechk').attr('checked','true').prop('checked',true);
			$(this).parent().siblings().find('.checkbox').addClass('on');
		}else{
			$(this).parent().siblings().find('.agreechk').removeAttr('checked').prop('checked',false);
			$(this).parent().siblings().find('.checkbox').removeClass('on');
		}
	});

	$('a.imglink').on('click', function(event){
		event.preventDefault();
		$('.fslide').stop().animate({
			right:'0'		
		});
		$('a.closeBBtn').on('click', function(event){
			$('.fslide').stop().animate({
				right:'-100%'		
			});
			return false;
		});
	});

});

/*
// 문서의 로딩이 완료 되었을때
$(window).load(function() {
	setTimeout(function(){
		$('.layer_mask').remove();
	}, 1200);	
});
*/

