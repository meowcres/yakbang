<?php
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.opator.php";

$Mode = "";
$Mode = $_REQUEST["Mode"];

$_link = "";        // 이동할 주소 변수


// 오퍼 처방전 등록
if($Mode == "prescription_update") {

    $ps_code = $_REQUEST["ps_code"];
    $pre_status = $_REQUEST["pre_status"];

    $qry_001  = " UPDATE {$TB_PS_PRECLEANING} SET ";    
    $qry_001 .= "  PRE_STATUS = '".$pre_status."' ";    
    $qry_001 .= ", S_DATE = now() ";
    $qry_001 .= " WHERE PS_CODE = '".$ps_code."' ";

    $res_001 = $db->exec_sql($qry_001);

    $idx = $_REQUEST["idx"];
    $one_injection = $_REQUEST["one_injection"];
    $day_injection = $_REQUEST["day_injection"];
    $total_injection = $_REQUEST["total_injection"];
    $pp_usage = $_REQUEST["pp_usage"];

    $qry_002  = " UPDATE {$TB_PS_PILL} SET ";
    $qry_002 .= " ONE_INJECTION  = '".$one_injection."' ";    
    $qry_002 .= ", DAY_INJECTION  = '".$day_injection."' ";    
    $qry_002 .= ", TOTAL_INJECTION  = '".$total_injection."' ";    
    $qry_002 .= ", PP_USAGE  = '".$pp_usage."' ";  
    $qry_002 .= " WHERE IDX = '".$idx."' ";

    $res_002 = $db->exec_sql($qry_002);


    if($pre_status == 5) {
        $qry_009  = " UPDATE {$TB_PS} SET ";    
        $qry_009 .= "  PS_STATUS    = 2 ";    
        $qry_009 .= " WHERE PS_CODE = '".$ps_code."' ";

        $res_009 = $db->exec_sql($qry_009);

    } else {
        $qry_009  = " UPDATE {$TB_PS} SET ";    
        $qry_009 .= "  PS_STATUS    = '".$pre_status."' ";    
        $qry_009 .= " WHERE PS_CODE = '".$ps_code."' ";

        $res_009 = $db->exec_sql($qry_009);

    }


    $res_003 = $db->exec_sql($qry_003);

    alert_js("parent_opener_reload", "", "");
    alert_js("alert_parent_selfclose", "처방전을 등록하였습니다", "");
    exit;


// 처방약 등록
}  else if($Mode == "add_pill") {

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

    $qry_001  = " INSERT INTO {$TB_PS_PILL} SET ";
    $qry_001 .= "  PS_CODE = '".$ps_code."' ";
    $qry_001 .= ", PP_TITLE = '".$row_api[0]."' ";

    $res_001 = $db->exec_sql($qry_001);

    alert_js("parent_opener_reload", "", "");
    alert_js("parent_selfclose", "", "");
    exit;


// 처방약 업데이트
}  else if($Mode == "update_pill_unit") {


    $p_idx = $_REQUEST["p_idx"];
    $p_field = $_REQUEST["p_field"];
    $p_val = $_REQUEST["p_val"];


    $qry_001  = " UPDATE {$TB_PS_PILL} SET ";
    $qry_001 .= $p_field." = '".$p_val."' ";
    $qry_001 .= " WHERE IDX = '".$p_idx."' ";

    $res_001 = $db->exec_sql($qry_001);

    echo "100";
    exit;



// 처방약 삭제
} else if($Mode == "delete_pill") {
 

    $idx = $_REQUEST["idx"];
    $ps_code = $_REQUEST["ps_code"];

    $_sql = "DELETE FROM {$TB_PS_PILL} WHERE IDX = '".$idx."' ";
    $db->exec_sql($_sql);

    alert_js("parent_reload", "", "");
    exit;



} 



$db->db_close();

