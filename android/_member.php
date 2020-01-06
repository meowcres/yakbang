<?php
if ($__member_chk == "no_member") {

    if (!isNull($_COOKIE["cookie_user_id"])) {
        alert_js("move", "", "../mypage/mypage.php");
        exit;
    }

} else {
    
    if(isNull($_COOKIE["cookie_user_id"])){
        alert_js("move", "", "../member/login.php");
        exit;
    } else {
        $mm_qry = " SELECT t1.*, t2.*  ";
        $mm_qry .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
        $mm_qry .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
        $mm_qry .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";
        $mm_qry .= " FROM {$TB_MEMBER} t1 ";
        $mm_qry .= " LEFT JOIN {$TB_MEMBER_INFO} t2 ON (t1.USER_ID = t2.ID_KEY) ";
        $mm_qry .= " WHERE t1.USER_ID = HEX(AES_ENCRYPT('" . $_COOKIE["cookie_user_id"] . "','" . SECRET_KEY . "'))";

        $mm_res = $db->exec_sql($mm_qry);
        $mm_row = $db->sql_fetch_array($mm_res);

        $mm_id = $mm_row["mm_id"];
        $mm_name = $mm_row["mm_name"];
        $userPhone_obj = explode("-",$mm_row["mm_phone"]);
        $mm_type = $mm_row["USER_TYPE"];
        $mm_request = $mm_row["PHARMACIST_REQUEST"];
        $mm_sex = $mm_row["USER_SEX"];

        if (isNull($mm_id)) {
            setcookie('cookie_user_id', '', time()-(3600*24*365), "/");
            // 쿠키명 testCookie 사용불가, 만료됨
            header("Location:/android/main/main.php");
        }
    }

}
?>