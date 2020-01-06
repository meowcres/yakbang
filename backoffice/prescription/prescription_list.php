<?
$offset = 20;
$page_block = 10;
$startNum = "";
$totalnum = "";
$page = "";
$_page = isNull($_REQUEST["page"]) ? $_clean["page"] : $_REQUEST["page"];

if (!isNull($_page)) {
    $page = $_page;
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

// 검색 변수
$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["type"] = isNull($_GET["search_type"]) ? "" : $_GET["search_type"];
$_search["keyfield1"] = isNull($_GET["keyfield1"]) ? "" : $_GET["keyfield1"];
$_search["keyword1"] = isNull($_GET["keyword1"]) ? "" : $_GET["keyword1"];
$_search["keyfield2"] = isNull($_GET["keyfield2"]) ? "" : $_GET["keyfield2"];
$_search["keyword2"] = isNull($_GET["keyword2"]) ? "" : $_GET["keyword2"];
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];

$_where[] = " 1 ";

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
/*if (!isNull($_search["keyword2"])) {
    $_where[] = "instr({$_search["keyfield2"]}, '{$_search["keyword2"]}') >0 ";
}*/

// 상태
if (!isNull($_search["status"])) {
    $_where[] = " t1.PS_STATUS = '{$_search["status"]}' ";
}
$_status[$_search["status"]] = "selected";

// 분류
if (!isNull($_search["type"])) {
    $_where[] = " t1.SEND_TYPE = '{$_search["type"]}' ";
}

$_opt = "&search_status=" . $_search["status"] . "&search_type=" . $_search["type"] . "&keyfield1=" . $_search["keyfield1"] . "&keyword1=" . $_search["keyword1"] . "&keyfield2=" . $_search["keyfield2"] . "&keyword2=" . $_search["keyword2"] . "&schChkDate=" . $_search["schChkDate"] . "&schReqSDate=" . $_search["schReqSDate"]. "&schReqEDate=" . $_search["schReqEDate"];


$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY t1.REG_DATE DESC ";
$_limit = " LIMIT " . $startNum . "," . $offset;


$qry_cnt = "SELECT count(*)  ";

$_from   = " FROM {$TB_PS} t1 ";
$_from  .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.USER_ID = t2.USER_ID ) ";
$_from  .= " LEFT JOIN {$TB_MEMBER_INFO} t3 ON ( t1.USER_ID = t3.ID_KEY ) ";

$res_cnt = $db->exec_sql($qry_cnt . $_from . $_whereqry);
$row_cnt = $db->sql_fetch_row($res_cnt);

