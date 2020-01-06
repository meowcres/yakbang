<?
#****************************************************************************
#  Function : registerSession($user_type,$user_id)
#  내용     : 
#  반환값   : 세션
#****************************************************************************
function registerSession($user_type,$user_id){
	global $db ;
	global $MEMBER_TB ;
	global $MEMBER_INFO_TB ;

	// 아이디 확인
	$_sql  = "SELECT * FROM {$MEMBER_TB} t1 " ;
	$_sql .= "LEFT JOIN {$MEMBER_INFO_TB} t2 ON (t1.idx=t2.user_idx) " ;
	$_sql .= "WHERE t1.userType='{$user_type}' " ;
	$_sql .= "AND t1.userID='{$user_id}'" ;

	$_res = $db->exec_sql($_sql) ;
	$_row = $db->sql_fetch_array($_res) ;

	session_unset();
	session_register("s_idx","s_id","s_name","s_type","s_icon","s_picture","s_hp","s_email","s_alert","s_letter","s_info") ;

	$s_idx     = $_row["idx"];
	$s_id      = $_row["userID"];
	$s_name    = $_row["userName"];
	$s_type    = $_row["userType"];

	$s_icon    = $_row["user_icon"];
	$s_picture = $_row["user_picture"];
	$s_hp      = $_row["user_hp"];
	$s_email   = $_row["user_email"];

	$s_alert   = $_row["sms_alert_YN"];
	$s_letter  = $_row["sms_letter_YN"];
	$s_info    = $_row["sms_info_YN"];
}


#****************************************************************************
#  Function : registerLogData($user_type,$user_id)
#  내용     : 회원 로그인 카운터 증가 및 로그 기록
#  반환값   : 
#****************************************************************************
function registerLogData($user_type,$user_id){
	global $db ;
	global $MEMBER_TB ;
	global $LOG_MEMBER_TB ;

	$log_ip = getenv("REMOTE_ADDR") ;

	$_sql1  = "UPDATE {$MEMBER_TB} SET login_number = login_number + 1, last_logDate = now() WHERE user_type='{$user_type}' and user_id='{$user_id}'" ;
	
	$_sql2  = "INSERT INTO {$LOG_MEMBER_TB} SET ";
	$_sql2 .= "  user_type = '{$user_type}' ";
	$_sql2 .= ", user_id   = '{$user_id}'   ";
	$_sql2 .= ", log_ip    = '{$log_ip}'    ";
	$_sql2 .= ", log_date  = now()          ";

	$db->exec_sql($_sql1);
	$db->exec_sql($_sql2);
}


#****************************************************************************
#  Function : penaltyChecker($num)
#  내용     : 
#  반환값   : 
#****************************************************************************
function penaltyChecker($num=0)
{
	global $db ;
	global $PENALTY_TB ;

	$_sql = "SELECT p_number FROM {$PENALTY_TB} WHERE idx='4'";
	$_res = $db->exec_sql($_sql) ;
	$_row = $db->sql_fetch_row($_res) ;

	if($num <= $_row[0]){
		session_destroy();
		return true;
	}else{
		return false;
	}

}


#****************************************************************************
#  Function : getUserIcon($user_idx)
#  내용     : 회원 아이콘 반환
#  반환값   : 
#****************************************************************************
function getUserIcon($user_idx=0)
{
	global $db ;
	global $MEMBER_TB ;
	global $MEMBER_INFO_TB ;
	global $MEMBER_TB ;
	global $MEMBER_ICON_TB ;
	global $IMG_MEMBER_ICON ;

	$_sql  = "SELECT t1.userType,t2.user_sex FROM {$MEMBER_TB} t1 ";
	$_sql .= "LEFT JOIN {$MEMBER_INFO_TB} t2 ON (t1.idx = t2.user_idx) " ;
	$_sql .= "WHERE t1.idx='{$user_idx}'" ;

	$_res  = $db->exec_sql($_sql) ;
	$_row  = $db->sql_fetch_row($_res) ;

	$_field_name = $_row[0]."_".$_row[1]."_icon" ;

	$_sql = "SELECT {$_field_name} FROM {$MEMBER_ICON_TB}" ;
	$_res = @$db->exec_sql($_sql);
	$_row = @$db->sql_fetch_row($_res) ;

	if(!isNull($_row[0])){
		$_userIcon = "<img src='".$IMG_MEMBER_ICON.$_row[0]."' width='15' height='15' align='absmiddle' alt='icon' />" ;
	}else{
		$_userIcon = "" ;
	}

	return $_userIcon ;

}


