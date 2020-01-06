<form id="sfrm" name="sfrm" method="GET" action="./admin.template.php">
    <input type="hidden" id="slot" name="slot" value="<?= $_slot ?>">
    <input type="hidden" id="type" name="type" value="<?= $_type ?>">
    <table class='tbl1'>
        <colgroup>
            <col width="8%">
            <col width="8%">
            <col width="*">
        </colgroup>
        
        <tr>
            <th rowspan="3">검색조건</th>
            <th>로그인 일자 &nbsp; <input type="checkbox" id="schChkDate" name="schChkDate" value="Y" onClick="dateDisable();" <?= $_checked ?>></th>
            <td>
                <input type="text" name="schReqSDate" id="schReqSDate" readonly value="<?= $schReqSDate ?>" class="w90" <?= $_disabled ?>/> 일 부터 &nbsp;&nbsp;
                <input type="text" name="schReqEDate" id="schReqEDate" readonly value="<?= $schReqEDate ?>" class="w90" <?= $_disabled ?>/> 일 까지
            </td>
        </tr>

        <tr>
            <th>단어 검색어</th>
            <td>
                <select id="keyfield" name="keyfield" class="w120">
                    <option value="t1.OP_ID" <? if ($_search["keyfield"] == "t1.OP_ID") echo "selected"; ?>>아이디</option>
                    <option value="t1.OP_IP" <? if ($_search["keyfield"] == "t1.OP_IP") echo "selected"; ?>>로그인IP</option>
                </select>

                <input type="text" id="keyword" name="keyword" value="<?= $search["keyword"] ?>" class="w50p">
            </td>
        </tr>

        <tr>
            <th>검색버튼</th>
            <td>
                <input type="submit" value="검색" class="btnOrange w80 h24"> &nbsp;
                <input type="button" value="초기화" class="btnGray w80 h24" onClick="location.href='./admin.template.php?slot=<?= $_slot ?>&type=<?= $_type ?>'">
            </td>
        </tr>
    </table>
</form>


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

    function dateDisable() {
        if (document.getElementById("schChkDate").checked == true) {
            document.getElementById("schReqSDate").disabled = false;
            document.getElementById("schReqEDate").disabled = false;
        } else {
            document.getElementById("schReqSDate").disabled = true;
            document.getElementById("schReqEDate").disabled = true;
        }
    }
    //-->
</script>