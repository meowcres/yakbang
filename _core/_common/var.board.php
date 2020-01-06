<?
############### 페이지 정보 ####################
$_slot = isNull($_REQUEST["slot"]) ? "" : $_REQUEST["slot"];
$_type = isNull($_REQUEST["type"]) ? "" : $_REQUEST["type"];
$_step = isNull($_REQUEST["step"]) ? "" : $_REQUEST["step"];
$_step = isNull($_step) ? "bbs_list" : $_step;
$_page = isNull($_REQUEST["page"]) ? "" : $_REQUEST["page"];

$_bd = isNull($_REQUEST["bd"]) ? "" : $_REQUEST["bd"];
$_bd = isNull($_fix_tb) ? $_bd : $_fix_tb; // 사용자 페이지에서 강제적 테이블을 지정해야 할때


############### 게시판 코드 정보가 없으면 x ####################
if (isNull($_bd)) {
    alert_js("alert_back", "정보가 옳바르지 않습니다!", "");
    exit;
}


############### 보드 환경 정보 ####################
$_sql = "SELECT t1.*                ";
$_sql .= " FROM {$BD_CONFIG_TB} t1   ";
$_sql .= " WHERE t1.bd_code='{$_bd}' ";

$_res = $db->exec_sql($_sql);
$_BOARD = $db->sql_fetch_array($_res);

unset($_sql);
unset($_res);


############### 보드 회원정보 설정
$_board_user_email = array();

if (!isNull($_passKey["id"])) {

    $_BOARD["user_idx"] = 0;
    $_BOARD["user_id"] = "webmaster";
    $_BOARD["user_pass"] = $_passKey["pass"];
    $_BOARD["user_name"] = $_passKey["name"];
    $_BOARD["user_grade"] = "99";
    $_BOARD["is_admin"] = "yes";

    $_board_user_email = explode("@", $_passKey["email"]);

} else {

    $_BOARD["user_idx"] = isNull($_SESSION["s_idx"]) ? 0 : $_SESSION["s_idx"];
    $_BOARD["user_id"] = isNull($_SESSION["s_id"]) ? "" : $_SESSION["s_id"];
    $_BOARD["user_pass"] = isNull($_MEMBER["user_pass"]) ? "" : $_MEMBER["user_pass"];
    $_BOARD["user_name"] = isNull($_SESSION["s_name"]) ? "" : $_SESSION["s_name"];
    $_BOARD["user_grade"] = isNull($_SESSION["s_type"]) ? "" : $_SESSION["s_type"];
    $_BOARD["is_admin"] = "no";

    $_board_user_email = array();
    $_board_user_email = explode("@", $_MEMBER["user_email"]);

}

############### 보드 파일정보
$BOARD_FILE_URL = "../_core/_files/board/" . $_BOARD["bd_code"] . "/";    //게시판 파일 주소
?>