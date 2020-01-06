<?php
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";

$mode = "";
$mode = $_REQUEST["mode"];


##### 광고 입력 ( ad 통합 )
if ( $mode == "add_top" || $mode == "add_main" || $mode == "add_sub" ) {
	
    $ad_code   = $_POST["ad_code"];
    $ad_type   = $_POST["ad_type"];
    $ad_status = $_POST["ad_status"];
    $reg_date  = $_POST["reg_date"];
    $ad_title  = add_escape($_POST["ad_title"]);
    $ad_txt_1  = add_escape($_POST["ad_txt_1"]);
    $ad_txt_2  = add_escape($_POST["ad_txt_2"]);
    $ad_txt_3  = add_escape($_POST["ad_txt_3"]);
    $ad_link   = add_escape($_POST["ad_link"]);
    $ad_link   = add_escape($_POST["ad_link"]);
	$start_date= $_POST["schReqSDate"];
	$end_date  = $_POST["schReqEDate"];

    
    //echo "<br>ad_code======================".$ad_code;
    //echo "<br>ad_type======================".$ad_type;
    //echo "<br>ad_status====================".$ad_status;
    //echo "<br>reg_date=====================".$reg_date;
    //echo "<br>ad_title=====================".$ad_title;
    //echo "<br>ad_txt_1=====================".$ad_txt_1;
    //echo "<br>ad_txt_2=====================".$ad_txt_2;
    //echo "<br>ad_txt_3=====================".$ad_txt_3;
    //echo "<br>ad_link======================".$ad_link;

    $qry_001  = "INSERT INTO {$TB_AD} SET        ";
    $qry_001 .= " AD_CODE     = '{$ad_code}'     ";
    $qry_001 .= ",AD_TYPE     = '{$ad_type}'     ";
    $qry_001 .= ",AD_STATUS   = '{$ad_status}'   ";
    $qry_001 .= ",AD_TITLE    = '{$ad_title}'    ";
    $qry_001 .= ",AD_TXT_1    = '{$ad_txt_1}'    ";
    $qry_001 .= ",AD_TXT_2    = '{$ad_txt_2}'    ";
    $qry_001 .= ",AD_TXT_3    = '{$ad_txt_3}'    ";
    $qry_001 .= ",AD_LINK     = '{$ad_link}'     ";
    $qry_001 .= ",REG_DATE    = '{$reg_date}'    ";
    $qry_001 .= ",START_DATE  = '{$start_date}'  ";
    $qry_001 .= ",END_DATE    = '{$end_date}'    ";

    $db->exec_sql($qry_001);

    //echo "<br>qry_001======================".$qry_001;



    $qry_002 = " SELECT * FROM {$TB_AD} WHERE AD_CODE = '{$ad_code}' ";
    $res_002 = $db->exec_sql($qry_002);
    $row_002 = $db->sql_fetch_array($res_002);

    
    $ad_code = $row_002["AD_CODE"];
	
	$p_code = $TB_AD ;
	$r_code = $ad_code ;
	$t_code = $ad_type ;
	$path   = "../../_core/_files/ad" ;
	$file_obj = $_FILES["ad_file"] ;

    //echo "<br>qry_002======================".$qry_002;
    //echo "<br>ad_code======================".$ad_code;
    //echo "<br>p_code======================".$p_code;
    //echo "<br>r_code======================".$r_code;
    //echo "<br>t_code======================".$t_code;
    //echo "<br>path======================".$path;
    //echo "<br>file_obj======================".$file_obj;

    if (isset($file_obj) && $file_obj['name'] != "") {

        $att = new Attech_Works();
		$att->addToFile($p_code, $r_code, $t_code, $path, $file_obj) ;
    }

    if ( $mode == "add_top" ) {
    alert_js('alert_parent_move', 'TOP 광고를 등록하였습니다', '../admin.template.php?slot=ad&type=ad_top_list');
    } else if ( $mode == "add_main" ) {
        alert_js('alert_parent_move', 'MAIN SLIDE 광고를 등록하였습니다', '../admin.template.php?slot=ad&type=main_slide_list');
    } else if ( $mode == "add_sub" ) {
        alert_js('alert_parent_move', 'SUB SLIDE 광고를 등록하였습니다', '../admin.template.php?slot=ad&type=sub_slide_list');
    }
    exit;


##### 광고 수정 ( ad 통합 )
} else if ( $mode == "up_top" || $mode == "up_main" || $mode == "up_sub" ) {

    $idx = $_POST["idx"];

	$ad_code   = $_POST["ad_code"];
    $ad_type   = $_POST["ad_type"];
    $ad_status = $_POST["ad_status"];
    $reg_date  = $_POST["reg_date"];
    $ad_title  = add_escape($_POST["ad_title"]);
    $ad_txt_1  = add_escape($_POST["ad_txt_1"]);
    $ad_txt_2  = add_escape($_POST["ad_txt_2"]);
    $ad_txt_3  = add_escape($_POST["ad_txt_3"]);
	$ad_link   = add_escape($_POST["ad_link"]);
    $hit       = $_POST["hit"];
	$old_file  = $_POST["old_file"];
	$start_date  = $_POST["schReqSDate"];
	$end_date  = $_POST["schReqEDate"];


    //echo "<br>ad_code======================".$ad_code;
    //echo "<br>ad_type======================".$ad_type;
    //echo "<br>ad_status======================".$ad_status;
    //echo "<br>reg_date======================".$reg_date;
    //echo "<br>ad_title======================".$ad_title;
    //echo "<br>ad_txt_1======================".$ad_txt_1;
    //echo "<br>ad_txt_2======================".$ad_txt_2;
    //echo "<br>ad_txt_3======================".$ad_txt_3;
	//echo "<br>ad_link======================".$ad_link;
    //echo "<br>hit======================".$hit;
    //echo "<br>old_file======================".$old_file;

    

    // 첨부파일1 삭제로직
    if ($_POST["del_file"] == "Y") {
        @unlink("../../_core/_files/ad/". $old_file);
        $del_qry = " DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '{$old_file}' ";
        @$db->exec_sql($del_qry);
    }

    $qry_001  = " UPDATE {$TB_AD} SET              ";
    $qry_001 .= " AD_STATUS  = '{$ad_status}'   ";
    $qry_001 .= ",AD_TITLE   = '{$ad_title}'    ";
    $qry_001 .= ",AD_TXT_1   = '{$ad_txt_1}'    ";
    $qry_001 .= ",AD_TXT_2   = '{$ad_txt_2}'    ";
    $qry_001 .= ",AD_TXT_3   = '{$ad_txt_3}'    ";
	$qry_001 .= ",START_DATE = '{$start_date}'  ";
	$qry_001 .= ",END_DATE   = '{$end_date}'    ";


    if (isset($_FILES['ad_file']) && $_FILES['ad_file']['name'] != "") {

		@unlink("../../_core/_files/ad/". $old_file);

		$p_code = $TB_AD ;
		$r_code = $ad_code ;
		$t_code = $ad_type ;
		$path   = "../../_core/_files/ad" ;
		$file_obj = $_FILES["ad_file"] ;

        $att = new Attech_Works();
		$att->addToFile($p_code, $r_code, $t_code, $path, $file_obj) ;

    }

    $qry_001 .= ",REG_DATE   = '{$reg_date}'   ";
    $qry_001 .= " WHERE IDX='{$idx}'           ";

    $db->exec_sql($qry_001);

    if ( $mode == "up_top" ) {
    alert_js('alert_parent_move', 'TOP 광고를 수정하였습니다', '../admin.template.php?slot=ad&type=ad_top_list');
    } else if ( $mode == "up_main" ) {
        alert_js('alert_parent_move', 'MAIN SLIDE 광고를 수정하였습니다', '../admin.template.php?slot=ad&type=main_slide_list');
    } else if ( $mode == "up_sub" ) {
        alert_js('alert_parent_move', 'SUB SLIDE 광고를 수정하였습니다', '../admin.template.php?slot=ad&type=sub_slide_list');
    }

    exit;



##### 광고 삭제 ( ad 통합 )
} else if ( $mode == "del_top" || $mode == "del_main" || $mode == "del_sub" ) {

    $idx = $_GET["idx"];
    $ad_type   = $_GET["ad_type"];

    //echo "<br>idx======================".$idx;
    //echo "<br>ad_type======================".$ad_type;

	$qry_001  = " SELECT t1.*, t2.PHYSICAL_NAME ";
	$qry_001 .= " FROM {$TB_AD} t1 ";
	$qry_001 .= " LEFT JOIN {$TB_ATTECH_FILES} t2 ON (t1.AD_CODE = t2.REFERENCE_CODE) ";
	$qry_001 .= " WHERE t1.IDX = '{$idx}' AND t1.AD_TYPE = '{$ad_type}' ";

    $res_001 = $db->exec_sql($qry_001);
    $row_001 = $db->sql_fetch_array($res_001);

	$file = $row_001["PHYSICAL_NAME"];

	//echo "<br>".$qry_001;
	//echo "<br>file======================".$file;

    if (!isNull($file)) {
        @unlink("../../_core/_files/ad/".$file);
    }
	$qry_002 = "DELETE FROM {$TB_ATTECH_FILES} WHERE PHYSICAL_NAME = '{$file}' ";
    $db->exec_sql($qry_002);

    $qry_003 = "DELETE FROM {$TB_AD} WHERE IDX = '{$idx}' ";
    $db->exec_sql($qry_003);

    if ( $mode == "del_top" ) {
    alert_js('alert_parent_move', 'TOP 광고를 삭제하였습니다', '../admin.template.php?slot=ad&type=ad_top_list');
    } else if ( $mode == "del_main" ) {
        alert_js('alert_parent_move', 'MAIN SLIDE 광고를 삭제하였습니다', '../admin.template.php?slot=ad&type=main_slide_list');
    } else if ( $mode == "del_sub" ) {
        alert_js('alert_parent_move', 'SUB SLIDE 광고를 삭제하였습니다', '../admin.template.php?slot=ad&type=sub_slide_list');
    }

    exit;




}


$db->db_close();
?>