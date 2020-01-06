<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";

$mode = "";
$mode = $_REQUEST["mode"];

$link = ""; // 이동할 주소 변수



if ($mode == "member_pharmacist_register") {

    $license_number = $_POST["license_number"];


    $qry_001 = "UPDATE {$TB_MEMBER} SET 
                PHARMACIST_REQUEST = 'yes',
                PHARMACIST_REG_DATE = now() 
                WHERE USER_ID = HEX(AES_ENCRYPT('" . $_SESSION['member']['id'] . "','" . SECRET_KEY . "'))";
    @$db->exec_sql($qry_001);

    $qry_002 = "UPDATE {$TB_MEMBER_INFO} SET 
                LICENSE_NUMBER = '{$license_number}'
                WHERE ID_KEY = HEX(AES_ENCRYPT('" . $_SESSION['member']['id'] . "','" . SECRET_KEY . "'))";
    @$db->exec_sql($qry_002);

    $obj = new Attech_Works();
    if (!isNull($_FILES["license_img"]["tmp_name"])) {
        $obj->addToFile($TB_MEMBER, $_SESSION['member']['id'], "pharmacist_license", "../../Web_Files/pharmacist", $_FILES["pharmacist_img"]);
    }

    //echo $_FILES["license_img"];

    alert_js("alert_parent_move", "전문약사를 신청을 완료하였습니다", "../main/index.html");
    exit;

} 

$db->db_close();

