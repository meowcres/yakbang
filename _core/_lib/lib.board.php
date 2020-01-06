<?
#****************************************************************************
#
# ���ϸ�        : lib.board.php
# �����ۼ���    : 2009-02-27
# ���          : �⺻ �Լ� �� Ŭ���� ���̺귯��
#
#****************************************************************************
#****************************************************************************
#  Function : getMaxGroupIDX($_bd)
#  ����     : �Խù� ��ȣ �׷� ��ȯ
#  ��ȯ��   : �Խù� �׷��ȣ
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
#  ����     : �Խù� ��ۼ��� ��ȯ
#  ��ȯ��   : �Խù� ��ۼ���
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
#  ����     : �̹��� ���� ������ ��ȯ
#  ��ȯ��   : �̹��� �±�
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
#  ����     : �Խ��� ���� ī���� +1 ����
#  ��ȯ��   : 
#****************************************************************************
function add_view_counter($bd,$idx) 
{
	global $db ;
	
	$_sql = "UPDATE {$bd} SET bd_hit = bd_hit + 1 WHERE idx='{$idx}'";
	@$db->exec_sql($_sql);
}


#****************************************************************************
#  Function : auth_grade($_user_grade,$_board_grade)
#  ����     : �۾��� ���� Ȯ��
#  ��ȯ��   : 
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