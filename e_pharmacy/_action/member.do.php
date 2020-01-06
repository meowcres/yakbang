<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/admin_auth.php";


$Mode = "";
$Mode = $_REQUEST["Mode"];


$_link = "";        // 이동할 주소 변수


// 내 정보관리 - 정보수정
if ($Mode == "member_up") {
    $idx = $_POST["idx"];
    $user_id = $_POST["user_id"];

    $user_name = $_POST["user_name"];
    $user_status = $_POST["user_status"];
    $user_birthday = $_POST["birth_year"]."-".$_POST["birth_month"]."-".$_POST["birth_day"];
    $user_sex = $_POST["user_sex"];
    $user_phone = $_POST["phone1"]."-".$_POST["phone2"]."-".$_POST["phone3"];
    $license_number = $_POST["license_number"];
    $mm_id = $_POST["mm_id"];

    $qry_001  = "UPDATE {$TB_MEMBER} SET ";
    $qry_001 .= "   USER_NAME   = HEX(AES_ENCRYPT('".$user_name."','".SECRET_KEY."'))";
    $qry_001 .= " , UP_DATE    = now() ";

    if ($user_status == 2) {
        $qry_001 .= " , DIAPAUSE_DATE    = now() ";
    } else if ($user_status == 3) {
        $qry_001 .= " , WITHDRAW_DATE    = now() ";
    }

    $qry_001 .= " WHERE IDX = '{$idx}' ";
    $db->exec_sql($qry_001);

    $qry_002  = "UPDATE {$TB_MEMBER_INFO} SET ";
    $qry_002 .= "   USER_BIRTHDAY = '{$user_birthday}' ";
    $qry_002 .= " , USER_SEX = '{$user_sex}' ";
    $qry_002 .= " , USER_PHONE = HEX(AES_ENCRYPT('".$user_phone."','".SECRET_KEY."'))";
    $qry_002 .= " , LICENSE_NUMBER = '{$license_number}' ";
    $qry_002 .= " WHERE ID_KEY = '{$user_id}' ";

    $db->exec_sql($qry_002);

    // 이미지 삭제
    if (!isNull($_POST["del_pharmacist"])) {
        @unlink("../../_core/_files/pharmacist/" . $_POST["del_pharmacist"]);
        $del_qry_001 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["del_pharmacist"] . "' ";
        @$db->exec_sql($del_qry_001);
    }
    if (!isNull($_POST["del_license"])) {
        @unlink("../../_core/_files/pharmacist_license/" . $_POST["del_license"]);
        $del_qry_002 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["del_license"] . "' ";
        @$db->exec_sql($del_qry_002);
    }

    $att = new Attech_Works();

    // 이미지 등록
    if (!isNull($_FILES["up_pharmacist"]["tmp_name"])) {
        if (!isNull($_POST["hidden_pharmacist"])) {
            @unlink("../../_core/_files/pharmacist/" . $_POST["hidden_pharmacist"]);
            $del_qry_003 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["hidden_pharmacist"] . "' ";
            @$db->exec_sql($del_qry_003);
        }
        $att->addToFile($TB_MEMBER, $mm_id, "pharmacist_img", "../../_core/_files/pharmacist", $_FILES["up_pharmacist"]);
    }
    if (!isNull($_FILES["up_license"]["tmp_name"])) {
        if (!isNull($_POST["hidden_license"])) {
            @unlink("../../_core/_files/pharmacist_license/" . $_POST["hidden_license"]);
            $del_qry_004 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["hidden_license"] . "' ";
            @$db->exec_sql($del_qry_004);
        }
        $att->addToFile($TB_MEMBER, $mm_id, "pharmacist_license", "../../_core/_files/pharmacist_license", $_FILES["up_license"]);
    }

    alert_js("alert_parent_move", "내 정보를 수정하였습니다", "../pharmacy.template.php?slot=member&type=pharmacist_detail&step=information");
    exit;



// 내 정보관리 - 비밀번호 수정
} else if ($Mode == "member_pass") {


    $idx = $_POST["idx"];
    $user_pass = md5($_POST["user_pass"]);

    echo "<br>==========================".$idx;
    echo "<br>==========================".$user_pass;

    $qry_001  = "UPDATE {$TB_MEMBER} SET ";
    $qry_001 .= " USER_PASS = '{$user_pass}' ";
    $qry_001 .= " , UP_DATE    = now() ";
    $qry_001 .= " WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_move", "비밀번호를 수정하였습니다.", "../pharmacy.template.php?slot=member&type=pharmacist_detail&step=information");
    exit;

// 내 정보관리 - 약국탈퇴
} else if ($Mode == "member_del") {

    $idx = $_POST["idx"];
    $ppidx = $_POST["ppidx"];
    $mm_pass = md5($_POST["mm_pass"]);



    $qry_pass = " SELECT * FROM {$TB_MEMBER} WHERE IDX = '{$idx}' ";
    $res_pass = $db->exec_sql($qry_pass);
    $row_pass = $db->sql_fetch_array($res_pass);
    $pass = $row_pass["USER_PASS"];


    if ($pass == $mm_pass) {

        $qry_001 = " DELETE FROM {$TB_PP} WHERE IDX = '{$ppidx}' ";

        $db->exec_sql($qry_001);

        alert_js("alert_parent_move", "약국탈퇴가 완료되었습니다", "../pharmacy.login.php");
        exit;

    } else {
        alert_js("alert_parent_reload", "기존 비밀번호가 일치하지 않습니다.", "");
    }
    exit;


// 마이페이지 - 쪽지 읽기
} else if ($Mode == "dm_read") {

    $mentee_id = $_REQUEST["mentee_id"];
    $mentor_id = $_REQUEST["mentor_id"];

    $qry_001  = " UPDATE {$TB_DM} SET ";
    $qry_001 .= " R_STATUS = '1' ";
    $qry_001 .= " , R_DATE = now() ";
    $qry_001 .= " WHERE SEND_ID = '{$mentee_id}' AND RECEIVE_ID = '{$mentor_id}' ";

    $db->exec_sql($qry_001);

    echo 0;

    exit;

// 마이페이지 - 쪽지 보내기
} else if ($Mode == "dm_add") {

    $send_id = add_escape($_REQUEST["send_id"]);
    $receive_id = add_escape($_REQUEST["receive_id"]);
    $message = add_escape($_REQUEST["message"]);

    $qry_001  = "   INSERT INTO {$TB_DM} SET ";
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

}

$db->db_close();
