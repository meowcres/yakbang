<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/admin_auth.php";

$Mode = "";
$Mode = $_REQUEST["Mode"];

$_link = "";        // 이동할 주소 변수


// 약국 수정
if ($Mode == "pharmacy_up") {

    $idx = $_POST["idx"];
    $pharmacy_code = $_POST["pharmacy_code"];
    $pharmacy_phone = $_POST["phone1"] . "-" . $_POST["phone2"] . "-" . $_POST["phone3"];
    $pharmacy_email = $_POST["emailID"] . "@" . $_POST["emailDomain"];
    $operation_hours = add_escape($_POST["operation_hours"]);
    $introduction = add_escape($_POST["introduction"]);

    $qry_001 = "   UPDATE {$TB_PHARMACY} SET ";
    $qry_001 .= "   PHARMACY_PHONE = '{$pharmacy_phone}' ";
    $qry_001 .= " , PHARMACY_EMAIL = '{$pharmacy_email}' ";
    $qry_001 .= " , OPERATION_HOURS = '{$operation_hours}' ";
    $qry_001 .= " , INTRODUCTION = '{$introduction}' ";
    $qry_001 .= "   WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_001);

    // 약국 로고 삭제
    if (!isNull($_POST["del_logo_obj"])) {
        @unlink("../../_core/_files/pharmacy/" . $_POST["del_logo_obj"]);
        $del_qry_001 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["del_logo_obj"] . "' ";
        @$db->exec_sql($del_qry_001);
    }
    // 약국 이미지 삭제
    if (!isNull($_POST["del_img_obj"])) {
        @unlink("../../_core/_files/pharmacy/" . $_POST["del_img_obj"]);
        $del_qry_001 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["del_img_obj"] . "' ";
        @$db->exec_sql($del_qry_001);
    }

    $att = new Attech_Works();

    // 약국 로고 등록
    if (!isNull($_FILES["up_logo_obj"]["tmp_name"])) {

        if (!isNull($_POST["hidden_logo_obj"])) {
            @unlink("../../_core/_files/pharmacy/" . $_POST["hidden_logo_obj"]);
            $del_qry_002 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["hidden_logo_obj"] . "' ";
            @$db->exec_sql($del_qry_002);
        }

        $att->addToFile($TB_PHARMACY, $pharmacy_code, "logo_img" . $i, "../../_core/_files/pharmacy", $_FILES["up_logo_obj"]);
    }

    // 약국 이미지 등록
    if (!isNull($_FILES["up_img_obj"]["tmp_name"])) {

        if (!isNull($_POST["hidden_img_obj"])) {
            @unlink("../../_core/_files/pharmacy/" . $_POST["hidden_img_obj"]);
            $del_qry_002 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '" . $_POST["hidden_img_obj"] . "' ";
            @$db->exec_sql($del_qry_002);
        }

        $att->addToFile($TB_PHARMACY, $pharmacy_code, "pharmacy_img" . $i, "../../_core/_files/pharmacy", $_FILES["up_img_obj"]);
    }

    alert_js("alert_parent_move", "수정하였습니다", "../pharmacy.template.php?slot=pharmacy&type=information");

    exit;

}


$db->db_close();
