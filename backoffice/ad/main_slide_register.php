<?php
$ad_code_txt = "M1".mktime();
?>
<div id="Contents">
    <h1>광고관리 &gt; MAIN SLIDE 광고 &gt; <strong>MAIN SLIDE 광고 등록</strong></h1><br>

    <form name="frm" method="post" enctype="multipart/form-data" action="./_action/ad.do.php"
          onSubmit="return chk_form(this);" style="display:inline;" target="actionForm">
        <input type="hidden" id="mode" name="mode" value="add_main">
        <input type="hidden" id="ad_code" name="ad_code" value="<?= $ad_code_txt ?>">
        <input type="hidden" id="ad_type" name="ad_type" value="2">
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
                    <input type="radio" id="ad_status_y" name="ad_status" value="y"> <label for="ad_status_y">활성</label> &nbsp;&nbsp;&nbsp;
                    <input type="radio" id="ad_status_n" name="ad_status" value="n" checked> <label for="ad_status_n">비활성</label>
                </td>
                <th>광고코드</th>
                <td class="left">
                    <?= $ad_code_txt?></td>
            </tr>

            <tr>
                
                <th>작성일</th>
                <td class="left">
                    <input type="text" name="reg_date" id="reg_date" value="<?= date('Y-m-d') ?>"
                       class="w120" />
                </td>
				<th>시작일</th>
            <td>
				<input type="text" name="schReqSDate" id="schReqSDate" readonly value="" class="w120"/>
			</td>
			<th>종료일</th>
            <td>
				<input type="text" name="schReqEDate" id="schReqEDate" readonly value="" class="w120"/>
			</td>
            </tr>

            <tr>
                <th>제목</th>
                <td class="left" colspan="5">
                    <input type="text" id="ad_title" name="ad_title" value="" class="w95p">
                </td>
            </tr>

            <tr>
                <th style="line-height:180%;">내용1</th>
                <td colspan="5">
                    <textarea id="ad_txt_1" name="ad_txt_1" class="w95p h50"><?= $_SITE["ad_txt_1"] ?></textarea>
                </td>
            </tr>
			<tr>
                <th style="line-height:180%;">내용2</th>
                <td colspan="5">
                    <textarea id="ad_txt_2" name="ad_txt_2" class="w95p h50"><?= $_SITE["ad_txt_2"] ?></textarea>
                </td>
            </tr>
			<tr>
                <th style="line-height:180%;">내용3</th>
                <td colspan="5">
                    <textarea id="ad_txt_3" name="ad_txt_3" class="w95p h50"><?= $_SITE["ad_txt_3"] ?></textarea>
                </td>
            </tr>
            <tr>
                <th>링크</th>
                <td class="left" colspan="5">
                    <input type="text" id="ad_link" name="ad_link" value="" class="w95p">
                </td>
            </tr>
            <tr>
                <th>광고이미지 (og:image)</th>
                <td colspan="5">
                    <input type="file" id="ad_file" name="ad_file" value="" class="w95p">
                </td>
            </tr>

        </table>

        <div style="margin-top:20px;" class="center">
            <input type="submit" value="등록" class="Button btnGreen w100"> &nbsp;
            <input type="button" value="취소" class="Button btnRed w100" onClick="history.back();">
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