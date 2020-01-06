<?
include_once "../../_core/_init.php" ;
include_once "../../_core/_common/var.admin.php" ;
include_once "../inc/in_top.php" ;
?>

<script language="javascript" type="text/javascript" src="../../js/ajax_select.js"> </script>

<style>
	html {background:#3ba0cd;}
</style>

<div id="Wrap" style="background:#fff;">

	<div id="Popup_Contents">
		<h1>
			환경설정 > 메뉴 설정 > <strong>소분류 메뉴 등록</strong>
		</h1>

		<form name="frm" method="post" action="../_action/conf.do.php" onSubmit="return chkForm(this);" target="actionForm">
		<input type="hidden" id="Mode"       name="Mode" value="add_menu">
		<input type="hidden" id="MENU_DEPTH" name="MENU_DEPTH" value="3">

		<table class="tbl1" summary="소분류 테이블 목록">

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
							<option value="y">표시</option>
							<option value="n">숨김</option>
						</select>&nbsp;
					</td>

					<th>정렬순위</th>
					<td>
						<select id="ORDER_SEQ" name="ORDER_SEQ">
						<?
						for($i=1;$i<=20;$i++){
							$ri = $i < 10 ? "0".$i : $i ;
							$selected = $ri == "10" ? "selected" : "" ;
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
						$_sql = "SELECT * FROM {$MENU_TB} WHERE MENU_DEPTH = '1' AND MENU_STATUS ='Y' ORDER BY ORDER_SEQ " ;
						$_res = $db->exec_sql($_sql);
						while($_row = $db->sql_fetch_array($_res)){
							?><option value="<?=$_row['MENU_CODE']?>"><?=$_row['MENU_NAME']?></option><?
						}
						?>
						</select>&nbsp;&nbsp;

						<select id="PARENT_CODE" name="PARENT_CODE" required hname="중분류를 선택하여 주십시오">
							<option value="">:: 중분류 ::</option>
						</select>
					</td>
				</tr>

				<tr>
					<th>소분류 메뉴ID</th>
					<td colspan="3">
						<input type="text" id="MENU_ID" name="MENU_ID" class="w90pro" required hname="중분류명을 입력하여 주십시오">
					</td>
				</tr>

				<tr>
					<th>소분류 메뉴명</th>
					<td colspan="3">
						<input type="text" id="MENU_NAME" name="MENU_NAME" class="w90pro" required hname="메뉴명을 입력하여 주십시오">
					</td>
				</tr>

				<tr>
					<th>소분류 메뉴<br>URL</th>
					<td colspan="3">
						<input type="text" id="MENU_URL" name="MENU_URL" class="w90pro" required hname="메뉴URL을 입력하여 주십시오">
					</td>
				</tr>

			</tbody>
		</table>

		<div style="margin-top:30px;text-align:center;">
			<input type="submit" value="등록하기" class="btn_w120b">
			<input type="button" value="창닫기" class="btn_w120r" onClick="self.close();">
		</div>
	</form>
<?
include_once "../inc/in_bottom.php";
?>