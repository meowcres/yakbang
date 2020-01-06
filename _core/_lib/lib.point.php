<?
#****************************************************************************
#  Function : point_process(사용자idx,사용포인트,증감,서비스타입,메세지)
#  내용     : 
#  반환값   : 
#****************************************************************************
function point_process($user_idx,$point,$op,$s_type,$msg){

	global $db ;
	global $LOG_POINT_TB ;
	global $MEMBER_TB ;
	
	$_sql  = "INSERT INTO {$LOG_POINT_TB} SET " ;
	$_sql .= " use_type     = '{$op}' " ;
	$_sql .= ",service_type = '{$s_type}' " ;
	$_sql .= ",service_cmt  = '{$msg}' " ;
	$_sql .= ",use_point    = '{$point}' " ;
	$_sql .= ",user_idx     = '{$user_idx}' " ;
	$_sql .= ",regDate      = now() " ;

	@$db->exec_sql($_sql);

	$_usql  = "UPDATE {$MEMBER_TB} SET " ;
	$_usql  = $op == "plus" ? $_usql." user_point = user_point + {$point} " : $_usql." user_point = user_point - {$point} " ;
	$_usql .= "WHERE idx = '{$user_idx}'" ;

	@$db->exec_sql($_usql);
	
}
?>