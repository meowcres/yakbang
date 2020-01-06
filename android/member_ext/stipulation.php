<link rel="stylesheet" type="text/css" href="../css/login.css">
<script type="text/javascript" src="../js/jquery-1.12.4.min.js"></script>

<div class="syrup_agreement_layer">
	<h2>서비스 약관<a href="" class="preVBTn"><img src="../images/sub/prevTBtn.png" alt="이전버튼 이미지"></a></h2>
	<ul class="dkTabMenu00 agreeMent">
		<li class="open"><a href="agreemEnt00">서비스<br/>이용약관</a></li>
		<li><a href="agreemEnt01">개인정보<br/>처리방침</a></li>
		<li><a href="agreemEnt02">개인정보<br/>제3자 제공 동의</a></li>
		<li><a href="agreemEnt03">개인정보 수집<br/>이용동의</a></li>
		<li><a href="agreemEnt04">위치기반<br/>이용약관</a></li>
	</ul>
	<div class="showfield" id="agreemEnt00">
		<div class="agreeMenTwrap">content01</div>
	</div>

	<div class="showfield" id="agreemEnt01">
		<div class="agreeMenTwrap">content02</div>
	</div>

	<div class="showfield" id="agreemEnt02">
		<div class="agreeMenTwrap">content03</div>
	</div>

	<div class="showfield" id="agreemEnt03">
		<div class="agreeMenTwrap">content04</div>
	</div>

	<div class="showfield" id="agreemEnt04">
		<div class="agreeMenTwrap">content05</div>
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