<?php
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.opator.php";

$Mode = "";
$Mode = $_REQUEST["Mode"];

$_link = "";        // 이동할 주소 변수


if($Mode == "member_modify") {

    $op_id = $_REQUEST["op_id"];    
    $op_pass = $_REQUEST["op_pass"];    
    $op_sex = isNull($_REQUEST["op_sex"]) ? "M" : $_REQUEST["op_sex"];
    $op_birth = subStr($_REQUEST["birth_year"], 2, 2) ."-". $_REQUEST["birth_month"] ."-". $_REQUEST["birth_day"];
    $op_hp = $_REQUEST["phone1"] ."-". $_REQUEST["phone2"] ."-". $_REQUEST["phone3"];
    $op_email = $_REQUEST["email_id"]  ."@". $_REQUEST["email_domain"];

    $qry_001 = " UPDATE {$TB_OP} SET   ";
    $qry_001 .= "  OP_PASS  = '{$op_pass}'  ";
    $qry_001 .= ", OP_SEX   = '{$op_sex}'   ";
    $qry_001 .= ", OP_BIRTH = '{$op_birth}' ";
    $qry_001 .= ", OP_HP    = '{$op_hp}'    ";
    $qry_001 .= ", OP_EMAIL = '{$op_email}'  ";
    $qry_001 .= ", OP_EMAIL = '{$op_email}'  ";
    $qry_001 .= "WHERE OP_ID = '{$op_id}'  ";

    $db->exec_sql($qry_001);
    $_link = "../op.template.php?slot=member&type=member_detail&step=information";

    alert_js("alert_parent_move", "정보를 수정하였습니다", $_link);


}







$db->db_close();