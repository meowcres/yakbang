<?php
/**
*  CONTROLLER 
**/

// 페이징 변수
$offset     = 20;
$page_block = 10;
$startNum   = "";
$totalnum   = "";
$page       = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

if ($page < 1) {
    $page = $_page;
    $startNum = ($page- 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

// 검색 변수
$search = array();
$search["status"]  = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$search["keyword"] = isNull($_GET["keyword"])       ? "" : $_GET["keyword"];

$where_array[] = "t1.CD_TYPE IN ('MENU')";
$where_array[] = "t1.CD_DEPTH IN ('1')";

// 활동상태
if (!isNull($search["status"])) {
    $where_array[] = "t1.CD_STATUS='{$search["status"]}'";
}
$search_status[$search["status"]] = "SELECTED";

// 키워드 검색
if (!isNull($search["keyword"])) {
    $where_array[] = "instr(t1.CD_TITLE,'{$search["keyword"]}')>0";
}

// 쿼리 조건절
$qry_where = count($where_array) ? " WHERE ".implode(' AND ',$where_array) : "" ;
$qry_order = " ORDER BY t1.CD_STATUS, t1.ORDER_SEQ" ;
$qry_limit = " LIMIT ".$startNum.",".$offset ;

// 목록수
$qry_001  = " SELECT           " ;
$qry_001 .= " count(*)         " ;

$qry_from = " FROM {$TB_CODE} t1 " ;

$res_001 = $db->exec_sql($qry_001.$qry_from.$qry_where);
$row_001 = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];

// 주소이동변수
$url_opt = "&search_status=".$search["status"]."&keyword=".$search["keyword"];