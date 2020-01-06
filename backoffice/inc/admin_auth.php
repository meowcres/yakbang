<?
// 관리자 아이디 존재 확인
if (isNull($_passKey["id"])) {
    $url="./admin.login.php?slot=login&type=form";
    alert_js("alert_move","로그인을 하여주십시오",$url);
    exit;
} else {
    $_admin = array();
    $sql_001 = "SELECT t1.* FROM {$TB_ADMIN} t1 WHERE t1.ADMIN_ID='{$_passKey["id"]}'";
    $res_001 = $db->exec_sql($sql_001);
    $row_001  = $db->sql_fetch_array($res_001);

    if ($row_001["IDX"] == $_passKey["idx"]) {

        $_admin["idx"] = $row_001["IDX"];
        $_admin["status"] = $row_001["ADMIN_STATUS"];
        $_admin["type"] = $row_001["ADMIN_TYPE"];
        $_admin["grade"] = $row_001["ADMIN_GRADE"];
        $_admin["id"] = $row_001["ADMIN_ID"];
        $_admin["pass"] = $row_001["ADMIN_PASS"];
        $_admin["name"] = clear_escape($row_001["ADMIN_NAME"]);
        $_admin["phone"] = clear_escape($row_001["ADMIN_PHONE"]);
        $_admin["mobile"] = clear_escape($row_001["ADMIN_MOBILE"]);
        $_admin["email"] = clear_escape($row_001["ADMIN_EMAIL"]);
        $_admin["dept"] = clear_escape($row_001["ADMIN_DEPT"]);
        $_admin["position"] = clear_escape($row_001["ADMIN_POSITION"]);
        $_admin["hit"] = $row_001["ADMIN_HIT"];
        $_admin["cmt"] = clear_escape($row_001["ADMIN_CMT"]);
        $_admin["reg_date"] = $row_001["REG_DATE"];
        $_admin["last_date"] = $row_001["LAST_DATE"];

        unset($sql_001);
        unset($res_001);
        unset($row_001);

    } else {
        $_SESSION["idx"] = "";
        $_SESSION["id"] = "";
        
        if($ADMIN_COOKIE_YN == "yes"){
            SetCookie("cookie_admin_idx", "",time()-3600,"/");
            SetCookie("cookie_admin_id", "",time()-3600,"/");
        }

        unset($_admin);
        unset($_passKey);

        $url="./admin.login.php?slot=login&type=form";
        alert_js("alert_move","로그인 정보가 일치하지 않습니다",$url);
        exit;
    }
}