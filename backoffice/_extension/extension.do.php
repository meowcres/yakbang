<?php
include_once "../../_core/_init.php";

$mode = "";
$mode = $_REQUEST["mode"];

$link = ""; // 이동할 주소 변수

// 정보등록
if ($mode=="update_information") {
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

        $sql_001  = "UPDATE {$TB_CONFIG} SET ";
        $sql_001 .= " SITE_ID = '{$site_id}' ";
        $sql_001 .= ",SITE_TITLE = '{$site_title}' ";
        $sql_001 .= ",SITE_TYPE = '{$site_type}' ";

        if (!isNull($_FILES["image_file"]["name"])) {
            $fileNameInfo = explode(".", $_FILES["image_file"]["name"]);
            $logicalName = "image_".mktime() ;

            @move_uploaded_file($_FILES["image_file"]["tmp_name"], "../../OG/".$logicalName.".".$fileNameInfo[1]);
            $site_image = $logicalName.".".$fileNameInfo[1] ;
            $sql_001 .= ",SITE_IMAGE = '{$site_image}' " ;
        }

        if (!isNull($_FILES["icon_file"]["name"])) {
            $fileNameInfo = explode(".", $_FILES["icon_file"]["name"]);
            $logicalName = "icon_".mktime() ;

            @move_uploaded_file($_FILES["icon_file"]["tmp_name"], "../../OG/".$logicalName.".".$fileNameInfo[1]);
            $site_icon = $logicalName.".".$fileNameInfo[1] ;
            $sql_001 .= ",SITE_ICON = '{$site_icon}' " ;
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
    }catch(exception $e){
        $return = 900;
    }

    echo $return;

// 이미지 삭제
} else if ($mode=="del_og_img") {
    $return = 900;
    try{
        $site_key = $_POST["site_id"] ;

        $sql = "SELECT SITE_IMAGE FROM {$TB_CONFIG} WHERE SITE_ID='{$site_key}'" ;
        $res = $db->exec_sql($sql) ;
        $row = $db->sql_fetch_row($res) ;

        @unlink("../../OG/".$_row[0]) ;

		$d_sql = "UPDATE {$TB_CONFIG} SET SITE_IMAGE='' WHERE SITE_ID='{$site_key}' " ;
		$d_res =$db->exec_sql($d_sql) ;

		if($d_res === false){
			$return = 400 ;
		}else{
			$return = 200 ;
		}

	}catch(exception $e){
		$return = 900;
	}

	echo $return;

// 이미지 삭제
} else if ($mode=="del_og_icon") {

    $return = 900;
	try{
        $site_key = $_POST["site_id"] ;

        $sql = "SELECT SITE_ICON  FROM {$TB_CONFIG} WHERE SITE_ID='{$site_key}'" ;
        $res = $db->exec_sql($sql) ;
        $row = $db->sql_fetch_row($res) ;

        @unlink("../../OG/".$_row[0]) ;

        $d_sql = "UPDATE {$TB_CONFIG} SET SITE_ICON='' WHERE SITE_ID='{$site_key}' " ;
		$d_res =$db->exec_sql($d_sql) ;

		if($d_res === false){
			$return = 400 ;
		}else{
			$return = 200 ;
		}

	}catch(exception $e){
		$return = 900;
	}

	echo $return;

##### 메뉴 입력
} else if ($mode=="add_menu") {

    if ($_POST['cd_depth'] == "2") {
        $parent_code = $_POST['parent_code'];
        $group_code = $parent_code."|".$cd_key;
	} else if ($_POST['cd_depth'] == "3") {
        $grand_parent_code = $_POST['grand_parent_code'];
        $parent_code = $_POST['parent_code'];
        $group_code = $grand_parent_code."|".$parent_code."|".$cd_key;
	} else {
        $parent_code = "";
        $group_code = $cd_key;
	}

    $cd_key = $_POST['cd_key'];
    $cd_status = $_POST['cd_status'];
    $cd_type = $_POST['cd_type'];
    $cd_title = add_escape(strip_tags($_POST['cd_title']));
    $cd_url = add_escape($_POST['cd_url']);
    $cd_depth = $_POST['cd_depth'];
    
    $qry_001  = "INSERT INTO {$TB_CODE} SET" ;
    $qry_001 .= "  CD_KEY = '{$cd_key}'" ;
    $qry_001 .= ", CD_STATUS = '{$cd_status}'" ;
    $qry_001 .= ", CD_TYPE = '{$cd_type}'" ;
    $qry_001 .= ", CD_TITLE = '{$cd_title}'" ;
    $qry_001 .= ", CD_URL = '{$cd_url}'" ;
    $qry_001 .= ", PARENT_CODE = '{$parent_code}'" ;
    $qry_001 .= ", GRUOP_CODE = '{$group_code}'" ;
    $qry_001 .= ", ORDER_SEQ = '{$order_seq}'" ;
    $qry_001 .= ", CD_DEPTH = '{$cd_depth}'" ;
    
    $db->exec_sql($qry_001) ;

    alert_js("parent_opener_reload","","");
    alert_js("alert_parent_reload","메뉴정보를 등록하였습니다.","");
    exit;



##### 메뉴 수정
} else if ($mode=="up_menu") {
    
    $cd_key = $_POST['cd_key'];
    $cd_status = $_POST['cd_status'];
    $cd_type = $_POST['cd_type'];
    $order_seq = $_POST['order_seq'];
    $cd_depth = $_POST['cd_depth'];
    $cd_url = add_escape($_POST['cd_url']);
    $cd_title = add_escape($_POST['cd_title']);
    $group_code = $_POST['group_code'];
    $parent_code = $_POST['parent_code'];
    
    $qry_001  = "UPDATE {$TB_CODE} SET" ;
    $qry_001 .= "  CD_STATUS = '{$cd_status}'" ;
    $qry_001 .= ", CD_TYPE = '{$cd_type}'" ;
    $qry_001 .= ", CD_TITLE = '{$cd_title}'" ;
    $qry_001 .= ", CD_URL = '{$cd_url}'" ;
    $qry_001 .= ", PARENT_CODE = '{$parent_code}'" ;
    $qry_001 .= ", GRUOP_CODE = '{$group_code}'" ;
    $qry_001 .= ", ORDER_SEQ = '{$order_seq}'" ;
    $qry_001 .= ", CD_DEPTH = '{$cd_depth}'" ;
    $qry_001 .= " WHERE CD_KEY = '{$cd_key}'" ;

	$db->exec_sql($qry_001) ;

	alert_js("parent_opener_reload","","");
	alert_js("alert_parent_reload","메뉴정보를 수정하였습니다.","");
	exit;



##### 메뉴 삭제
} else if ($mode=="del_menu") {

	if(isNull($_GET["cd_key"])){
		alert_js("alert_parent_reload","옳바르지 않은 정보입니다.","");
		exit;
	}

	$qry_001 = "DELETE FROM {$TB_CODE} WHERE CD_KEY='{$_GET["cd_key"]}' " ;
	$db->exec_sql($qry_001) ;

	alert_js("alert_parent_reload","메뉴정보를 삭제하였습니다.","");
	exit;




































































// 통화량
} else if ($Mode=="update_currency") {


	$return = 900;

	try{

		// SITE 정보 변경
		$_KRW   = $_POST["KRW"] ;
		$_JPY   = $_POST["JPY"] ;
		$_CNY   = $_POST["CNY"] ;
		$_TWD   = $_POST["TWD"] ;


		$_sql  = "UPDATE PPW_CURRENCY SET  " ;
		$_sql .= "  KRW  = '{$_KRW}'       " ;
		$_sql .= ", JPY  = '{$_JPY}'       " ;
		$_sql .= ", CNY  = '{$_CNY}'       " ;
		$_sql .= ", UPDATE_DATE = now()    " ;

		$_res = $db->exec_sql($_sql) ;

		if($_res === false){
			$return = 400 ;
		}else{
			$return = 200 ;
		}

	}catch(exception $e){
		$return = 900;
	}
	
	echo $return;














##### 메뉴 입력
} else if ($mode=="add_menu") {

	if($_POST['MENU_DEPTH'] == "1"){

		$_MENU_CODE    = "L".str_pad(rand(0,9999), 4, "0", STR_PAD_LEFT) ;
		$_MENU_STATUS  = $_POST['MENU_STATUS']                           ;
		$_ORDER_SEQ    = $_POST['ORDER_SEQ']                             ;
		$_MENU_DEPTH   = $_POST['MENU_DEPTH']                            ;
		$_MENU_ID      = ChkEscape($_POST['MENU_ID'])                   ;
		$_MENU_URL     = ChkEscape($_POST['MENU_URL'])                  ;
		$_MENU_NAME    = ChkEscape($_POST['MENU_NAME'])                 ;


		$_SQL  = "INSERT INTO {$MENU_TB} SET                           " ;
		$_SQL .= "  MENU_CODE       = '{$_MENU_CODE}'                  " ;
		$_SQL .= ", MENU_STATUS     = '{$_MENU_STATUS}'                " ;
		$_SQL .= ", ORDER_SEQ       = '{$_ORDER_SEQ}'                  " ;
		$_SQL .= ", MENU_DEPTH      = '{$_MENU_DEPTH}'                 " ;
		$_SQL .= ", MENU_ID         = '{$_MENU_ID}'                    " ;
		$_SQL .= ", MENU_URL        = '{$_MENU_URL}'                   " ;
		$_SQL .= ", MENU_NAME       = '{$_MENU_NAME}'                  " ;

		$db->exec_sql($_SQL) ;

	}else if($_POST['MENU_DEPTH'] == "2"){

		$_MENU_CODE    = "M".str_pad(rand(0,9999), 4, "0", STR_PAD_LEFT) ;
		$_PARENT_CODE  = trim($_POST['PARENT_CODE'])                     ;
		$_MENU_STATUS  = $_POST['MENU_STATUS']                           ;
		$_ORDER_SEQ    = $_POST['ORDER_SEQ']                             ;
		$_MENU_DEPTH   = $_POST['MENU_DEPTH']                            ;
		$_MENU_ID      = ChkEscape($_POST['MENU_ID'])                   ;
		$_MENU_URL     = ChkEscape($_POST['MENU_URL'])                  ;
		$_MENU_NAME    = ChkEscape($_POST['MENU_NAME'])                 ;


		$_SQL  = "INSERT INTO {$MENU_TB} SET                           " ;
		$_SQL .= "  MENU_CODE       = '{$_MENU_CODE}'                  " ;
		$_SQL .= ", PARENT_CODE     = '{$_PARENT_CODE}'                " ;
		$_SQL .= ", MENU_STATUS     = '{$_MENU_STATUS}'                " ;
		$_SQL .= ", ORDER_SEQ       = '{$_ORDER_SEQ}'                  " ;
		$_SQL .= ", MENU_DEPTH      = '{$_MENU_DEPTH}'                 " ;
		$_SQL .= ", MENU_ID         = '{$_MENU_ID}'                    " ;
		$_SQL .= ", MENU_URL        = '{$_MENU_URL}'                   " ;
		$_SQL .= ", MENU_NAME       = '{$_MENU_NAME}'                  " ;

		$db->exec_sql($_SQL) ;

	}else{

		$_MENU_CODE    = "S".str_pad(rand(0,9999), 4, "0", STR_PAD_LEFT) ;
		$_PARENT_CODE  = trim($_POST['PARENT_CODE'])                     ;
		$_MENU_STATUS  = $_POST['MENU_STATUS']                           ;
		$_ORDER_SEQ    = $_POST['ORDER_SEQ']                             ;
		$_MENU_DEPTH   = $_POST['MENU_DEPTH']                            ;
		$_MENU_ID      = ChkEscape($_POST['MENU_ID'])                   ;
		$_MENU_URL     = ChkEscape($_POST['MENU_URL'])                  ;
		$_MENU_NAME    = ChkEscape($_POST['MENU_NAME'])                 ;


		$_SQL  = "INSERT INTO {$MENU_TB} SET                           " ;
		$_SQL .= "  MENU_CODE       = '{$_MENU_CODE}'                  " ;
		$_SQL .= ", PARENT_CODE     = '{$_PARENT_CODE}'                " ;
		$_SQL .= ", MENU_STATUS     = '{$_MENU_STATUS}'                " ;
		$_SQL .= ", ORDER_SEQ       = '{$_ORDER_SEQ}'                  " ;
		$_SQL .= ", MENU_DEPTH      = '{$_MENU_DEPTH}'                 " ;
		$_SQL .= ", MENU_ID         = '{$_MENU_ID}'                    " ;
		$_SQL .= ", MENU_URL        = '{$_MENU_URL}'                   " ;
		$_SQL .= ", MENU_NAME       = '{$_MENU_NAME}'                  " ;

		$db->exec_sql($_SQL) ;

	}

	alert_js("parent_opener_reload","메뉴정보를 등록하였습니다.","");
	alert_js("alert_parent_reload","메뉴정보를 등록하였습니다.","");
	exit;



##### 메뉴 수정
} else if ($Mode=="up_menu") {

	if(isNull($_POST['MENU_CODE'])){
		alert_js('alert_','옳바르지 않은 정보입니다.','');
		exit;
	}

	$_MENU_CODE    = $_POST['MENU_CODE']               ;
	$_PARENT_CODE  = trim($_POST['PARENT_CODE'])       ;
	$_MENU_STATUS  = $_POST['MENU_STATUS']             ;
	$_ORDER_SEQ    = $_POST['ORDER_SEQ']               ;
	$_MENU_DEPTH   = $_POST['MENU_DEPTH']              ;
	$_MENU_ID      = ChkEscape($_POST['MENU_ID'])     ;
	$_MENU_URL     = ChkEscape($_POST['MENU_URL'])    ;
	$_MENU_NAME    = ChkEscape($_POST['MENU_NAME'])   ;


	$_SQL  = "UPDATE {$MENU_TB} SET                  " ;
	$_SQL .= "  MENU_STATUS     = '{$_MENU_STATUS}'  " ;
	$_SQL .= ", PARENT_CODE     = '{$_PARENT_CODE}'  " ;
	$_SQL .= ", ORDER_SEQ       = '{$_ORDER_SEQ}'    " ;
	$_SQL .= ", MENU_DEPTH      = '{$_MENU_DEPTH}'   " ;
	$_SQL .= ", MENU_ID         = '{$_MENU_ID}'      " ;
	$_SQL .= ", MENU_URL        = '{$_MENU_URL}'     " ;
	$_SQL .= ", MENU_NAME       = '{$_MENU_NAME}'    " ;
	$_SQL .= "  WHERE MENU_CODE = '{$_MENU_CODE}'    " ;

	$db->exec_sql($_SQL) ;

	alert_js("parent_opener_reload","메뉴정보를 수정하였습니다.","");
	alert_js("alert_parent_reload","메뉴정보를 수정하였습니다.","");
	exit;
	exit;



##### 메뉴 삭제
} else if ($Mode=="del_menu") {

	if(isNull($_GET["MENU_CODE"])){
		alert_js("alert_parent_reload","옳바르지 않은 정보입니다.","");
		exit;
	}

	$_sql = "DELETE FROM {$MENU_TB} WHERE MENU_CODE='{$_GET["MENU_CODE"]}' " ;
	$db->exec_sql($_sql) ;

	alert_js("alert_parent_reload","메뉴정보를 삭제하였습니다.","");
	exit;



}else if($Mode=="id_find"){

	$_admin_id = $_REQUEST["admin_id"];

	$_sql = "SELECT count(*) FROM {$ADMIN_TB} WHERE admin_id='{$_admin_id}'";
	$_res = $db->exec_sql($_sql) ;
	$_row = $db->sql_fetch_row($_res) ;

	if($_row[0] > 0){
		echo "<script language='javascript'>\n";
		echo "alert (\"이미 사용중인 아이디 입니다. 다시 입력해 주세요!\");";
		echo "parent.document.getElementById(\"chk_id\").value = '';";
		echo "parent.document.getElementById(\"admin_id\").value = '';";
		echo "parent.document.getElementById(\"admin_id\").focus();";
		echo "</script>\n";
	}else{
		echo "<script language='javascript'>\n";
		echo "alert (\"사용이 가능한 아이디 입니다.\");";
		echo "parent.document.getElementById(\"chk_id\").value = '{$_admin_id}';";
		echo "parent.document.getElementById(\"admin_name\").focus();";
		echo "</script>\n";
	}




}else if($Mode=="admin_add"){

	if(isNull($_POST["chk_id"])){
		alert_js("alert","아이디 정보가 올바르지 않습니다.","") ;
		exit;
	}

	$_admin_name   = ChkEscape($_POST["admin_name"]) ;
	$_admin_pass   = ChkEscape($_POST["admin_pass"]) ;
	$_admin_phone  = $_POST["Phone1"]."-".$_POST["Phone2"]."-".$_POST["Phone3"] ;
	$_admin_mobile = $_POST["Mobile1"]."-".$_POST["Mobile2"]."-".$_POST["Mobile3"] ;
	$_admin_email  = $_POST["emailID"]."@".$_POST["emailDomain"] ;

	$_admin_id     = $_POST["chk_id"] ;

	$_MENU_CODE = "" ;
	$_number       = sizeof($_POST['MENU_CODE']);
	for($_i=0;$_i<$_number;$_i++){

		$_sql1  = " INSERT INTO {$MENU_CON_TB} SET               " ;
		$_sql1 .= " MENU_CODE     = '{$_POST['MENU_CODE'][$_i]}' " ;
		$_sql1 .= ",ADMIN_ID      = '{$_admin_id}'               " ;

		$db->exec_sql($_sql1) ;
	}


	$_admin_cmt = ChkEscape($_POST["admin_cmt"]);

	$_sql  = "INSERT INTO {$ADMIN_TB} SET ";
	$_sql .= " ADMIN_STATUS ='Y'" ;
	$_sql .= ",ADMIN_ID     ='{$_admin_id}'" ;
	$_sql .= ",ADMIN_PASS   ='".md5($_admin_pass)."' " ;
	$_sql .= ",ADMIN_NAME   ='{$_admin_name}'" ;
	$_sql .= ",ADMIN_MOBILE ='{$_admin_mobile}'" ;
	$_sql .= ",ADMIN_EMAIL  ='{$_admin_email}'" ;
	$_sql .= ",ADMIN_HIT    =0" ;
	$_sql .= ",ADMIN_DESC   ='{$_admin_cmt}'" ;
	$_sql .= ",REG_DATE     =now()" ;


	$db->exec_sql($_sql) ;

	$_link = "../admin.conf.php?slot=conf&type=admin_list" ;
	alert_js("alert_parent_move","부 운영자를 등록하였습니다.",$_link) ;




}else if($Mode=="admin_modify"){

	if(isNull($_POST["idx"])){
		alert_js("alert","관리자 정보가 올바르지 않습니다.","") ;
		exit;
	}

	$_admin_name   = ChkEscape($_POST["admin_name"]) ;
	if(!isNull($_POST["admin_pass"])){
        $_admin_pass   = md5(ChkEscape($_POST["admin_pass"])) ;
    }
	$_admin_phone  = $_POST["Phone1"]."-".$_POST["Phone2"]."-".$_POST["Phone3"] ;
	$_admin_mobile = $_POST["Mobile1"]."-".$_POST["Mobile2"]."-".$_POST["Mobile3"] ;
	$_admin_email  = $_POST["emailID"]."@".$_POST["emailDomain"] ;
	$_admin_cmt    = ChkEscape($_POST['admin_cmt']) ;
	$_admin_status = $_POST['admin_status'] ;

	$_id_sql = "SELECT * FROM {$ADMIN_TB} WHERE ADMIN_ID = '{$_POST['idx']}' " ;
	$_id_res = $db->exec_sql($_id_sql);
	$_id_row = $db->sql_fetch_array($_id_res);

	$_del_sql = "DELETE FROM {$MENU_CON_TB} WHERE ADMIN_ID = '{$_id_row['ADMIN_ID']}' " ;

	$db->exec_sql($_del_sql);

	$_MENU_CODE = "" ;
	$_number       = sizeof($_POST['MENU_CODE']);
	for($_i=0;$_i<$_number;$_i++){

		$_sql1  = " INSERT INTO {$MENU_CON_TB} SET               " ;
		$_sql1 .= " MENU_CODE     = '{$_POST['MENU_CODE'][$_i]}' " ;
		$_sql1 .= ",ADMIN_ID      = '{$_id_row['ADMIN_ID']}'     " ;

		$db->exec_sql($_sql1) ;

	}

	$_admin_cmt = ChkEscape($_POST["admin_cmt"]);

	$_sql  = "UPDATE {$ADMIN_TB} SET ";
	$_sql .= " ADMIN_STATUS='{$_admin_status}'" ;
    if(!isNull($_POST["admin_pass"])){
        $_sql .= ",ADMIN_PASS='".md5(ChkEscape($_POST["admin_pass"]))."' " ;
    }
	$_sql .= ",ADMIN_NAME='{$_admin_name}'" ;
	$_sql .= ",ADMIN_MOBILE='{$_admin_mobile}'" ;
	$_sql .= ",ADMIN_EMAIL='{$_admin_email}'" ;
	$_sql .= ",ADMIN_DESC ='{$_admin_cmt}'" ;
	$_sql .= " WHERE ADMIN_ID='{$_POST["idx"]}' " ;

	$_res  = $db->exec_sql($_sql) ;

	alert_js("alert_parent_reload","부 운영자 정보를 수정하였습니다.","") ;


}else if($Mode=="admin_delete"){

	if(isNull($_GET["admin_id"])){
		alert_js("alert","관리자 정보가 올바르지 않습니다.","") ;
		exit;
	}

	$_id_sql = "SELECT * FROM {$ADMIN_TB} WHERE ADMIN_ID = '{$_GET['admin_id']}' " ;
	$_id_res = $db->exec_sql($_id_sql);
	$_id_row = $db->sql_fetch_array($_id_res);

	$_sql  = "DELETE FROM {$ADMIN_TB} WHERE ADMIN_ID='{$_GET["admin_id"]}'       " ;
	$_sql1 = "DELETE FROM {$MENU_CON_TB} WHERE ADMIN_ID='{$_GET["admin_id"]}'    " ;

	$db->exec_sql($_sql) ;
	$db->exec_sql($_sql1);

	alert_js("alert_parent_reload","부 운영자 정보를 삭제하였습니다.","") ;




}else if($Mode == "up_transfer_price"){
	if(isNull($_POST['idx'])){
		alert_js('alert_','올바르지 않은 정보입니다','');
		exit;
	}

	$_idx = $_POST['idx'] ;
	$_total_price = uncomma($_POST['total_price']) ;
	$_sell_price = uncomma($_POST['sell_price']) ;
	$_contents   = ChkEscape($_POST['contents']) ;

	$_sql = "UPDATE {$T_PRICE_TB} SET " ;
	$_sql .= "total_price = '{$_total_price}' " ;
	$_sql .= ", sell_price = '{$_sell_price}' " ;
	$_sql .= ", contents = '{$_contents}' " ;
	$_sql .= " WHERE idx = '{$_idx}' " ;

	$db->exec_sql($_sql) ;

	alert_js('alert_parent_reload','배송비정책을 변경하였습니다','');
	exit;


	/* 계좌정보 */
} else if ($Mode=="add_bank") {

	$_bank_status    = $_POST["bank_status"] ;
	$_line_up        = $_POST["line_up"] ;
	$_bank_code      = $_POST["bank_code"] ;
	$_account_number = ChkEscape($_POST["account_number"]) ;
	$_account_name   = ChkEscape($_POST["account_name"]) ;

	$_sql  = "INSERT INTO {$BANK_TB} SET        " ;
	$_sql .= "  bank_status = '{$_bank_status}' " ;
	$_sql .= ", line_up     = '{$_line_up}'     " ;
	$_sql .= ", bank_code       = '{$_bank_code}'      " ;
	$_sql .= ", account_number  = '{$_account_number}' " ;
	$_sql .= ", account_name    = '{$_account_name}'   " ;
	$_sql .= ", reg_date        = now()                " ;

	$db->exec_sql($_sql) ;

	alert_js("parent_opener_reload","거래은행 정보를 입력하였습니다.","");
	alert_js("alert_parent_reload","거래은행 정보를 입력하였습니다.","");
	exit;



##### 은행정보 수정
} else if ($Mode=="up_bank") {

	$_idx            = $_POST["idx"] ;
	$_bank_status    = $_POST["bank_status"] ;
	$_line_up        = $_POST["line_up"] ;
	$_bank_code      = $_POST["bank_code"] ;
	$_account_number = ChkEscape($_POST["account_number"]) ;
	$_account_name   = ChkEscape($_POST["account_name"]) ;

	$_sql  = "UPDATE {$BANK_TB} SET             " ;
	$_sql .= "  bank_status = '{$_bank_status}' " ;
	$_sql .= ", line_up     = '{$_line_up}'     " ;
	$_sql .= ", bank_code       = '{$_bank_code}'      " ;
	$_sql .= ", account_number  = '{$_account_number}' " ;
	$_sql .= ", account_name    = '{$_account_name}'   " ;
	$_sql .= " WHERE idx        = '{$_idx}'            " ;

	$db->exec_sql($_sql) ;

	alert_js("parent_opener_reload","거래은행 정보를 수정하였습니다.","");
	alert_js("alert_parent_reload","거래은행 정보를 수정하였습니다.","");
	exit;



##### 은행정보 삭제
} else if ($Mode=="del_bank") {

	if(isNull($_GET["idx"])){
		alert_js("alert_parent_reload","은행정보 정보가 올바르지 않습니다.","");
		exit;
	}

	$_sql = "DELETE FROM {$BANK_TB} WHERE idx='{$_GET["idx"]}' " ;	
	$db->exec_sql($_sql) ;

	alert_js("alert_parent_reload","은행정보 정보를 삭제하였습니다.","");
	exit;




}else if($Mode == "update_ip"){


	if(isNull($_POST['user_id'])){
		alert_js('alert_','올바르지 않은 정보입니다.','') ;
		exit ;
	}
	$_conf_ip   = $_POST['conf_ip'] ;
	$_modify_id = $_POST['user_id'] ;


	$_sql = "UPDATE {$IP_CONF} SET CONF_IP = '{$_conf_ip}', MODIFY_ID = '{$_modify_id}', MODIFY_DATE = now() " ;
	$db->exec_sql($_sql) ;


	alert_js('alert_parent_reload','해당 정보를 수정하였습니다.','') ;
	exit ;



}else if($Mode == "up_conf"){

	$_policy_txt = ChkEscape($_POST['policy_txt']) ;

	$_sql = "UPDATE {$POLICY_TXT} SET policy_txt = '{$_policy_txt}' " ;
	$db->exec_sql($_sql) ;

	alert_js('alert_parent_reload','해당정보를 수정하였습니다.','') ;
	exit ;



}else if($Mode == "modify_about"){


	$_contents = addslashes($_POST['content'])    ;
	$_idx      = $_POST['idx']                    ;

	$_sql  = "UPDATE PPW_ATTACH_CONTENTS SET    " ;
	$_sql .= " CONTENTS    = '{$_contents}'     " ;
	$_sql .= " WHERE IDX   = '{$_idx}'          " ;

	$db->exec_sql($_sql)                          ;


	alert_js("alert_parent_reload","Your Request Success!","") ;
	exit ;




}






$db->db_close();
?>