<?php
include_once "../../_core/_init.php";

$Mode = $_REQUEST["Mode"];

switch ($Mode) {
    // 로그인
    case "login" :

        $pharmacy_code = $_POST["pharmacy_code"];
        $pharmacist_id = $_POST["pharmacist_id"];
        $pharmacist_pass = $_POST["pharmacist_pass"];

        // 약국 코드와 약사 아이디 확인
        /*$qry_001  = " SELECT IDX FROM {$TB_PP} ";
        $qry_001 .= " WHERE PHARMACY_CODE='{$pharmacy_code}' ";
        $qry_001 .= " AND P_STATUS = '1' ";
        $qry_001 .= " AND S_DATE <= now() AND E_DATE >= now() ";
        $qry_001 .= " AND USER_ID = HEX(AES_ENCRYPT('" . $pharmacist_id . "','" . SECRET_KEY . "')) ";

        $res_001  = $db->exec_sql($qry_001) ;
        $row_001  = $db->sql_fetch_row($res_001) ;*/

        //if ($row_001[0] > 0) {

        $qry_002 = " SELECT USER_PASS FROM {$TB_MEMBER} ";
        $qry_002 .= " WHERE USER_ID = HEX(AES_ENCRYPT('" . $pharmacist_id . "','" . SECRET_KEY . "')) ";
        $qry_002 .= " AND USER_STATUS = '1' ";  // 회원상태
        $qry_002 .= " AND USER_TYPE = '2' ";  // 약사상태
        $res_002 = $db->exec_sql($qry_002);
        $row_002 = $db->sql_fetch_row($res_002);

        if (!isNull($row_002[0])) {

            if ($row_002["0"] == md5($pharmacist_pass)) {

                $qry_sex = " SELECT USER_SEX FROM {$TB_MEMBER_INFO} WHERE ID_KEY = HEX(AES_ENCRYPT('" . $pharmacist_id . "','" . SECRET_KEY . "')) ";
                $res_sex = $db->exec_sql($qry_sex);
                $row_sex = $db->sql_fetch_row($res_sex);

                $_SESSION["pharmacy"]["code"] = $pharmacy_code;
                $_SESSION["pharmacy"]["id"] = $pharmacist_id;
                $_SESSION["pharmacy"]["sex"] = $row_sex[0];

                // 접속 카운터 증가
                $qry_003 = " UPDATE {$TB_MEMBER} t1 SET ";
                $qry_003 .= " t1.LOG_COUNT=t1.LOG_COUNT+1, t1.LAST_LOGIN=now() ";
                $qry_003 .= " WHERE t1.USER_ID = HEX(AES_ENCRYPT('" . $pharmacist_id . "','" . SECRET_KEY . "')) ";

                @$db->exec_sql($qry_003);

                $return_path = "../pharmacy.template.php?slot=login&type=form";
                alert_js("parent_move", "", $return_path);

            } else {

                alert_js("alert", "비밀번호가 일치하지 않습니다. \\n\\n다시 확인해 주세요!", "");
                exit;

            }
        } else {
            alert_js("alert", "아이디가 존재하지 않습니다. \\n\\n다시 확인해 주세요!", "");
        }

        /*} else {

          alert_js("alert","일치하는 정보가 없습니다. \\n\\n다시 확인해 주세요!","");
          exit;

        }*/

        break;

    // 로그아웃
    case "logout" :

        $_SESSION["pharmacy"]["code"] = "";
        $_SESSION["pharmacy"]["id"] = "";
        $_SESSION["pharmacy"]["sex"] = "";

        $Return_Path = "../pharmacy.login.php?slot=login&type=form";
        alert_js("alert_parent_move", "로그아웃 되었습니다.", $Return_Path);

        break;

    // 약국정보 받고 메인으로 이동하기
    case "go_main" :

        $p_code = $_REQUEST["p_code"];
        $user_id = $_REQUEST["user_id"];
        $slot = $_REQUEST["slot"];

        $_SESSION["pharmacy"]["code"] = $p_code;

        $qry_001 = " SELECT * FROM {$TB_PP} ";
        $qry_001 .= " WHERE USER_ID = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "')) ";
        $qry_001 .= " AND PHARMACY_CODE = '{$p_code}' ";
        $qry_001 .= " AND P_STATUS = '1' ";

        $res_001 = $db->exec_sql($qry_001);
        $row_001 = $db->sql_fetch_row($res_001);

        if (!isNull($row_001[0])) {
            $return_path = "../pharmacy.template.php?slot=main&type=dashboard";
            alert_js("parent_move", "", $return_path);
        } else {
            if ($slot == "login") {
            $return_path = "../pharmacy.login.php?slot=login&type=form";
            alert_js("alert_move", "해당 약국에서 활동중인 약사만 접근이 가능합니다.", "$return_path");
            } else {
                $return_path = "../pharmacy.login.php?slot=login&type=form";
                alert_js("alert_move", "해당 약국에서 활동중인 약사만 접근이 가능합니다.", "$return_path");
            }
        }

}


$db->db_close();