<?
include_once "../../_core/_init.php" ;
include_once "../../_core/_common/var.admin.php" ;
include_once "../inc/in_top.php" ;

$_MENU_CODE = $_GET['MENU_CODE'] ;

$_sql = "SELECT * FROM {$MENU_TB} WHERE MENU_CODE = '{$_MENU_CODE}' AND MENU_DEPTH = '2' " ;
$_res = $db->exec_sql($_sql) ;
$_row = $db->sql_fetch_array($_res);

$_status[$_row['MENU_STATUS']] = "selected" ;

?> 

<style>
	html {background:#3ba0cd;}
</style>

<div id="Wrap" style="background:#fff;">

	<div id="Popup_Contents">
		<h1>
			환경설정 > 메뉴 설정 > <strong>중분류 메뉴 수정</strong>
		</h1>

		<form name="frm" method="post" action="../_action/conf.do.php" onSubmit="return chkForm(this);" target="actionForm">
		<input type="hidden" id="Mode"       name="Mode" value="up_menu">
		<input type="hidden" id="MENU_DEPTH" name="MENU_DEPTH" value="<?=$_row['MENU_DEPTH']?>">
		<input type="hidden" id="MENU_CODE"  name="MENU_CODE"  value="<?=$_MENU_CODE?>">

		<table class="tbl1" summary="중분류 테이블 목록">

			<caption>중분류 리스트</caption>
			<colgroup>
				<col width="20%">
				<col width="30%">
				<col width="20%">
				<col width="*">
			</colgroup>

			<tbody>

				<tr>
					<th>표시여부</th>
					<td>
						<select id="MENU_STATUS" name="MENU_STATUS" style="width:150px">
							<option value="y" <?=$_status['y']?>>표시</option>
							<option value="n" <?=$_status['n']?>>숨김</option>
						</select>&nbsp;
					</td>

					<th>정렬순위</th>
					<td>
						<select id="ORDER_SEQ" name="ORDER_SEQ" style="width:150px">
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
					<th>대분류</th>
					<td colspan='3'>
						<select id="PARENT_CODE" NAME="PARENT_CODE" required hname="대분류를 선택하여 주십시오">
						<option value="">:: 대분류 ::</option>
						<?
						$_sql1 = "SELECT * FROM {$MENU_TB} WHERE MENU_DEPTH = '1' AND MENU_STATUS ='Y' ORDER BY ORDER_SEQ " ;
						$_res1 = $db->exec_sql($_sql1);
						while($_row1 = $db->sql_fetch_array($_res1)){
							$_selected = $_row1['MENU_CODE'] == $_row['PARENT_CODE'] ? "selected" : "" ;
							?><option value="<?=$_row1['MENU_CODE']?>" <?=$_selected?>><?=$_row1['MENU_NAME']?></option><?
						}
						?>
					</td>
				</tr>

				<tr>
					<th>중분류 메뉴ID</th>
					<td colspan="3">
						<input type="text" id="MENU_ID" name="MENU_ID" class="w90pro" value="<?=$_row['MENU_ID']?>" required hname="중분류명을 입력하여 주십시오">
					</td>
				</tr>

				<tr>
					<th>중분류 메뉴명</th>
					<td colspan="3">
						<input type="text" id="MENU_NAME" name="MENU_NAME" class="w90pro" value="<?=$_row['MENU_NAME']?>" required hname="메뉴명을 입력하여 주십시오">
					</td>
				</tr>

				<tr>
					<th>중분류 메뉴<br>URL</th>
					<td colspan="3">
						<input type="text" id="MENU_URL" name="MENU_URL" class="w90pro" value="<?=$_row['MENU_URL']?>" required hname="메뉴URL을 입력하여 주십시오">
					</td>
				</tr>

			</tbody>
		</table>

		<div style="margin-top:30px;text-align:center;">
			<input type="submit" value="수정하기" class="btn_w80g">
			<input type="button" value="창닫기" class="btn_w80r" onClick="self.close();">
		</div>
	</form>
<?
include_once "../inc/in_bottom.php";
?>