<?
/**
 *  파일명 : var.operator.php
 *  비고   : 오퍼 기본정보 설정 파일
 **/

/* 기본 변수 정보 */
$_slot = isNull($_REQUEST["slot"]) ? "" : $_REQUEST["slot"];
$_type = isNull($_REQUEST["type"]) ? "" : $_REQUEST["type"];
$_step = isNull($_REQUEST["step"]) ? "" : $_REQUEST["step"];
$_page = isNull($_REQUEST["page"]) ? "1" : $_REQUEST["page"];


/* 조작자 top 메뉴 정보 */
$_opMenu = array(
  "dashboard" => array("DASHBOARD", "./op.template.php?slot=dashboard&type=dashboard_list")  
, "prescription" => array("처방전 리스트", "./op.template.php?slot=prescription&type=prescription_list")
, "member" => array("내 정보관리", "./op.template.php?slot=member&type=member_detail&step=information")
);
reset($_opMenu);

/* 오퍼 변수 초기화 */
$_opKey = array();
$_opKey["id"]   = "";


/* 세션변수 등록 */
$_opKey["id"]   = $_SESSION["op_id"];

