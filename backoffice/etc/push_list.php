<?
$offset = 20;
$page_block = 10;
$startNum = "";
$totalnum = "";
$page = "";
$page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

if (!isNull($page)) {
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

// 검색 변수
$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["keyfield1"] = isNull($_GET["keyfield1"]) ? "" : $_GET["keyfield1"];
$_search["keyword1"] = isNull($_GET["keyword1"]) ? "" : $_GET["keyword1"];
$_search["keyfield2"] = isNull($_GET["keyfield2"]) ? "" : $_GET["keyfield2"];
$_search["keyword2"] = isNull($_GET["keyword2"]) ? "" : $_GET["keyword2"];
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];

$_where[] = "P_STATUS = '1' ";

if ($_search["schChkDate"] == "Y") {
    $_checked = "checked";
    $_disabled = "";

    $_where[] = " t1.REG_DATE BETWEEN '" . date("Y-m-d H:i:s", strtotime($_search["schReqSDate"])) . "' AND '" . date("Y-m-d H:i:s", strtotime("+1 days", strtotime($_search["schReqEDate"]) - 1)) . "' ";
} else {
    $_checked = "";
    $_disabled = "disabled";
}

// 키워드 단어검색
if (!isNull($_search["keyword1"])) {
    $_where[] = $_search["keyfield1"] . " = HEX(AES_ENCRYPT('" . $_search["keyword1"] . "','" . SECRET_KEY . "'))";
}

// 키워드 범위검색
if (!isNull($_search["keyword2"])) {
    $_where[] = "instr({$_search["keyfield2"]}, '{$_search["keyword2"]}') >0 ";

}

$_opt = "&keyfield1=" . $_search["keyfield1"] . "&keyword1=" . $_search["keyword1"] . "&keyfield2=" . $_search["keyfield2"] . "&keyword2=" . $_search["keyword2"] . "&schChkDate=" . $_search["schChkDate"] . "&schReqSDate=" . $_search["schReqSDate"]. "&schReqEDate=" . $_search["schReqEDate"];

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY t1.IDX desc";
$_limit = " LIMIT " . $startNum . "," . $offset;

$_sql = " SELECT ";
$_sql .= " count(*) ";

$_from = " FROM {$TB_PUSH} t1 ";
$_from .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.USER_ID = t2.USER_ID )";
$_from .= " LEFT JOIN {$TB_MEMBER_INFO} t3 ON ( t1.USER_ID = t3.ID_KEY )";

$_res = $db->exec_sql($_sql . $_from . $_whereqry);
$_row = $db->sql_fetch_row($_res);
$totalnum = $_row[0];

