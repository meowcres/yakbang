<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/admin_auth.php";


$Mode = "";
$Mode = $_REQUEST["Mode"];


$_link = "";        // 이동할 주소 변수


// 처방전 삭제
if ($Mode == "del_prescription") {

    $ps_code = $_REQUEST["ps_code"];

        // 파일 클래스
        $qry_img = " SELECT PHYSICAL_NAME FROM {$TB_PS_IMAGE} WHERE PS_CODE = '{$ps_code}' ";
        $res_img = $db->exec_sql($qry_img);
        $row_img = $db->sql_fetch_row($res_img);
        $prescription_img = $row_img[0];

        @unlink("../../_core/_files/prescription/" . $prescription_img);
        $del_001 = " DELETE FROM {$TB_PS_IMAGE} WHERE PS_CODE = '{$ps_code}' ";
        $del_002 = " DELETE FROM {$TB_PS} WHERE PS_CODE='{$ps_code}' ";
        $del_003 = " DELETE FROM {$TB_PS_PHARMACY} WHERE PS_CODE='{$ps_code}' ";
        $del_004 = " DELETE FROM {$TB_PS_PILL} WHERE PS_CODE='{$ps_code}' ";

        @$db->exec_sql($del_001);
        @$db->exec_sql($del_002);
        @$db->exec_sql($del_003);
        @$db->exec_sql($del_004);


        $go_link = "../admin.template.php?slot=prescription&type=prescription_list";
        alert_js("parent_move", "", $go_link);

        exit;


// 처방약 등록
} else if ($Mode == "add_pill") {

    $ps_code = $_POST['ps_code'];
    $one_injection = $_POST['one_injection'];
    $day_injection = $_POST['day_injection'];
    $total_injection = $_POST['total_injection'];
    $pp_title = add_escape($_POST['pp_title']);
    $pp_usage = add_escape($_POST['pp_usage']);

    $qry_001 = " INSERT INTO {$TB_PS_PILL} SET ";
    $qry_001 .= "  PS_CODE = '{$ps_code}' ";
    $qry_001 .= ", PP_TYPE = '1' ";
    $qry_001 .= ", ONE_INJECTION = '{$one_injection}' ";
    $qry_001 .= ", DAY_INJECTION = '{$day_injection}' ";
    $qry_001 .= ", TOTAL_INJECTION = '{$total_injection}' ";
    $qry_001 .= ", PP_TITLE = '{$pp_title}' ";
    $qry_001 .= ", PP_USAGE = '{$pp_usage}' ";

    $db->exec_sql($qry_001);

    //$id = mysql_insert_id();

    alert_js("parent_opener_reload", "", "");
    alert_js("alert_parent_reload", "처방약을 등록하였습니다.", "");
    exit;


// 처방약 삭제
} else if ($Mode == "del_pill") {

    $idx = $_REQUEST["idx"];
    $ps_code = $_REQUEST["ps_code"];

    $del_001 = " DELETE FROM {$TB_PS_PILL} WHERE IDX = '{$idx}' ";

    @$db->exec_sql($del_001);

    $go_link = "../admin.template.php?slot=prescription&type=prescription_detail&step=pill&ps_code=".$ps_code;
    alert_js("parent_move", "", $go_link);

    exit;

}

$db->db_close();
