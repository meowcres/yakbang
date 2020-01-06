<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";

$Mode = "";
$Mode = $_REQUEST["Mode"];


$_link = "";        // 이동할 주소 변수


if ($Mode == "id_find") {
 
    $chk_id = $_REQUEST["chk_id"];

    $qry_001 = " SELECT count(OP_ID) FROM {$TB_OP} WHERE OP_ID = '".$chk_id."' ";
    $res_001 = $db->exec_sql($qry_001);
    $row_001 = $db->sql_fetch_row($res_001);

    if ($row_001[0] > 0) {
        echo "100";
    } else {
        echo "200";
    }


// 오퍼 등록
} else if ($Mode == "operator_add") {

    $op_id = $_REQUEST["chk_id"];
    $op_status = $_REQUEST["op_status"];
    $op_grade = $_REQUEST["op_grade"];
    $op_pass = $_REQUEST["op_pass"];
    $op_name = $_REQUEST["op_name"];
    $op_sex = isNull($_REQUEST["op_sex"]) ? "M" : $_REQUEST["op_sex"];
    $op_birth = subStr($_REQUEST["birth_year"], 2, 2) ."-". $_REQUEST["birth_month"] ."-". $_REQUEST["birth_day"];
    $op_hp = $_REQUEST["phone1"] ."-". $_REQUEST["phone2"] ."-". $_REQUEST["phone3"];
    $op_email = $_REQUEST["email_id"]  ."@". $_REQUEST["email_domain"];
    $op_start = $_REQUEST["start_year"] ."-". $_REQUEST["start_month"] ."-". $_REQUEST["start_day"];
    $op_end = $_REQUEST["end_year"] ."-". $_REQUEST["end_month"] ."-". $_REQUEST["end_day"];
    $admin_memo = $_REQUEST["admin_memo"];
    
    $qry_001 = "INSERT INTO {$TB_OP} SET ";
    $qry_001 .= " OP_ID = '{$op_id}' ";
    $qry_001 .= " , OP_STATUS = '{$op_status}' ";
    $qry_001 .= " , OP_GRADE = '{$op_grade}' ";
    $qry_001 .= " , OP_PASS = '{$op_pass}' ";
    $qry_001 .= " , OP_NAME = '{$op_name}' ";
    $qry_001 .= " , OP_SEX = '{$op_sex}' ";
    $qry_001 .= " , OP_BIRTH = '{$op_birth}' ";
    $qry_001 .= " , OP_HP = '{$op_hp}' ";
    $qry_001 .= " , OP_EMAIL = '{$op_email}' ";
    $qry_001 .= " , START_DATE = '{$op_start}' ";
    $qry_001 .= " , END_DATE = '{$op_end}' ";
    $qry_001 .= " , REG_DATE = now() ";
    $qry_001 .= " , ADMIN_MEMO = '{$admin_memo}' ";

    $db->exec_sql($qry_001);
    $_link = "../admin.template.php?slot=operator&type=operator_list";

    alert_js("alert_parent_move", "오퍼를 등록하였습니다", $_link);


// 오퍼 삭제
} else if ($Mode == "del_op_list") {

    if (isNull($_REQUEST["op_id"])) {
        alert_js("alert_parent_reload", "삭제 정보가 올바르지 않습니다.", "");
        exit;
    }

    $OP_ID = $_REQUEST["op_id"];

    $_sql = "DELETE FROM {$TB_OP} WHERE OP_ID = '{$OP_ID}' ";
    $db->exec_sql($_sql);

    $_link = "../admin.template.php?slot=operator&type=operator_list";

    alert_js("alert_parent_move", "회원 정보 삭제가 완료 되었습니다.", $_link);
    exit;


} else if ($Mode == "operator_modify") {

    $op_id = $_REQUEST["op_id"];
    $op_status = $_REQUEST["op_status"];
    $op_grade = $_REQUEST["op_grade"];
    $op_pass = $_REQUEST["op_pass"];
    $op_name = $_REQUEST["op_name"];
    $op_sex = isNull($_REQUEST["op_sex"]) ? "M" : $_REQUEST["op_sex"];
    $op_birth = subStr($_REQUEST["birth_year"], 2, 2) ."-". $_REQUEST["birth_month"] ."-". $_REQUEST["birth_day"];
    $op_hp = $_REQUEST["phone1"] ."-". $_REQUEST["phone2"] ."-". $_REQUEST["phone3"];
    $op_email = $_REQUEST["email_id"]  ."@". $_REQUEST["email_domain"];
    $op_start = $_REQUEST["start_year"] ."-". $_REQUEST["start_month"] ."-". $_REQUEST["start_day"];
    $op_end = $_REQUEST["end_year"] ."-". $_REQUEST["end_month"] ."-". $_REQUEST["end_day"];
    $admin_memo = $_REQUEST["admin_memo"];
    
    $qry_001 = "UPDATE {$TB_OP} SET ";
    $qry_001 .= " OP_STATUS = '{$op_status}' ";
    $qry_001 .= " , OP_GRADE = '{$op_grade}' ";
    $qry_001 .= " , OP_PASS = '{$op_pass}' ";
    $qry_001 .= " , OP_NAME = '{$op_name}' ";
    $qry_001 .= " , OP_SEX = '{$op_sex}' ";
    $qry_001 .= " , OP_BIRTH = '{$op_birth}' ";
    $qry_001 .= " , OP_HP = '{$op_hp}' ";
    $qry_001 .= " , OP_EMAIL = '{$op_email}' ";
    $qry_001 .= " , START_DATE = '{$op_start}' ";
    $qry_001 .= " , END_DATE = '{$op_end}' ";
    $qry_001 .= " , ADMIN_MEMO = '{$admin_memo}' ";
    $qry_001 .= " WHERE OP_ID = '{$op_id}' ";


    $db->exec_sql($qry_001);

    alert_js("alert_parent_reload", "오퍼 정보를 수정하였습니다", "");


// 오퍼 처방전 삭제
} else if ($Mode == "del_prescription_list") {

    if (isNull($_REQUEST["ps_code"])) {
        alert_js("alert_parent_reload", "삭제 정보가 올바르지 않습니다.", "");
        exit;
    }

    $ps_code = $_REQUEST["ps_code"];

    $_sql_001 = "DELETE FROM {$TB_PS_PRECLEANING} WHERE PS_CODE = '{$ps_code}' ";
    $db->exec_sql($_sql_001);

    $_link = "../admin.template.php?slot=operator&type=prescription_operator_list";

    alert_js("alert_parent_move", "처방전 정보 삭제가 완료 되었습니다.", $_link);
    exit;


}


$db->db_close();
