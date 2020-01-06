<?

$offset     = 20 ;
$page_block = 10 ;
$startNum   = "" ;
$totalnum   = "" ;
$page       = "" ;
$_page      = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"] ;

if(!isNull($_page)){
	$page     = $_page ;
	$startNum = ($page- 1) * $offset ;
}else{
	$page     = 1 ;
	$startNum = 0 ;
}

// 검색 변수
$_search = array();
$_search["status"]     = isNull($_GET["search_status"])   ? $_clean["search_status"]   : $_GET["search_status"]   ;
$_search["large"]      = isNull($_GET["search_large"])    ? $_clean["search_large"]    : $_GET["search_large"]    ;
$_search["middle"]     = isNull($_GET["search_middle"])   ? $_clean["search_middle"]   : $_GET["search_middle"]   ;
$_search["keyword"]    = isNull($_GET["keyword"])         ? $_clean["keyword"]         : $_GET["keyword"]         ;

$_where[]  = " t1.MENU_DEPTH = 3 " ;

// 활동상태
if(!isNull($_search["status"])){
	$_where[] = "t1.MENU_STATUS='{$_search["status"]}'" ;
}
$_status[$_search["status"]] = "selected" ;

// 대분류
if(!isNull($_search["large"])){
	$_where[] = "t2.PARENT_CODE='{$_search["large"]}'" ;
}

// 증분류
if(!isNull($_search["middle"])){
	$_where[] = "t1.PARENT_CODE='{$_search["middle"]}'" ;
}

// 키워드 검색
if(!isNull($_search["keyword"])){
	$_where[] = "instr(t1.MENU_NAME, '{$_search["keyword"]}') >0 ";

}

$_whereqry = count($_where) ? " WHERE ".implode(' AND ',$_where) : "" ;
$_order    = " ORDER BY t1.ORDER_SEQ  " ;
$_limit    = " LIMIT ".$startNum.",".$offset ;

$_sql  = " SELECT           " ;
$_sql .= " count(*)         " ;

$_from  = " FROM {$MENU_TB} t1 " ;
$_from .= " LEFT JOIN {$MENU_TB} t2 ON (t1.PARENT_CODE = t2.MENU_CODE)" ;
$_from .= " LEFT JOIN {$MENU_TB} t3 ON (t2.PARENT_CODE = t3.MENU_CODE)" ;

$_res = $db->exec_sql($_sql.$_from.$_whereqry);
$_row = $db->sql_fetch_row($_res);
$totalnum = $_row[0];

$_opt = "&search_status=".$_search["status"]."&keyword=".$_search["keyword"] ;

//echo $_sql.$_from.$_whereqry ;


