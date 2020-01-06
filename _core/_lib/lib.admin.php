<?
#****************************************************************************
#  Function : get_admin_login($_admin_id,$_admin_pass)
#  내용     : admin table에 해당 정보가 있는 지 확인
#  반환값   : 존재 : 테이블 정보값 / 미존재 : end
#****************************************************************************
function get_admin_login($_admin_id,$_admin_pass){
	global $db ;
	global $ADMIN_TB ;
	$_vars = array();

	// 아이디 확인
	$_sql  = "SELECT                " ;
	$_sql .= "t1.idx                " ;
	$_sql .= ",t1.admin_id          " ;
	$_sql .= ",t1.admin_pass        " ;
	$_sql .= ",t1.admin_name        " ;
	$_sql .= ",t1.admin_email       " ;
	$_sql .= ",t1.admin_grade       " ;
	$_sql .= "FROM {$ADMIN_TB} t1   " ;
	$_sql .= "WHERE t1.admin_id='{$_admin_id}'  " ;
	$_sql .= "AND t1.admin_status in ('Y')      " ;

	$_res  = $db->exec_sql($_sql) ;
	$_row  = $db->sql_fetch_row($_res) ;

	if(isNull($_row[0])){
		alert_js("alert","일치하는 아이디 정보가 없습니다. \\n\\n다시 확인해 주세요!","");
		exit;
	}

	if($_row[2] == md5($_admin_pass)){

		$_vars["idx"]   = $_row[0] ;
		$_vars["id"]    = $_row[1] ;
		$_vars["pass"]  = $_row[2] ;
		$_vars["name"]  = $_row[3] ;
		$_vars["email"] = $_row[4] ;
		$_vars["grade"] = $_row[5] ;
		
		return $_vars ;
	}else{
		alert_js("alert","비밀번호가 틀립니다. \\n\\n다시 확인해 주세요!","");
		exit;
	}
}


#****************************************************************************
#  Function : add_admin_counter($idx)
#  내용     : 해당 idx 의 로그인 정보값 증가
#  반환값   : 
#****************************************************************************
function add_admin_counter($idx){
	global $db ;
	global $ADMIN_TB ;

	// 정보 변경
	$_sql  = "UPDATE {$ADMIN_TB} t1 SET ";
	$_sql .= "t1.admin_hit = t1.admin_hit + 1, t1.lastDate=now() " ;
	$_sql .= "WHERE t1.idx='{$idx}'" ;

	$db->exec_sql($_sql) ;
}
?>