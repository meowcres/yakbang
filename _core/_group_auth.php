<?
if(!isNull($_SESSION["s_idx"])){
	$_GROUP = array();

	$_group_sql = "SELECT group_code, is_admin FROM {$GROUP_TB} WHERE user_id='{$_SESSION["s_id"]}'" ;
	$_group_res = $db->exec_sql($_group_sql) ;

	$__g = 0 ;
	while($_group_row = $db->sql_fetch_array($_group_res)){

		$_GROUP[$__g][0] = $_group_row["group_code"] ;
		$_GROUP[$__g][1] = $_group_row["is_admin"] ;

		$__g++ ;
	}
}
?>