$totalnum = $row_cnt[0];
?>
<div id="Contents">
    <h1>처방전관리 &gt; 처방전 관리 &gt; <strong>처방전목록</strong></h1>

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
                <th>등록일 &nbsp; <input type="checkbox" id="schChkDate" name="schChkDate" value="Y"
                                      onClick="dateDisable();" <?= $_checked ?>></th>
                <td>
                    <input type="text" name="schReqSDate" id="schReqSDate" readonly value="<?= $_search["schReqSDate"] ?>"
                           class="w90" <?= $_disabled ?>/> 일 부터
                    <input type="text" name="schReqEDate" id="schReqEDate" readonly value="<?= $_search["schReqEDate"] ?>"
                           class="w90" <?= $_disabled ?>/> 일 까지
                </td>
            </tr>
            <tr>
                <th>분류조건</th>
                <td>
                    <strong>구분</strong>
                    <select id="search_status" name="search_status" onChange="sfrm.submit();" class="w100">
                        <option value="">전체</option>
                        <?php
                        foreach ($prescription_status_array as $key => $val) {
                            $selected = $key == $_search["status"] ? "SELECTED" : "";
                            ?>
                        <option value="<?= $key ?>" <?= $selected ?> > <?= $val ?> </option><?
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                    <strong>분류</strong>
                    <select id="search_type" name="search_type" onChange="sfrm.submit();" class="w100">
                        <option value="">전체</option>
                        <?php
                        foreach ($prescription_type_array as $key => $val) {
                            $selected = $key == $_search["type"] ? "SELECTED" : "";
                            ?>
                        <option value="<?= $key ?>" <?= $selected ?> > <?= $val ?> </option><?
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <th>단어검색</th>
                <td>
                    <select id="keyfield1" name="keyfield1" class="w120">
                        <option value="t2.USER_NAME" <? if ($_search["keyfield1"] == "t2.USER_NAME") echo "selected"; ?>>회원명
                        </option>
                        <option value="t1.USER_ID" <? if ($_search["keyfield1"] == "t1.USER_ID") echo "selected"; ?>>회원아이디
                        </option>
                        <option value="t3.USER_PHONE" <? if ($_search["keyfield1"] == "t3.USER_PHONE") echo "selected"; ?>>회원연락처
                        </option>
                    </select>

                    <input type="text" id="keyword1" name="keyword1" value="<?= $_search["keyword1"] ?>" class="w50p">
                </td>
            </tr>
            <!--<tr>
                <th>범위검색</th>
                <td>
                    <select id="keyfield2" name="keyfield2" class="w120">
                        <option value="t1.P_MSG" <?/* if ($_search["keyfield2"] == "t1.P_MSG") echo "selected"; */?>>내용
                        </option>
                    </select>

                    <input type="text" id="keyword2" name="keyword2" value="<?/*= $_search["keyword2"] */?>" class="w50p">
                </td>
            </tr>-->
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

    <div class="left" style="margin-top:15px;"><b>처방전 목록</b> ( <?= number_format($totalnum) ?> 건 )</div>
    <table>
        <colgroup>
            <col width="10%"/>
            <col width="6%"/>
            <col width="6%"/>
            <col width="*"/>
            <col width="10%"/>
            <col width="10%"/>
            <col width="10%"/>
            <col width="10%"/>
            <col width="8%"/>
        </colgroup>
        <tr>
            <th>처방전 코드</th>
            <th>처방전 상태</th>
            <th>처방전 타입</th>
            <th>이름 ( 아이디 )</th>
            <th>연락처</th>
            <th>등록일</th>
            <th>수정일</th>
            <th>완료일</th>
            <th>관리</th>
        </tr>
        <?
        if ($totalnum > 0) {

            $qry_002  = " SELECT t1.*, t2.*, t1.REG_DATE AS date, t1.UP_DATE AS up_date  ";
            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

            $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order . $_limit);
            while ($row_002 = $db->sql_fetch_array($res_002)) {
                $information_ref = "./admin.template.php?slot=prescription&type=prescription_detail&step=pill&ps_code=" . $row_002["PS_CODE"] . $_opt;
                if ($row_002["PS_STATUS"] == 1) {
                    $status = "<font color='0000FF'>".$prescription_status_array[$row_002["PS_STATUS"]]."</font>";
                } else if ($row_002["PS_STATUS"] == 2) {
                    $status = "<font color='FF0000'>".$prescription_status_array[$row_002["PS_STATUS"]]."</font>";
                }
                    ?>
                    <tr>
                        <td class="center"><?= $row_002["PS_CODE"] ?></td>
                        <td class="center"><?= $status ?></td>
                        <td class="center"><?= $prescription_type_array[$row_002["SEND_TYPE"]] ?></td>
                        <td class="center"><?= $row_002["mm_name"] ?> ( <?= $row_002["mm_id"] ?> )</td>
                        <td class="center"><?= $row_002["mm_phone"] ?></td>
                        <td class="center"><?= $row_002["date"] ?></td>
                        <td class="center"><?= $row_002["up_date"] ?></td>
                        <td class="center"><?= $row_002["COMPLETE_DATE"] ?></td>
                        <td class="center">
                            <input type="button" value="관리" class="Small_Button btnGreen"
                                   onClick="location.href='<?= $information_ref ?>'">
                            <input type="button" value="삭제" class="Small_Button btnRed"
                                   onClick="del_ps('<?= $row_002["PS_CODE"] ?>');">
                        </td>
                    </tr>
                    <?
            }
        } else {
            ?>
            <tr>
                <td colspan="9" height="200" class="center">처방전 목록이 없습니다.</td>
            </tr>
            <?
        }
        ?>
    </table>

    <div align="center" style="padding-top:10px;">
        <?
        $_url = "&slot=prescription&type=prescription_list";
        $paging = new paging("./admin.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
        $paging->pagingArea("", "");
        ?>
    </div><br>

    <? $db->db_close(); ?>

</div>

<script>
    function del_ps(ps_code) {
        if(confirm("\n정말 삭제하시겠습니까? \n\n삭제 후에는 복구가 불가능합니다.")) {
            location.href="./_action/prescription.do.php?Mode=del_prescription&ps_code="+ps_code;
        }
    }
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