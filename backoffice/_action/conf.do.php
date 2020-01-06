<?php
include_once "../../_core/_init.php";
include_once "../../_core/_common/var.admin.php";

$mode = "";
$mode = $_REQUEST["mode"];

$link = ""; // 이동할 주소 변수

// 정보등록
if ($mode == "update_information") {
    $return = 900;
    try {
        // SITE 정보 변경
        $site_id = $_POST["site_id"];
        $give_type = $_POST["give_type"];
        $site_point = $_POST["site_point"];
        $site_percent = $_POST['site_percent'];
        $site_title = add_escape(strip_tags($_POST["site_title"]));
        $site_type = add_escape($_POST["site_type"]);
        $site_url = add_escape(strip_tags($_POST["site_url"]));
        $site_description = add_escape(strip_tags($_POST["site_description"]));
        $site_keywords = add_escape(strip_tags($_POST["site_keywords"]));
        $site_up_name = add_escape(strip_tags($_POST["site_up_name"]));
        $site_down_name = add_escape(strip_tags($_POST["site_down_name"]));
        $site_owner = add_escape(strip_tags($_POST["site_owner"]));
        $site_charge = add_escape(strip_tags($_POST["site_charge"]));
        $business_number = add_escape(strip_tags($_POST["business_number"]));
        $sale_number = add_escape(strip_tags($_POST["sale_number"]));
        $site_phone = $_POST["site_phone"];
        $site_fax = $_POST["site_fax"];
        $site_email = add_escape($_POST["site_email"]);
        $site_address = add_escape($_POST["site_address"]);
        $site_copyright = add_escape($_POST['site_copyright']);
        $use_cookie = $_POST["use_cookie"];

        $sql_001 = "UPDATE {$TB_CONFIG} SET ";
        $sql_001 .= " SITE_ID = '{$site_id}' ";
        $sql_001 .= ",SITE_TITLE = '{$site_title}' ";
        $sql_001 .= ",SITE_TYPE = '{$site_type}' ";

        if (!isNull($_FILES["image_file"]["name"])) {
            $fileNameInfo = explode(".", $_FILES["image_file"]["name"]);
            $logicalName = "image_" . mktime();

            @move_uploaded_file($_FILES["image_file"]["tmp_name"], "../../OG/" . $logicalName . "." . $fileNameInfo[1]);
            $site_image = $logicalName . "." . $fileNameInfo[1];
            $sql_001 .= ",SITE_IMAGE = '{$site_image}' ";
        }

        if (!isNull($_FILES["icon_file"]["name"])) {
            $fileNameInfo = explode(".", $_FILES["icon_file"]["name"]);
            $logicalName = "icon_" . mktime();

            @move_uploaded_file($_FILES["icon_file"]["tmp_name"], "../../OG/" . $logicalName . "." . $fileNameInfo[1]);
            $site_icon = $logicalName . "." . $fileNameInfo[1];
            $sql_001 .= ",SITE_ICON = '{$site_icon}' ";
        }

        $sql_001 .= ",SITE_URL = '{$site_url}' ";
        $sql_001 .= ",SITE_KEYWORDS = '{$site_keywords}' ";
        $sql_001 .= ",SITE_DESCRIPTION = '{$site_description}' ";
        $sql_001 .= ",SITE_UP_NAME = '{$site_up_name}' ";
        $sql_001 .= ",SITE_DOWN_NAME = '{$site_down_name}' ";
        $sql_001 .= ",BUSINESS_NUMBER = '{$business_number}' ";
        $sql_001 .= ",SALE_NUMBER = '{$sale_number}' ";
        $sql_001 .= ",SITE_OWNER  = '{$site_owner}' ";
        $sql_001 .= ",SITE_CHARGE = '{$site_charge}' ";
        $sql_001 .= ",SITE_EMAIL = '{$site_email}' ";
        $sql_001 .= ",SITE_ADDRESS = '{$site_address}' ";
        $sql_001 .= ",SITE_COPYRIGHT = '{$site_copyright}' ";
        $sql_001 .= ",SITE_PHONE = '{$site_phone}' ";
        $sql_001 .= ",SITE_FAX = '{$site_fax}' ";
        $sql_001 .= ",SITE_GIVE_TYPE = '{$give_type}' ";
        $sql_001 .= ",SITE_POINT = '{$site_point}' ";
        $sql_001 .= ",SITE_PERCENT = '{$site_percent}' ";
        $sql_001 .= ",USE_COOKIE = '{$use_cookie}' ";

        $res_001 = $db->exec_sql($sql_001);

        if ($res_001 === false) {
            $return = 400;
        } else {
            $return = 200;
        }
    } catch (exception $e) {
        $return = 900;
    }

    echo $return;

// 이미지 삭제
} else if ($mode == "del_og_img") {
    $return = 900;
    try {
        $site_key = $_POST["site_id"];

        $sql = "SELECT SITE_IMAGE FROM {$TB_CONFIG} WHERE SITE_ID='{$site_key}'";
        $res = $db->exec_sql($sql);
        $row = $db->sql_fetch_row($res);

        @unlink("../../OG/" . $_row[0]);

        $d_sql = "UPDATE {$TB_CONFIG} SET SITE_IMAGE='' WHERE SITE_ID='{$site_key}' ";
        $d_res = $db->exec_sql($d_sql);

        if ($d_res === false) {
            $return = 400;
        } else {
            $return = 200;
        }

    } catch (exception $e) {
        $return = 900;
    }

    echo $return;

// 이미지 삭제
} else if ($mode == "del_og_icon") {

    $return = 900;
    try {
        $site_key = $_POST["site_id"];

        $sql = "SELECT SITE_ICON  FROM {$TB_CONFIG} WHERE SITE_ID='{$site_key}'";
        $res = $db->exec_sql($sql);
        $row = $db->sql_fetch_row($res);

        @unlink("../../OG/" . $_row[0]);

        $d_sql = "UPDATE {$TB_CONFIG} SET SITE_ICON='' WHERE SITE_ID='{$site_key}' ";
        $d_res = $db->exec_sql($d_sql);

        if ($d_res === false) {
            $return = 400;
        } else {
            $return = 200;
        }

    } catch (exception $e) {
        $return = 900;
    }

    echo $return;

    
} else if ($mode == "id_find") {

    $_admin_id = $_REQUEST["admin_id"];

    $_sql = "SELECT count(*) FROM {$TB_ADMIN} WHERE ADMIN_ID='{$_admin_id}'";
    $_res = $db->exec_sql($_sql);
    $_row = $db->sql_fetch_row($_res);

    if ($_row[0] > 0) {
        echo "<script language='javascript'>\n";
        echo "alert (\"이미 사용중인 아이디 입니다. 다시 입력해 주세요!\");";
        echo "parent.document.getElementById(\"chk_id\").value = '';";
        echo "parent.document.getElementById(\"admin_id\").value = '';";
        echo "parent.document.getElementById(\"admin_id\").focus();";
        echo "</script>\n";
    } else {
        echo "<script language='javascript'>\n";
        echo "alert (\"사용이 가능한 아이디 입니다.\");";
        echo "parent.document.getElementById(\"chk_id\").value = '{$_admin_id}';";
        echo "parent.document.getElementById(\"admin_name\").focus();";
        echo "</script>\n";
    }


} else if ($mode == "admin_add") {

    if (isNull($_POST["chk_id"])) {
        alert_js("alert", "아이디 정보가 올바르지 않습니다.", "");
        exit;
    }

    $_admin_name = add_escape($_POST["admin_name"]);
    $_admin_pass = add_escape($_POST["admin_pass"]);
    $_admin_phone = $_POST["Phone1"] . "-" . $_POST["Phone2"] . "-" . $_POST["Phone3"];
    $_admin_mobile = $_POST["Mobile1"] . "-" . $_POST["Mobile2"] . "-" . $_POST["Mobile3"];
    $_admin_email = $_POST["emailID"] . "@" . $_POST["emailDomain"];

    $_admin_id = $_POST["chk_id"];

    $_admin_grade = "" ;
    $_grade_number = sizeof($_adminMenu) ;
    
    for($i=1;$i<=$_grade_number;$i++){
      ${"g".$i} = $_POST["g{$i}"] == "Y" ? "Y" : "N" ;
      $_admin_grade .= ${"g".$i} ;
    }

    $_admin_cmt = add_escape($_POST["admin_cmt"]);

    $_sql = "INSERT INTO {$TB_ADMIN} SET ";
    $_sql .= " ADMIN_STATUS ='Y'";
    $_sql .= ",ADMIN_GRADE  ='{$_admin_grade}'";
    $_sql .= ",ADMIN_ID     ='{$_admin_id}'";
    $_sql .= ",ADMIN_PASS   ='{$_admin_pass}'";
    $_sql .= ",ADMIN_NAME   ='{$_admin_name}'";
    $_sql .= ",ADMIN_MOBILE ='{$_admin_mobile}'";
    $_sql .= ",ADMIN_EMAIL  ='{$_admin_email}'";
    $_sql .= ",ADMIN_HIT    =0";
    $_sql .= ",ADMIN_CMT    ='{$_admin_cmt}'";
    $_sql .= ",REG_DATE     =now()";


    $db->exec_sql($_sql);

    $_link = "../admin.template.php?slot=conf&type=admin_list";
    alert_js("alert_parent_move", "운영자를 등록하였습니다.", $_link);


} else if ($mode == "admin_modify") {

    if (isNull($_POST["idx"])) {
        alert_js("alert", "운영자 정보가 올바르지 않습니다.", "");
        exit;
    }

    $_admin_name = add_escape($_POST["admin_name"]);

    /*
    if (!isNull($_POST["admin_pass"])) {
        $_admin_pass = md5(ChkEscape($_POST["admin_pass"]));
    }
    */

    $_admin_phone  = $_POST["Phone1"] . "-" . $_POST["Phone2"] . "-" . $_POST["Phone3"];
    $_admin_mobile = $_POST["Mobile1"] . "-" . $_POST["Mobile2"] . "-" . $_POST["Mobile3"];
    $_admin_email  = $_POST["emailID"] . "@" . $_POST["emailDomain"];
    $_admin_cmt    = add_escape($_POST['admin_cmt']);
    $_admin_status = $_POST['admin_status'];

    /*
    $_id_sql = "SELECT * FROM {$ADMIN_TB} WHERE ADMIN_ID = '{$_POST['idx']}' ";
    $_id_res = $db->exec_sql($_id_sql);
    $_id_row = $db->sql_fetch_array($_id_res);

    $_del_sql = "DELETE FROM {$MENU_CON_TB} WHERE ADMIN_ID = '{$_id_row['ADMIN_ID']}' ";

    $db->exec_sql($_del_sql);
    */
    
    $_admin_grade = "" ;
    $_grade_number = sizeof($_adminMenu) ;
    
    for($i=1;$i<=$_grade_number;$i++){
      ${"g".$i} = $_POST["g{$i}"] == "Y" ? "Y" : "N" ;
      $_admin_grade .= ${"g".$i} ;
    }

    $_admin_cmt = add_escape($_POST["admin_cmt"]);

    $_sql = "UPDATE {$TB_ADMIN} SET ";
    $_sql .= " ADMIN_STATUS='{$_admin_status}'";
    $_sql .= ",ADMIN_GRADE  ='{$_admin_grade}'";

    if (!isNull($_POST["admin_pass"])) {
        $_sql .= ",ADMIN_PASS='{$_POST["admin_pass"]}' ";
    }
    
    $_sql .= ",ADMIN_NAME='{$_admin_name}'";
    $_sql .= ",ADMIN_MOBILE='{$_admin_mobile}'";
    $_sql .= ",ADMIN_EMAIL='{$_admin_email}'";
    $_sql .= ",ADMIN_CMT ='{$_admin_cmt}'";
    $_sql .= " WHERE ADMIN_ID='{$_POST["idx"]}' ";

    $_res = $db->exec_sql($_sql);

    alert_js("alert_parent_reload", "운영자 정보를 수정하였습니다.", "");


} else if ($mode == "admin_delete") {

    if (isNull($_GET["admin_id"])) {
        alert_js("alert", "관리자 정보가 올바르지 않습니다.", "");
        exit;
    }

    /*
    $_id_sql = "SELECT * FROM {$TB_ADMIN} WHERE ADMIN_ID = '{$_GET['admin_id']}' ";
    $_id_res = $db->exec_sql($_id_sql);
    $_id_row = $db->sql_fetch_array($_id_res);
    */

    $_sql = "DELETE FROM {$TB_ADMIN} WHERE ADMIN_ID='{$_GET["admin_id"]}'       ";
    //$_sql1 = "DELETE FROM {$MENU_CON_TB} WHERE ADMIN_ID='{$_GET["admin_id"]}'    ";

    $db->exec_sql($_sql);
    //$db->exec_sql($_sql1);

    alert_js("alert_parent_reload", "운영자 정보를 삭제하였습니다.", "");



}


$db->db_close();
?>