<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/admin_auth.php";


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


// 약국의 전문약사 등록
} else if ($Mode == "add_pharmacist") {


    $user_id = $_REQUEST["user_id"];
    $p_code = $_REQUEST["p_code"];


    $qry_001 = "INSERT INTO {$TB_PP} SET ";
    $qry_001 .= " PHARMACY_CODE = '{$p_code}' ";
    $qry_001 .= " , USER_ID = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "')) ";
    $qry_001 .= " , P_STATUS = '1' ";
    $qry_001 .= " , P_GRADE = '1' ";
    $qry_001 .= " , S_DATE = now() ";
    $qry_001 .= " , E_DATE = now() ";
    $qry_001 .= " , REG_DATE = now() ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "전문약사 정보를 등록하였습니다", "");
    alert_js("parent_reload", "", "");


// 약국의 전문약사 정보 수정
} else if ($Mode == "up_pharmacist") {


    $idx = $_REQUEST["idx"];
    $p_status = $_REQUEST["p_status"];
    $p_grade = $_REQUEST["p_grade"];
    $s_date = $_REQUEST["s_date"];
    $e_date = $_REQUEST["e_date"];


    $qry_001 = "UPDATE {$TB_PP} SET ";
    $qry_001 .= " P_STATUS = '{$p_status}' ";
    $qry_001 .= " , P_GRADE = '{$p_grade}' ";
    $qry_001 .= " , S_DATE = '{$s_date}' ";
    $qry_001 .= " , E_DATE = '{$e_date}' ";
    $qry_001 .= "  WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "전문약사 정보를 수정하였습니다", "");
    alert_js("parent_reload", "", "");


// 약국에 전문약사 제외
} else if ($Mode == "del_pharmacist") {


    $idx = $_REQUEST["idx"];
    echo "====".$idx;

    $qry_001 = "DELETE FROM {$TB_PP} WHERE IDX='{$idx}'";
    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "전문약사를 해당 약국에서 제외하였습니다", "");
    alert_js("parent_reload", "", "");


// 약국에 전문약사 제외
} else if ($Mode == "del_pharmacist_popup") {


    $idx = $_REQUEST["idx"];


    $qry_001 = "DELETE FROM {$TB_PP} WHERE IDX='{$idx}'";
    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "전문약사를 해당 약국에서 제외하였습니다", "");
    alert_js("parent_selfclose", "", "");


