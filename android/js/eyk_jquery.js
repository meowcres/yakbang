/*********************************
Scripts required for screen composition , 2018
user interface (jquery)
developer p.KIM 
**********************************/
$(document).ready(function(){

	$('.showmyLayer').on('click', function(event){
		event.preventDefault();
		var showLayer = $(this).attr('href')
		$( '<div class="syrup_mymask"></div>' ).prependTo('body');
		$('.syrup_mypage_layer').hide();
		$('#' + showLayer ).show();
		layerhei();
	});

	$('a.closeBTn').on('click', function(clc){
		clc.preventDefault();
		$('.syrup_mymask').remove();
		$('.syrup_mypage_layer').hide();
		$('.slidePopup').hide();
	});

	function layerhei(){
		var windowhei = window.outerHeight - 15;
		var scrollhei = windowhei - $('.mypageLayer_wrap > h2').outerHeight()
		$('.layer_coNt').css({'height':scrollhei});
	}

	$(window).resize(function(){
		layerhei();
	});

	$('.layer_coNt input').each(function(){
		$(this).on('focus', function(){
			var target = $(this).position().top - 70
			$('.layer_coNt').stop().animate({
				scrollTop : target
			});
		});
	});


	//수량기입
	$('.btn_quantity a.plusBTn').on('click', function(btn){
		btn.preventDefault();
		var numing = $(this).parent().find('input').val();
		var num = parseInt(numing,10);
		num++;
		if(num > 100){
			alert('더이상 수량을 늘릴 수 없습니다.');
			num = 100;
		}
		$(this).parent().find('input').val(num);
	});

	$('.btn_quantity a.minusBTn').on('click', function(btn){
		btn.preventDefault();
		var numing = $(this).parent().find('input').val();
		var num = parseInt(numing,10);
		num--;
		if(num <= 0){
			alert('더이상 수량을 줄일 수 없습니다.');
			num = 1;
		}
		$(this).parent().find('input').val(num);
	});

	$('input[type="radio"]').each(function(){
		$(this).css('display','none');
		$(this).wrap('<span class="radio"/>');
		$('input[type="radio"]:checked').parent().addClass('on');
		$('.radio').off('click').on('click', function(){
			if($(this).hasClass('on')){
				// $(this).removeClass('on').find('input[type="radio"]').removeAttr('checked');
			}else{
				$(this).siblings().removeClass('on').find('input[type="radio"]').removeAttr('checked').prop('checked',false);
				$(this).addClass('on');
				$(this).find('input').attr('checked','true').prop('checked',true);
			}
		});
		$("label[for='"+$(this).attr('id')+"']").html();
	});

	$('input[type="checkbox"]').each(function(){
		$(this).css('display','none');
		$(this).wrap('<span class="checkbox"/>');
		$('input[type="checkbox"]:checked').parent().addClass('on');
		$('.checkbox').off('click').on('click', function(){
			if($(this).hasClass('on')){
				$(this).removeClass('on').find('input[type="checkbox"]').removeAttr('checked').prop('checked',false);
			}else{
				$(this).addClass('on');
				$(this).find('input').attr('checked','true').prop('checked', true);
			}
		});
		$("label[for='"+$(this).attr('id')+"']").html();
	});

	// selectBox jquery
	var selectTarget = $('.selectBox select');
	selectTarget.on('click', function(){
		if($(this).parent().hasClass('focus')){
			$(this).parent().removeClass('focus');
		}else{
			$(this).parent().addClass('focus');
		}
	});
	selectTarget.change(function(){
		var select_name = $(this).children('option:selected').text();
		$(this).siblings('label').text(select_name);
	});

	$('a.option_Active').on('click', function(event){
		event.preventDefault();
		var tagetaa = $(this).attr('href')
		$('#' + tagetaa).toggle();
	});


	$('.showmyLayer00').on('click', function(event){
		event.preventDefault();
		var showLayer = $(this).attr('href')
		$( '<div class="syrup_mymask"></div>' ).prependTo('body');
		$('.slidePopup').hide();
		$('#' + showLayer ).show();
	});

	$('.tablePopup').on('click', function(){
		var targEt = $(this).attr('data-target')
		$('.producT_quest').stop().animate({
			left : '-100%'
		},100);
		$('#' + targEt).show().animate({
			right : 0
		},200);
	});

	$('.prevLayer .preVBTn').on('click', function(event){
		event.preventDefault();
		$('.prevLayer').stop().animate({
			right : '-100%'
		},100);
		$('.producT_quest').stop().animate({
			left : 0
		},200);
	});

	$(document).on('click', 'a.flow_schBTn', function(event){
		event.preventDefault();
		$('.full_search').stop().show().animate({
			right:0
		},100);
	});

	$(document).on('click', 'a.preVBTn', function(event){
		event.preventDefault();
		$('.full_search').stop().animate({
			right : '-100%'
		},100);
	});

});