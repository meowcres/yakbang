<?php

$page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

// 검색 변수
$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["type"] = isNull($_GET["search_type"]) ? "" : $_GET["search_type"];
$_search["seq"] = isNull($_GET["search_seq"]) ? "" : $_GET["search_seq"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];
$_opt = "page=".$page."&search_status=" . $_search["status"] . "&search_type=" . $_search["type"] . "&search_seq=" . $_search["seq"] . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"];

$idx = $_REQUEST["idx"];

$qry_001 = "SELECT * FROM {$TB_FAQ} WHERE IDX='".$idx."'";
$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

?>
<div id="Contents">
	<h1>커뮤니티 &gt; 게시판 &gt; <strong>FAQ 수정</strong></h1>

	<form name="frm" method="post" enctype="multipart/form-data" action="./_action/board.do.php" onSubmit="return chk_form(this);" style="display:inline;" target="actionForm">
	<input type="hidden" id="mode" name="mode" value="up_faq">
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
				<select id="f_type" name="f_type" class="w30p">
				<?
        $qry_type = "SELECT * FROM {$TB_CODE} WHERE CD_STATUS in ('y') AND CD_TYPE='FAQ' ORDER BY ORDER_SEQ";
        $res_type = $db->exec_sql($qry_type);
        while($row_type = $db->sql_fetch_array($res_type)){
          $_selected = $row_type["CD_KEY"] == $row_001["F_TYPE"] ? "selected" : "" ;
          ?><option value="<?=$row_type["CD_KEY"]?>" <?=$_selected?>><?=clear_escape($row_type["CD_TITLE"])?></option><?
        }
				?>
				</select> 
			</td>
			<th>노출여부</th>
			<td class="left">
				<input type="radio" id="f_status_y" name="f_status" value="y" <?php if ($row_001["F_STATUS"] == "y") { echo "checked"; } ?>> <label for="f_status_y">노출</label> &nbsp;&nbsp;&nbsp;
        <input type="radio" id="f_status_n" name="f_status" value="n" <?php if ($row_001["F_STATUS"] == "n") { echo "checked"; } ?>> <label for="f_status_n">숨김</label> 
      </td>
		</tr>

    <tr>
			<th>질문</th>
			<td class="left">
				<input type="text" id="f_question" name="f_question" value="<?=clear_escape($row_001["F_QUESTION"])?>" class="w95p">
			</td>
            <th>정렬순서</th>
				<td>
				<select id="order_seq" name="order_seq" class="w30p">
					<?php
					for($i=1; $i<=50; $i++) {
						$selected = $i == $row_001["ORDER_SEQ"] ? "selected" : "";
					?>
						<option value="<?=$i?>" <?=$selected?>><?=$i?></option>
					<?
					}
					?>
				</select>
		</tr>

    <tr>
			<th style="line-height:180%;">답변</th>
			<td colspan="3">
				<textarea id="f_answer" name="f_answer" class="w95p" style="height:150px;"><?=clear_escape($row_001["F_ANSWER"])?></textarea>
			</td>
		</tr>

	</table>

	<div style="margin-top:20px;" class="center">
		<input type="submit" value="수 정" class="Button btnGreen w120"> &nbsp; 
		<input type="button" value="목 록" class="Button btnRed w120" onClick="location.href='./admin.template.php?slot=board&type=faq_list&<?= $_opt ?>'">
	</div>
	</form>

</div>

<script language="JavaScript" type="text/JavaScript">
<!--
function chk_form(f){

  if($("#f_question").val()==""){
    alert("질문을 입력 해 주시기 바랍니다");
    $("#f_question").focus();
    return false;
  }

  return ;
}
</script>