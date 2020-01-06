<?php

$page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

// 검색 변수
$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["type"] = isNull($_GET["search_type"]) ? "" : $_GET["search_type"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];
$_opt = "page=".$page."&search_status=" . $_search["status"] . "&search_type=" . $_search["type"] . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"];

$idx = $_REQUEST["idx"];

$qry_001 = "SELECT * FROM {$TB_NOTICE} WHERE IDX='".$idx."'";
$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

if ($row_001["N_IMG"]) {
  $n_img = $BOARD_URL.$row_001["N_IMG"] ;
}
?>
<div id="Contents">
	<h1>커뮤니티 &gt; 게시판 &gt; <strong>공지사항 수정</strong></h1>

	<form name="frm" method="post" enctype="multipart/form-data" action="./_action/board.do.php" onSubmit="return chk_form(this);" style="display:inline;" target="actionForm">
	<input type="hidden" id="mode" name="mode" value="up_notice">
  <input type="hidden" id="idx"  name="idx"  value="<?=$row_001["IDX"]?>">
  <input type="hidden" id="old_file" name="old_file" value="<?=$row_001["N_IMG"]?>">
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
				<select id="n_type" name="n_type" class="w95p">
				<?
        $qry_type = "SELECT * FROM {$TB_CODE} WHERE CD_STATUS in ('y') AND CD_TYPE='NOTICE' ORDER BY ORDER_SEQ";
        $res_type = $db->exec_sql($qry_type);
        while($row_type = $db->sql_fetch_array($res_type)){
          $_selected = $row_type["CD_KEY"] == $row_001["N_TYPE"] ? "selected" : "" ;
          ?><option value="<?=$row_type["CD_KEY"]?>" <?=$_selected?>><?=clear_escape($row_type["CD_TITLE"])?></option><?
        }
				?>
				</select> 
			</td>
			<th>공개여부</th>
			<td class="left">
				<input type="radio" id="n_status_y" name="n_status" value="y" <?php if ($row_001["N_STATUS"] == "y") { echo "checked"; } ?>> <label for="n_status_y">공지</label> &nbsp;&nbsp;&nbsp;
        <input type="radio" id="n_status_n" name="n_status" value="n" <?php if ($row_001["N_STATUS"] == "n") { echo "checked"; } ?>> <label for="n_status_n">일반</label> 
      </td>
		</tr>
    
		<tr>
			<th>작성자</th>
			<td class="left">
				<input type="text" id="n_writer" name="n_writer" value="<?=clear_escape($row_001["N_WRITE"])?>" style="width:90%;">
			</td>
			<th>작성일</th>
			<td class="left">
				<input type="text" id="reg_date" name="reg_date" value="<?=$row_001["REG_DATE"]?>" style="width:200px;">
			</td>
		</tr>

    <tr>
			<th>제목</th>
			<td class="left" colspan="3">
				<input type="text" id="n_title" name="n_title" value="<?=clear_escape($row_001["N_TITLE"])?>" class="w80p">&nbsp;&nbsp; HIT : <input type="text" id="hit" name="hit" value="<?=$row_001["HIT"]?>">
			</td>
		</tr>

    <tr>
			<th style="line-height:180%;">내용</th>
			<td colspan="3">
				<textarea id="n_contents" name="n_contents" class="w90p" style="height:150px;"><?=clear_escape($row_001["N_CONTENTS"])?></textarea>
			</td>
		</tr>

    <tr>
			<th>목록이미지 (og:image)</th>
			<td colspan="3">
				<?php
        if (!isNull($row_001["N_IMG"])) {
          ?>
          <div style="padding:10px;">
            <img src="<?=$n_img?>" width="300">
          </div>
          <div style="padding:10px 0;">
            <input type="checkbox" id="del_file" name="del_file" value="Y"/>
            <label for="del_file">첨부파일 삭제</label>
          </div>
          <?
        }
        ?>
        <input type="file" id="n_img" class="uploadBtn" name="n_img" style="width:80%;">
			</td>
		</tr>

		<tr>
			<th style="line-height:180%;">간단설명<br>(og:description)</th>
			<td colspan="3">
				<textarea id="og_desc" name="og_desc" class="w90p" style="height:90px;"><?=clear_escape($row_001["OG_DESC"])?></textarea>
			</td>
		</tr>

    
		<tr>
			<th>원문주소</th>
			<td colspan="3">
				<input type="text" id="n_addr" name="n_addr" value="<?=clear_escape($row_001["N_ADDR"])?>" class="w95p">
			</td>
		</tr>


	</table>

	<div style="margin-top:20px;" class="center">
		<input type="submit" value="수 정" class="Button btnGreen w120"> &nbsp; 
		<input type="button" value="목 록" class="Button btnRed w120" onClick="location.href='./admin.template.php?slot=board&type=notice_list&<?= $_opt ?>'">
	</div>
	</form>

</div>

<script language="JavaScript" type="text/JavaScript">
<!--
function chk_form(f){
  if($("#n_writer").val()==""){
    alert("작성자를 입력 해 주시기 바랍니다");
    $("#n_writer").focus();
    return false;
  }

  if($("#n_title").val()==""){
    alert("제목을 입력 해 주시기 바랍니다");
    $("#n_title").focus();
    return false;
  }

  return ;
}
</script>