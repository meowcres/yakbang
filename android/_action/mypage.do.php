<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/admin_auth.php";


$Mode = "";
$Mode = $_REQUEST["Mode"];


$_link = "";        // 이동할 주소 변수

// 마이페이지 - 정보수정
if ($Mode == "member_up") {

    $idx = $_POST["idx"];
    $user_id = $_POST["user_id"];
    $user_name = $_POST["user_name"];
    $user_phone = $_POST["phone1"] . "-" . $_POST["phone2"] . "-" . $_POST["phone3"];
    $user_birthday = $_POST["birth_year"] . "-" . $_POST["birth_month"] . "-" . $_POST["birth_day"];
    $user_sex = $_POST["user_sex"];

    $qry_001 = "UPDATE {$TB_MEMBER} SET ";
    $qry_001 .= "  USER_NAME   = HEX(AES_ENCRYPT('" . $user_name . "','" . SECRET_KEY . "'))";
    $qry_001 .= " , UP_DATE    = now() ";
    $qry_001 .= " WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_001);

    $qry_002 = "UPDATE {$TB_MEMBER_INFO} SET ";
    $qry_002 .= "   USER_BIRTHDAY = '{$user_birthday}' ";
    $qry_002 .= " , USER_SEX = '{$user_sex}' ";
    $qry_002 .= " , USER_PHONE = HEX(AES_ENCRYPT('" . $user_phone . "','" . SECRET_KEY . "'))";
    $qry_002 .= " WHERE ID_KEY = '{$user_id}' ";

    $db->exec_sql($qry_002);

    echo 0;

    exit;


// 마이페이지 - 비밀번호 수정
} else if ($Mode == "member_pass") {


    $idx = $_POST["idx"];
    $user_pass = md5($_POST["user_pass"]);
    $mm_pass = md5($_POST["mm_pass"]);

    $qry_pass = " SELECT * FROM {$TB_MEMBER} WHERE IDX = '{$idx}' ";
    $res_pass = $db->exec_sql($qry_pass);
    $row_pass = $db->sql_fetch_array($res_pass);
    $pass = $row_pass["USER_PASS"];

    if ($pass == $mm_pass) {

        $qry_001 = "UPDATE {$TB_MEMBER} SET ";
        $qry_001 .= "  USER_PASS = '{$user_pass}' ";
        $qry_001 .= " ,UP_DATE    = now() ";
        $qry_001 .= " WHERE IDX = '{$idx}' ";

        $db->exec_sql($qry_001);

        echo 0;

    } else {
        echo 1;
    }

    exit;


// 마이페이지 - 회원탈퇴신청
} else if ($Mode == "member_del") {

    $idx = $_POST["idx"];
    $user_pass = md5($_POST["mm_pass"]);

    $qry_001 = " SELECT USER_PASS FROM {$TB_MEMBER} WHERE IDX = '{$idx}' ";
    $res_001 = $db->exec_sql($qry_001);
    $row_001 = $db->sql_fetch_row($res_001);

    if ($row_001[0] == $user_pass) {
        $qry_002 = " UPDATE {$TB_MEMBER} SET ";
        $qry_002 .= "   USER_STATUS   = '3' ";
        $qry_002 .= " , WITHDRAW_DATE = now() ";
        $qry_002 .= " WHERE IDX = '{$idx}' ";

        $db->exec_sql($qry_002);
        echo 0;

    } else {
        echo 1;
    }


// 마이페이지 - 쪽지 읽기 ( 멘토리스트 )
} else if ($Mode == "mentor_list_dm_read") {

    $mentee_id = $_REQUEST["mentee_id"];
    $mentor_id = $_REQUEST["mentor_id"];

    $qry_001 = " UPDATE {$TB_DM} SET ";
    $qry_001 .= " R_STATUS = '1' ";
    $qry_001 .= " , R_DATE = now() ";
    $qry_001 .= " WHERE SEND_ID = '{$mentor_id}' AND RECEIVE_ID = '{$mentee_id}' ";

    $db->exec_sql($qry_001);

    echo 0;

// 마이페이지 - 쪽지 읽기 ( 멘티리스트 )
} else if ($Mode == "mentee_list_dm_read") {

    $mentee_id = $_REQUEST["mentee_id"];
    $mentor_id = $_REQUEST["mentor_id"];

    $qry_001 = " UPDATE {$TB_DM} SET ";
    $qry_001 .= " R_STATUS = '1' ";
    $qry_001 .= " , R_DATE = now() ";
    $qry_001 .= " WHERE SEND_ID = '{$mentee_id}' AND RECEIVE_ID = '{$mentor_id}' ";

    $db->exec_sql($qry_001);

    echo 0;

// 마이페이지 - 쪽지 보내기
} else if ($Mode == "dm_add") {

    $send_id = add_escape($_REQUEST["send_id"]);
    $receive_id = add_escape($_REQUEST["receive_id"]);
    $message = add_escape($_REQUEST["message"]);

    $qry_001 = "   INSERT INTO {$TB_DM} SET ";
    $qry_001 .= "   SEND_ID = '{$send_id}' ";
    $qry_001 .= " , RECEIVE_ID = '{$receive_id}' ";
    $qry_001 .= " , S_STATUS = '1' ";
    $qry_001 .= " , R_STATUS = '2' ";
    $qry_001 .= " , MESSAGE = '{$message}' ";
    $qry_001 .= " , S_DATE = now() ";
    $qry_001 .= " , REG_DATE = now() ";

    $db->exec_sql($qry_001);

    echo 0;


    exit;


// 마이페이지 - 약사신청
} else if ($Mode == "apply_pharmacist_add") {

    $idx = $_REQUEST["idx"];
    $user_id = $_REQUEST["user_id"];
    $pharmacist_request = $_REQUEST["pharmacist_request"];
    $license_number = $_REQUEST["license_number"];

    $qry_001 = " UPDATE {$TB_MEMBER} SET ";
    $qry_001 .= "   PHARMACIST_REQUEST = '{$pharmacist_request}' ";
    $qry_001 .= " , PHARMACIST_REG_DATE = now() ";
    $qry_001 .= " WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_001);

    $qry_002 = " UPDATE {$TB_MEMBER_INFO} SET ";
    $qry_002 .= " LICENSE_NUMBER = '{$license_number}' ";
    $qry_002 .= " WHERE ID_KEY = '{$user_id}' ";

    $db->exec_sql($qry_002);


    $qry_003 = " INSERT INTO {$TB_ATTECH_FILES} SET ";
    $qry_003 .= "   PARENT_CODE = '{$TB_MEMBER}'  ";
    $qry_003 .= " , REFERENCE_CODE = '{$user_id}' ";
    $qry_003 .= " , TYPE_CODE = 'pharmacist_license' ";

    echo 0;
    exit;


// 멘토&멘티 리스트 마지막 레코드 비교
} else if ($Mode == "ajax_call") {

    $r_status = $_REQUEST['r_status'];
    $reg_date = $_REQUEST['reg_date'];
    $mentee_id = $_REQUEST['mentee_id'];
    $mentor_id = $_REQUEST['mentor_id'];

    $db->exec_sql($qry_read);

    $qry_cnt = " SELECT COUNT(*) ";
    $qry_sel = " SELECT *, t1.REG_DATE AS reg_date ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t1.SEND_ID),'" . SECRET_KEY . "') as char) as s_id ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t1.RECEIVE_ID),'" . SECRET_KEY . "') as char) as r_id ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as s_name ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as r_name ";
    $qry_001 = " FROM {$TB_DM} t1 ";
    $qry_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.SEND_ID = t2.USER_ID ) ";
    $qry_001 .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.RECEIVE_ID = t3.USER_ID ) ";
    $qry_001 .= " WHERE ( t1.SEND_ID = '{$mentee_id}' AND t1.RECEIVE_ID = '{$mentor_id}' ) OR ( t1.SEND_ID = '{$mentor_id}' AND t1.RECEIVE_ID = '{$mentee_id}' ) ";
    $qry_001 .= " ORDER BY t1.S_DATE ";
    $qry_001 .= " LIMIT 0, 100 ";

    $res_cnt = $db->exec_sql($qry_cnt . $qry_001);
    $row_cnt = $db->sql_fetch_row($res_cnt);
    $totalnum = $row_cnt[0];

    if ($totalnum > 0) {
        $res_001 = $db->exec_sql($qry_sel . $qry_001);
        while ($row_001 = $db->sql_fetch_array($res_001)) {
            $ajax_date = $row_001["reg_date"];
            $ajax_status = $row_001["R_STATUS"];
        }
    } else {
    }

    if ( $r_status == $ajax_status && $reg_date == $ajax_date ) {
        echo 0;
        /*echo $r_status.", ".$ajax_status."<br>".$reg_date.",".$ajax_date;*/
        exit;
    } else {
        echo 999;
        exit;
    }