#****************************************************************************
#  Function : registerMemberStatus($user_idx)
#  내용     : 회원 로그인 상태 기록
#  반환값   : 
#****************************************************************************
function registerMemberStatus($user_idx){
	global $db ;
	global $MEMBER_STATUS_TB ;

	$_sql  = "DELETE FROM {$MEMBER_STATUS_TB} WHERE log_date < DATE_SUB(now(), INTERVAL 6 HOUR)" ;
	@$db->exec_sql($_sql);

	$_sql1 = "SELECT log_date FROM {$MEMBER_STATUS_TB} WHERE user_idx='{$user_idx}'" ;
	$_res1 = $db->exec_sql($_sql1);
	$_row1 = $db->sql_fetch_row($_res1);

	if(isNull($_row1[0])){
		$_sql2  = "INSERT INTO {$MEMBER_STATUS_TB} SET ";
		$_sql2 .= " user_idx='{$user_idx}' ";
		$_sql2 .= ",log_date=now() ";
	}else{
		$_sql2  = "UPDATE {$MEMBER_STATUS_TB} SET  ";
		$_sql2 .= "log_date=now()  ";
		$_sql2 .= "WHERE user_idx='{$user_idx}'  ";
	}

	@$db->exec_sql($_sql2);
}


#****************************************************************************
#  Function : cleanMemberStatus($user_idx)
#  내용     : 회원 로그인 상태 삭제
#  반환값   : 
#****************************************************************************
function cleanMemberStatus($user_idx){
	global $db ;
	global $MEMBER_STATUS_TB ;

	$_sql = "DELETE FROM {$MEMBER_STATUS_TB} WHERE user_idx='{$user_idx}'" ;
	@$db->exec_sql($_sql);
	
}


#****************************************************************************
#  Function : log_status($user_idx)
#  내용     : 로그인 상태 유지
#  반환값   : 
#****************************************************************************
function log_status($user_idx){
	global $db ;
	global $MEMBER_STATUS_TB ;

	$_sql = "UPDATE {$MEMBER_STATUS_TB} SET log_date=now() WHERE user_idx='{$user_idx}'";
	@$db->exec_sql($_sql) ;
	
}


#****************************************************************************
#  Function : chk_ban_id($_user_id)
#  내용     : 금지된 아이디 체크
#  반환값   : 
#****************************************************************************
function chk_ban_id($_user_id){

	global $db ;
	global $BAN_WORD_TB ;
	
	$_sql = "SELECT * FROM {$BAN_WORD_TB}" ;
	$_res = $db->exec_sql($_sql);
	$_row = $db->sql_fetch_array($_res);

	$_banID = explode(",",$_row["ban_id"]) ;
	$_size  = sizeof($_banID);

	for($i=0;$i<=$_size;$i++){
		if($_user_id == $_banID[$i]){
			return false ;
			break;
		}
	}

	return true ;

}


