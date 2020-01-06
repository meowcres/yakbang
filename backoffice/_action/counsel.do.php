<?php
include_once "../../_core/_init.php";

$Mode = "";
$Mode = $_REQUEST["Mode"];

$link = ""; // 이동할 주소 변수


##### 상담 삭제
if ($Mode == "del_counsel") {

    $idx = $_REQUEST["idx"];

    $qry_001 = "DELETE FROM {$TB_COUNSEL} WHERE IDX = '{$idx}' ";
    $db->exec_sql($qry_001);

    alert_js("parent_move", "", "../admin.template.php?slot=counsel&type=counsel_list");
    exit;


    ##### 문의 삭제
} else if ($Mode == "del_cr") {

        $cr_idx = $_REQUEST["cr_idx"];
        $idx = $_REQUEST["idx"];

        $qry_001 = " DELETE FROM {$TB_CR} WHERE IDX = '{$cr_idx}' ";
        $db->exec_sql($qry_001);

        alert_js("parent_move", "", "../admin.template.php?slot=counsel&type=counsel_detail&idx=".$idx);
        exit;

}


$db->db_close();
?>