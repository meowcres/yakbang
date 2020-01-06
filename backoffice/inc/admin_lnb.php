<div id="LNB">
    <!-- 기타관리 -->
    <div style="display:<?= $_lnb_display["main"] ?>;">
        <h1>DASHBOARD</h1>
        <ul>
            <h2>사이트 현황</h2>
            <li><a href="./admin.template.php?slot=main&type=dashboard">현황판</a></li>
        </ul>
    </div>


    <!-- 환경설정 -->
    <div style="display:<?= $_lnb_display["conf"] ?>;">
        <h1><?= $_adminMenu["conf"][0] ?></h1>
        <ul>
            <h2>환경 설정</h2>
            <li><a href="./admin.template.php?slot=conf&type=information">사이트 정보관리</a></li>
        </ul>
        <ul>
            <h2>운영자 관리</h2>
            <li><a href="./admin.template.php?slot=conf&type=admin_list">운영자 목록</a></li>
            <li><a href="./admin.template.php?slot=conf&type=admin_register">운영자 등록</a></li>
        </ul>
    </div>


    <!-- 회원관리 -->
    <div style="display:<?= $_lnb_display["member"] ?>;">
        <h1><?= $_adminMenu["member"][0] ?></h1>
        <ul>
            <h2>약관 정보</h2>
            <li><a href="./admin.template.php?slot=member&type=stipulation_control&idx=1">서비스이용약관</a></li>
            <li><a href="./admin.template.php?slot=member&type=stipulation_control&idx=2">개인정보처리방침</a></li>
            <li><a href="./admin.template.php?slot=member&type=stipulation_control&idx=3">개인정보제3자제공동의</a></li>
            <li><a href="./admin.template.php?slot=member&type=stipulation_control&idx=4">개인정보수집이용동의</a></li>
            <li><a href="./admin.template.php?slot=member&type=stipulation_control&idx=5">위치기반이용약관</a></li>
        </ul>
        <ul>
            <h2>회원 관리</h2>
            <li><a href="./admin.template.php?slot=member&type=member_list">회원목록</a></li>
            <li><a href="./admin.template.php?slot=member&type=member_register">회원등록</a></li>
        </ul>
    </div>


    <!-- 약사관리 -->
    <div style="display:<?= $_lnb_display["pharmacist"] ?>;">
        <h1><?= $_adminMenu["pharmacist"][0] ?></h1>
        <ul>
            <h2>약관 정보</h2>
            <li><a href="./admin.template.php?slot=pharmacist&type=stipulation_control&idx=6">약사신청약관</a></li>
        </ul>
        <ul>
            <h2>신청서 관리</h2>
            <li><a href="./admin.template.php?slot=pharmacist&type=req_pharmacist_list">약사신청서목록</a></li>
        </ul>
        <ul>
            <h2>약사 관리</h2>
            <li><a href="./admin.template.php?slot=pharmacist&type=pharmacist_list">약사목록</a></li>
            <li><a href="./admin.template.php?slot=pharmacist&type=pharmacist_register">약사등록</a></li>
        </ul>
    </div>


    <!-- 약국관리 -->
    <div style="display:<?= $_lnb_display["pharmacy"] ?>;">
        <h1><?= $_adminMenu["pharmacy"][0] ?></h1>
        <ul>
            <h2>약관 정보</h2>
            <li><a href="./admin.template.php?slot=pharmacy&type=stipulation_control&idx=7">약국신청약관</a></li>
        </ul>
        <ul>
            <h2>신청서 관리</h2>
            <li><a href="./admin.template.php?slot=pharmacy&type=req_pharmacy_list">약국신청서목록</a></li>
        </ul>
        <ul>
            <h2>약국 관리</h2>
            <li><a href="./admin.template.php?slot=pharmacy&type=pharmacy_list">약국목록</a></li>
            <li><a href="./admin.template.php?slot=pharmacy&type=pharmacy_register">약국등록</a></li>
            <li><a href="./admin.template.php?slot=pharmacy&type=pharmacy_pharmacist_list">소속약사신청목록</a></li>
        </ul>
        <ul>
            <h2>심평원 - 관리약국</h2>
            <li><a href="./admin.template.php?slot=pharmacy&type=hira_pharmacy_list">약국목록</a></li>
        </ul>
        <ul>
            <h2>의약품 관리</h2>
            <li><a href="./admin.template.php?slot=pharmacy&type=pill_list">의약품목록</a></li>
        </ul>
    </div>


    <!-- 처방전관리 -->
    <div style="display:<?= $_lnb_display["prescription"] ?>;">
        <h1><?= $_adminMenu["prescription"][0] ?></h1>
        <ul>
            <h2>약관 정보</h2>
            <li><a href="./admin.template.php?slot=prescription&type=stipulation_control&idx=8">처방전전송동의</a></li>
        </ul>
        <ul>
            <h2>처방전 관리</h2>
            <li><a href="./admin.template.php?slot=prescription&type=prescription_list">처방전 목록</a></li>
        </ul>
        <ul>
            <h2></h2>
            <li><a href="javascript:void(0);"></a></li>
        </ul>
    </div>


    <!-- 정산관리 -->
    <div style="display:<?= $_lnb_display["calculate"] ?>;">
        <h1><?= $_adminMenu["calculate"][0] ?></h1>
        <ul>
            <h2></h2>
            <li><a href="javascript:void(0);"></a></li>
        </ul>
    </div>


    <!-- 상담관리 -->
    <div style="display:<?= $_lnb_display["counsel"] ?>;">
        <h1><?= $_adminMenu["counsel"][0] ?></h1>
        <ul>
            <h2>상담 관리</h2>
            <li><a href="./admin.template.php?slot=counsel&type=counsel_list">상담 리스트</a></li>
        </ul>
        <!--<ul>
            <h2></h2>
            <li><a href="javascript:void(0);"></a></li>
        </ul>-->
    </div>


    <!-- 쪽지관리 -->
    <div style="display:<?= $_lnb_display["dm"] ?>;">
        <h1><?= $_adminMenu["dm"][0] ?></h1>
        <ul>
            <h2>쪽지 관리</h2>
            <li><a href="./admin.template.php?slot=dm&type=dm_list">목록</a></li>
        </ul>
    </div>


    <!-- 커뮤니티 -->
    <div style="display:<?= $_lnb_display["board"] ?>;">
        <h1><?= $_adminMenu["board"][0] ?></h1>
        <ul>
            <h2>분류관리</h2>
            <li><a href="./admin.template.php?slot=board&type=type_notice_list">공지사항 분류</a></li>
            <li><a href="./admin.template.php?slot=board&type=type_faq_list">FAQ 분류</a></li>
            <li><a href="./admin.template.php?slot=board&type=type_request_list">문의 분류</a></li>
        </ul>
        <ul>
            <h2>게시판</h2>
            <li><a href="./admin.template.php?slot=board&type=notice_list">공지사항</a></li>
            <li><a href="./admin.template.php?slot=board&type=faq_list">FAQ</a></li>
        </ul>
        <ul>
            <h2>문의관리</h2>
            <li><a href="./admin.template.php?slot=board&type=request_list">문의목록</a></li>
        </ul>
    </div>


    <!-- 광고관리 -->
    <div style="display:<?= $_lnb_display["ad"] ?>;">
        <h1><?= $_adminMenu["ad"][0] ?></h1>
        <ul>
            <h2>TOP 광고</h2>
            <li><a href="./admin.template.php?slot=ad&type=ad_top_list">TOP 광고 목록</a></li>
            <li><a href="./admin.template.php?slot=ad&type=ad_top_register">TOP 광고 등록</a></li>
        </ul>
        <ul>
            <h2>MAIN SLIDE 광고관리</h2>
            <li><a href="./admin.template.php?slot=ad&type=main_slide_list">MAIN SLIDE 목록</a></li>
            <li><a href="./admin.template.php?slot=ad&type=main_slide_register">MAIN SLIDE 등록</a></li>
        </ul>
        
        <ul>
            <h2>SUB SLIDE 광고관리</h2>
            <li><a href="./admin.template.php?slot=ad&type=sub_slide_list">SUB SLIDE 목록</a></li>
            <li><a href="./admin.template.php?slot=ad&type=sub_slide_register">SUB SLIDE 등록</a></li>
        </ul>
    </div>


    <!-- 기타관리 -->
    <div style="display:<?= $_lnb_display["etc"] ?>;">
        <h1><?= $_adminMenu["etc"][0] ?></h1>
        <ul>
            <h2>푸시관리</h2>
            <li><a href="./admin.template.php?slot=etc&type=push_list">푸시 목록</a></li>
            <li><a href="./admin.template.php?slot=etc&type=push_register">푸시 등록</a></li>

        </ul>
        <ul>
            <h2>FCM 푸시</h2>
            <li><a href="./admin.template.php?slot=etc&type=fcm_view">FCM 알림창 관리</a></li>
            <li><a href="./admin.template.php?slot=etc&type=fcm_list">FCM 푸시 목록</a></li>
            <li><a href="./admin.template.php?slot=etc&type=fcm_register">FCM 푸시 발송</a></li>
        </ul>
        <!--<ul>
            <h2>포트폴리오 관리</h2>
            <li><a href="./admin.template.php?slot=etc&type=portfolio_list">포트폴리오 목록</a></li>
            <li><a href="./admin.template.php?slot=etc&type=portfolio_register">포트폴리오 등록</a></li>
        </ul>-->
    </div>



    <!-- 오퍼관리 -->
    <div style="display:<?= $_lnb_display["operator"] ?>;">
        <h1><?= $_adminMenu["operator"][0] ?></h1>
        <ul>
            <h2>오퍼 관리</h2>
            <li><a href="./admin.template.php?slot=operator&type=operator_list">오퍼 목록</a></li>
            <li><a href="./admin.template.php?slot=operator&type=operator_register">오퍼 등록</a></li>
            <li><a href="./admin.template.php?slot=operator&type=operator_login_status">오퍼 로그인 현황</a></li>
        </ul>
        <ul>
            <h2>처방전 현황</h2>
            <li><a href="./admin.template.php?slot=operator&type=prescription_operator_list">처방전 목록</a></li>
        </ul>
    </div>


    <!-- 게시판 --
	<div style="display:<?= $_lnb_display["board"] ?>;">
		<h1><?= $_adminMenu["board"][0] ?></h1>
		<ul>
			<h2>FAQ 분류관리</h2>
			<li><a href="./admin.board.php?slot=board&type=large_list">FAQ 분류목록</a></li>
		</ul>
		<ul>
			<h2>게시판</h2>
			<li><a href="./admin.board.php?slot=board&type=consult_list">1:1문의</a></li>
			<li><a href="./admin.board.php?slot=board&type=notice_list">공지사항</a></li>
			<li><a href="./admin.board.php?slot=board&type=faq_list">FAQ</a></li>
			<li><a href="./admin.board.php?slot=board&type=album_list">KISEC ALBUM</a></li>
			<li><a href="./admin.board.php?slot=board&type=lab_list">f-NGS Lab</a></li>
			<li><a href="./admin.board.php?slot=board&type=working_list">취업현황</a></li>
			<li><a href="./admin.board.php?slot=board&type=after_list">수강후기</a></li>
		</ul>
	</div>



	<!-- 기타관리 --
	<div style="display:<?= $_lnb_display["etc"] ?>;">
		<h1><?= $_adminMenu["etc"][0] ?></h1>
		<ul>
			<h2>팝업관리</h2>
			<li><a href="./admin.etc.php?slot=etc&type=popup_list">팝업 목록</a></li>
			<li><a href="./admin.etc.php?slot=etc&type=popup_register">팝업 등록</a></li>
		</ul>
<!--        <ul>-->
    <!--            <h2>파트너관리</h2>-->
    <!--            <li><a href="./admin.etc.php?slot=etc&type=partner_list">파트너 목록</a></li>-->
    <!--            <li><a href="./admin.etc.php?slot=etc&type=partner_register">파트너 등록</a></li>-->
    <!--        </ul>-->

</div>