?>
<div id="Contents">
    <h1>기타관리 > 푸시 관리 > <strong>푸시 목록</strong></h1><br>

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
                <th rowspan="4">검색조건</th>
                <th>발송일 &nbsp; <input type="checkbox" id="schChkDate" name="schChkDate" value="Y"
                                       onClick="dateDisable();" <?= $_checked ?>></th>
                <td>
                    <input type="text" name="schReqSDate" id="schReqSDate" readonly value="<?= $_search["schReqSDate"] ?>"
                           class="w90" <?= $_disabled ?>/> 일 부터
                    <input type="text" name="schReqEDate" id="schReqEDate" readonly value="<?= $_search["schReqEDate"] ?>"
                           class="w90" <?= $_disabled ?>/> 일 까지
                </td>
            </tr>
            <tr>
                <th>단어검색</th>
                <td>
                    <select id="keyfield1" name="keyfield1" class="w120">
                        <option value="t1.USER_ID" <? if ($_search["keyfield1"] == "t1.USER_ID") echo "selected"; ?>>회원아이디
                        </option>
                        <option value="t2.USER_NAME" <? if ($_search["keyfield1"] == "t2.USER_NAME") echo "selected"; ?>>회원명
                        </option>
                        <option value="t3.USER_PHONE" <? if ($_search["keyfield1"] == "t3.USER_PHONE") echo "selected"; ?>>회원연락처
                        </option>
                    </select>

                    <input type="text" id="keyword1" name="keyword1" value="<?= $_search["keyword1"] ?>" class="w50p">
                </td>
            </tr>
            <tr>
                <th>범위검색</th>
                <td>
                    <select id="keyfield2" name="keyfield2" class="w120">
                        <option value="t1.P_MSG" <? if ($_search["keyfield2"] == "t1.P_MSG") echo "selected"; ?>>내용
                        </option>
                    </select>

                    <input type="text" id="keyword2" name="keyword2" value="<?= $_search["keyword2"] ?>" class="w50p">
                </td>
            </tr>
            <tr>
                <th>검색버튼</th>
                <td>
                    <input type="submit" value="검색" class="btnOrange w80 h24"> &nbsp;
                    <input type="button" value="초기화" class="btnGray w80 h24"
                           onClick="location.href='./admin.template.php?slot=<?= $_slot ?>&type=<?= $_type ?>'"> &nbsp;
                </td>
            </tr>
        </table>
    </form>

    <div class="pt10">Total : <?= $totalnum ?></div>
    <form id='frm' name='frm'>
        <input type="hidden" id="Mode" name="Mode" value="">

        <table class='tbl1'>
            <colgroup>
                <col width="3%"/>
                <col width="12%"/>
                <col width="8%"/>
                <col width="12%"/>
                <col width="*"/>
                <col width="10%"/>
                <col width="15%"/>
                <col width="15%"/>
            </colgroup>
            <tr>
                <th>
                    <?
                    if ($totalnum > 0) {
                        ?><input type='checkbox' id='allChk' name='allChk'><?
                    } else {
                        ?>&nbsp;<?
                    }
                    ?>
                </th>
                <th>회원아이디</th>
                <th>회원명</th>
                <th>회원연락처</th>
                <th>푸시내용</th>
                <th>발송ID</th>
                <th>발송일</th>
                <th>확인일</th>
            </tr>
            <?
            if ($totalnum > 0) {

                $qry_001 = " SELECT t1.*, t2.*, t3.*, t1.IDX AS idx, t1.REG_DATE date ";
                $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
                $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

                $res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry . $_order . $_limit);

                while ($row_001 = $db->sql_fetch_array($res_001)) {
                    $SHOW_DATE_TXT = $row_001["SHOW_DATE"] == "0000-00-00 00:00:00" ? "미확인" : $row_001["SHOW_DATE"];

                    ?>
                    <tr>
                        <td class='center'><input type="checkbox" name="checked_member[]"
                                                  value="<?= $row_001['IDX'] ?>"/>
                        </td>
                        <td><?= $row_001["mm_id"] ?></td>
                        <td><?= $row_001["mm_name"] ?></td>
                        <td><?= $row_001["mm_phone"] ?></td>
                        <td class="left"><?= stripslashes(cut_str($row_001["P_MSG"], 40, "...")) ?>&nbsp;&nbsp;&nbsp;&nbsp;<span
                                    onClick="openWin('./etc/popup_push_msg.php?idx=<?= $row_001["idx"] ?>','msgTxt',500,600,'scrollbars=yes')"
                                    style="cursor:pointer;">[전문보기]</span></td>
                        <td><?= $row_001["ADMIN_ID]"] ?></td>
                        <td><?= $row_001["date"] ?></td>
                        <td><?= $SHOW_DATE_TXT ?></td>
                    </tr>
                    <?
                }
            } else {
                ?>
                <tr>
                    <td colspan="10" class='center' style='height:200px;'>발송한 푸시메시지가 없습니다.</td>
                </tr>
                <?
            }
            ?>
        </table>

        <div id="Paser">
            <?
            $paging = new paging("./admin.template.php", "slot=push&type=push_list", $offset, $page_block, $totalnum, $page, $_opt);
            $paging->pagingArea("", "");
            ?>
        </div>

    </form>
</div>

<script language="JavaScript" type="text/JavaScript">
    <!--
    $("#allChk").click(function () {
        if ($("#allChk").prop("checked") == true) {
            $("#groupTable input[type='checkbox']").prop("checked", true);
        } else {
            $("#groupTable input[type='checkbox']").prop("checked", false);
        }
    });

    function checkedSubmit() {
        if (0 == $("input[name='checked_member[]']:checked").length) {
            alert("최소 한명 이상의 회원을 선택하셔야 합니다.");
            return false;
        }

        if (confirm("푸시정보를 삭제하시겠습니까? \n\n삭제 후에는 복구가 불가능합니다")) {
            $("#frm").submit();
        }

    }

    function msgLayer(e) {


        var sWidth = window.innerWidth;
        var sHeight = window.innerHeight;

        var oWidth = $('.popupLayer').width();
        var oHeight = $('.popupLayer').height();

        // 레이어가 나타날 위치를 셋팅한다.
        var divLeft = e.clientX + 10;
        var divTop = e.clientY + 5;

        // 레이어가 화면 크기를 벗어나면 위치를 바꾸어 배치한다.
        if (divLeft + oWidth > sWidth) divLeft -= oWidth;
        if (divTop + oHeight > sHeight) divTop -= oHeight;

        // 레이어 위치를 바꾸었더니 상단기준점(0,0) 밖으로 벗어난다면 상단기준점(0,0)에 배치하자.
        if (divLeft < 0) divLeft = 0;
        if (divTop < 0) divTop = 0;

        $('.popupLayer').css({
            "top": divTop,
            "left": divLeft,
            "position": "absolute"
        }).show();

        $('popupLayer').html("aaa");

    }

    //-->
</script>

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