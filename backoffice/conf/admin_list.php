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

$_where[]  = " 1 " ;
$_whereqry = count($_where) ? " WHERE ".implode(' AND ',$_where) : "" ;
$_order    = " ORDER BY REG_DATE " ;
$_limit    = " LIMIT ".$startNum.",".$offset ;

$_sql  = "SELECT " ;
$_sql .= "count(*) " ;
$_sql .= "FROM {$TB_ADMIN} t1 " ;

$_res = $db->exec_sql($_sql.$_whereqry);
$_row = $db->sql_fetch_row($_res);
$totalnum = $_row[0];
?>
<div id="Contents">
	<h1>환경설정 &gt; 운영자관리 &gt; <strong>운영자목록</strong></h1>
	<table class="tbl1">
		<colgroup>
			<col width="3%" />
			<col width="7%" />
			<col width="10%" />
			<col width="*" />
            <?php
            foreach($_adminMenu as $key=>$val){
                ?><col width="5%" /><?php
            }
            ?>
			<col width="6%" />
			<col width="5%" />
			<col width="8%" />
		</colgroup>
		<tr>
			<th rowspan="2">No</th>
			<th rowspan="2">상태</th>
			<th rowspan="2">ID</th>
			<th rowspan="2">이름</th>
			<th colspan="<?=sizeof($_adminMenu)?>">관리권한</th>
			<th rowspan="2">로그<br />횟수</th>
			<th rowspan="2">등록일</th>
		</tr>
		<tr>
            <?php
            foreach($_adminMenu as $key=>$val){
                ?><th><?=$val[0]?></th><?
            }
            ?>
		</tr>
		<?
		if($totalnum > 0){
			unset($_sql);
			unset($_res);
			unset($_row);

			$_menu_num = 1 ;

			$_sql  = "SELECT * " ;
			$_sql .= ",IF(t1.ADMIN_STATUS='y','<font color=\"#3300FF\"><b>Active</b></font>','<font color=\"#FF6600\"><b>Stop</b></font>') ast " ;

			foreach($_adminMenu as $key=>$val){
				$_sql .= ",IF(substring(t1.ADMIN_GRADE,".$_menu_num.",1)='Y','<B>○</B>','Ⅹ') GRADE".$_menu_num." " ;
				$_menu_num++ ;
			}
			
			$_sql .= ",DATE_FORMAT(REG_DATE,'%Y.%m.%d') rd " ;
			$_sql .= "FROM {$TB_ADMIN} t1 " ;

			$_res = $db->exec_sql($_sql.$_whereqry.$_order.$_limit);
			//echo $_sql.$_whereqry.$_order.$_limit ;
			$_j = 0 ;

			while($_row = $db->sql_fetch_array($_res)){

				$_del_ref = "./_action/conf.do.php?mode=admin_delete&admin_id=".$_row["ADMIN_ID"] ;

				$_jul = $totalnum - ($_j + $startNum) ;

				?>
				<tr onClick="line_detail('<?=$_row["ADMIN_ID"]?>')" style="cursor:pointer;">
					<td class="center"><b><?=$_jul?></b></td>
					<td class="center"><?=$_row["ast"]?></td>
					<td class="center"><?=$_row["ADMIN_ID"]?></td>
					<td class="center"><?=$_row["ADMIN_NAME"]?></td>
                    <?php
                    $jj = 1;
                    foreach($_adminMenu as $key=>$val){
                        ?><td class="center"><?=$_row["GRADE".$jj]?></td><?
                        $jj++;
                    }
                    ?>
					<td class="center"><?=number_format($_row["ADMIN_HIT"])?></td>
					<td class="center"><?=$_row["rd"]?></td>
				</tr>
				<tr id="line_<?=$_row["ADMIN_ID"]?>" style="display:none;">
					<td colspan="18" style="padding:5px 5px 30px 50px;" class="right">
						
						<table>
							<colgroup>
								<col width="15%" align="center" bgcolor="#F7F7F7" />
								<col width="35%" />
								<col width="15%" align="center" bgcolor="#F7F7F7" />
								<col width="*" />
							</colgroup>
							<tr>
								<th>상태</th>
								<td colspan="3" class="left"><b><u><?=$_row["ast"]?></u></b> &nbsp;&nbsp; [ 총 : <?=number_format($_row["ADMIN_HIT"])?> 회,  최근 로그인 시간 : <?=$_row["LAST_DATE"]?>  ]</td>
							</tr>
							<tr>
								<th>관리자 정보</th>
								<td class="left"><?=$_row["ADMIN_NAME"]?> ( ID : <?=$_row["ADMIN_ID"]?> )</td>
								<th>PASS</th>
								<td class="left"><?=$_row["ADMIN_PASS"]?></td>
							</tr>
							<tr>
								<th>핸드폰</th>
								<td class="left" colspan="3"><?=stripslashes($_row["ADMIN_MOBILE"])?></td>
							</tr>
							<tr>
								<th>Email</th>
								<td colspan="3" class="left"><?=stripslashes($_row["ADMIN_EMAIL"])?></td>
							</tr>
							<tr>
								<th>관리등급</th>
								<td colspan="3" style="padding:20px;">
									<table class='tbl1' width="100%">
										<colgroup>
											<col width="35%" />
											<col width="15%" />
											<col width="35%" />
											<col width="*"   />
										</colgroup>
										<?
										$_menu_num = 1 ;
										foreach($_adminMenu as $key=>$val){
											
											if($_menu_num%2){
												echo "<tr>" ;
											}

											$_grade = "GRADE".$_menu_num ; 

											?><th class='center'><?=$val[0]?></th><td class='center'><?=$_row[$_grade]?></td><?

											if(!($_menu_num%2)){
												echo "<tr />" ;
											}

											$_menu_num++ ;
										}

										if(!($_menu_num%2)){
											echo "<td colspan='2'>&nbsp;</td></tr>" ;
										}
										reset($_adminMenu) ;
										?>
									</table>
								</td>
							</tr>
						</table>
						<div style="margin-top:10px;" class="right">
							<input type="button" value="정보수정" class="btn btn_green w80 h32" onClick="location.href='./admin.template.php?slot=conf&type=admin_update&admin_id=<?=$_row["ADMIN_ID"]?>'"> &nbsp;
							<input type="button" value="삭제" class="btn btn_red w80 h32" onClick="confirm_process('actionForm','관리자 정보를 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다. \n\n상태를 중지 시키면 권한을 박탈할 수 있습니다. \n\n그래도 삭제하시겠습니까?','<?=$_del_ref?>');">
						</div>
						

					</td>
				</tr>
				<?
			$_j++ ;
			}
		}else{
		?>
			<tr>
				<td colspan="6" height="200">등록된 관리자가 없습니다.</td>
			</tr>
		<?
		}
		?>
	</table>

	<div id="Paser">
	<?
		$paging = new paging("./admin.conf.php","slot=conf&type=admin_list",$offset,$page_block,$totalnum,$page,"");
		$paging->pagingArea("","") ;
	?>
	</div>

</div>

<?$db->db_close();?>