<?
/**
 *  파일명 : var.admin.php
 *  비고   : 관리자 기본정보 설정 파일
 **/

/* 기본 변수 정보 */
$_slot = isNull($_REQUEST["slot"]) ? "" : $_REQUEST["slot"];
$_type = isNull($_REQUEST["type"]) ? "" : $_REQUEST["type"];
$_step = isNull($_REQUEST["step"]) ? "" : $_REQUEST["step"];
$_page = isNull($_REQUEST["page"]) ? "1" : $_REQUEST["page"];


/* 관리자 top 메뉴 정보 */
$_adminMenu = array(
    "conf" => array("환경설정", "./admin.template.php?slot=conf&type=information")
, "member" => array("회원관리", "./admin.template.php?slot=member&type=member_list")
, "pharmacist" => array("약사관리", "./admin.template.php?slot=pharmacist&type=pharmacist_list")
, "pharmacy" => array("약국관리", "./admin.template.php?slot=pharmacy&type=pharmacy_list")
, "prescription" => array("처방전관리", "./admin.template.php?slot=prescription&type=prescription_list")
, "calculate" => array("정산관리", "./admin.template.php?slot=calculate&type=calculate_list")
, "counsel" => array("상담관리", "./admin.template.php?slot=counsel&type=counsel_list")
, "dm" => array("쪽지관리", "./admin.template.php?slot=dm&type=dm_list")
, "board" => array("커뮤니티", "./admin.template.php?slot=board&type=notice_list")
, "ad" => array("광고관리", "./admin.template.php?slot=ad&type=ad_top_list")
, "etc" => array("기타관리", "./admin.template.php?slot=etc&type=push_list")
, "operator" => array("OPERATOR", "./admin.template.php?slot=operator&type=operator_list")
);
reset($_adminMenu);

/* Member top 메뉴 정보 */
$member_menu_array = array(
    "information" => "추가정보"
, "update" => "정보수정"
, "pass" => "비밀번호수정"
, "mento" => "멘토리스트"
, "dm" => "쪽지관리"
, "prescription" => "처방내역관리"
, "pill" => "알약현황"
, "del" => "회원삭제"
);
reset($member_menu_array);

/* Pharmacist top 메뉴 정보 */
$pharmacist_menu_array = array(
    "information" => "추가정보"
, "update" => "정보수정"
, "pass" => "비밀번호수정"
, "pharmacy" => "소속약국"
, "mentee" => "멘티리스트"
, "pill" => "알약현황"
, "del" => "약사삭제"
);
reset($pharmacist_menu_array);

/* Pharmacy top 메뉴 정보 */
$pharmacy_menu_array = array(
    "information" => "추가정보"
, "update" => "정보수정"
, "ykiho" => "심평원"
, "pharmacist" => "전문약사관리"
, "del" => "약국삭제"
);
reset($pharmacy_menu_array);

/* prescription 메뉴 정보 */
$prescription_menu_array = array(
    "pill" => "처방약"
, "pharmacy" => "처방약국"
, "pay" => "결제정보"
, "del" => "삭제"
);
reset($prescription_menu_array);

/* 관리자 변수 초기화 */
$_passKey = array();
$_passKey["idx"] = "";
$_passKey["id"] = "";

/* 세션변수 등록 */
$_passKey["idx"] = $_SESSION["admin"]["idx"];
$_passKey["id"] = $_SESSION["admin"]["id"];

if ($ADMIN_COOKIE_YN == "yes") {
    $_passKey["idx"] = $_COOKIE["cookie_admin_idx"];
    $_passKey["id"] = $_COOKIE["cookie_admin_id"];
}