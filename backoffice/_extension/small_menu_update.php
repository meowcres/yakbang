<?
include_once "../../_core/_init.php" ;
include_once "../../_core/_common/var.admin.php" ;
include_once "../inc/in_top.php" ;

$_MENU_CODE = $_GET['MENU_CODE'] ;

$_sql   = "SELECT t1.*, t2.MENU_CODE as MIDDLE_CODE, t3.MENU_CODE as LARGE_CODE " ;
$_from  = " FROM {$MENU_TB} t1                                                  " ;
$_from .= " LEFT JOIN {$MENU_TB} t2 ON (t1.PARENT_CODE = t2.MENU_CODE)          " ;
$_from .= " LEFT JOIN {$MENU_TB} t3 ON (t2.PARENT_CODE = t3.MENU_CODE)          " ;
$_where = " WHERE t1.MENU_CODE = '{$_MENU_CODE}' AND t1.MENU_DEPTH = '3'        " ;
$_res   = $db->exec_sql($_sql.$_from.$_where) ;
$_row   = $db->sql_fetch_array($_res)         ;

$_status[$_row['MENU_STATUS']] = "selected"   ;
?> 

<script language="javascript" type="text/javascript" src="../../js/ajax_select.js"> </script>

<style>
	html {background:#3ba0cd;}
</style>

<div id="Wrap" style="background:#fff;">

	<div id="Popup_Contents">
		<h1>
			환경설정 > 메뉴 설정 > <strong>소분류 메뉴 수정</strong>
		</h1>

		<form name="frm" method="post" action="../_action/conf.do.php" onSubmit="return chkForm(this);" target="actionForm">
		<input type="hidden" id="Mode"       name="Mode" value="up_menu">
		<input type="hidden" id="MENU_DEPTH" name="MENU_DEPTH" value="<?=$_row['MENU_DEPTH']?>">
		<input type="hidden" id="MENU_CODE"  name="MENU_CODE"  value="<?=$_MENU_CODE?>">

		<table class="tbl1" summary="중분류 테이블 목록">

			<caption>소분류 리스트</caption>
			<colgroup>
				<col width="20%">
				<col width="30%">
				<col width="20%">
				<col width="*">
			</colgroup>

			<tbody>

				<tr>
					<th>상태</th>
					<td>
						<select id="MENU_STATUS" name="MENU_STATUS">
							<option value="y" <?=$_status['y']?>>표시</option>
							<option value="n" <?=$_status['n']?>>숨김</option>
						</select>&nbsp;
					</td>

					<th>정렬순위</th>
					<td>
						<select id="ORDER_SEQ" name="ORDER_SEQ">
						<?
						for($i=1;$i<=20;$i++){
							$ri = $i < 10 ? "0".$i : $i ;
							$selected = $ri == $_row['ORDER_SEQ'] ? "selected" : "" ;
							?><option value="<?=$ri?>" <?=$selected?>><?=$ri?></option><?
						}
						?>
						</select>&nbsp;
					</td>
				</tr>

				<tr>
					<th>참조분류</th>
					<td colspan='3'>
						<select id="LARGE_CODE" NAME="LARGE_CODE" required hname="대분류를 선택하여 주십시오" onChange="change_middle_type(this.value);">
						<option value="">:: 대분류 ::</option>
						<?
						$_sql1 = "SELECT * FROM {$MENU_TB} WHERE MENU_DEPTH = '1' AND MENU_STATUS ='Y' ORDER BY ORDER_SEQ " ;
						$_res1 = $db->exec_sql($_sql1);
						while($_row1 = $db->sql_fetch_array($_res1)){
							$_selected = $_row1['MENU_CODE'] == $_row['LARGE_CODE'] ? "selected" : "" ;
							?><option value="<?=$_row1['MENU_CODE']?>" <?=$_selected?>><?=$_row1['MENU_NAME']?></option><?
						}
						?>
						</select>&nbsp;&nbsp;

						<select id="PARENT_CODE" name="PARENT_CODE" required hname="중분류를 선택하여 주십시오">
							<option value="">:: 중분류 ::</option>
							<?
							if(!isNull($_row["LARGE_CODE"])){
								$_sql2 = "SELECT * FROM {$MENU_TB} WHERE PARENT_CODE = '{$_row['LARGE_CODE']}'ORDER BY ORDER_SEQ " ;
								$_res2 = $db->exec_sql($_sql2);
								while($_row2 = $db->sql_fetch_array($_res2)){
									$_selected = $_row2['MENU_CODE'] == $_row['MIDDLE_CODE'] ? "selected" : "" ;
									?><option value="<?=$_row2['MENU_CODE']?>" <?=$_selected?>><?=$_row2['MENU_NAME']?></option><?
								}
							}
							?>
						</select>
					</td>
				</tr>

				<tr>
					<th>소분류 메뉴ID</th>
					<td colspan="3">
						<input type="text" id="MENU_ID" name="MENU_ID" class="w90pro" value="<?=$_row['MENU_ID']?>" required hname="중분류명을 입력하여 주십시오">
					</td>
				</tr>

				<tr>
					<th>소분류 메뉴명</th>
					<td colspan="3">
						<input type="text" id="MENU_NAME" name="MENU_NAME" class="w90pro" value="<?=$_row['MENU_NAME']?>" required hname="메뉴명을 입력하여 주십시오">
					</td>
				</tr>

				<tr>
					<th>소분류 메뉴<br>URL</th>
					<td colspan="3">
						<input type="text" id="MENU_URL" name="MENU_URL" class="w90pro" value="<?=$_row['MENU_URL']?>" required hname="메뉴URL을 입력하여 주십시오">
					</td>
				</tr>

			</tbody>
		</table>

		<div style="margin-top:30px;text-align:center;">
			<input type="submit" value="수정하기" class="btn_w120g">
			<input type="button" value="창닫기" class="btn_w120r" onClick="self.close();">
		</div>
	</form>
<?
include_once "../inc/in_bottom.php";
?>