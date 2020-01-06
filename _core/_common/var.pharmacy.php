<?
/**
 *  파일명 : var.pharmacy.php
 *  비고   : 전문약사 기본정보 설정 파일
 **/

/* 기본 변수 정보 */
$_slot = isNull($_REQUEST["slot"]) ? "" : $_REQUEST["slot"];
$_type = isNull($_REQUEST["type"]) ? "" : $_REQUEST["type"];
$_step = isNull($_REQUEST["step"]) ? "" : $_REQUEST["step"];
$_page = isNull($_REQUEST["page"]) ? "1" : $_REQUEST["page"];


/* 관리자 top 메뉴 정보 */
$_pharmacyMenu1 = array(
  "prescription" => array("처방전관리", "./pharmacy.template.php?slot=prescription&type=prescription_list")
, "counsel" => array("상담관리", "./pharmacy.template.php?slot=counsel&type=counsel_list")
, "dm" => array("쪽지관리", "./pharmacy.template.php?slot=dm&type=mentee_list")
, "member" => array("내 정보관리", "./pharmacy.template.php?slot=member&type=pharmacist_detail&step=information")
);
reset($_pharmacyMenu1);


/* 관리자 top 메뉴 정보 */
$_pharmacyMenu2 = array(
    "pharmacy" => array("약국관리", "./pharmacy.template.php?slot=pharmacy&type=information")
, "pharmacist" => array("약사관리", "./pharmacy.template.php?slot=pharmacist&type=pharmacist_list")
, "prescription" => array("처방전관리", "./pharmacy.template.php?slot=prescription&type=prescription_list")
, "calculate" => array("정산관리", "./pharmacy.template.php?slot=calculate&type=calculate_list")
, "counsel" => array("상담관리", "./pharmacy.template.php?slot=counsel&type=counsel_list")
, "dm" => array("쪽지관리", "./pharmacy.template.php?slot=dm&type=mentee_list")
, "member" => array("내 정보관리", "./pharmacy.template.php?slot=member&type=pharmacist_detail&step=information")
);
reset($_pharmacyMenu2);

/* Pharmacist top 메뉴 정보 */
$pharmacist_menu_array = array(
    "information" => "추가정보"
, "update" => "정보수정"
, "pass" => "비밀번호수정"
, "pharmacy" => "소속약국"
, "del" => "약국탈퇴"
);
reset($pharmacist_menu_array);

/* prescription 메뉴 정보 */
$prescription_menu_array = array(
    "pill" => "처방약"
, "preparation" => "조제약"
);
reset($pharmacist_menu_array);


/* 전문약사 변수 초기화 */
$_pmyKey = array();
$_pmyKey["code"] = "";
$_pmyKey["id"]   = "";


/* 세션변수 등록 */
$_pmyKey["code"] = $_SESSION["pharmacy"]["code"];
$_pmyKey["id"]   = $_SESSION["pharmacy"]["id"];