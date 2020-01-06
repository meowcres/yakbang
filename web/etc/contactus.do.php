<?                                                                                                                       
include_once "../../_core/_init.php";

$mode = "";
$mode = $_REQUEST["mode"];

$link = ""; // 이동할 주소 변수



##### CONTACT US
if ($mode == "send_cont") {

    $R_TYPE     = $_REQUEST["title_inp"];
    $R_TITLE    = $_REQUEST["title_name"];
    $R_WRITE    = $_REQUEST["title_user"];
    $R_PHONE    = $_REQUEST["title_phone"] . "-" . $_REQUEST["title_phone1"] . "-" . $_REQUEST["title_phone2"];
    $R_EMAIL    = $_REQUEST["title_emailID"] . "@" . $_REQUEST["emailDomain"];
    $R_CONTENTS = $_REQUEST["info_inp"];


    $qry_001 = "INSERT INTO {$TB_REQUEST} SET";
    $qry_001 .= "  R_TYPE = '{$R_TYPE}'";
    $qry_001 .= ", R_TITLE = '{$R_TITLE}'";
    $qry_001 .= ", R_CONTENTS = '{$R_CONTENTS}'";
    $qry_001 .= ", R_WRITE = '{$R_WRITE}'";
    $qry_001 .= ", R_PHONE = '{$R_PHONE}'";
    $qry_001 .= ", R_EMAIL = '{$R_EMAIL}'";
    $qry_001 .= ", REG_DATE = sysdate()";
    $qry_001 .= ", UP_DATE = sysdate()";

    $db->exec_sql($qry_001);

    alert_js("parent_opener_reload", "", "");
    alert_js("alert_parent_reload", "CONTACTUS를 등록하였습니다.", "");
    exit;


}

$db->db_close();

