<?
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/admin_auth.php";


$Mode = "";
$Mode = $_REQUEST["Mode"];


$_link = "";        // 이동할 주소 변수

// 사진 처방전
if ($Mode == "send_op") {

    $ps_code = $_REQUEST["ps_code"];

    $qry_001 = "   UPDATE {$TB_PS} SET ";
    $qry_001 .= "   PS_STATUS = '3' ";
    $qry_001 .= " WHERE PS_CODE='" . $ps_code . "' ";

    $res = $db->exec_sql($qry_001);

    if ($res) {
        echo "100";
        exit;
    } else {
        echo "999";
        exit;
    }


    // 처방전 등록
} else if ($Mode == "add_ps") {

    $idx = $_REQUEST["idx"];
    $user_id = $_REQUEST["user_id"];
    $send_type = $_REQUEST["send_type"];
    $ps_code = $_REQUEST["ps_code"];

    //$ps_code = "P" . $idx . "-" . date(Ymdhms);

    /*$qry_001 = "   INSERT INTO {$TB_PS} SET ";
    $qry_001 .= "   PS_CODE = '{$ps_code}' ";
    $qry_001 .= " , PS_STATUS = '1' ";
    $qry_001 .= " , SEND_TYPE = '{$send_type}' ";
    $qry_001 .= " , USER_ID = '{$user_id}' ";
    $qry_001 .= " , REG_DATE = now() ";

    $db->exec_sql($qry_001);*/

    //alert_js("parent_move", "", "../pharmacy/find_map.php?ps_code=" . $ps_code);

    echo 1;


    exit;


// 처방전 약국 등록
} else if ($Mode == "add_ps_pharmacy") {

    $ps_code = $_REQUEST["ps_code"];
    $p_code = $_REQUEST["p_code"];

    $qry_chk = " SELECT COUNT(*) FROM {$TB_PS_PHARMACY} WHERE PS_CODE = '{$ps_code}' AND PHARMACY_CODE = '{$p_code}' ";
    $res_chk = $db->exec_sql($qry_chk);
    $row_chk = $db->sql_fetch_row($res_chk);
    $check = $row_chk[0];

    if ($check > 0) {

        alert_js("parent_move", "", "../prescription/prescription_status.php?ps_code=" . $ps_code);

    } else {

        $qry_001 = "   INSERT INTO {$TB_PS_PHARMACY} SET ";
        $qry_001 .= "   PS_CODE = '{$ps_code}' ";
        $qry_001 .= " , A_STATUS = '1' ";
        $qry_001 .= " , PHARMACY_CODE = '{$p_code}' ";
        $qry_001 .= " , REG_DATE = now() ";

        $db->exec_sql($qry_001);
        alert_js("parent_move", "", "../prescription/prescription_status.php?ps_code=" . $ps_code);
    }


    exit;

// 처방전 약국 전송취소
} else if ($Mode == "del_ps_pharmacy") {

    $ps_code = $_REQUEST["ps_code"];
    $p_code = $_REQUEST["p_code"];

    $qry_001 = "   DELETE FROM {$TB_PS_PHARMACY} ";
    $qry_001 .= "   WHERE PS_CODE = '{$ps_code}' AND PHARMACY_CODE = '{$p_code}' ";

    $db->exec_sql($qry_001);

    echo 0;
    //alert_js("parent_move", "", "../prescription/prescription_status.php?ps_code=".$ps_code);

    exit;

// 처방전 약국 전체 전송취소
} else if ($Mode == "del_ps_pharmacy_all") {

    $ps_code = $_REQUEST["ps_code"];

    $qry_001 = "   DELETE FROM {$TB_PS_PHARMACY} ";
    $qry_001 .= "   WHERE PS_CODE = '{$ps_code}' ";

    $db->exec_sql($qry_001);

    echo 0;
    //alert_js("parent_move", "", "../prescription/prescription_status.php?ps_code=".$ps_code);

    exit;


// 결제신청
} else if ($Mode == "payment") {

    $ps_code = $_REQUEST["ps_code"];
    $p_code = $_REQUEST["p_code"];

    $qry_001 = " UPDATE {$TB_PS} SET ";
    $qry_001 .= " PS_STATUS   = '5' ";
    $qry_001 .= " ,COMPLETE_DATE = now() ";
    $qry_001 .= " WHERE PS_CODE = '{$ps_code}' ";

    $db->exec_sql($qry_001);

    $qry_002 = " UPDATE {$TB_PS_PHARMACY} SET ";
    $qry_002 .= " A_STATUS   = '5' ";
    $qry_002 .= " WHERE PS_CODE = '{$ps_code}' AND PHARMACY_CODE = '{$p_code}' ";

    $db->exec_sql($qry_002);

    $qry_003 = " UPDATE {$TB_PS_PHARMACY} SET ";
    $qry_003 .= " A_STATUS   = '4' ";
    $qry_003 .= " WHERE PS_CODE = '{$ps_code}' AND PHARMACY_CODE != '{$p_code}' ";

    $db->exec_sql($qry_003);

    echo 0;
    //alert_js("alert", "결제가 완료되었습니다.", "");

    exit;

// 처방전 상태 - 실시간
} else if ($Mode == "ajax_call") {

    $ps_code = $_REQUEST["ps_code"];
    $a_status = $_REQUEST["a_status"];

    $qry_002 = " SELECT *, t1.REG_DATE AS date ";
    $_from = " FROM {$TB_PS_PHARMACY} t1 ";
    $_from .= " LEFT JOIN {$TB_PHARMACY} t2 ON ( t1.PHARMACY_CODE = t2.PHARMACY_CODE ) ";
    $_where = " WHERE t1.PS_CODE = '{$ps_code}' ";


    $res_002 = $db->exec_sql($qry_002 . $_from . $_where);
    while ($row_002 = $db->sql_fetch_array($res_002)) {
        $ajax_status = $row_002["A_STATUS"];
    }
    if ($a_status == $ajax_status) {
        echo 0;
        //echo $a_status.", ".$ajax_status;
        exit;
    } else {
        echo 999;
        //echo $a_status.", ".$ajax_status;
        exit;
    }


// 처방전 상태 - 실시간 - 다시 그리기
} else if ($Mode == "ajax_call_change") {

    $ps_code = $_REQUEST["ps_code"];

    $qry_002 = " SELECT *, t1.REG_DATE AS date ";
    $_from = " FROM {$TB_PS_PHARMACY} t1 ";
    $_from .= " LEFT JOIN {$TB_PHARMACY} t2 ON ( t1.PHARMACY_CODE = t2.PHARMACY_CODE ) ";
    $_where = " WHERE t1.PS_CODE = '{$ps_code}' ";

    $_list = "";

    $res_002 = $db->exec_sql($qry_002 . $_from . $_where);
    while ($row_002 = $db->sql_fetch_array($res_002)) {
        $a_status = $row_002["A_STATUS"];
        $d_date = strtotime($row_002["date"]);
        $dd_date = strtotime(date("Ymd H:i:s"));
        $total_time = $dd_date - $d_date;

        $days = floor($total_time / 86400);
        $time = $total_time - ($days * 86400);
        $hours = floor($time / 3600);
        $time = $time - ($hours * 3600);
        $min = floor($time / 60);
        $sec = $time - ($min * 60);

        if ($days == 0 && $hours == 0 && $min == 0) {
            $result_date = $sec . "초 경과";
        } else if ($days == 0 && $hours == 0) {
            $result_date = $min . "분 " . $sec . "초 경과";
        } else if ($days == 0) {
            $result_date = $hours . "시간 " . $min . "분 " . $sec . "초 경과";
        } else {
            $result_date = $days . "일 " . $hours . "시간 " . $min . "분 " . $sec . "초 경과";
        }

        $_list .= "
           <tr>
                <th scope='row'>" . $row_002["PHARMACY_NAME"] . "</th>";
        $_list .= "
                <td>" . $prescription_pharmacy_status_array[$row_002["A_STATUS"]] . "</td>";
        $_list .= "
                <td>" . $result_date . "</td>";
        if ($row_002["A_STATUS"] == 1) {
            $_list .= "
                <td>
                    <a href='javascript:void(0);' 
                    onclick='del_ps_pharmacy('" . $ps_code . "','" . $row_002['PHARMACY_CODE'] . "')'
                    class='cancleBtn'>취소</a>
                </td>";
        } else if ($row_002["A_STATUS"] == 2) {
            $_list .= "
                <td>
                    <a href='./prescription_payment.php?ps_code=" . $ps_code . "&p_code=" . $row_002["PHARMACY_CODE"] . "'
                       class='paymentBtn'>결제요청</a>
                </td>";
        } else if ($row_002["A_STATUS"] == 3) {
            $_list .= "
                <td>
                    <a href='./prescription_substitute.php?ps_code=" . $ps_code . "&p_code=" . $row_002["PHARMACY_CODE"] . "'
                       class='replaceBtn'>대체조제</a>
                </td>";
        } else if ($row_002["A_STATUS"] == 4) {
            $_list .= "
                <td><a href='javascript:void(0);' class='cancleBtn'>조제불가</a></td>";
        } else if ($row_002["A_STATUS"] == 5) {
            $_list .= "
                <td><a href='javascript:void(0);' class='paymentBtn'>결제완료</a></td>";
        }
        $_list .= "</tr>";
    }
    $_list .= '<input type="hidden" id="a_status" name="a_status" value="' . $a_status . '">';

    echo $_list;

// 처방전 상태 - 처방전 삭제
} else if ($Mode == "del_prescription") {
    $ps_code = $_REQUEST["ps_code"];

    $qry_img = " SELECT * FROM {$TB_PS_IMAGE} WHERE PS_CODE='{$ps_code}' ";
    $res_img = $db->exec_sql($qry_img);
    $row_img = $db->sql_fetch_array($res_img);

    @unlink("../../Web_Files/prescription/" . $row_img["PHYSICAL_NAME"]);

    $qry_001 = " DELETE FROM {$TB_PS_PHARMACY} WHERE PS_CODE = '{$ps_code}' ";
    $qry_002 = " DELETE FROM {$TB_PS} WHERE PS_CODE='{$ps_code}' ";
    $qry_003 = " DELETE FROM {$TB_PS_IMAGE} WHERE PS_CODE='{$ps_code}' ";
    $qry_004 = " DELETE FROM {$TB_PS_PILL} WHERE PS_CODE='{$ps_code}' ";

    $result_001 = $db->exec_sql($qry_001);
    $result_002 = $db->exec_sql($qry_002);
    $result_003 = $db->exec_sql($qry_003);
    $result_004 = $db->exec_sql($qry_004);

    if ($result_001 && $result_002 && $result_003 && $result_004) {
        echo 999;
        exit;
    } else {
        echo 0;
        exit;
    }


} else if ($Mode == "update_prescription_file") {

    $ps_code = $_POST["ps_code"];
    $user_id = $_POST["user_id"];
    $send_type = $_POST["send_type"];
    $reg_date = date('Y-m-d H:i:s');
    /*echo $ps_code."-".$user_id."-".$send_type;
    exit;*/

    $qry_001 = "   INSERT INTO {$TB_PS} SET ";
    $qry_001 .= "   PS_CODE = '{$ps_code}' ";
    $qry_001 .= " , PS_STATUS = '3' ";
    $qry_001 .= " , SEND_TYPE = '{$send_type}' ";
    $qry_001 .= " , USER_ID = HEX(AES_ENCRYPT('" . $user_id . "','" . SECRET_KEY . "')) ";
    $qry_001 .= " , REG_DATE = '{$reg_date}' ";


    if ($db->exec_sql($qry_001)) {

        $qry_002 = "   INSERT INTO {$TB_PS_IMAGE} SET ";
        $qry_002 .= "   PS_CODE = '{$ps_code}' ";


        if (!isNull($_FILES["image_file"]["name"])) {
            $fileNameInfo = explode(".", $_FILES["image_file"]["name"]);

            //@move_uploaded_file($_FILES["image_file"]["tmp_name"], "../../_core/_files/prescription/" . $ps_code . "." . $fileNameInfo[1]);
            move_uploaded_file($_FILES["image_file"]["tmp_name"], "../../Web_Files/prescription/" . $ps_code . "." . $fileNameInfo[1]);

            //print_r($_FILES["image_file"]);
            //exit;

            $prescription_file = $ps_code . "." . $fileNameInfo[1];
            $qry_002 .= ",PHYSICAL_NAME = '{$prescription_file}' ";
        }

        $qry_002 .= " , REG_DATE = now() ";

        if ($db->exec_sql($qry_002)) {

            echo "100";
            exit;

        } else {

            $qry_003 = "DELETE FROM {$TB_PS} WHERE PS_CODE = '{$ps_code}' ";
            @$db->exec_sql($qry_003);

            echo "200";
            exit;

        }

    } else {

        echo "300";
        exit;

    }


} else if ($Mode == "re_prescription_file") {

    $ps_code = $_POST["ps_code"];

    $qry_001 = " SELECT * FROM {$TB_PS_IMAGE} WHERE PS_CODE='{$ps_code}' ";
    $res_001 = $db->exec_sql($qry_001);
    $row_001 = $db->sql_fetch_array($res_001);

    @unlink("../../Web_Files/prescription/" . $row_001["PHYSICAL_NAME"]);

    $qry_002 = "DELETE FROM {$TB_PS} WHERE PS_CODE='{$ps_code}' ";
    $qry_003 = "DELETE FROM {$TB_PS_IMAGE} WHERE PS_CODE='{$ps_code}' ";

    @$db->exec_sql($qry_002);
    @$db->exec_sql($qry_003);

    echo "100";
    exit;


} else if ($Mode == "check_prescription") {

    $ps_code = $_POST["ps_code"];

    $qry_001 = " SELECT PS_STATUS FROM {$TB_PS} WHERE PS_CODE = '{$ps_code}' ";
    $res_001 = $db->exec_sql($qry_001);
    $row_001 = $db->sql_fetch_array($res_001);

    echo $row_001["PS_STATUS"];
    exit;


} else if ($Mode == "cancel_prescription") {

    $ps_code = $_POST["ps_code"];

    $qry_001 = " UPDATE {$TB_PS} SET ";
    $qry_001 .= " PS_STATUS   = '6' ";
    $qry_001 .= " ,COMPLETE_DATE = now() ";
    $qry_001 .= " WHERE PS_CODE = '{$ps_code}' ";

    $db->exec_sql($qry_001);

    echo "100";
    exit;


} else if ($Mode == "cancel_prescription_img_del") {

    $physical_name = $_POST["physical_name"];

    @unlink("../../Web_Files/prescription/" . $physical_name);

    $qry_001 = "DELETE FROM {$TB_PS_IMAGE} WHERE PHYSICAL_NAME ='{$physical_name}' ";

    if ($db->exec_sql($qry_001)) {
        echo "100";
        exit;
    } else {
        echo "실패";
        exit;
    }


}


$db->db_close();
