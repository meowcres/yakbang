<?php
include_once "../../_core/_init.php";

$Mode = $_REQUEST["Mode"];

switch ($Mode) {

    // 로그인
    case "login" :

        $op_id = $_REQUEST["op_id"];
        $op_pass = $_REQUEST["op_pass"];
        
        $qry_001 = " SELECT OP_PASS, END_DATE FROM {$TB_OP} ";
        $qry_001 .= " WHERE OP_ID = '".$op_id."' ";
        $qry_001 .= " AND OP_STATUS = '2' ";  // 회원상태
        $qry_001 .= " AND START_DATE <= curdate() ";  // 접속권한시작일
        $qry_001 .= " AND END_DATE >= curdate() ";  // 접속권한마감일
        $res_001 = $db->exec_sql($qry_001);
        $row_001 = $db->sql_fetch_row($res_001);

        
        $today = date("Ymd");

        if ($row_001["1"] < $today) {
            alert_js("alert", "접속권한일이 유효하지 않습니다. \\n\\n다시 확인해 주세요!", "");
            exit;
        }

        if (!isNull($row_001[0])) {

            if ($row_001["0"] == $op_pass) {

                $_SESSION["op_id"] = $op_id; 
                $session_key = session_id();
                $ip_add = $_SERVER["REMOTE_ADDR"];

                // 접속 카운터 증가
                $qry_002 = " UPDATE {$TB_OP} SET ";
                $qry_002 .= " LOGIN_COUNT = LOGIN_COUNT+1, LAST_DATE = now() ";
                $qry_002 .= " WHERE OP_ID = '".$op_id."' ";

                @$db->exec_sql($qry_002);

                $qry_003 = " INSERT INTO {$TB_OP_LOG} SET ";
                $qry_003 .= "  OP_ID       = '".$op_id."' ";
                $qry_003 .= ", SESSION_KEY = '".$session_key."' ";
                $qry_003 .= ", OP_IP       = '".$ip_add."' ";
                $qry_003 .= ", IN_DATE     = sysdate() ";

                @$db->exec_sql($qry_003);

                //$return_path = "../op.template.php?slot=main&type=dashboard";
                $return_path = "../op.template.php?slot=dashboard&type=dashboard_list";
                alert_js("parent_move", "", $return_path);
                
            } else {

                alert_js("alert", "비밀번호가 일치하지 않습니다. \\n\\n다시 확인해 주세요!", "");
                exit;

            }
        } else {
            alert_js("alert", "아이디가 존재하지 않습니다. \\n\\n다시 확인해 주세요!", "");
        }

        break;

    // 로그아웃
    case "logout" :
        
        $session_key = session_id();

        $qry_004 = " UPDATE {$TB_OP_LOG} SET ";
        $qry_004 .= " OUT_DATE = sysdate() ";
        $qry_004 .= " WHERE SESSION_KEY = '".$session_key."' ";


        @$db->exec_sql($qry_004);

        $_SESSION["op_id"] = "";
        
        setcookie(session_name(), "", time()-42000, "/");
        setcookie(session_id(), "", time()-42000,  "/");
        
        $Return_Path = "../op.login.php?slot=login&type=form";
        alert_js("alert_parent_move", "로그아웃 되었습니다.", $Return_Path);

        break;

}


$db->db_close();