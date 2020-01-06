<?
// 오퍼 아이디 존재 확인
if (isNull($_opKey["id"])) {
    $url="./op.login.php?slot=login&type=form";
    alert_js("alert_move","로그인을 하여주십시오",$url);
    exit;
} else {

    $_op   = array();

    $qry_001  = " SELECT *, DATE_FORMAT(START_DATE, '%Y-%m-%d') AS S_DATE, DATE_FORMAT(END_DATE, '%Y-%m-%d') AS E_DATE ";
    $qry_001 .= " FROM {$TB_OP} ";
    $qry_001 .= " WHERE OP_STATUS = '2' AND OP_ID = '".$_opKey["id"]."' ";


    $res_001  = $db->exec_sql($qry_001);
    $_op      = $db->sql_fetch_array($res_001);

}



