<?php
$idx = $_REQUEST["idx"];

$qry_001 = "SELECT * FROM {$TB_REQUEST} WHERE IDX='".$idx."'";
$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);
?>
<div id="Contents">
	<h1>커뮤니티 &gt; 문의관리 &gt; <strong>문의 수정</strong></h1>

	<form name="frm" method="post" enctype="multipart/form-data" action="./_action/board.do.php" onSubmit="return chk_form(this);" style="display:inline;" target="actionForm">
	<input type="hidden" id="mode" name="mode" value="up_request">
  <input type="hidden" id="idx"  name="idx"  value="<?=$row_001["IDX"]?>">
	<table class="tbl1">
		<colgroup>
			<col width="15%" />
			<col width="35%" />
			<col width="15%" />
			<col width="*" />
		</colgroup>
		<tr>
			<th>분류</th>
			<td class="left">
				<?
        $qry_type = "SELECT * FROM {$TB_CODE} WHERE CD_KEY = '".$row_001["R_TYPE"]."'";
        $res_type = $db->exec_sql($qry_type);
        $row_type = $db->sql_fetch_array($res_type);

        echo clear_escape($row_type["CD_TITLE"]);
				?>
			</td>
			<th>상태</th>
			<td class="left">
        <select id="r_status" name="r_status" >
        <?php
        foreach($request_status_array as $key => $val){
          $_selected = $row_001["R_STATUS"] == $key ? "selected" : "" ;
          ?><option value="<?= $key ?>" <?= $_selected ?>><?= $val ?></option><?
        }
        ?>
        </select>
      </td>
		</tr>
    
		<tr>
			<th>작성일</th>
			<td class="left">
				<?=$row_001["REG_DATE"]?>
			</td>

      <th>최종 수정일</th>
			<td class="left">
				<?=$row_001["UP_DATE"]?>
			</td>
		</tr>

    <tr>
			<th>작성자</th>
			<td colspan="3" class="left">
				<?=clear_escape($row_001["R_WRITE"])?>
			</td>
		</tr>

    <tr>
			<th>제목</th>
			<td class="left" colspan="3">
        <?=clear_escape($row_001["R_TITLE"])?>
			</td>
		</tr>

    <tr>
			<th style="line-height:180%;">내용</th>
			<td colspan="3">
        <?=clear_escape(nl2br($row_001["R_CONTENTS"]))?>
			</td>
		</tr>

		<tr>
			<th style="line-height:180%;">관리자 메모</th>
			<td colspan="3">
				<textarea id="admin_desc" name="admin_desc" class="w90p" style="height:90px;"><?=clear_escape($row_001["ADMIN_DESC"])?></textarea>
			</td>
		</tr>

	</table>

	<div style="margin-top:20px;" class="center">
		<input type="submit" value="수 정" class="Button btnGreen w120"> &nbsp; 
		<input type="button" value="목 록" class="Button btnRed w120" onClick="location.href='./admin.template.php?slot=board&type=request_list'">
	</div>
	</form>

</div>

<script language="JavaScript" type="text/JavaScript">
<!--
function chk_form(f){
  return ;
}
</script>