<?
#****************************************************************************
#  Function : getTotalDays($month,$year)
#  내용     : 해당 년과 달을 가지고 날 수를 구한다
#  반환값   : 해당 년월의 날수
#****************************************************************************
function getTotalDays($month,$year) {
	$date = date("t",mktime(0,0,1,$month,1,$year));
	return $date;
}



#****************************************************************************
#  Function : iconSchedule($tyy,$tmm,$tdd)
#  내용     : 
#  반환값   : 
#****************************************************************************
function iconSchedule($tyy,$tmm,$tdd) {
	global $SCHEDULE_TABLE ;

	$SQL    = "SELECT count(idx)    ";
	$QUERY  = "FROM ".$SCHEDULE_TABLE." st " ;
	$QUERY .= "WHERE " ;
	$QUERY .= "LEFT(st.dateKey,8)='".$tyy.$tmm.$tdd."'  " ;
	$QUERY .= "order by dateKey  " ;

	$innerHTML = "" ;

	$RES = sql_query($SQL.$QUERY) ;
	$ROW = sql_fetch_row($RES) ;

	if($ROW[0] > 0){
		
		$innerHTML = "<a onClick=\"chgRightList('".$tyy."','".$tmm."','".$tdd."')\" style='cursor:pointer;'><img src='./img/icon/icon_s.gif' align='absmiddle'></a>" ;

	}

	echo $innerHTML ;

}



#****************************************************************************
#  Function : drawSchedule($tyy,$tmm,$tdd,$sessID)
#  내용     : 
#  반환값   : 
#****************************************************************************
function drawSchedule($tyy,$tmm,$tdd,$sessID) {
	global $SCHEDULE_TABLE ;

	$SQL    = "SELECT count(idx)    ";
	$QUERY  = "FROM ".$SCHEDULE_TABLE." st " ;
	$QUERY .= "WHERE " ;
	$QUERY .= "LEFT(st.dateKey,8)='".$tyy.$tmm.$tdd."'  " ;
	$QUERY .= "order by dateKey  " ;

	$innerHTML = "" ;

	$RES = sql_query($SQL.$QUERY) ;
	$ROW = sql_fetch_row($RES) ;

	if($ROW[0] > 0){
		
		$SQL  = "SELECT st.idx  " ;
		$SQL .= ",st.dateKey    " ;
		$SQL .= ",st.sTitle     " ;
		$SQL .= ",st.userID     " ;
		$RES = sql_query($SQL.$QUERY) ;

		$innerHTML = "<table width='90' border='0' cellspacing='0' cellpadding='0'>" ;

		while($ROW = sql_fetch_array($RES)){

			$sHour  = substr($ROW["dateKey"],-2);
			if ($ROW["userID"] == $sessID ){
				$Title = "<a href=\"javascript:scheduleView('".$ROW["idx"]."','".$ROW["userID"]."','./')\" style=\"cursor:pointer;\"><font color='blue'>".cutText($ROW["sTitle"],6)."</font></a>" ;
			}else{
				$Title = "<a href=\"javascript:scheduleView('".$ROW["idx"]."','".$ROW["userID"]."','./')\" style=\"cursor:pointer;\">".cutText($ROW["sTitle"],6)."</a>" ;
			}
			
			$innerHTML .= "<tr><td style='padding-left:1;'><img src='./img/icon/icon_03.gif' align='absmiddle'> ".$sHour.") ".$Title."</td></tr>" ;

		}

		$innerHTML .= "</table>" ;

	}else{

		$innerHTML = "<table width='90' border='0' cellspacing='0' cellpadding='0'>
										<tr>
											<td>&nbsp;</td>
										</tr>
									</table>" ;

	}

	echo $innerHTML ;

}
?>