<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/admin_auth.php";


$Mode = "";
$Mode = $_REQUEST["Mode"];


$_link = "";        // 이동할 주소 변수


// 처방전 상세 - 상태 변경
if ($Mode == "up_status") {
    $idx = $_REQUEST["idx"];
    $a_status = $_REQUEST["a_status"];


    $qry_001  = " UPDATE {$TB_PS_PHARMACY} SET ";
    $qry_001 .= " A_STATUS   = '{$a_status}'";
    $qry_001 .= " WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_001);

    alert_js("parent_move", "", "../pharmacy.template.php?slot=prescription&type=prescription_list");


// 처방전상세 - 대체약품 등록
} else if ($Mode == "add_pill_popup") {

    $ps_code = $_REQUEST["ps_code"];
    $pp_type = $_REQUEST["pp_type"];
    $parent_idx = $_REQUEST["parent_idx"];
    $pp_pharmacy = $_REQUEST["pharmacy_code"];
    $one_injection = $_REQUEST["one_injection"];
    $day_injection = $_REQUEST["day_injection"];
    $total_injection = $_REQUEST["total_injection"];
    $pp_title = add_escape($_REQUEST["pp_title"]);
    $pp_cmt = add_escape($_REQUEST["pp_cmt"]);
    $pp_usage = add_escape($_REQUEST["pp_usage"]);

    $qry_001  = "  INSERT INTO {$TB_PS_PILL} SET ";
    $qry_001 .= "  PS_CODE = '{$ps_code}' ";
    $qry_001 .= ", PP_TYPE = '2' ";
    $qry_001 .= ", PARENT_IDX = '{$parent_idx}' ";
    $qry_001 .= ", PP_PHARMACY = '{$pp_pharmacy}' ";
    $qry_001 .= ", PP_PHARMACIST = HEX(AES_ENCRYPT('" . $_SESSION["pharmacy"]["id"] . "','" . SECRET_KEY . "')) ";
    $qry_001 .= ", ONE_INJECTION = '{$one_injection}' ";
    $qry_001 .= ", DAY_INJECTION = '{$day_injection}' ";
    $qry_001 .= ", TOTAL_INJECTION = '{$total_injection}' ";
    $qry_001 .= ", PP_TITLE = '{$pp_title}' ";
    $qry_001 .= ", PP_CMT = '{$pp_cmt}' ";
    $qry_001 .= ", PP_USAGE = '{$pp_usage}' ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "대체약품을 등록하였습니다", "");
    alert_js("parent_close", "", "");

    exit;


// 처방약 삭제
} else if ($Mode == "del_pill") {

    $idx = $_REQUEST["idx"];
    $ps_code = $_REQUEST["ps_code"];

    $del_001 = " DELETE FROM {$TB_PS_PILL} WHERE IDX = '{$idx}' ";

    @$db->exec_sql($del_001);

    $go_link = "../pharmacy.template.php?slot=prescription&type=prescription_detail&step=pill&ps_code=".$ps_code;
    alert_js("parent_move", "", $go_link);

    exit;


}  else if($Mode == "add_pill_order") {

    // API를 처방약 테이블 insert
    $pidx = $_REQUEST["pidx"];
    $pCode = $_REQUEST["pCode"];
    $pName = $_REQUEST["pName"];

    $pill_idx = check_pill($pidx, $pCode, $pName);

    $qry_api = "SELECT IDX FROM {$TB_PILL} WHERE PILL_CODE='{$pCode}' AND PILL_NAME='{$pName}'";
    $res_api = $db->exec_sql($qry_api);
    $row_api = $db->sql_fetch_row($res_api);


    // 약 처방전 insert
    $ps_code = $_REQUEST["ps_code"];
    $pharmacy_code = $_REQUEST["pharmacy_code"];

    $qry_001  = " INSERT INTO {$TB_PS_PILL} SET ";
    $qry_001 .= "  PS_CODE = '{$ps_code}' ";
    $qry_001 .= ", PP_PHARMACY = '{$pharmacy_code}' ";
    $qry_001 .= ", PP_TITLE = '{$row_api[0]}' ";
    $qry_001 .= ", PP_PHARMACIST = HEX(AES_ENCRYPT('" . $_SESSION["pharmacy"]["id"] . "','" . SECRET_KEY . "')) ";

    $res_001 = $db->exec_sql($qry_001);

    alert_js("parent_opener_reload", "", "");
    alert_js("parent_selfclose", "", "");
    exit;

} else if($Mode == "update_pill_unit") {

    $p_idx = $_REQUEST["p_idx"];
    $p_field = $_REQUEST["p_field"];
    $p_val = $_REQUEST["p_val"];

    $qry_001  = " UPDATE {$TB_PS_PILL} SET ";
    $qry_001 .= $p_field." = '".$p_val."' ";
    $qry_001 .= " WHERE IDX = '".$p_idx."' ";

    $res_001 = $db->exec_sql($qry_001);

    echo "100";
    exit;

}


$db->db_close();