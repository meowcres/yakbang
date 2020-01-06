<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/admin_auth.php";


$Mode = "";
$Mode = $_REQUEST["Mode"];


$_link = "";        // 이동할 주소 변수


// 약국의 전문약사 등록
if ($Mode == "add_pharmacist") {

    $user_id = $_REQUEST["user_id"];
    $p_code = $_REQUEST["p_code"];

    $qry_001 = "INSERT INTO {$TB_PP} SET ";
    $qry_001 .= " PHARMACY_CODE = '{$p_code}' ";
    $qry_001 .= " , USER_ID = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "')) ";
    $qry_001 .= " , P_STATUS = '2' ";
    $qry_001 .= " , P_GRADE = '1' ";
    $qry_001 .= " , S_DATE = now() ";
    $qry_001 .= " , E_DATE = now() ";
    $qry_001 .= " , REG_DATE = now() ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "전문약사를 신청하였습니다", "");
    alert_js("parent_selfclose", "", "");


// 약국의 전문약사 정보 수정
} else if ($Mode == "up_pharmacist") {


    $idx = $_REQUEST["idx"];
    $p_status = $_REQUEST["p_status"];
    $p_grade = $_REQUEST["p_grade"];

    $qry_001 = "UPDATE {$TB_PP} SET ";
    $qry_001 .= " P_STATUS = '{$p_status}' ";
    $qry_001 .= " , P_GRADE = '{$p_grade}' ";
    $qry_001 .= "  WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "전문약사 정보를 수정하였습니다", "");
    alert_js("parent_reload", "", "");

    exit;


// 약국 약사등록신청 취소
} else if ($Mode == "cancle_pharmacist") {

    $idx = $_REQUEST["idx"];
    echo "====".$idx;

    $qry_001 = "DELETE FROM {$TB_PP} WHERE IDX='{$idx}'";
    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "전문약사 신청을 취소하였습니다", "");
    alert_js("parent_reload", "", "");


// 약국 소속약사 삭제
} else if ($Mode == "del_pharmacist") {


    $idx = $_REQUEST["idx"];
    $qry_001 = "DELETE FROM {$TB_PP} WHERE IDX='{$idx}'";
    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "전문약사를 해당 약국에서 제외하였습니다", "");
    alert_js("parent_reload", "", "");


}






$db->db_close();
