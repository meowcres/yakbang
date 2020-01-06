<div id="Contents">
	<h1>확장메뉴 &gt; SITE 메뉴관리 &gt; <strong> 대분류 메뉴관리</strong></h1>

	<div class="right">
		<input type="button" value="대분류 메뉴 등록" class="btnGreen w120 h32" onClick="openWin('./_extension/large_menu_register.php','menuRegister',700,270,'scrollbars=no');" >
	</div>
	<form id="sfrm" name="sfrm" method="GET" action="./admin.extension.php">
	<input type="hidden" id="_iraeKey_" name="_iraeKey_" value="<?=$_GET["_iraeKey_"]?>">
	<input type="hidden" id="type" name="type" value="large_menu">
	<table class='tbl1'>
	    <tr>
			<td>
				<strong>상태</strong>
				<select id="search_status" name="search_status" onChange="sfrm.submit();">
					<option value="">전체</option>
					<option value="y" <?=$_status["y"]?>>표시</option>
					<option value="n" <?=$_status["n"]?>>숨김</option>
				</select>&nbsp;&nbsp;

				&nbsp;<b>대분류</b> <input type="text" id="keyword" name="keyword" value="<?=$search["keyword"]?>">&nbsp;
				<input type="submit" value="검색" class="btnOrange w80 h24"> &nbsp;
				<input type="button" value="초기화" class="btnGray w80 h24" onClick="location.href='./admin.extension.php?_iraeKey_=<?=$_GET["_iraeKey_"]?>&type=large_menu'"> 
			</td>
		</tr>
    </table>
    </form>
	<table class='tbl1'>
		<colgroup>
			<col width="4%">
			<col width="5%">
			<col width="4%">
			<col width="7%">
			<col width="*">
			<col width="12%">
		</colgroup>

		<tbody>
		<tr>
			<th>No</th>
			<th>표시</th>
			<th>정렬</th>
            <th>분류코드</th>
			<th>대분류</th>
			<th>수정 / 삭제</th>
		</tr>
		<?
        if ($totalnum > 0) {
            unset($qry_001);
            unset($res_001);
            unset($row_001);

            $qry_002 = "SELECT t1.* ";
            $res_002 = $db->exec_sql($qry_002.$qry_from.$qry_where.$qry_order.$qry_limit);

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
                <td colspan="5" class='center' style="height:150px;">등록된 대분류가 없습니다.</td>
            </tr>
            <?
        }
        ?>
        </tbody>
    </table>

	<div id="Paser">
	<?
		$paging = new paging("./admin.conf.php","slot=conf&type=large_menu",$offset,$page_block,$totalnum,$page,$_opt);
		$paging->pagingArea("","") ;
	?>
	</div>

</div>

<script language="javascript">
<!--
function del_menu(cdKey){
    if (confirm("메뉴정보를 삭제하겠습니까? \n\n삭제 후에는 복구가 불가능합니다.")) {
        actionForm.location.href="./_extension/extension.do.php?mode=del_menu&cd_key="+cdKey ;
        return ;
    }
}
//-->
</script>

<?$db->db_close();?>