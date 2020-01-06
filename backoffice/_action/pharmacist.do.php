<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";

$Mode = "";
$Mode = $_REQUEST["Mode"];


$_link = "";        // 이동할 주소 변수

// 약사 신청 승인
if ($Mode == "accept_pharmacist") {

    $user_id = $_REQUEST["u_id"];

    $qry_001 = " UPDATE {$TB_MEMBER} SET ";
    $qry_001 .= "  USER_TYPE = '2' ";
    $qry_001 .= ", UP_DATE = now() ";
    $qry_001 .= ", PHARMACIST_REG_DATE = now() ";
    $qry_001 .= " WHERE USER_ID = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "'))";

    $res_001 = $db->exec_sql($qry_001);

    if ($res_001 == true) {

        alert_js("parent_move", "", "../admin.template.php?slot=pharmacist&type=pharmacist_list");

    } else {

        alert_js("alert", "승인이 완료되지 못했습니다. 고객센터에 문의 해 주시기 바랍니다.", "");

    }

    exit;


// 약사 신청 거부
} else if ($Mode == "cencel_pharmacist") {

    $user_id = $_REQUEST["u_id"];

    $qry_001 = " UPDATE {$TB_MEMBER} SET ";
    $qry_001 .= "  PHARMACIST_REQUEST = 'no' ";
    $qry_001 .= ", UP_DATE = now() ";
    $qry_001 .= ", PHARMACIST_REG_DATE = '' ";
    $qry_001 .= " WHERE USER_ID = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "'))";

    $res_001 = $db->exec_sql($qry_001);

    if ($res_001 == true) {

        alert_js("alert_parent_reload", "승인이 거부되었습니다", "");

    } else {

        alert_js("alert", "승인거부가 완료되지 못했습니다. 고객센터에 문의 해 주시기 바랍니다.", "");

    }

    exit;

// 약사 등록
} else if ($Mode == "pharmacist_add") {

    $user_status = isNull($_POST["user_status"]) ? "1" : $_POST["user_status"];
    $user_type = "2";

    $user_id = $_POST["chk_id"];
    $user_pass = md5($_POST["user_pass"]);

    $user_name = $_POST["user_name"];

    $user_phone = $_POST["phone1"] . "-" . $_POST["phone2"] . "-" . $_POST["phone3"];
    $user_birthday = $_POST["birth_year"] . "-" . $_POST["birth_month"] . "-" . $_POST["birth_day"];
    $user_sex = isNull($_POST["user_sex"]) ? "M" : $_POST["user_sex"];

    $pharmacist_license = $_POST["pharmacist_license"];


    $qry_001 = "INSERT INTO {$TB_MEMBER} SET ";
    $qry_001 .= " USER_STATUS = '{$user_status}' ";
    $qry_001 .= " , USER_TYPE = '{$user_type}' ";
    $qry_001 .= " , USER_ID = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "'))";
    $qry_001 .= " , USER_PASS = '{$user_pass}' ";
    $qry_001 .= " , USER_NAME = HEX(AES_ENCRYPT('" . $user_name . "','" . SECRET_KEY . "'))";
    $qry_001 .= " , REG_DATE = now() ";
    $qry_001 .= " , PHARMACIST_REQUEST = 'yes' ";
    $qry_001 .= " , PHARMACIST_REG_DATE = now() ";

    $db->exec_sql($qry_001);


    $qry_002 = "INSERT INTO {$TB_MEMBER_INFO} SET ";
    $qry_002 .= " ID_KEY = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "'))";
    $qry_002 .= " , USER_BIRTHDAY = '{$user_birthday}' ";
    $qry_002 .= " , USER_SEX = '{$user_sex}' ";
    $qry_002 .= " , USER_PHONE = HEX(AES_ENCRYPT('" . $user_phone . "','" . SECRET_KEY . "'))";
    $qry_002 .= " , LICENSE_NUMBER = '{$pharmacist_license}'   ";

    $db->exec_sql($qry_002);

    $obj = new Attech_Works();
    if (!isNull($_FILES["license_paper"]["tmp_name"])) {
        $obj->addToFile($TB_MEMBER, $user_id, "pharmacist_license", "../../Web_Files/pharmacist_license", $_FILES["license_paper"]);
    }
    if (!isNull($_FILES["pharmacist_img"]["tmp_name"])) {
        $obj->addToFile($TB_MEMBER, $user_id, "pharmacist_img", "../../Web_Files/pharmacist", $_FILES["pharmacist_img"]);
    }

    alert_js("alert_parent_move", "전문약사를 등록하였습니다", "../admin.template.php?slot=pharmacist&type=pharmacist_list");
    exit;


} else if ($Mode == "member_update") {

    if ($_POST["MM_TYPE"] == 2 && $_POST["MM_ID"] == "") {
        $_MM_ID = $_POST["emailID"] . "@" . $_POST["emailDomain"];
    } else {
        $_MM_ID = $_POST["MM_ID"];
    }

    $_MM_STATUS = isNull($_POST["MM_STATUS"]) ? "1" : $_POST["MM_STATUS"];
    if ($_POST["MM_EMAIL"]) {
        $_MM_EMAIL = $_POST["MM_EMAIL"];
    } else {
        $_MM_EMAIL = $_POST["emailID"] . "@" . $_POST["emailDomain"];

    }
    $_MM_PASS = md5($_POST["user_pass"]);
    $_MM_PHONE = $_POST["MM_PHONE"];
    $_MM_TITLE = $_POST["MM_TITLE"];
    $_MM_FIRST_NAME = $_POST["MM_FIRST_NAME"];
    $_MM_LAST_NAME = $_POST["MM_LAST_NAME"];
    $_ORGANIZATION = $_POST["ORGANIZATION"];
    $_MM_PHONE = $_POST["MM_PHONE"];
    $_JOB_TITLE = $_POST["JOB_TITLE"];
    $_DESCRIPTION_ORGANIZATION = addslashes($_POST["DESCRIPTION_ORGANIZATION"]);
    $_FAX = $_POST["FAX"];
    $_COMPANY_NAME = $_POST["COMPANY_NAME"];
    $_COMPANY_WEBSITE = $_POST["COMPANY_WEBSITE"];
    $_COMPANY_DESCRIPTION = $_POST["COMPANY_DESCRIPTION"];
    $_STREET = $_POST["STREET"];
    $_CITY = $_POST["CITY"];
    $_ZIP_CODE = $_POST["ZIP_CODE"];
    $_STATE = $_POST["STATE"];
    $_COUNTRY = $_POST["COUNTRY"];
    $_INDUSTRY = $_POST["INDUSTRY"];
    $_SPECIFY_OTHER = $_POST["SPECIFY_OTHER"];
    $_COMPANY = $_POST["COMPANY"];
    $_EXCELL = $_POST["EXCELL"];
    $_PDF = $_POST["PDF"];
    $_HARD_COPY = $_POST["HARD_COPY"];
    $_ONLINE_ACCESS = $_POST["ONLINE_ACCESS"];
    $_CD_ROM = $_POST["CD_ROM"];
    $_CD = $_POST["CD"];
    $_DVD = $_POST["DVD"];
    $_MP3 = $_POST["MP3"];
    $_OTHER = $_POST["OTHER"];
    $_O_TEXT = $_POST["O_TEXT"];

    if (is_uploaded_file($_FILES["COMPANY_LOGO"]["tmp_name"])) {
        if (!isImageExt($_FILES["COMPANY_LOGO"]["name"])) {
            echo "Not_Image";
            exit;
        }

        $_file_name = uniqid('c_logo');
        $_file_ext = getFileExtension($_FILES["COMPANY_LOGO"]["name"], true);

        $_fObj = fileUpload($_FILES["COMPANY_LOGO"]["tmp_name"], $_file_name . "." . $_file_ext, $PUBLISH_URL);

        $_COMPANY_LOGO = $_fObj["savedName"];

    } else {

        $_COMPANY_LOGO = "";

    }

    $_sql = "UPDATE {$MEMBER_TB} SET           ";
    $_sql .= " MM_STATUS    = '{$_MM_STATUS}'   ";
    $_sql .= " ,MM_TITLE     = '{$_MM_TITLE}'   ";
    $_sql .= " ,MM_FIRST_NAME   = '{$_MM_FIRST_NAME}'";
    $_sql .= " ,MM_LAST_NAME = '{$_MM_LAST_NAME}'";
    $_sql .= " ,MM_EMAIL     = '{$_MM_EMAIL}'   ";
    $_sql .= " ,MM_PHONE     = '{$_MM_PHONE}'   ";
    $_sql .= " WHERE MM_ID   = '{$_MM_ID}'      ";

    $db->exec_sql($_sql);

    $_info_sql = "UPDATE {$MEMBER_INFO_TB} SET    ";
    $_info_sql .= " ORGANIZATION    = '{$_ORGANIZATION}'   ";
    $_info_sql .= " ,JOB_TITLE       = '{$_JOB_TITLE}'   ";
    $_info_sql .= " ,DESCRIPTION_ORGANIZATION    = '{$_DESCRIPTION_ORGANIZATION}'";
    $_info_sql .= " ,FAX             = '{$_FAX}'   ";
    $_info_sql .= " ,COMPANY_NAME    = '{$_COMPANY_NAME}'   ";
    $_info_sql .= " ,COMPANY_WEBSITE = '{$_COMPANY_WEBSITE}'   ";
    $_info_sql .= " ,COMPANY_LOGO    = '{$_COMPANY_LOGO}'   ";
    $_info_sql .= " ,COMPANY_DESCRIPTION    = '{$_COMPANY_DESCRIPTION}'";
    $_info_sql .= " ,STREET          = '{$_STREET}'   ";
    $_info_sql .= " ,CITY            = '{$_CITY}'   ";
    $_info_sql .= " ,ZIP_CODE        = '{$_ZIP_CODE}'   ";
    $_info_sql .= " ,STATE           = '{$_STATE}'   ";
    $_info_sql .= " ,COUNTRY         = '{$_COUNTRY}'   ";
    $_info_sql .= " ,INDUSTRY        = '{$_INDUSTRY}'   ";
    $_info_sql .= " ,SPECIFY_OTHER   = '{$_SPECIFY_OTHER}'   ";
    $_info_sql .= " ,COMPANY         = '{$_COMPANY}'   ";
    $_info_sql .= " ,EXCELL          = '{$_EXCELL}'   ";
    $_info_sql .= " ,PDF             = '{$_PDF}'   ";
    $_info_sql .= " ,HARD_COPY       = '{$_HARD_COPY}'   ";
    $_info_sql .= " ,ONLINE_ACCESS   = '{$_ONLINE_ACCESS}'   ";
    $_info_sql .= " ,CD_ROM          = '{$_CD_ROM}'   ";
    $_info_sql .= " ,CD              = '{$_CD}'   ";
    $_info_sql .= " ,DVD             = '{$_DVD}'   ";
    $_info_sql .= " ,MP3             = '{$_MP3}'   ";
    $_info_sql .= " ,OTHER           = '{$_OTHER}'   ";
    $_info_sql .= " ,O_TEXT          = '{$_O_TEXT}'   ";
    $_info_sql .= " WHERE ID_KEY   = '{$_MM_ID}'      ";

    $db->exec_sql($_info_sql);

    alert_js("alert_parent_reload", "정보를 변경하였습니다", "");
    exit;


} else if ($Mode == "del_pharmacist_list") {

    if (isNull($_GET["u_id"])) {
        alert_js("alert_parent_reload", "삭제 정보가 올바르지 않습니다.", "");
        exit;
    }

    $U_ID = $_GET["u_id"];

    $_sql1 = "DELETE FROM {$TB_MEMBER} WHERE USER_ID = '{$U_ID}' ";
    $db->exec_sql($_sql1);

    $_sql2 = "DELETE FROM {$TB_MEMBER_INFO} WHERE ID_KEY = '{$U_ID}' ";
    $db->exec_sql($_sql2);

    $_link = "../admin.template.php?slot=pharmacist&type=pharmacist_list";

    alert_js("alert_parent_move", "회원 정보 삭제가 완료 되었습니다.", $_link);
    exit;


// 약사상세정보에서 약사 삭제
} else if ($Mode == "pharmacist_del") {

    // 관리자 비밀번호 확인
    $admin_id = $_SESSION["admin"]["id"]; 
    $mm_pass = $_REQUEST["mm_pass"];

    $qry_001 = " SELECT ADMIN_PASS FROM {$TB_ADMIN} AS t1 WHERE t1.ADMIN_ID='{$admin_id}' ";
    $res_001  = $db->exec_sql($qry_001) ;
    $row_001  = $db->sql_fetch_row($res_001) ;

    if ($row_001[0] !== $mm_pass) {
        alert_js("alert","관리자 비밀번호가 일치하지 않습니다. \\n\\n다시 확인해 주세요!","");
        exit;
    } else {
    
        // 약사회원 삭제
        $user_id = $_REQUEST["user_id"];

        $_sql1 = "DELETE FROM {$TB_MEMBER} WHERE USER_ID = '{$user_id}' ";
        $db->exec_sql($_sql1);

        $_sql2 = "DELETE FROM {$TB_MEMBER_INFO} WHERE ID_KEY = '{$user_id}' ";
        $db->exec_sql($_sql2);

        $_link = "../admin.template.php?slot=pharmacist&type=pharmacist_list";

        alert_js("alert_parent_move", "회원 정보 삭제가 완료 되었습니다.", $_link);  

    }

    exit;


} else if ($Mode == "Del") {

    if (isNull($_GET["u_id"])) {
        alert_js("alert_parent_reload", "삭제 정보가 올바르지 않습니다.", "");
        exit;
    }

    $USER_ID = $_GET["u_id"];

    $_sql1 = "DELETE FROM {$MEMBER_TB} WHERE MM_ID = '{$USER_ID}' ";
    $db->exec_sql($_sql1);

    $_sql2 = "DELETE FROM {$MEMBER_INFO_TB} WHERE MM_ID = '{$USER_ID}' ";
    $db->exec_sql($_sql2);

    if ($_MM_TYPE == 1) {
        $_link = "../admin.template.php?slot=member&type=general_list";
    } else {
        $_link = "../admin.template.php?slot=member&type=publisher_list";
    }

    alert_js("alert_parent_move", "회원 정보 삭제가 완료 되었습니다.", $_link);
    exit;



// 약사 수정
} else if ($Mode == "pharmacist_up") {

    $idx = $_POST["idx"];
    $user_id = $_POST["user_id"];

    $user_name = $_POST["user_name"];
    $user_status = $_POST["user_status"];
    $user_birthday = $_POST["birth_year"]."-".$_POST["birth_month"]."-".$_POST["birth_day"];
    $user_sex = $_POST["user_sex"];
    $user_phone = $_POST["phone1"]."-".$_POST["phone2"]."-".$_POST["phone3"];
    $license_number = $_POST["license_number"];
    $pharmacist_img = $_POST["pharmacist_img"];
    $license_img = $_POST["license_img"];
    $mm_id = $_POST["mm_id"];

    echo "<br>=========================".$idx;
    echo "<br>=========================".$user_name;
    echo "<br>=========================".$user_status;
    echo "<br>=========================".$user_birthday;
    echo "<br>=========================".$user_sex;
    echo "<br>=========================".$user_phone;

    $qry_001  = "UPDATE {$TB_MEMBER} SET ";
    $qry_001 .= "   USER_STATUS = '{$user_status}' ";
    $qry_001 .= " , USER_NAME   = HEX(AES_ENCRYPT('".$user_name."','".SECRET_KEY."'))";
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

    // 첨부파일1 삭제로직
    if (!isNull($_POST["del_pharmacist"])) {
        @unlink("../../Web_Files/pharmacist/" . $pharmacist_img);
        $del_qry_001 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '{$pharmacist_img}' ";
        @$db->exec_sql($del_qry_001);
    }
    if (!isNull($_POST["del_license"])) {
        @unlink("../../Web_Files/pharmacist_license/" . $license_img);
        $del_qry_002 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '{$license_img}' ";
        @$db->exec_sql($del_qry_002);
    }

    $att = new Attech_Works();

    if (!isNull($_FILES["up_pharmacist"]["tmp_name"])) {
        if (!isNull($_POST["hidden_pharmacist"])) {
            @unlink("../../Web_Files/pharmacist/" . $_POST["hidden_pharmacist"]);
            $del_qry_003 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["hidden_pharmacist"] . "' ";
            @$db->exec_sql($del_qry_003);
        }
        $att->addToFile($TB_MEMBER, $mm_id, "pharmacist_img", "../../Web_Files/pharmacist", $_FILES["up_pharmacist"]);
    }

    if (!isNull($_FILES["up_license"]["tmp_name"])) {
        if (!isNull($_POST["hidden_license"])) {
            @unlink("../../Web_Files/pharmacist_license/" . $_POST["hidden_license"]);
            $del_qry_004 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["hidden_license"] . "' ";
            @$db->exec_sql($del_qry_004);
        }
        $att->addToFile($TB_MEMBER, $mm_id, "pharmacist_license", "../../Web_Files/pharmacist_license", $_FILES["up_license"]);
    }

    alert_js("alert_parent_move", "약사를 수정하였습니다", "../admin.template.php?slot=pharmacist&type=pharmacist_list");
    exit;


// 약사 비밀번호 변경
} else if ($Mode == "pharmacist_pass") {


    $idx = $_POST["idx"];
    $user_pass = md5($_POST["user_pass"]);

    echo "<br>==========================".$idx;
    echo "<br>==========================".$user_pass;

    $qry_001  = "UPDATE {$TB_MEMBER} SET ";
    $qry_001 .= " USER_PASS = '{$user_pass}' ";
    $qry_001 .= " , UP_DATE    = now() ";
    $qry_001 .= " WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_move", "비밀번호를 수정하였습니다.", "../admin.template.php?slot=pharmacist&type=pharmacist_list");
    exit;





}


$db->db_close();
