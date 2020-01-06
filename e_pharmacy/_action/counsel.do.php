<?php
include_once "../../_core/_init.php";

$Mode = "";
$Mode = $_REQUEST["Mode"];

$link = ""; // 이동할 주소 변수


##### 답변 삭제 ( 관리자 페이지 )
if ($Mode == "del_cr") {

    $cr_idx = $_REQUEST["cr_idx"];
    $idx = $_REQUEST["idx"];

    $qry_001 = " DELETE FROM {$TB_CR} WHERE IDX = '{$cr_idx}' ";
    $db->exec_sql($qry_001);

    alert_js("parent_move", "", "../pharmacy.template.php?slot=counsel&type=counsel_detail&idx=" . $idx);
    exit;

##### 답변 삭제 ( 약국 페이지 )
} else if ($Mode == "del_cr2") {

    $cr_idx = $_REQUEST["cr_idx"];
    $idx = $_REQUEST["idx"];
    $r_write = $_REQUEST["r_write"];


    $qry_002 = " DELETE FROM {$TB_CR} WHERE IDX = '{$cr_idx}' ";
    $db->exec_sql($qry_002);

    alert_js("alert_parent_move", "댓글이 삭제되었습니다.", "../pharmacy.template.php?slot=counsel&type=counsel_detail&idx=" . $idx);

    exit;



##### 답변 등록
} else if ($Mode == "add_cr") {

    $idx = $_REQUEST["idx"];
    $r_answer = add_escape($_REQUEST["r_answer"]);
    $r_write = add_escape($_REQUEST["r_write"]);

    $qry_001 = "INSERT INTO {$TB_CR} SET";
    $qry_001 .= "  PARENT_KEY = '{$idx}'";
    $qry_001 .= ", R_ANSWER = '{$r_answer}'";
    $qry_001 .= ", R_WRITE = HEX(AES_ENCRYPT('" . $r_write . "','" . SECRET_KEY . "'))";
    $qry_001 .= ", REG_DATE   = now() ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_move", "댓글이 작성되었습니다.", "../pharmacy.template.php?slot=counsel&type=counsel_detail&idx=" . $idx);
    exit;

}


$db->db_close();