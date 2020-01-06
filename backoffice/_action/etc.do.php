<?php
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";

$mode = "";
$mode = $_REQUEST["mode"];

// 포트폴리오 등록
if ($mode == "portfolio_add") {

    $pf_code = $_POST["pf_code"];
    $pf_title = $_POST["pf_title"];
    $pf_contents = $_POST["pf_contents"];

    //echo "<br>==============".$pf_code;
    //echo "<br>==============".$pf_title;
    //echo "<br>==============".$pf_contents;

    $qry_001 = " INSERT INTO {$TB_PORTFOLIO} SET        ";
    $qry_001 .= " PF_CODE     = '{$pf_code}'     ";
    $qry_001 .= ",PF_TITLE     = '{$pf_title}'     ";
    $qry_001 .= ",PF_CONTENTS   = '{$pf_contents}'   ";
    $qry_001 .= ",REG_DATE    = now()   ";

    $db->exec_sql($qry_001);

    $att = new Attech_Works();

    if (!isNull($_FILES["file1"]["tmp_name"])) {

        $att->addToFile($TB_PORTFOLIO, $pf_code, "portfolio_1", "../../_core/_files/etc", $_FILES["file1"]);

    }
    if (!isNull($_FILES["file2"]["tmp_name"])) {

        $att->addToFile($TB_PORTFOLIO, $pf_code, "portfolio_2", "../../_core/_files/etc", $_FILES["file2"]);

    }
    if (!isNull($_FILES["file3"]["tmp_name"])) {

        $att->addToFile($TB_PORTFOLIO, $pf_code, "portfolio_3", "../../_core/_files/etc", $_FILES["file3"]);

    }
    if (!isNull($_FILES["file4"]["tmp_name"])) {

        $att->addToFile($TB_PORTFOLIO, $pf_code, "portfolio_4", "../../_core/_files/etc", $_FILES["file4"]);

    }

    alert_js("alert_parent_move", "등록하였습니다", "../admin.template.php?slot=etc&type=portfolio_list");

    exit;

// 포트폴리오 수정
} else if ($mode == "portfolio_update") {


    $pf_code = $_POST["pf_code"];
    $pf_company = $_POST["pf_company"];
    $pf_status = $_POST["pf_status"];
    $pf_type = $_POST["pf_type"];
    $pf_title = $_POST["pf_title"];
    $pf_contents = $_POST["pf_contents"];

    $qry_001 = "   UPDATE {$TB_PORTFOLIO} SET ";
    $qry_001 .= "   PF_COMPANY = '{$pf_company}' ";
    $qry_001 .= " , PF_STATUS = '{$pf_status}' ";
    $qry_001 .= " , PF_TYPE = '{$pf_type}' ";
    $qry_001 .= " , PF_TITLE = '{$pf_title}' ";
    $qry_001 .= " , PF_CONTENTS = '{$pf_contents}' ";
    $qry_001 .= "   WHERE PF_CODE = '{$pf_code}' ";

    $db->exec_sql($qry_001);


    // 첨부파일 삭제로직

    for ($i = 1; $i <= 4; $i++) {

        if (!isNull($_POST["del_portfolio_" . $i])) {
            @unlink("../../_core/_files/etc/" . $_POST["del_portfolio_" . $i]);
            $del_qry_001 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["del_portfolio_" . $i] . "' ";
            @$db->exec_sql($del_qry_001);
        }

    }

    $att = new Attech_Works();

    for ($i = 1; $i <= 4; $i++) {

        if (!isNull($_FILES["up_portfolio_" . $i]["tmp_name"])) {

            if (!isNull($_POST["hidden_file_" . $i])) {
                @unlink("../../_core/_files/etc/" . $_POST["hidden_file_" . $i]);
                $del_qry_001 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["hidden_file_" . $i] . "' ";
                @$db->exec_sql($del_qry_001);
            }

            $att->addToFile($TB_PORTFOLIO, $pf_code, "portfolio_" . $i, "../../_core/_files/etc", $_FILES["up_portfolio_" . $i]);
        }

    }

    alert_js("alert_parent_move", "수정하였습니다", "../admin.template.php?slot=etc&type=portfolio_list");

    exit;


// 포트폴리오 삭제
} else if ($mode == "portfolio_delete") {


    $pf_code = $_REQUEST["pf_code"];

    echo "<br>==========================" . $pf_code;

    $qry_001 = " SELECT * FROM {$TB_ATTECH_FILES} WHERE PARENT_CODE='{$TB_PORTFOLIO}' AND REFERENCE_CODE = '{$pf_code}' ";
    $res_001 = $db->exec_sql($qry_001);
    while ($row_001 = $db->sql_fetch_array($res_001)) {

        if (!isNull($row_001["PHYSICAL_NAME"])) {
            @unlink("../../_core/_files/etc/" . $row_001["PHYSICAL_NAME"]);
        }

    }

    $del_qry_001 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PARENT_CODE='{$TB_PORTFOLIO}' AND REFERENCE_CODE = '{$pf_code}' ";
    $del_qry_002 = " DELETE FROM {$TB_PORTFOLIO} WHERE PF_CODE='{$pf_code}' ";

    @$db->exec_sql($del_qry_001);
    @$db->exec_sql($del_qry_002);

    alert_js("parent_reload", "", "");
    exit;


// 푸시 등록 - 푸시대상회원추가
} else if ($mode == "multi_add_push_member") {

    foreach ($_POST['checked_member'] as $key => $value) {

        $user_id = explode("|", $value);

        $qry_002 = "  INSERT INTO {$TB_PUSH_TMP} SET ";
        $qry_002 .= "  USER_ID  = '{$user_id[1]}' ";
        $qry_002 .= " ,ADMIN_ID = '{$user_id[0]}' ";
        $qry_002 .= " ,REG_DATE = now() ";

        $db->exec_sql($qry_002);

    }

    alert_js('alert_perent_parent_parent_iFrame2_reload', '푸시대상 정보를 갱신하였습니다', '');
    exit;


// 푸시 등록 - 전체회원추가
} else if ($mode == "allPush") {

    $qry_001 = " SELECT * FROM {$TB_MEMBER} WHERE USER_TYPE = '1' AND USER_STATUS = '1' ORDER BY IDX ";
    $res_001 = $db->exec_sql($qry_001);

    while ($row_001 = $db->sql_fetch_array($res_001)) {

        $qry_002 = "  INSERT INTO {$TB_PUSH_TMP} SET ";
        $qry_002 .= "  USER_ID  = '{$row_001["USER_ID"]}' ";
        $qry_002 .= " ,ADMIN_ID = '1' ";
        $qry_002 .= " ,REG_DATE = now() ";

        $db->exec_sql($qry_002);

    }

    echo 0;
    exit;


// 푸시 등록 - 선택회원삭제
} else if ($mode == "multi_del_push_member") {

    foreach ($_POST['checked_member'] as $key => $value) {

        $qry_001 = " DELETE FROM {$TB_PUSH_TMP} WHERE USER_ID = '" . $value . "'";
        $db->exec_sql($qry_001);

    }

    alert_js('parent_reload', '', '');
    exit;


// 푸시 등록 - 전체회원삭제
} else if ($mode == "allDelPush") {

    $qry_001 = " DELETE FROM {$TB_PUSH_TMP} ";
    $db->exec_sql($qry_001);

    echo 0;
    exit;


// 푸시 등록 - 푸시내용 발송
} else if ($mode == "send_push") {

    $qry_cnt = " SELECT COUNT(*) FROM {$TB_PUSH_TMP} ";
    $res_cnt = $db->exec_sql($qry_cnt);
    $row_cnt = $db->sql_fetch_row($res_cnt);

    if ($row_cnt[0] < 1) {
        echo 1;
        //alert_js("alert_","푸시 대상회원이 없습니다","");
        exit;
    } else {
        $p_msg = addslashes($_POST["p_msg"]);

        $qry_001  = " SELECT t1.*,t2.*,t3.* ";
        $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
        $qry_001 .= " FROM {$TB_PUSH_TMP} t1 ";
        $qry_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON (t1.USER_ID = t2.USER_ID)  ";
        $qry_001 .= " LEFT JOIN {$TB_MEMBER_INFO} t3 ON (t1.USER_ID = t3.ID_KEY)  ";
        $res_001 = $db->exec_sql($qry_001);
        while ($row_001 = $db->sql_fetch_array($res_001)) {

            $_in_push_msg = str_replace("{{user}}", $row_001["mm_name"], $p_msg);

            $qry_002 = " INSERT INTO {$TB_PUSH} SET ";
            $qry_002 .= "  P_STATUS    = '1' ";
            $qry_002 .= ", USER_ID  = '" . $row_001["USER_ID"] . "' ";
            //$qry_002 .= ", P_MSG       = '" . $p_msg . "' ";
            $qry_002 .= ", P_MSG       = '" . $_in_push_msg . "' ";
            $qry_002 .= ", ADMIN_ID    = '" . $_admin["name"] . "' ";
            $qry_002 .= ", REG_DATE    = now() ";
            $qry_002 .= ", SHOW_DATE   = '' ";

            @$db->exec_sql($qry_002);
        }

        $qry_003 = "DELETE FROM {$TB_PUSH_TMP}";
        @$db->exec_sql($qry_003);

        echo 0;
        //alert_js('parent_move','전송되었습니다','../dw.etc.php?slot=etc&type=push_list') ;
        exit;

    }

// FCM 푸시 - FCM 알림창 관리
}else if($mode=="fcm_config"){

    $idx    = $_POST["idx"] ;
    $fcm_status    = $_POST["fcm_status"] ;
    $fcm_title   = stripslashes($_POST["fcm_title"]) ;
    $fcm_msg = stripslashes($_POST["fcm_msg"]) ;
    $fcm_img = $_POST["fcm_img"];

    $_sql  = "UPDATE {$TB_FCM_VIEW} SET      " ;
    $_sql .= "  FCM_STATUS    = '{$fcm_status}'  " ;
    $_sql .= ", FCM_TITLE   = '{$fcm_title}' " ;

    $att = new Attech_Works();

    // 이미지 삭제로직
    if (!isNull($_POST["del_fcm"])) {
        @unlink("../../_core/_files/etc/" . $fcm_img);
        $del_qry_001 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '{$fcm_img}' ";
        @$db->exec_sql($del_qry_001);
    }

    $att = new Attech_Works();

    if (!isNull($_FILES["up_fcm"]["tmp_name"])) {
        if (!isNull($_POST["hidden_fcm"])) {
            @unlink("../../_core/_files/etc/" . $_POST["hidden_fcm"]);
            $del_qry_002 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["hidden_fcm"] . "' ";
            @$db->exec_sql($del_qry_002);
        }
        $att->addToFile($TB_FCM_VIEW, $idx, "fcm_img", "../../_core/_files/etc", $_FILES["up_fcm"]);
    }


    $_sql .= ", FCM_MSG = '{$fcm_msg}' " ;
    $_sql .= ", REG_DATE  = now()           " ;

    $db->exec_sql($_sql) ;

    alert_js('alert_parent_reload','수정이 완료되었습니다.','') ;
    exit ;


}

$db->db_close();