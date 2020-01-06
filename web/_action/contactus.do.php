<?                                                                                                                       
include_once "../../_core/_init.php";

$mode = "";
$mode = $_REQUEST["mode"];

$link = ""; // 이동할 주소 변수


// WEB CONTACT US 문의하기
if ($mode == "send_cont") {

    $r_type = $_REQUEST["choice_inp"];
    $r_title = $_REQUEST["title_inp"];
    $r_write = $_REQUEST["title_name"];
    $r_phone = $_REQUEST["title_phone"] . "-" . $_REQUEST["title_phone1"] . "-" . $_REQUEST["title_phone2"];
    $r_email = $_REQUEST["title_emailID"] . "@" . $_REQUEST["emailDomain"];
    $r_contents = $_REQUEST["info_inp"];

    $qry_001 = "INSERT INTO {$TB_REQUEST} SET";
    $qry_001 .= "  R_TYPE = '{$r_type}'";
    $qry_001 .= ", R_TITLE = '{$r_title}'";
    $qry_001 .= ", R_WRITE = '{$r_write}'";
    $qry_001 .= ", R_PHONE = '{$r_phone}'";
    $qry_001 .= ", R_EMAIL = '{$r_email}'";
    $qry_001 .= ", R_CONTENTS = '{$r_contents}'";
    $qry_001 .= ", REG_DATE = sysdate()";
    $qry_001 .= ", UP_DATE = sysdate()";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_reload", "CONTACTUS를 등록하였습니다.", "");

    exit;



}

$db->db_close();

