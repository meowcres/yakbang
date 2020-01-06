<div id="Contents">
	<h1>환경설정 &gt; 메뉴관리 &gt; <strong> 중분류 </strong></h1>

	<div class="right">
		<input type="button" value="중분류 메뉴 등록" class="btnGreen w120 h32" onClick="openWin('./_extension/middle_menu_register.php','menuRegister',700,300,'scrollbars=no');" >
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
                    $qry_large = "SELECT * FROM {$TB_CODE} WHERE CD_STATUS = 'y' AND CD_DEPTH = '1' ORDER BY ORDER_SEQ ";
                    $res_large = $db->exec_sql($qry_large);
                    while($row_large = $db->sql_fetch_array($res_large)){
                        $_selected = $row_large['CD_KEY'] == $search["large"] ? "selected" : "" ;
                        ?><option value="<?=$row_large['CD_KEY']?>" <?=$_selected?>><?=clear_escape($row_large['CD_TITLE'])?></option><?
                    }
                    ?>
                </select>&nbsp;&nbsp;
                &nbsp;<b>중분류</b> <input type="text" id="keyword" name="keyword" value="<?=$search["keyword"]?>">&nbsp;
                <input type="submit" value="검색" class="btnOrange w80 h24"> &nbsp;
				<input type="button" value="초기화" class="btnGray w80 h24" onClick="location.href='./admin.extension.php?_iraeKey_=<?=$_GET["_iraeKey_"]?>&type=middle_menu'"> 
            </td>
        </tr>
    </table>
	<table class='tbl1'>
		<colgroup>
			<col width="8%">
			<col width="8%">
			<col width="8%">
			<col width="15%">
            <col width="20%">
			<col width="*">
			<col width="15%">
		</colgroup>

		<tbody>
		<tr>
			<th>No</th>
			<th>표시</th>
			<th>정렬</th>
            <th>분류코드</th>
			<th>대분류</th>
            <th>중분류</th>
			<th>수정 / 삭제</th>
		</tr>
		<?
        if ($totalnum > 0) {
            unset($qry_001);
            unset($res_001);
            unset($row_001);
            
            $qry_002 = "SELECT t1.*, t2.CD_TITLE as LARGE_NAME ";
            $res_002  = $db->exec_sql($qry_002.$qry_from.$qry_where.$qry_order.$qry_limit);

			$j = 1 ;
            while($row_002 = $db->sql_fetch_array($res_002)){

                $line_number = $j + $startNum ;
                $status_view = $row_002["CD_STATUS"] == "y" ? "<font color='#3333FF'><b>활성</b></font><br>" : "<font color='#FF3300'>비활성</font><br>" ;
                ?>
                <tr>
                    <td class="center"><?=$line_number?></td>
                    <td class="center"><?=$status_view?></td>
                    <td class="center"><?=$row_002["ORDER_SEQ"]?></td>
                    <td class="center"><?=$row_002["CD_KEY"]?></td>
                    <td class="center"><?=$row_002['LARGE_NAME']?></td>
                    <td>
                        <?=clear_escape($row_002["CD_TITLE"])?><br />
                        URL : <?=clear_escape($row_002['CD_URL'])?>
                    </td>
                    <td class="center">
                        <input type="button" value="수정" class="btnBlue w60 h24" onClick="openWin('./_extension/large_menu_update.php?CD_KEY=<?=$row_002['CD_KEY']?>','typeRegister',700,270,'scrollbars=no');" >&nbsp;
                        <input type="button" value="삭제" class="btnRed w60 h24" onClick="del_menu('<?=$row_002["CD_KEY"]?>')">
                    </td>
                </tr>
				<?
				$_j++ ;
			}
		}else{
			?>
			<tr>
				<td colspan="7" class='center' style="height:150px;">등록된 중분류가 없습니다.</td>
			</tr>
			<?
		}
		?>
		</tbody>
	</table>

	<div id="Paser">
	<?
		$paging = new paging("./admin.conf.php","slot=conf&type=middle_menu",$offset,$page_block,$totalnum,$page,$_opt);
		$paging->pagingArea("","") ;
	?>
	</div>

</div>

<?$db->db_close();?>