<link rel="stylesheet" type="text/css" href="../css/login.css">
<script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>

<div class="syrup_login_wrap">
	<h2>아이디/비밀번호 찾기<a href="javascript:history.back();" class="preVBTn"><img src="../images/sub/prevTBtn.png" alt="이전버튼 이미지"></a></h2>
	<ul class="dkTabMenu00 idpassTab">
		<li class="open"><a href="idFind">아이디 찾기</a></li>
		<li><a href="passwordFind">비밀번호 찾기</a></li>
	</ul>
	<div class="showfield" id="idFind">
		<form action="" method="">
			<fieldset>
				<legend>아이디 찾기</legend>
				<div class="inp_field">
					<label for="mobile_num00">휴대폰번호</label>
					<input type="tel" name="" id="mobile_num00" placeholder="핸드폰번호 입력">
				</div>
				<div class="inp_field">
					<input type="button" value="인증번호받기" class="btngL_W100" title="인증번호받기 버튼">
				</div>
				<div class="inp_field">
					<label for="certification_num00">인증번호</label>
					<input type="number" name="" id="certification_num00" placeholder="인증번호 입력">
				</div>
				<p class="field_txt">휴대폰 인증 후 아이디 찾기가 완료됩니다.</p>
				<div class="inp_field">
					<input type="submit" class="btnWg100" name="" value="확인" title="확인 버튼">
				</div>
			</fieldset>
		</form>
	</div>

	<div class="showfield" id="passwordFind">
		<form action="" method="">
			<fieldset>
				<legend>비밀번호 찾기</legend>
				<div class="inp_field">
					<label for="email_id">이메일 아이디</label>
					<input type="text" name="" id="email_id" placeholder="example@eyacbang.com">
				</div>
				<div class="inp_field">
					<label for="mobile_num01">핸드폰번호</label>
					<input type="text" name="" id="mobile_num01" placeholder="핸드폰번호 입력">
				</div>
				<div class="inp_field">
					<input type="button" value="인증번호받기" class="btngL_W100" title="인증번호받기 버튼">
				</div>
				<div class="inp_field">
					<label for="certification_num">인증번호</label>
					<input type="number" name="" id="certification_num" placeholder="인증번호 입력">
				</div>
				<p class="field_txt">휴대폰 인증 후 비밀번호 찾기가 완료됩니다.</p>
				<div class="inp_field">
					<input type="submit" class="btnWg100" name="" value="확인" title="확인 버튼">
				</div>
			</fieldset>
		</form>
	</div>

</div>

<script type="text/javascript">

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
	});

</script>