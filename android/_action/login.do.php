<?php
include_once "../../_core/_init.php";

$Mode = $_POST["Mode"];

switch ($Mode) {

    case "user_login" :

        $log_id = $_POST["log_id"];
        $log_pass = $_POST["log_pass"];

        /*echo "<br>================".$log_id;
        echo "<br>================".$log_pass;
        exit;*/

        $qry_001 = " SELECT t1.USER_STATUS ";
        $qry_001 .= ", t1.USER_PASS ";
        $qry_001 .= " FROM {$TB_MEMBER} t1";
        //$qry_001 .= " WHERE t1.USER_ID = HEX(AES_ENCRYPT('" . $log_id . "','" . SECRET_KEY . "')) AND t1.USER_TYPE = '1' ";
        $qry_001 .= " WHERE t1.USER_ID = HEX(AES_ENCRYPT('" . $log_id . "','" . SECRET_KEY . "')) ";

        $res_001 = $db->exec_sql($qry_001);
        $row_001 = $db->sql_fetch_row($res_001);

        if ($row_001[1] == MD5($log_pass)) {

            switch ($row_001[0]) {
                case("1"):
                    SetCookie("cookie_user_id", $log_id, time() + (3600 * 24 * 365), "/");

                    $qry_002 = "UPDATE {$TB_MEMBER} SET LAST_LOGIN=now(), LOG_COUNT=LOG_COUNT+1 WHERE USER_ID = HEX(AES_ENCRYPT('" . $log_id . "','" . SECRET_KEY . "'))";
                    @$db->exec_sql($qry_002);

                    echo "100";
                    break;

                default:
                    echo "200";
                    exit;

            }

        } else {
            echo "300";
            exit;
        }

        break;

}

$db->db_close();