// 멘티리스트 - 실시간 채팅 ajax
} else if ($Mode == "ajax_call_mentee") {

    $mentee_id = $_REQUEST['mentee_id'];
    $mentor_id = $_REQUEST['mentor_id'];
    $_list = "";

    $qry_read = " UPDATE {$TB_DM} SET ";
    $qry_read .= " R_STATUS = '1' ";
    $qry_read .= " , R_DATE = now() ";
    $qry_read .= " WHERE SEND_ID = '{$mentee_id}' AND RECEIVE_ID = '{$mentor_id}' ";

    $db->exec_sql($qry_read);

    $qry_cnt = " SELECT COUNT(*) ";
    $qry_sel = " SELECT *, t1.REG_DATE AS reg_date ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t1.SEND_ID),'" . SECRET_KEY . "') as char) as s_id ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t1.RECEIVE_ID),'" . SECRET_KEY . "') as char) as r_id ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as s_name ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as r_name ";
    $qry_001 = " FROM {$TB_DM} t1 ";
    $qry_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.SEND_ID = t2.USER_ID ) ";
    $qry_001 .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.RECEIVE_ID = t3.USER_ID ) ";
    $qry_001 .= " WHERE ( t1.SEND_ID = '{$mentee_id}' AND t1.RECEIVE_ID = '{$mentor_id}' ) OR ( t1.SEND_ID = '{$mentor_id}' AND t1.RECEIVE_ID = '{$mentee_id}' ) ";
    $qry_001 .= " ORDER BY t1.S_DATE ";
    $qry_001 .= " LIMIT 0, 100 ";

    $res_cnt = $db->exec_sql($qry_cnt . $qry_001);
    $row_cnt = $db->sql_fetch_row($res_cnt);
    $totalnum = $row_cnt[0];

    if ($totalnum > 0) {
        $res_001 = $db->exec_sql($qry_sel . $qry_001);
        while ($row_001 = $db->sql_fetch_array($res_001)) {
            if ($row_001["R_STATUS"] == 1) {
                $status = "읽음";
            } else if ($row_001["R_STATUS"] == 2) {
                $status = "1";
            } else if ($row_001["R_STATUS"] == 3) {
                $status = "삭제";
            }
            $reg_date = $row_001["reg_date"];
            $r_status = $row_001["R_STATUS"];

            if ($row_001["RECEIVE_ID"] == $mentor_id) {
                $_list .= '<div class="lefTBx"> ';
                $_list .= '<div class="inName">';
                $_list .= '<span>' . $row_001["s_name"] . '<em class="sdate">' . $row_001["S_DATE"] . '</em><em>'.$status.'</em></span>';
                $_list .= '<div class="sAytxx">'.$row_001["MESSAGE"].'</div>';
                $_list .= '</div>';
                $_list .= '</div>';
            } else {
                $_list .= '<div class="riGhtBx"> ';
                $_list .= '<div class="inName">';
                $_list .= '<span><em>' . $status . '</em><em class="sdate">' . $row_001["S_DATE"] . '</em>' . $row_001["s_name"] . '</span>';
                $_list .= '<div class="sAytxx">' . $row_001["MESSAGE"] . '</div>';
                $_list .= '</div>';
                $_list .= '</div>';
            }
        }
        $_list .= '<input type="hidden" id="reg_date" name="reg_date" value="'.$reg_date.'">';
        $_list .= '<input type="hidden" id="r_status" name="r_status" value="'.$r_status.'">';
    } else {

    }

    echo $_list;
    exit;


