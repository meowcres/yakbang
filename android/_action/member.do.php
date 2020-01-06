<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/admin_auth.php";


$Mode = "";
$Mode = $_REQUEST["Mode"];


$_link = "";        // 이동할 주소 변수


// 약국신청 - 약국등록
if ($Mode == "apply_pharmacy_add") {
    $user_id = $_REQUEST["user_id"];
    $pharmacy_name = add_escape($_REQUEST["pharmacy_name"]);
    $zipcode = $_REQUEST["zipcode"];
    $address = $_REQUEST["address"];
    $address_ext = add_escape($_REQUEST["address_ext"]);
    $latitude = $_REQUEST["latitude"];
    $longtitude = $_REQUEST["longtitude"];
    $pharmacy_phone = $_REQUEST["phone1"] . "-" . $_REQUEST["phone2"] . "-" . $_REQUEST["phone3"];
    $pharmacy_email = $_REQUEST["emailID"] . "@" . $_REQUEST["emailDomain"];
    $operation_hours = add_escape($_REQUEST["operation_hours"]);
    $introduction = add_escape($_REQUEST["introduction"]);

    $qry_001 = "INSERT INTO {$TB_AP} SET ";
    $qry_001 .= " PHARMACY_NAME = '{$pharmacy_name}' ";
    $qry_001 .= " , APPLY_STATUS = '1' ";
    $qry_001 .= " , USER_ID = '{$user_id}' ";
    $qry_001 .= " , ZIPCODE = '{$zipcode}' ";
    $qry_001 .= " , ADDRESS = '{$address}' ";
    $qry_001 .= " , ADDRESS_EXT = '{$address_ext}' ";
    $qry_001 .= " , LATITUDE = '{$latitude}' ";
    $qry_001 .= " , LONGTITUDE = '{$longtitude}' ";
    $qry_001 .= " , PHARMACY_PHONE = '{$pharmacy_phone}' ";
    $qry_001 .= " , PHARMACY_EMAIL = '{$pharmacy_email}' ";
    $qry_001 .= " , OPERATING_HOURS = '{$operation_hours}' ";
    $qry_001 .= " , INTRODUCTION = '{$introduction}' ";
    $qry_001 .= " , APPLY_DATE = now() ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_move", "약국을 신청하였습니다", "../member/apply_pharmacy.php");
    exit;


    // 회원가입 시 아이디 체크
} else if ($Mode == "double_check_id") {

    $user_id = $_REQUEST["user_id"];

    if (!preg_match("/^[a-z]/i", $user_id)) {
        echo "400";
        exit;
    }

    $qry_001 = "SELECT COUNT(IDX) FROM {$TB_MEMBER} WHERE USER_ID = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "'))";
    $res_001 = $db->exec_sql($qry_001);
    $row_001 = $db->sql_fetch_row($res_001);

    if ($row_001[0] == 0) {
        echo "200";
    } else {
        echo "300";
    }
    exit;


// 회원가입 ( AJax )
} else if ($Mode == "member_add") {
    $user_status = isNull($_POST["user_status"]) ? "1" : $_POST["user_status"];
    $user_type = "1";
    $user_id = $_POST["chk_id"];
    $user_pass = md5($_POST["user_pass"]);
    $user_name = $_POST["user_name"];
    $user_phone = $_POST["phone1"] . "-" . $_POST["phone2"] . "-" . $_POST["phone3"];
    $user_birthday = $_POST["birth_year"] . "-" . $_POST["birth_month"] . "-" . $_POST["birth_day"];
    $user_sex = $_POST["user_sex"];


    $qry_001 = "INSERT INTO {$TB_MEMBER} SET ";
    $qry_001 .= " USER_STATUS = '{$user_status}' ";
    $qry_001 .= " , USER_TYPE = '{$user_type}' ";
    $qry_001 .= " , USER_ID = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "'))";
    $qry_001 .= " , USER_PASS = '{$user_pass}' ";
    $qry_001 .= " , USER_NAME = HEX(AES_ENCRYPT('" . $user_name . "','" . SECRET_KEY . "'))";
    $qry_001 .= " , REG_DATE = now() ";

    $db->exec_sql($qry_001);


    $qry_002 = "INSERT INTO {$TB_MEMBER_INFO} SET ";
    $qry_002 .= " ID_KEY = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "'))";
    $qry_002 .= " , USER_BIRTHDAY = '{$user_birthday}' ";    
    $qry_002 .= " , USER_SEX = '{$user_sex}' ";
    $qry_002 .= " , USER_PHONE = HEX(AES_ENCRYPT('" . $user_phone . "','" . SECRET_KEY . "'))";
    $qry_002 .= " , LICENSE_NUMBER = ''   ";

    $db->exec_sql($qry_002);



    SetCookie("cookie_user_id", $user_id, time() + (3600 * 24 * 365), "/");
    $qry_003 = "UPDATE {$TB_MEMBER} SET LAST_LOGIN=now(), LOG_COUNT=LOG_COUNT+1 WHERE USER_ID = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "'))";
    @$db->exec_sql($qry_003);


    echo "1";   
    exit;


}

$db->db_close();
