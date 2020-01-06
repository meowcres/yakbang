<?
// 전문약사 아이디 존재 확인
if (isNull($_pmyKey["id"])) {
    $url="./pharmacy.login.php?slot=login&type=form";
    alert_js("alert_move","로그인을 하여주십시오",$url);
    exit;
} else {

    $_pharmacy   = array();
    $_pharmacist = array();

    $qry_001  = " SELECT t1.*, t2.*, t3.* ";
    $qry_001 .= ", t1.IDX as ppidx ";
    $qry_001 .= ", t2.IDX as member_idx ";
    $qry_001 .= ", CAST(AES_DECRYPT(UNHEX(t2.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
    $qry_001 .= ", CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
    $qry_001 .= " FROM {$TB_PP} t1 ";
    $qry_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON (t1.USER_ID = t2.USER_ID)";
    $qry_001 .= " LEFT JOIN {$TB_PHARMACY} t3 ON (t1.PHARMACY_CODE = t3.PHARMACY_CODE)";
    $qry_001 .= " WHERE t1.PHARMACY_CODE = '{$_pmyKey["code"]}'";
    $qry_001 .= " AND t1.USER_ID = HEX(AES_ENCRYPT('" . $_pmyKey["id"] . "','" . SECRET_KEY . "'))";

    $res_001  = $db->exec_sql($qry_001);
    $row_001  = $db->sql_fetch_array($res_001);

    if ($row_001["PHARMACY_CODE"] == $_pmyKey["code"]) {

        // 약국 정보
        $idx = $row_001["IDX"];
        $_pharmacy["code"] = $row_001["PHARMACY_CODE"];
        $_pharmacy["status"] = $row_001["PHARMACY_NAME"];
        $_pharmacy["name"] = clear_escape($row_001["PHARMACY_NAME"]);
        $_pharmacy["zipcode"] = $row_001["ZIPCODE"];
        $_pharmacy["address"] = $row_001["ADDRESS"];
        $_pharmacy["addr_ext"] = clear_escape($row_001["ADDRESS_EXT"]);
        $_pharmacy["lati"] = $row_001["LATITUDE"];
        $_pharmacy["longti"] = $row_001["LONGTITUDE"];
        $_pharmacy["phone"] = $row_001["PHARMACY_PHONE"];
        $_pharmacy["email"] = $row_001["PHARMACY_EMAIL"];
        $_pharmacy["operation"] = clear_escape($row_001["OPERATION_HOURS"]);
        $_pharmacy["introduction"] = clear_escape($row_001["INTRODUCTION"]);
        $_pharmacy["start_date"] = $row_001["START_DATE"];

        // 약사 정보
        $_pharmacist["p_status"] = $row_001["P_STATUS"];
        $_pharmacist["grade"] = $row_001["P_GRADE"];
        $_pharmacist["id"] = $row_001["mm_id"];
        $_pharmacist["name"] = $row_001["mm_name"];
        $_pharmacist["s_date"] = $row_001["S_DATE"];
        $_pharmacist["e_date"] = $row_001["E_DATE"];
        $_pharmacist["reg_date"] = $row_001["REG_DATE"];
        $_pharmacist["up_date"] = $row_001["UP_DATE"];
        $_pharmacist["last_login"] = $row_001["LAST_LOGIN"];
        $_pharmacist["diapause_date"] = $row_001["DIAPAUSE_DATE"];
        $_pharmacist["withdraw_date"] = $row_001["WITHDRAW_DATE"];
        $_pharmacist["log_count"] = $row_001["LOG_COUNT"];
        $_pharmacist["pharmacist_request"] = $row_001["PHARMACIST_REQUEST"];
        $_pharmacist["pharmacist_reg_date"] = $row_001["PHARMACIST_REG_DATE"];
        $_pharmacist["key"] = $row_001["USER_ID"];
        $_pharmacist["idx"] = $row_001["member_idx"];
        $_pharmacist["ppidx"] = $row_001["ppidx"];

        unset($qry_001);
        unset($res_001);
        unset($row_001);

    } else {

        $_SESSION["pharmacy"]["idx"] = "";
        $_SESSION["pharmacy"]["id"]  = "";

        unset($_pharmacy);
        unset($_pharmacist);
        unset($_pmyKey);

        $url="./pharmacy.login.php?slot=login&type=form";
        alert_js("alert_move","로그인 정보가 일치하지 않습니다",$url);
        exit;

    }

}