?>
<div id="Contents">
	<h1>환경설정 &gt; 메뉴관리 &gt; <strong> 소분류 </strong></h1>

	<div class="right">
		<input type="button" value="소분류 메뉴 등록"  class="btn btn_green w120 h32" onClick="openWin('./conf/conf.small_menu_register.php','typeRegister',700,500,'scrollbars=no');" >
	</div>
	<form id="sfrm" name="sfrm" method="GET" action="./admin.conf.php">
	<input type="hidden" id="slot" name="slot" value="<?=$_slot?>">
	<input type="hidden" id="type" name="type" value="<?=$_type?>">
	<table class='tbl1'>
	<tr>
			<td>
				<strong>상태</strong>
				<select id="search_status" name="search_status" onChange="sfrm.submit();">
					<option value="">전체</option>
					<option value="y" <?=$_status["y"]?>>표시</option>
					<option value="n" <?=$_status["n"]?>>숨김</option>
				</select>&nbsp;&nbsp;

				<b>대분류</b>
				<select id="search_large" name="search_large" onChange="sfrm.submit();">
					<option value="">전체</option>
					<?
					$_large_sql = "SELECT * FROM {$MENU_TB} WHERE MENU_STATUS = 'y' AND MENU_DEPTH = '1' ORDER BY ORDER_SEQ ";
					$_large_res = $db->exec_sql($_large_sql);
					while($_large_row = $db-> sql_fetch_array($_large_res)){
						$_selected = $_large_row['MENU_CODE'] == $_search["large"] ? "selected" : "" ;
						?><option value="<?=$_large_row['MENU_CODE']?>" <?=$_selected?>><?=$_large_row['MENU_NAME']?></option><?
					}
					?>
				</select>&nbsp;&nbsp;

				<?
				if(isNull($_search['large'])){
				}else{
					?><b>중분류</b>
				<select id="search_middle" name="search_middle" onChange="sfrm.submit();">
					<option value="">전체</option>
					<?
					$_large_sql = "SELECT * FROM {$MENU_TB} WHERE MENU_STATUS = 'y' AND MENU_DEPTH = '2' AND PARENT_CODE = '{$_search['large']}' ORDER BY ORDER_SEQ ";
					$_large_res = $db->exec_sql($_large_sql);
					while($_large_row = $db-> sql_fetch_array($_large_res)){
						$_selected = $_large_row['MENU_CODE'] == $_search["middle"] ? "selected" : "" ;
						?><option value="<?=$_large_row['MENU_CODE']?>" <?=$_selected?>><?=$_large_row['MENU_NAME']?></option><?
					}
					?>
				</select>&nbsp;&nbsp;<?
				}
				?>

				

				&nbsp;<b>소분류</b> <input type="text" id="keyword" name="keyword" value="<?=$_search["keyword"]?>" required hname="소분류 명을 입력하여 주십시오!">&nbsp;
				<input type="submit" value="검색" class="btn_w80s">
				<input type="button" value="초기화" class="btn_w80o" onClick="location.href='./admin.conf.php?slot=<?=$_slot?>&type=<?=$_type?>'"> 
			</td>
		</tr>
	<table class='tbl1'>
		<colgroup>
			<col width="7%">
			<col width="7%">
			<col width="7%">
			<col width="14%">
			<col width="14%">
			<col width="*">
			<col width="15%">
		</colgroup>

		<tbody>
		<tr>
			<th>No</th>
			<th>표시</th>
			<th>정렬순위</th>
			<th>대분류</th>
			<th>중분류</th>
			<th>소분류</th>
			<th>수정 / 삭제</th>
		</tr>
		<?
		if($totalnum > 0){ 
			unset($_sql);
			unset($_res);
			unset($_row);
			
			$_sql  = "SELECT t1.*,t2.MENU_NAME as MIDDLE_NAME, t3.MENU_NAME as LARGE_NAME ";
			$_res  = $db->exec_sql($_sql.$_from.$_whereqry.$_order.$_limit);

			$_j = 1 ;
			while($_row = $db->sql_fetch_array($_res)){

				$_jul = $_j + $startNum ;

				$_status_view = $_row["MENU_STATUS"] == "y" ? "<font color='#3333FF'><b>표시</b></font><br>" : "<font color='#FF3300'>숨김</font><br>" ;

				?>
				<tr>
					<td class="center"><?=$_jul?></td>
					<td class="center"><?=$_status_view?></td>
					<td class="center"><?=$_row["ORDER_SEQ"]?></td>
					<td class="center"><?=$_row['LARGE_NAME']?></td>
					<td class="center"><?=$_row['MIDDLE_NAME']?></td>
					<td><a href = "<?=$_row['MENU_URL']?>"><?=stripslashes($_row["MENU_NAME"])?> (<?=$_row['MENU_URL']?>)</a></td>
					<td class="center">
						<input type="button" value="수정" class="btn btn_green w80 h32" onClick="openWin('./conf/conf.small_menu_update.php?MENU_CODE=<?=$_row['MENU_CODE']?>','typeRegister',700,500,'scrollbars=no');" >
						<input type="button" value="삭제" class="btn btn_red w80 h32" onClick="confirm_process('actionForm','메뉴정보를 삭제하시겠습니까? \n\n삭제 후에는 복구가 불가능합니다. ','./_action/conf.do.php?Mode=del_menu&MENU_CODE=<?=$_row["MENU_CODE"]?>')">
					</td>
				</tr>
				<?
				$_j++ ;
			}
		}else{
			?>
			<tr>
				<td colspan="7" class='center'>등록된 소분류가 없습니다.</td>
			</tr>
			<?
		}
		?>
		</tbody>
	</table>

	<div id="Paser">
	<?
		$paging = new paging("./admin.conf.php","slot=conf&type=small_menu",$offset,$page_block,$totalnum,$page,$_opt);
		$paging->pagingArea("","") ;
	?>
	</div>

</div>

<?$db->db_close();?>