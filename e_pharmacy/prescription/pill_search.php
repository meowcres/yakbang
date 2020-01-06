<form id="sfrm" name="sfrm" method="GET" action="./popup_pill_list.php?ps_code=<?=$ps_code?>&pharmacy_code=<?=$pharmacy_code?>">
    <input type="hidden" id="ps_code" name="ps_code" value="<?= $ps_code ?>">
    <input type="hidden" id="pharmacy_code" name="pharmacy_code" value="<?= $pharmacy_code ?>">

    <table class='tbl1'>
        <colgroup>
            <col width="10%">
            <col width="*">
        </colgroup>

            <th>검색어</th>
            <td style="text-align:left">
                <select id="keyfield" name="keyfield" class="w120">
                    <option value="t1.PILL_STANDARD_CODE" <? if ($_search["keyfield"] == "t1.PILL_STANDARD_CODE") echo "selected"; ?>>표준코드명</option>
                    <option value="t1.PILL_CATEGORY" <? if ($_search["keyfield"] == "t1.PILL_CATEGORY") echo "selected"; ?>>품목분류</option>
                    <option value="t1.PILL_NAME" <? if ($_search["keyfield"] == "t1.PILL_NAME") echo "selected"; ?>>의약품명</option>
                    <option value="t1.PILL_COMPANY" <? if ($_search["keyfield"] == "t1.PILL_COMPANY") echo "selected"; ?>>제조사명</option>
                </select>

                <input type="text" id="keyword" name="keyword" value="<?= $_search["keyword"] ?>" style="width:200px;">&nbsp;&nbsp;
                
                <input type="submit" value="검색" style="width:70px;height:24px;background-color:#51c33a;color:white;border-radius:5px;"> &nbsp;
                <input type="button" value="초기화" onClick="location.href='./popup_pill_list.php?ps_code=<?=$ps_code?>&pharmacy_code=<?=$pharmacy_code?>'" style="width:70px;height:24px;background-color:#51c33a;color:white;border-radius:5px;">
            </td>
        </tr>
    </table>
</form><br>


<script language="JavaScript" type="text/JavaScript">

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


</script>