#****************************************************************************
#  Function : site_sendMail($_user_email,$_user_id,$_user_name,$_type)
#  내용     : 메일전송
#  반환값   : 
#****************************************************************************
function site_sendMail($_user_email,$_user_id,$_user_name,$_type)
{
	global $db ;
	global $EMAIL_CONFIG ;
	global $CONFIG_TB ;

	$_c_sql = "SELECT site_name,site_domain FROM {$CONFIG_TB}" ;
	$_c_res = $db->exec_sql($_c_sql);
	$_cfg   = $db->sql_fetch_array($_c_res);

	$_mailling_tag = "
	<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.0 Transitional//EN'>
	<html>
	<head>
	<meta http-equiv='Content-type' content='text/html; charset=ecu-kr' />
	<meta http-equiv='imagetoolbar' content='no' />
	<title>".$_cfg["site_name"]."</title>
	<link rel='stylesheet' href='http://".$_cfg["site_domain"]."/css/css_basic.css' type='text/css'>
	</head>

	<body topmargin='0' leftmargin='0'>
	<table width='100%' border='0' cellspacing='0' cellpadding='0'  bordercolorlight='#939393' bordercolordark='#FFFFFF'>
		<tr>
			<td valign='top' style='padding:30px;'>
				<table width='{{w_size}}' border='0' cellspacing='0' cellpadding='0' background='http://".$_cfg["site_domain"]."/_core/_files/email/{{back_img}}' style='background-repeat:no-repeat;'>
					<tr>
						<td width='{{w_size}}' height='{{h_size}}' style='padding:30px;' valign='top'>{{email_cmt}}</td>
					</tr>
					{{email_footer}}
				</table>
			</td>
		</tr>
	</table>
	</body>
	</html>" ;

	$_sql = "SELECT * FROM {$EMAIL_CONFIG} ";
	$_res = $db->exec_sql($_sql);
	$_row = $db->sql_fetch_array($_res);

	if($_type == "register"){

		if($_row["r_chk"] == "Y"){

			// 메일 제목
			$_email_title = str_replace("{{수신자}}",$_user_name,$_row["r_title"]);

			// 메일 내용
			$_email_cmt   = str_replace("{{수신자}}",$_user_name,$_row["r_cmt"]);
			$_email_cmt   = str_replace("{{아이디}}",$_user_id,$_row["r_cmt"]);
			$_email_cmt   = nl2br(stripslashes($_email_cmt)) ;

			// 전송 메일 하단 설정
			if(!isNull($_row["r_footer"])){
				$_email_footer = "<tr><td align='center' style='padding:5px;' bgcolor='#F7FAF5'>".nl2br(stripslashes($_row["r_footer"]))."</td></tr>";
				$_email_footer = str_replace("{{today}}",date("Y-m-d H:i:s"),$_email_footer);
			}else{
				$_email_footer = "";
			}

			$_mailling_tag = str_replace("{{w_size}}",$_row["r_width"],$_mailling_tag);
			$_mailling_tag = str_replace("{{h_size}}",$_row["r_height"],$_mailling_tag);
			$_mailling_tag = str_replace("{{back_img}}",$_row["r_back_img"],$_mailling_tag);
			$_mailling_tag = str_replace("{{email_cmt}}",$_email_cmt,$_mailling_tag);
			$_mailling_tag = str_replace("{{email_footer}}",$_email_footer,$_mailling_tag);

			SendMail($_user_email,$_row["admin_email"],$_row["admin_name"],addslashes($_email_title),$_mailling_tag,'');
		}

	}else if($_type == "secession"){

		if($_row["d_chk"] == "Y"){

			// 메일 제목
			$_email_title = str_replace("{{수신자}}",$_user_name,$_row["d_title"]);

			// 메일 내용
			$_email_cmt   = str_replace("{{수신자}}",$_user_name,$_row["d_cmt"]);
			$_email_cmt   = str_replace("{{아이디}}",$_user_id,$_row["d_cmt"]);
			$_email_cmt   = nl2br(stripslashes($_email_cmt)) ;

			// 전송 메일 하단 설정
			if(!isNull($_row["d_footer"])){
				$_email_footer = "<tr><td align='center' style='padding:5px;' bgcolor='#F7FAF5'>".nl2br(stripslashes($_row["d_footer"]))."</td></tr>";
				$_email_footer = str_replace("{{today}}",date("Y-m-d H:i:s"),$_email_footer);
			}else{
				$_email_footer = "";
			}

			$_mailling_tag = str_replace("{{w_size}}",$_row["d_width"],$_mailling_tag);
			$_mailling_tag = str_replace("{{h_size}}",$_row["d_height"],$_mailling_tag);
			$_mailling_tag = str_replace("{{back_img}}",$_row["d_back_img"],$_mailling_tag);
			$_mailling_tag = str_replace("{{email_cmt}}",$_email_cmt,$_mailling_tag);
			$_mailling_tag = str_replace("{{email_footer}}",$_email_footer,$_mailling_tag);

			SendMail($_user_email,$_row["admin_email"],$_row["admin_name"],addslashes($_email_title),$_mailling_tag,'');

		}

	}

}
?>