// 약국 등록
} else if ($Mode == "pharmacy_add") {

    $pharmacy_code = $_POST["pharmacy_code"];
    $pharmacy_number = add_escape($_POST["pharmacy_number"]);
    $pharmacy_status = isNull($_POST["pharmacy_status"]) ? "1" : $_POST["pharmacy_status"];
    $pharmacy_name = add_escape($_POST["pharmacy_name"]);

    $zipcode = $_POST["zipcode"];
    $address = $_POST["address"];
    $address_ext = add_escape($_POST["address_ext"]);

    $latitude = $_POST["latitude"];
    $longtitude = $_POST["longtitude"];

    $pharmacy_phone = $_POST["phone1"] . "-" . $_POST["phone2"] . "-" . $_POST["phone3"];
    $pharmacy_email = $_POST["emailID"] . "@" . $_POST["emailDomain"];

    $operation_hours = add_escape($_POST["operation_hours"]);
    $introduction = add_escape($_POST["introduction"]);

    $admin_cmt = add_escape($_POST["admin_cmt"]);


    $qry_001 = "INSERT INTO {$TB_PHARMACY} SET ";
    $qry_001 .= " PHARMACY_CODE = '{$pharmacy_code}' ";
    $qry_001 .= " , PHARMACY_NUMBER = '{$pharmacy_number}' ";
    $qry_001 .= " , PHARMACY_STATUS = '{$pharmacy_status}' ";
    $qry_001 .= " , PHARMACY_NAME = '{$pharmacy_name}' ";
    $qry_001 .= " , ZIPCODE = '{$zipcode}' ";
    $qry_001 .= " , ADDRESS = '{$address}' ";
    $qry_001 .= " , ADDRESS_EXT = '{$address_ext}' ";
    $qry_001 .= " , LATITUDE = '{$latitude}' ";
    $qry_001 .= " , LONGTITUDE = '{$longtitude}' ";
    $qry_001 .= " , PHARMACY_PHONE = '{$pharmacy_phone}' ";
    $qry_001 .= " , PHARMACY_EMAIL = '{$pharmacy_email}' ";
    $qry_001 .= " , OPERATION_HOURS = '{$operation_hours}' ";
    $qry_001 .= " , INTRODUCTION = '{$introduction}' ";
    $qry_001 .= " , START_DATE = now() ";
    $qry_001 .= " , ADMIN_ID = '{$_passKey["id"]}' ";
    $qry_001 .= " , ADMIN_CMT = '{$admin_cmt}' ";


    $db->exec_sql($qry_001);

    $obj = new Attech_Works();

    if (!isNull($_FILES["logo_img"]["tmp_name"])) {

        $obj->addToFile($TB_PHARMACY, $pharmacy_code, "logo_img", "../../Web_Files/pharmacy", $_FILES["logo_img"]);

    }


    if (!isNull($_FILES["pharmacy_img"]["tmp_name"])) {

        $obj->addToFile($TB_PHARMACY, $pharmacy_code, "pharmacy_img", "../../Web_Files/pharmacy", $_FILES["pharmacy_img"]);

    }

    alert_js("alert_parent_move", "약국을 등록하였습니다", "../admin.template.php?slot=pharmacy&type=pharmacy_list");
    exit;


// 약국 수정
} else if ($Mode == "pharmacy_up") {


    $idx = $_POST["idx"];
    $pharmacy_code = $_POST["pharmacy_code"];
    $pharmacy_number = add_escape($_POST["pharmacy_number"]);
    $pharmacy_status = $_POST["pharmacy_status"];
    $pharmacy_name = add_escape($_POST["pharmacy_name"]);
    $zipcode = $_POST["zipcode"];
    $address = $_POST["address"];
    $address_ext = add_escape($_POST["address_ext"]);
    $latitude = $_POST["latitude"];
    $longtitude = $_POST["longtitude"];
    $pharmacy_phone = $_POST["phone1"] . "-" . $_POST["phone2"] . "-" . $_POST["phone3"];
    $pharmacy_email = $_POST["emailID"] . "@" . $_POST["emailDomain"];
    $operation_hours = add_escape($_POST["operation_hours"]);
    $introduction = add_escape($_POST["introduction"]);
    $admin_cmt = add_escape($_POST["admin_cmt"]);

    $physical_name1 = $_POST["physical_name1"];
    $physical_name2 = $_POST["physical_name2"];


    $qry_001 = "   UPDATE {$TB_PHARMACY} SET ";
    $qry_001 .= "   PHARMACY_CODE = '{$pharmacy_code}' ";
    $qry_001 .= " , PHARMACY_NUMBER = '{$pharmacy_number}' ";
    $qry_001 .= " , PHARMACY_STATUS = '{$pharmacy_status}' ";
    $qry_001 .= " , PHARMACY_NAME = '{$pharmacy_name}' ";
    $qry_001 .= " , ZIPCODE = '{$zipcode}' ";
    $qry_001 .= " , ADDRESS = '{$address}' ";
    $qry_001 .= " , ADDRESS_EXT = '{$address_ext}' ";
    $qry_001 .= " , LATITUDE = '{$latitude}' ";
    $qry_001 .= " , LONGTITUDE = '{$longtitude}' ";
    $qry_001 .= " , PHARMACY_PHONE = '{$pharmacy_phone}' ";
    $qry_001 .= " , PHARMACY_EMAIL = '{$pharmacy_email}' ";
    $qry_001 .= " , OPERATION_HOURS = '{$operation_hours}' ";
    $qry_001 .= " , INTRODUCTION = '{$introduction}' ";
    $qry_001 .= " , ADMIN_CMT = '{$admin_cmt}' ";
    $qry_001 .= "   WHERE IDX = '{$idx}' ";

    //echo "<br>========================".$idx;
    //echo "<br>========================".$pharmacy_code;
    //echo "<br>========================".$pharmacy_status;
    //echo "<br>========================".$pharmacy_name;
    //echo "<br>========================".$zipcode;
    //echo "<br>========================".$address;
    //echo "<br>========================".$address_ext;
    //echo "<br>========================".$latitude;
    //echo "<br>========================".$longtitude;
    //echo "<br>========================".$pharmacy_phone;
    //echo "<br>========================".$pharmacy_email;
    //echo "<br>========================".$operation_hours;
    //echo "<br>========================".$introduction;
    //echo "<br>========================".$admin_cmt;
    echo "<br>========================" . $physical_name1;
    echo "<br>========================" . $physical_name2;
    echo "<br>========================" . $_FILES["logo_img"]["tmp_name"];

    // 첨부파일1 삭제로직
    if ($_POST["del_file1"] == "Y") {
        @unlink("../../Web_Files/pharmacy/" . $physical_name1);
        $del_qry_001 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '{$physical_name1}' ";
        @$db->exec_sql($del_qry_001);
    }
    if ($_POST["del_file2"] == "Y") {
        @unlink("../../Web_Files/pharmacy/" . $physical_name2);
        $del_qry_002 = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '{$physical_name2}' ";
        @$db->exec_sql($del_qry_002);
    }


    $db->exec_sql($qry_001);

    $att = new Attech_Works();

    if (!isNull($_FILES["logo_img"]["tmp_name"])) {

        $att->addToFile($TB_PHARMACY, $pharmacy_code, "logo_img", "../../Web_Files/pharmacy", $_FILES["logo_img"]);

    }


    if (!isNull($_FILES["pharmacy_img"]["tmp_name"])) {

        $att->addToFile($TB_PHARMACY, $pharmacy_code, "pharmacy_img", "../../Web_Files/pharmacy", $_FILES["pharmacy_img"]);

    }


    alert_js("alert_parent_move", "수정하였습니다", "../admin.template.php?slot=pharmacy&type=pharmacy_list");
    exit;


} else if ($Mode == "del_pharmacy") {


    if (isNull($_POST["p_code"])) {
        alert_js("alert_parent_reload", "삭제 정보가 올바르지 않습니다.", "");
        exit;
    }

    $p_code = $_POST["p_code"];
    $mm_pass = $_POST["mm_pass"];

    $page = $_POST["page"];
    $search_sex = $_POST["search_sex"];
    $search_region = $_POST["search_region"];
    $search_support = $_POST["search_support"];
    $search_nation = $_POST["search_nation"];
    $search_ssCode = $_POST["search_ssCode"];
    $keyfield = $_POST["keyfield"];
    $keyword = $_POST["keyword"];


    if ($_admin["pass"] == $mm_pass) {

        $obj = new Attech_Works();
        @$obj->delFile($TB_PHARMACY, $p_code, "pharmacy_img", "../../Web_Files/pharmacy");
        @$obj->delFile($TB_PHARMACY, $p_code, "logo_img", "../../Web_Files/pharmacy");

        $del_qry_001 = "DELETE FROM {$TB_PHARMACY} WHERE PHARMACY_CODE='{$p_code}'";
        $del_qry_002 = "DELETE FROM {$TB_PP} WHERE PHARMACY_CODE='{$p_code}'";

        @$db->exec_sql($del_qry_001);
        @$db->exec_sql($del_qry_002);


        $go_link = "../admin.template.php?slot=pharmacy&type=pharmacy_list";
        alert_js("parent_move", "", $go_link);

        exit;

    } else {

        alert_js("alert_parent_reload", "비밀번호가 일치 하지 않습니다.", "");
        exit;

    }


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




// 소속약사신청 승인
} else if ($Mode == "sign_pp") {

    $idx = $_REQUEST["idx"];

    $qry_001 = "UPDATE {$TB_PP} SET ";
    $qry_001 .= " P_STATUS = '1' ";
    $qry_001 .= ", REG_DATE = now() ";
    $qry_001 .= "  WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "소속약사 신청의 승인이 완료되었습니다.", "");
    alert_js("parent_reload", "", "");


// 소속약사신청 보류
} else if ($Mode == "hold_pp") {

    $idx = $_REQUEST["idx"];

    $qry_001 = "UPDATE {$TB_PP} SET ";
    $qry_001 .= " P_STATUS = '3' ";
    $qry_001 .= "  WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "소속약사 신청이 보류되었습니다.", "");
    alert_js("parent_reload", "", "");


// 소속약사신청 취소
} else if ($Mode == "cancel_pp") {

    $idx = $_REQUEST["idx"];

    $qry_001 = "DELETE FROM {$TB_PP} WHERE IDX='{$idx}'";
    $db->exec_sql($qry_001);

    alert_js("alert_parent_opener_reload", "소속약사 신청이 취소되었습니다.", "");
    alert_js("parent_reload", "", "");



// 약국신청 - 약국등록
} else if ($Mode == "req_pharmacy_add") {

    $pharmacy_code = $_POST["pharmacy_code"];
    $idx = $_POST["idx"];
    $pharmacy_name = add_escape($_POST["pharmacy_name"]);
    $zipcode = $_POST["zipcode"];
    $address = $_POST["address"];
    $address_ext = add_escape($_POST["address_ext"]);
    $latitude = $_POST["latitude"];
    $longtitude = $_POST["longtitude"];
    $pharmacy_phone = $_POST["pharmacy_phone"];
    $pharmacy_email = $_POST["pharmacy_email"];
    $operation_hours = add_escape($_POST["operation_hours"]);
    $introduction = add_escape($_POST["introduction"]);

    $qry_001 = "INSERT INTO {$TB_PHARMACY} SET ";
    $qry_001 .= " PHARMACY_CODE = '{$pharmacy_code}' ";
    $qry_001 .= " , PHARMACY_STATUS = '1' ";
    $qry_001 .= " , PHARMACY_NAME = '{$pharmacy_name}' ";
    $qry_001 .= " , ZIPCODE = '{$zipcode}' ";
    $qry_001 .= " , ADDRESS = '{$address}' ";
    $qry_001 .= " , ADDRESS_EXT = '{$address_ext}' ";
    $qry_001 .= " , LATITUDE = '{$latitude}' ";
    $qry_001 .= " , LONGTITUDE = '{$longtitude}' ";
    $qry_001 .= " , PHARMACY_PHONE = '{$pharmacy_phone}' ";
    $qry_001 .= " , PHARMACY_EMAIL = '{$pharmacy_email}' ";
    $qry_001 .= " , OPERATION_HOURS = '{$operation_hours}' ";
    $qry_001 .= " , INTRODUCTION = '{$introduction}' ";
    $qry_001 .= " , START_DATE = now() ";
    $qry_001 .= " , ADMIN_ID = '{$_passKey["id"]}' ";

    $db->exec_sql($qry_001);

    $qry_002 = "UPDATE {$TB_AP} SET ";
    $qry_002 .= " APPLY_STATUS = '2' ";
    $qry_002 .= ",APPROVAL_DATE  = now() ";
    $qry_002 .= "  WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_002);

    /*$obj = new Attech_Works();
    if (!isNull($_FILES["logo_img"]["tmp_name"])) {
        $obj->addToFile($TB_PHARMACY, $pharmacy_code, "logo_img", "../../Web_Files/pharmacy", $_FILES["logo_img"]);
    }
    if (!isNull($_FILES["pharmacy_img"]["tmp_name"])) {
        $obj->addToFile($TB_PHARMACY, $pharmacy_code, "pharmacy_img", "../../Web_Files/pharmacy", $_FILES["pharmacy_img"]);
    }*/

    alert_js("alert_parent_move", "약국을 등록하였습니다", "../admin.template.php?slot=pharmacy&type=pharmacy_core&step=update&pcode=".$pharmacy_code);
    exit;


// 약국신청 - 승인불가
} else if ($Mode == "no_apply") {

    $idx = $_REQUEST["idx"];

    $qry_001 = "UPDATE {$TB_AP} SET ";
    $qry_001 .= " APPLY_STATUS = '3' ";
    $qry_001 .= ",REFUSAL_DATE = now() ";
    $qry_001 .= "  WHERE IDX = '{$idx}' ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_move", "승인불가 처리가 완료되었습니다.", "../admin.template.php?slot=pharmacy&type=req_pharmacy_list");



} else if($Mode == "pill_register") {


    $pill_code = $_REQUEST["pill_code"];
    $pill_name = $_REQUEST["pill_name"];
    $pill_company = $_REQUEST["pill_company"];
    $pill_medical_name = $_REQUEST["pill_medical_name"];
    $pill_medical_code = $_REQUEST["pill_medical_code"];
    $pill_status = $_REQUEST["pill_status"];


    $qry_001  = " INSERT INTO {$TB_PILL} SET ";    
    $qry_001 .= "  PILL_CODE   = '".$pill_code."' ";    
    $qry_001 .= ", PILL_NAME  = '".$pill_name."' ";    
    $qry_001 .= ", PILL_COMPANY  = '".$pill_company."' ";    
    $qry_001 .= ", PILL_MEDICAL_NAME  = '".$pill_medical_name."' ";    
    $qry_001 .= ", PILL_MEDICAL_CODE  = '".$pill_medical_code."' ";    
    $qry_001 .= ", PILL_STATUS  = '".$pill_status."' ";    
    $qry_001 .= ", REG_DATE  = now() ";    

    $res_001 = $db->exec_sql($qry_001);
    $row_001 = $db->sql_fetch_row($res_001);
    
    
    alert_js("parent_opener_reload","처방약을 등록하였습니다.","")    ;
    alert_js("alert_parent_selfclose","처방약을 등록하였습니다.","")  ;    


} else if($Mode == "del_pill"){

    $pill_code = $_GET["pill_code"] ;

    $_sql = "DELETE FROM {$TB_PILL} WHERE PILL_CODE = '{$pill_code}' " ;
    $db->exec_sql($_sql) ;

    alert_js('alert_parent_reload','해당 약품을 삭제하였습니다.','') ;
    exit ;

} else if($Mode == "pill_update") {


    $idx = $_REQUEST["idx"];
    $pill_code = $_REQUEST["pill_code"];
    $pill_name = $_REQUEST["pill_name"];
    $pill_company = $_REQUEST["pill_company"];
    $pill_medical_name = $_REQUEST["pill_medical_name"];
    $pill_medical_code = $_REQUEST["pill_medical_code"];
    $pill_status = $_REQUEST["pill_status"];


    $qry_001  = " UPDATE {$TB_PILL} SET ";    
    $qry_001 .= "  PILL_CODE   = '".$pill_code."' ";    
    $qry_001 .= ", PILL_NAME  = '".$pill_name."' ";    
    $qry_001 .= ", PILL_COMPANY  = '".$pill_company."' ";    
    $qry_001 .= ", PILL_MEDICAL_NAME  = '".$pill_medical_name."' ";    
    $qry_001 .= ", PILL_MEDICAL_CODE  = '".$pill_medical_code."' ";    
    $qry_001 .= ", PILL_STATUS  = '".$pill_status."' ";    
    $qry_001 .= ", REG_DATE  = now() ";    
    $qry_001 .= " WHERE IDX = '{$idx}' ";    

    $res_001 = $db->exec_sql($qry_001);
    $row_001 = $db->sql_fetch_row($res_001);
    
    
    alert_js("parent_opener_reload","처방약을 등록하였습니다.","")    ;
    alert_js("alert_parent_selfclose","처방약을 등록하였습니다.","")  ;    


// 약국 심평원 동기화
} else if ($Mode == "pharmacy_ykiho_regist") {

    $pharmacy_code = $_REQUEST["pharmacy_code"];
    $ykiho = $_REQUEST["ykiho_number"];

    $qry_001  = "UPDATE {$TB_PHARMACY} SET ";
    $qry_001 .= " YKIHO = '{$ykiho}' ";
    $qry_001 .= " WHERE PHARMACY_CODE = '{$pharmacy_code}' ";

    $db->exec_sql($qry_001);

    alert_js("alert_parent_parent_reload", "심평원 등록이 완료되었습니다.", "");
    exit;










}

$db->db_close();
