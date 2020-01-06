<link rel="stylesheet" type="text/css" href="../css/login.css">
<script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>

<div class="syrup_login_wrap">
	<h2>회원가입<a href="javascript:history.back();" class="preVBTn"><img src="../images/sub/prevTBtn.png" alt="이전버튼 이미지"></a></h2>
	<form action="" method="">
		<fieldset>
			<legend>회원가입폼</legend>
			<div class="inp_field">
				<label for="email_id">이메일 아이디<span class="imporTbullet">*</span></label>
				<input type="text" name="" id="email_id" placeholder="example@eyacbang.com">
			</div>
			<div class="inp_field">
				<label for="syrup_pass">비밀번호<span class="imporTbullet">*</span></label>
				<input type="text" name="" id="syrup_pass" placeholder="8-20자로 입력해주세요.">
			</div>
			<div class="inp_field">
				<label for="syrup_pass01">비밀번호 확인<span class="imporTbullet">*</span></label>
				<input type="text" name="" id="syrup_pass01" placeholder="비밀번호를 한번 더 입력해주세요.">
			</div>
			<div class="inp_field">
				<label for="syrup_name">이름<span class="imporTbullet">*</span></label>
				<input type="text" name="" id="syrup_name" placeholder="이약방">
			</div>
			<div class="inp_field">
				<span class="flabel">생년월일</span>
				<div class="inner_Two">
					<div class="inner_Left">
						<input type="number" name="" title="년도 기입창" placeholder="YYYY">
						<em>/</em>
						<input type="number" name="" title="월 기입창" placeholder="MM">
						<em>/</em>
						<input type="number" name="" title="일 기입창" placeholder="DD">
					</div>
					<div class="inner_Right">
						<input type="radio" name="sex_choice" id="male" checked="checked">
						<label for="male">남성</label>
						<input type="radio" name="sex_choice" id="fmale">
						<label for="fmale">여성</label>
					</div>
				</div>
			</div>
			<div class="inp_field">
				<span class="flabel maRtop20">이용약관 동의</span>
				<ul class="agreAreaList">
					<li>
						<input type="checkbox" name="" id="all_chk">
						<label for="all_chk">모든 약관에 전체동의합니다.</label>
					</li>
					<li>
						<input type="checkbox" name="" id="inp_chk00" class="agreechk">
						<label for="inp_chk00">e약방 이용약관 동의<em>(필수)</em></label>
						<a href="show_Fullslide00" class="infoLink showLayerForm">약관보기</a>
					</li>
					<li>
						<input type="checkbox" name="" id="inp_chk01" class="agreechk">
						<label for="inp_chk01">개인정보 수집이용 동의<em>(필수)</em></label>
						<a href="show_Fullslide01" class="infoLink showLayerForm">약관보기</a>
					</li>
					<li>
						<input type="checkbox" name="" id="inp_chk03" class="agreechk">
						<label for="inp_chk03">마케팅 정보 메일 SMS 수신 동의<em>(선택)</em></label>
					</li>
				</ul>
			</div>
			<div class="inp_field">
				<a href="" class="btnWg100">다음</a>
			</div>
		</fieldset>	
	</form>
</div>


<div class="syrup_agreement_layer">
	<h2>서비스 약관<a href="" class="preVBTn"><img src="../images/sub/prevTBtn.png" alt="이전버튼 이미지"></a></h2>
	<ul class="dkTabMenu00 agreeMent">
		<li class="open"><a href="agreemEnt00" id="show_Fullslide00">서비스<br/>이용약관</a></li>
		<li><a href="agreemEnt01" id="show_Fullslide01">개인정보<br/>처리방침</a></li>
		<li><a href="agreemEnt02" id="show_Fullslide02">개인정보<br/>제3자 제공 동의</a></li>
		<li><a href="agreemEnt03" id="show_Fullslide03">개인정보 수집<br/>이용동의</a></li>
		<li><a href="agreemEnt04" id="show_Fullslide04">위치기반<br/>이용약관</a></li>
	</ul>
	<div class="showfield" id="agreemEnt00">
		<div class="scrollOver">
			<div class="agreeMenTwrap">
				서비스 이용약관<br>
        1<br>
        2<br>
        3<br>
        4
			</div>
		</div>
	</div>

	<div class="showfield" id="agreemEnt01">
		<div class="scrollOver">
			<div class="agreeMenTwrap">
				개인정보 처리방침<br>
        1<br>
        2<br>
        3<br>
        4
			</div>
		</div>
	</div>

	<div class="showfield" id="agreemEnt02">
		<div class="scrollOver">
			<div class="agreeMenTwrap">
				개인정보 제 3자 제공동의<br>
        1<br>
        2<br>
        3<br>
        4
			</div>
		</div>
	</div>

	<div class="showfield" id="agreemEnt03">
		<div class="scrollOver">
			<div class="agreeMenTwrap">
				개인정보 수집 이용동의<br>
        1<br>
        2<br>
        3<br>
        4
			</div>
		</div>
	</div>

	<div class="showfield" id="agreemEnt04">
		<div class="scrollOver">
			<div class="agreeMenTwrap">
				위치기반 이용약관<br>
        1<br>
        2<br>
        3<br>
        4
			</div>
		</div>
	</div>

</div>


<script type="text/javascript">
	var currentscroller = "";

	function bodyFix(){
		currentscroller = $(window).scrollTop();
		$('.syrup_login_wrap').css({'position' : 'fixed', 'top' : -currentscroller});
		$('.syrup_login_wrap').on('scroll touchmove mousewheel', function(e){
			e.preventDefault();
			e.stopPropagation();
			return false;
		});
	}

	function bodyFixRelease(){
		$('.syrup_login_wrap').css({'position' : '', 'top' : 0});
		$(window).scrollTop(currentscroller);
		$('.syrup_login_wrap').off('scroll touchmove mousewheel');
	}

	//input type number maxLength script
	function maxLengthCheck(object){
		if (object.value.length > object.maxLength){
			object.value = object.value.slice(0, object.maxLength);
		}
	}

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
				$(this).siblings().removeClass('on').find('input[type="radio"]').removeAttr('checked').prop('checked',false);
				$(this).addClass('on');
				$(this).find('input').attr('checked','true').prop('checked',true);
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
				$(this).removeClass('on').find('input[type="checkbox"]').removeAttr('checked').prop('checked',false);
			}else{
				$(this).addClass('on');
				$(this).find('input').attr('checked','true').prop('checked', true);
			}
		});
		$('label[for=' + $(this).attr('id') + ']').html();
	});

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
		$('.syrup_agreement_layer').stop().show().animate({'right':'0'}, 250);
		$('#' + targetname).trigger('click');
		bodyFix();
	});

	$('a.preVBTn').on('click', function(clc){
		clc.preventDefault();
		$('.syrup_agreement_layer').stop().animate({'right':'-100%'}, 250);
		bodyFixRelease();
	});

	function layerhei(){
		var windowhei = $('.syrup_agreement_layer').outerHeight();
		var toTalHhei = $('.syrup_agreement_layer > h2').outerHeight() + $('.agreeMent').outerHeight()
		var scrollhei = windowhei - toTalHhei
		$('.scrollOver').css({'height':scrollhei});
	}


	//풀스크린 레이어 오픈시 footer 영역 복사 구조 변경하는 스크립트
	$(document).ready(function(){
		$('#footer').each(function(){
			var footerhtml = $(this).html()
			$(this).css('display','none');
			$('.syrup_login_wrap > form').after('<div id="footer" class="footer_restyle">'+footerhtml+'</div>');
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
</script>