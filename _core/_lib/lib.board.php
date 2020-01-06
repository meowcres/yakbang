<?
#****************************************************************************
#
# 파일명        : lib.board.php
# 최초작성일    : 2009-02-27
# 비고          : 기본 함수 및 클래스 라이브러리
#
#****************************************************************************
#****************************************************************************
#  Function : getMaxGroupIDX($_bd)
#  내용     : 게시물 번호 그룹 반환
#  반환값   : 게시물 그룹번호
#****************************************************************************
function getMaxGroupIDX($_bd)
{
	global $db ;

	$_sql = "SELECT max(group_idx) FROM {$_bd} " ;
	$_res = $db->exec_sql($_sql);
	$_row = $db->sql_fetch_row($_res);

	$max  = $_row[0] > 0 ? $_row[0] + 1 : 1 ;

	return $max ;
}


#****************************************************************************
#  Function : getThread($_bd,$_group_idx,$_thread)
#  내용     : 게시물 답글순위 반환
#  반환값   : 게시물 답글순위
#****************************************************************************
function getThread($_bd,$_group_idx,$_thread)
{
	global $db ;

	$_sql  = "SELECT thread, right(thread,1) FROM {$_bd} " ;
	$_sql .= "WHERE group_idx = '{$_group_idx}' ";
	$_sql .= "AND length(thread) = length('{$_thread}')+1 ";
	$_sql .= "AND locate('{$_thread}',thread) = 1 order by thread DESC LIMIT 1" ;

	//echo $_sql ;
	//exit;

	$_res  = $db->exec_sql($_sql);
	$_row  = $db->sql_fetch_row($_res);

	if(!isNull($row[0])){
		$thread_head = substr($row[0],0,-1);
		$thread_foot = ++$row[1];
		$new_thread  = $thread_head . $thread_foot;
	}else{
		$new_thread = $_thread . "A";
	}

	return $new_thread ;
}


#****************************************************************************
#  Function : getFileIcon($url,$fileName)
#  내용     : 이미지 파일 아이콘 반환
#  반환값   : 이미지 태그
#****************************************************************************
function getFileIcon($url,$fileName)
{
	$ext = getFileExtension($fileName, true);

	if(is_file($url."/icon_".$ext.".gif")){
		return "<img src='".$url."/icon_".$ext.".gif' align='abmiddle'>" ;
	}else{
		return "<img src='".$url."/icon_default.gif' align='abmiddle'>" ;
	}
	
}


#****************************************************************************
#  Function : add_view_counter($bd,$idx) 
#  내용     : 게시판 보기 카운터 +1 증가
#  반환값   : 
#****************************************************************************
function add_view_counter($bd,$idx) 
{
	global $db ;
	
	$_sql = "UPDATE {$bd} SET bd_hit = bd_hit + 1 WHERE idx='{$idx}'";
	@$db->exec_sql($_sql);
}


#****************************************************************************
#  Function : auth_grade($_user_grade,$_board_grade)
#  내용     : 글쓰기 권한 확인
#  반환값   : 
#****************************************************************************
function auth_grade($_user_grade,$_board_grade)
{
	if($_board_grade == "0"){
		return true ;
	}else{
		if($_board_grade <= $_user_grade)	return true ;
		else															return false ;
	}
}

?>