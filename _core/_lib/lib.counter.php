<?
$referer=$HTTP_REFERER;

function getOsName()
{
	global $HTTP_USER_AGENT,$OsSet1;

	$Agent = $HTTP_USER_AGENT;
	$OsNum = sizeof($OsSet1);

	for ($i = 0; $i < $OsNum; $i++)
	{
		if ($OsSet1[$i] == 'Windows')
		{
			return getOsVersion($Agent);
		}else {
			if (stristr($Agent,$OsSet1[$i])) return $i+5;
		}
	}
	return 0;
}

function getOsVersion($agent)
{
	$agent_exp = explode('Windows ', $agent);
	if (strstr($agent_exp[1] , 'NT 5.1')) return 1;
	if (strstr($agent_exp[1] , 'NT 5.0')) return 2;
	if (strstr($agent_exp[1] , 'ME'    )) return 3;
	if (strstr($agent_exp[1] , 'NT 4'  )) return 4;
	if (strstr($agent_exp[1] , '98'    )) return 5;
	if (strstr($agent_exp[1] , '95'    )) return 5;
	return 5;
}

function getBrowserName()
{
	global $HTTP_USER_AGENT,$BrSet1;

	$Agent = $HTTP_USER_AGENT;
	$BrNum = sizeof($BrSet1);

	for ($i = $BrNum-1; $i >= 0; $i--)
	{
		if ($BrSet1[$i] != 'MSIE')
		{
			if ($BrSet1[$i] == 'GEC')
			{
				if (stristr($Agent,'NETSCAPE')) return $i+3;
				if (stristr($Agent,'GEC')) return $i+5;
			}else {
				if (stristr($Agent,$BrSet1[$i])) return $i+5;
			}
		}else {
			return getBrowserVersion($Agent);
		}
	}
	return 0;
}

function getBrowserVersion($agent)
{
	$agent_exp = explode('MSIE ', $agent);
	if (strstr($agent_exp[1] , '7.' )) return 1;
	if (strstr($agent_exp[1] , '6.' )) return 2;
	if (strstr($agent_exp[1] , '5.5')) return 3;
	if (strstr($agent_exp[1] , '5.' )) return 4;
	if (strstr($agent_exp[1] , '4.' )) return 5;
	return 0;
}

function getDomain($url)
{
	global $ENSET;
	$url_exp = explode('/' , $url);
	$eng_num = sizeof($ENSET);

	for ($i = 1; $i < $eng_num; $i++)
	{
		$eng_exp = explode(',' , $ENSET[$i]);
		$ser_exp = explode('.' , $eng_exp[1]);
		if (strstr($url_exp[2] , $ser_exp[0])) return $i;
	}
	return 0;
}

function getDomain1($url)
{
	global $ENSET;
	$url_exp = explode('/' , $url);
	$eng_num = sizeof($ENSET);

	for ($i = 1; $i < $eng_num; $i++)
	{
		$eng_exp = explode(',' , $ENSET[$i]);
		$ser_exp = explode('.' , $eng_exp[1]);
		if (strstr($url_exp[2] , $ser_exp[0])) return $eng_exp[1];
	}
	return '';
}

function getKeyword($url , $engine)
{
	global $ENSET;
	if (!$engine)
	{
		$url_exp = explode('?' , urldecode($url));
		if (!trim($url_exp[1])) return '';
		$que_exp = explode('&' , $url_exp[1]);
		$que_num = sizeof($que_exp);
		for ($i = 0; $i < $que_num; $i++)
		{
			$val_exp = explode('=' , $que_exp[$i]);
			if ($val_exp[1] > "z") return $val_exp[1];
		}
		return '';
	}

	$this_Que= explode(',' , $ENSET[$engine]);
	$url_exp = explode($this_Que[2].'=' , $url);
	$key_exp = explode('&' , $url_exp[1]);

	return urldecode($key_exp[0]);
}


function getLanguage($lang)
{
	if(stristr($lang,'ko')) return 0;
	if(stristr($lang,'en')) return 1;
	if(stristr($lang,'ja')) return 2;
	if(stristr($lang,'zh')) return 3;
	if(stristr($lang,'fr')) return 4;
	if(stristr($lang,'de')) return 5;
	if(stristr($lang,'es')) return 6;
	if(stristr($lang,'it')) return 7;
	return 8;
}

$OsSet1    = array("Windows","Linux","Mac","Irix","Sunos","Phone");
$BrSet1    = array("MSIE","NETSCAPE","OPERA","GEC","FIREFOX");

$today_date= date("Ymd");
$RFIP      = $REMOTE_ADDR;
$RFID      = '';
$RFREFERER = $referer;
$RFSEARCH  = getDomain($referer);

$RFENGINE  = getDomain1($referer);
$RFKEYWORD = getKeyword($referer , $RFSEARCH);
$RFOS      = getOsName();
$RFLANG    = getLanguage($HTTP_ACCEPT_LANGUAGE);
$RFAGENT   = getBrowserName();
$RFDATE    = $today_date.date("His");
$CT_WEEK   = date("w");

$_sql  = "INSERT INTO {$REFERER_TB} SET ";
$_sql .= " visit_ip = '{$RFIP}' "; 
$_sql .= ",visit_id = '{$RFID}' "; 
$_sql .= ",visit_referer = '{$RFREFERER}' "; 
$_sql .= ",visit_search  = '{$RFSEARCH}' "; 
$_sql .= ",visit_keyword = '{$RFKEYWORD}' "; 
$_sql .= ",visit_os = '{$RFOS}' "; 
$_sql .= ",visit_agent = '{$RFAGENT}' "; 
$_sql .= ",visit_lang  = '{$RFLANG}' "; 
$_sql .= ",regDate  = '{$RFDATE}' "; 

@$db->exec_sql($_sql) ;

$_sql = "SELECT COUNT(idx) FROM {$COUNT_TB} WHERE regDate='{$today_date}'";
$_res = $db->exec_sql($_sql);
$_row = $db->sql_fetch_row($_res);

if($_row[0] > 0) {
	$_sql = "UPDATE {$COUNT_TB} SET visit_count = visit_count + 1 WHERE regDate = '{$today_date}'";
	@$db->exec_sql($_sql);
}else {
	$_sql  = "INSERT INTO {$COUNT_TB} SET    " ;
	$_sql .= " visit_count = 1 " ;
	$_sql .= ",regDate     = '{$today_date}' " ;
	$_sql .= ",week_day    = '{$CT_WEEK}'    " ;
	@$db->exec_sql($_sql);
}

unset($referer);
unset($_sql);
unset($_res);
unset($_row);
?>