// 멘토리스트 - 실시간 채팅 ajax
} else if ($Mode == "ajax_call_mentor") {

    $mentee_id = $_REQUEST['mentee_id'];
    $mentor_id = $_REQUEST['mentor_id'];
    $_list = "";

    $qry_read = " UPDATE {$TB_DM} SET ";
    $qry_read .= " R_STATUS = '1' ";
    $qry_read .= " , R_DATE = now() ";
    $qry_read .= " WHERE SEND_ID = '{$mentor_id}' AND RECEIVE_ID = '{$mentee_id}' ";

    $db->exec_sql($qry_read);

    $qry_cnt = " SELECT COUNT(*) ";
    $qry_sel = " SELECT *, t1.REG_DATE AS reg_date ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t1.SEND_ID),'" . SECRET_KEY . "') as char) as s_id ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t1.RECEIVE_ID),'" . SECRET_KEY . "') as char) as r_id ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as s_name ";
    $qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as r_name ";
    $qry_001 = " FROM {$TB_DM} t1 ";
    $qry_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.SEND_ID = t2.USER_ID ) ";
    $qry_001 .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.RECEIVE_ID = t3.USER_ID ) ";
    $qry_001 .= " WHERE ( t1.SEND_ID = '{$mentee_id}' AND t1.RECEIVE_ID = '{$mentor_id}' ) OR ( t1.SEND_ID = '{$mentor_id}' AND t1.RECEIVE_ID = '{$mentee_id}' ) ";
    $qry_001 .= " ORDER BY t1.S_DATE ";
    $qry_001 .= " LIMIT 0, 100 ";

    $res_cnt = $db->exec_sql($qry_cnt . $qry_001);
    $row_cnt = $db->sql_fetch_row($res_cnt);
    $totalnum = $row_cnt[0];

    if ($totalnum > 0) {
        $res_001 = $db->exec_sql($qry_sel . $qry_001);
        while ($row_001 = $db->sql_fetch_array($res_001)) {
            if ($row_001["R_STATUS"] == 1) {
                $status = "읽음";
            } else if ($row_001["R_STATUS"] == 2) {
                $status = "1";
            } else if ($row_001["R_STATUS"] == 3) {
                $status = "삭제";
            }
            $reg_date = $row_001["reg_date"];
            $r_status = $row_001["R_STATUS"];

            if ($row_001["RECEIVE_ID"] == $mentee_id) {
                $_list .= '<div class="lefTBx"> ';
                $_list .= '<div class="inName">';
                $_list .= '<span>' . $row_001["s_name"] . '<em class="sdate">' . $row_001["S_DATE"] . '</em><em>'.$status.'</em></span>';
                $_list .= '<div class="sAytxx">'.$row_001["MESSAGE"].'</div>';
                $_list .= '</div>';
                $_list .= '</div>';
            } else {
                $_list .= '<div class="riGhtBx"> ';
                $_list .= '<div class="inName">';
                $_list .= '<span><em>' . $status . '</em><em class="sdate">' . $row_001["S_DATE"] . '</em>' . $row_001["s_name"] . '</span>';
                $_list .= '<div class="sAytxx">' . $row_001["MESSAGE"] . '</div>';
                $_list .= '</div>';
                $_list .= '</div>';
            }
        }
        $_list .= '<input type="hidden" id="reg_date" name="reg_date" value="'.$reg_date.'">';
        $_list .= '<input type="hidden" id="r_status" name="r_status" value="'.$r_status.'">';
    } else {

    }

    echo $_list;
    exit;

}

$db->db_close();

