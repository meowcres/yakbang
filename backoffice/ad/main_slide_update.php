<?php

$page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

// 검색 변수
$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["type"] = isNull($_GET["search_type"]) ? "" : $_GET["search_type"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];

$_opt = "page=".$page."&search_status=" . $_search["status"] . "&search_type=" . $_search["type"]  . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"];

$idx = $_REQUEST["idx"];

$qry_001  = " SELECT t1.*, t2.PHYSICAL_NAME ";
$qry_001 .= " FROM {$TB_AD} t1 ";
$qry_001 .= " LEFT JOIN {$TB_ATTECH_FILES} t2 ON (t1.AD_CODE = t2.REFERENCE_CODE) ";
$qry_001 .= " WHERE t1.IDX = '{$idx}' AND t1.AD_TYPE = '2' ";

$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

if ($row_001["PHYSICAL_NAME"]) {
  $ad_img = "../../_core/_files/ad/".$row_001["PHYSICAL_NAME"] ;
}

$reg_date = date("Y-m-d", strtotime($row_001["REG_DATE"]));
?>
<div id="Contents">
	<h1>광고관리 &gt; MAIN SLIDE 광고 &gt; <strong>MAIN SLIDE 광고 수정</strong></h1><br>

	<form name="frm" method="post" enctype="multipart/form-data" action="./_action/ad.do.php" onSubmit="return chk_form(this);" style="display:inline;" target="actionForm">
	<input type="hidden" id="mode" name="mode" value="up_main">
  <input type="hidden" id="idx"  name="idx"  value="<?=$row_001["IDX"]?>">
  <input type="hidden" id="old_file" name="old_file" value="<?=$row_001["PHYSICAL_NAME"]?>">
  <input type="hidden" id="ad_code" name="ad_code" value="<?=$row_001["AD_CODE"]?>">
  <input type="hidden" id="ad_type" name="ad_type" value="<?=$row_001["AD_TYPE"]?>">

	<table class="tbl1">
		<colgroup>
			<col width="12%" />
			<col width="*%" />
			<col width="12%" />
			<col width="21%" />
			<col width="12%" />
			<col width="21%" />
		</colgroup>
		<tr>
			<th>분류</th>
                <td class="left">
                    &nbsp;MAIN SLIDE 광고
                </td>
			<th>상태</th>
			<td class="left">
				<input type="radio" id="ad_status_y" name="ad_status" value="y" <?php if ($row_001["AD_STATUS"] == "y") { echo "checked"; } ?>> <label for="ad_status_y">활성</label> &nbsp;&nbsp;&nbsp;
				<input type="radio" id="ad_status_n" name="ad_status" value="n" <?php if ($row_001["AD_STATUS"] == "n") { echo "checked"; } ?>> <label for="ad_status_n">비활성</label>
			</td>
			<th>광고코드</th>
            <td class="left">
				<?= $row_001["AD_CODE"] ?>
			</td>
			</tr>
		<tr>
			<th>작성일</th>
			<td class="left">
				<input type="text" id="reg_date" name="reg_date" value="<?=$reg_date?>" style="width:120px;">
			</td>
			<th>시작일</th>
            <td>
				<input type="text" name="schReqSDate" id="schReqSDate" readonly value="<?= $row_001["START_DATE"] ?>" class="w120"/>
			</td>
			<th>종료일</th>
            <td>
				<input type="text" name="schReqEDate" id="schReqEDate" readonly value="<?= $row_001["END_DATE"] ?>" class="w120"/>
			</td>
            
			
		</tr>

		<tr>
			<th>제목</th>
			<td class="left" colspan="5">
				<input type="text" id="ad_title" name="ad_title" value="<?=clear_escape($row_001["AD_TITLE"])?>" class="w80p">&nbsp;&nbsp; 
				
			</td>
		</tr>

		<tr>
			<th style="line-height:180%;">내용1</th>
			<td colspan="5">
				<textarea id="ad_txt_1" name="ad_txt_1" class="w90p" style="height:50px;"><?=clear_escape($row_001["AD_TXT_1"])?></textarea>
			</td>
		</tr>
		<tr>
			<th style="line-height:180%;">내용2</th>
			<td colspan="5">
				<textarea id="ad_txt_2" name="ad_txt_2" class="w90p" style="height:50px;"><?=clear_escape($row_001["AD_TXT_2"])?></textarea>
			</td>
		</tr>
		<tr>
			<th style="line-height:180%;">내용3</th>
			<td colspan="5">
				<textarea id="ad_txt_3" name="ad_txt_3" class="w90p" style="height:50px;"><?=clear_escape($row_001["AD_TXT_3"])?></textarea>
			</td>
		</tr>
	    <tr>
			<th>링크</th>
			<td class="left" colspan="5">
				<input type="text" id="ad_link" name="ad_link" value="<?=clear_escape($row_001["AD_LINK"])?>" class="w80p">&nbsp;&nbsp; 
			</td>
		</tr>
		<tr>
			<th>광고이미지 (og:image)</th>
			<td colspan="5">
				<?php
        if (!isNull($row_001["PHYSICAL_NAME"])) {
          ?>
          <div style="padding:10px;">
            <img src="<?=$ad_img?>" width="300">
          </div>
          <div style="padding:10px 0;">
            <input type="checkbox" id="del_file" name="del_file" value="Y"/>
            <label for="del_file">첨부파일 삭제</label>
          </div>
          <?
        }
        ?>
        <input type="file" id="ad_file" class="uploadBtn" name="ad_file" style="width:80%;">
			</td>
		</tr>


	</table>

	<div style="margin-top:20px;" class="center">
		<input type="submit" value="수 정" class="Button btnGreen w120"> &nbsp; 
		<input type="button" value="목 록" class="Button btnRed w120" onClick="location.href='./admin.template.php?slot=ad&type=main_slide_list&<?= $_opt ?>'">
	</div>
	</form>

</div>

<script language="JavaScript" type="text/JavaScript">
    <!--
    $(document).ready(function () {
        var dates = $("#schReqSDate, #schReqEDate").datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            showMonthAfterYear: true,
            onSelect: function (selectedDate) {
                var option = this.id == "schReqSDate" ? "minDate" : "maxDate",
                    instance = $(this).data("datepicker"),
                    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                dates.not(this).datepicker("option", option, date);
            }
        });

    });

	$(document).ready(function () {
        var dates = $("#reg_date").datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
            showMonthAfterYear: true,
            
        });

    });

	function chk_form(f) {
            if ($("#ad_title").val() == "") {
                alert("제목을 입력 해 주시기 바랍니다");
                $("#ad_title").focus();
                return false;
            }

            return;
        }
    //-->
</script>