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

$_where[] = "1";

// 상태
if (!isNull($_search["status"])) {
    $_where[] = " t1.C_STATUS = '{$_search["status"]}' ";
}
$_status[$_search["status"]] = "selected";

// 분류
if (!isNull($_search["type"])) {
    $_where[] = " t1.C_TYPE = '{$_search["type"]}' ";
}

// 키워드 단어검색
if (!isNull($_search["keyword1"])) {
    $_where[] = $_search["keyfield1"] . " = HEX(AES_ENCRYPT('" . $_search["keyword1"] . "','" . SECRET_KEY . "'))";
}

// 키워드 범위검색
if (!isNull($_search["keyword2"])) {
    $_where[] = "instr({$_search["keyfield2"]}, '{$_search["keyword2"]}') >0 ";
}

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY t1.C_STATUS DESC, t1.REG_DATE DESC";
$_limit = " LIMIT " . $startNum . "," . $offset;


$qry_001  = " SELECT   ";
$qry_001 .= " count(*) ";
$_from    = " FROM {$TB_COUNSEL} t1 ";
$_from   .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.C_WRITE = t2.USER_ID ) ";
$_from   .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.C_MENTOR = t3.USER_ID ) ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];

$_opt = "&search_status=" . $_search["status"] . "&keyfield1=" . $_search["keyfield1"] . "&keyword1=" . $_search["keyword1"] . "&keyfield2=" . $_search["keyfield2"] . "&keyword2=" . $_search["keyword2"];

?>

<div id="Contents">
    <h1>상담관리 > 상담관리 > <strong>상담 리스트</strong></h1>

    <form id="sfrm" name="sfrm" method="GET" action="./admin.template.php">
        <input type="hidden" id="slot" name="slot" value="<?= $_slot ?>">
        <input type="hidden" id="type" name="type" value="<?= $_type ?>">
        <table class='tbl1'>
            <colgroup>
                <col width="10%">
                <col width="10%">
                <col width="*">
            </colgroup>
            <tr>
                <th rowspan="4">검색조건</th>
                <th>분류조건</th>
                <td>
                    <strong>구분</strong>
                    <select id="search_status" name="search_status" onChange="sfrm.submit();" class="w100">
                        <option value="">전체</option>
                        <option value="y" <?= $_status["y"] ?>>활성</option>
                        <option value="n" <?= $_status["n"] ?>>비활성</option>
                    </select>&nbsp;&nbsp;
                    <strong>분류</strong>
                    <select id="search_type" name="search_type" onChange="sfrm.submit();" class="w100">
                        <option value="">전체</option>
                        <?php
                        $qry_type = "SELECT * FROM {$TB_CODE} WHERE CD_STATUS='y' AND CD_TYPE='COUNSEL' ORDER BY ORDER_SEQ";
                        $res_type = $db->exec_sql($qry_type);
                        while ($row_type = $db->sql_fetch_array($res_type)) {
                            $_selected = $row_type["CD_KEY"] == $_search["type"] ? "SELECTED" : "";
                            ?>
                            <option
                            value="<?= $row_type["CD_KEY"] ?>" <?= $_selected ?>><?= clear_escape($row_type["CD_TITLE"]) ?></option><?
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <th>단어 검색어</th>
                <td>
                    <select id="keyfield1" name="keyfield1" class="w100">
                        <option value="t3.USER_NAME" <? if ($_search["keyfield1"] == "t3.USER_NAME") echo "selected"; ?>>전문약사명
                        </option>
                        <option value="t2.USER_NAME" <? if ($_search["keyfield1"] == "t2.USER_NAME") echo "selected"; ?>>작성자명
                        </option>
                    </select>

                    <input type="text" id="keyword1" name="keyword1" value="<?= $_search["keyword1"] ?>" class="w50p">
                </td>
            </tr>
            <tr>
                <th>범위 검색어</th>
                <td>
                    <select id="keyfield2" name="keyfield2" class="w100">
                        <option value="t1.C_TITLE" <? if ($_search["keyfield2"] == "t1.C_TITLE") {
                            echo "selected";
                        } ?>>제목
                        </option>
                        <option value="t1.C_QUESTION" <? if ($_search["keyfield2"] == "t1.C_QUESTION") {
                            echo "selected";
                        } ?>>내용
                        </option>
                    </select>
                    <input type="text" id="keyword2" name="keyword2" value="<?= $_search["keyword2"] ?>"
                           style='width:150px;'>&nbsp;
                </td>
            </tr>
            <tr>
                <th>검색버튼</th>
                <td>
                    <input type="submit" value="검색" class="btnOrange w80 h24"> &nbsp;
                    <input type="button" value="초기화" class="btnGray w80 h24"
                           onClick="location.href='./admin.template.php?slot=<?= $_slot ?>&type=<?= $_type ?>'">
                </td>
            </tr>
        </table>
    </form>

    <div class="pt10">Total : <?= $totalnum ?></div>
    <form id='frm' name='frm'>
        <input type="hidden" id="Mode" name="Mode" value="">

        <table class='tbl1'>
            <colgroup>
                <col width="4%"/>
                <col width="6%"/>
                <col width="6%"/>
                <col width="15%"/>
                <col width="*"/>
                <col width="10%"/>
                <col width="5%"/>
                <col width="10%"/>
                <col width="10%"/>
            </colgroup>

            <tr>
                <th>No</th>
                <th>상태</th>
                <th>분류</th>
                <th>전문약사</th>
                <th>제목</th>
                <th>작성자</th>
                <th>클릭수</th>
                <th>등록일</th>
                <th>관리</th>
            </tr>
            <?
            if ($totalnum > 0) {

                $qry_002  = " SELECT t1.*, t1.REG_DATE AS date ";
                $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t1.C_MENTOR),'" . SECRET_KEY . "') as char) as mm_id ";
                $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as p_name ";
                $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order . $_limit);

                $_j = 0;
                while ($row_002 = $db->sql_fetch_array($res_002)) {

                    $_jul = $totalnum - ($startNum + $_j);
                    $_status_view = $row_002["C_STATUS"] == "y" ? "활성" : "비활성";
                    $secret = (isNull($row_002["C_MENTOR"])) ? "전체공개" : "약사";
                    $up_url = "./admin.template.php?slot=counsel&type=counsel_detail&idx=" . $row_002["IDX"] . "&page=" . $page . $_opt;

                    ?>
                    <tr>
                        <td class="center"><?= $_jul ?></td>
                        <td class="center"><?= $_status_view ?></td>
                        <!--<td class="center"><?/*= clear_escape($row_002["CD_TITLE"]) */ ?></td>-->
                        <td class="center"><?= $row_002["C_TYPE"] ?></td>
                        <td class="center">
                            <?php
                            if ($secret == "약사") {
                                echo "<font color='FF0000'>".$row_002["p_name"]. " ( " . $row_002["mm_id"] . " ) </font>";
                            } else {
                                echo "<font color='0000FF'>".$secret."</font>";
                            }
                            ?>
                        </td>
                        <td class="center"><?= clear_escape($row_002["C_TITLE"]) ?><br></td>
                        <td class="center"><?= clear_escape($row_002["mm_name"]) ?></td>
                        <td class="center"><?= number_format($row_002["HIT"]) ?></td>
                        <td class="center"><?= clear_escape($row_002["date"]) ?></td>
                        <td class="center">
                            <input type="button" value="상세" class="Small_Button btnGreen w50 h24"
                                   onClick="location.href='<?= $up_url ?>'">&nbsp;
                            <input type="button" value="삭제" class="Small_Button btnRed w50 h24"
                                   onClick="del_counsel('<?= $row_002["IDX"] ?>');">
                        </td>
                    </tr>
                    <?
                    $_j++;
                }
            } else {
                ?>
                <tr>
                    <td colspan="9" style='height:200px;' class='center'>등록된 상담이 없습니다.</td>
                </tr>
                <?
            }
            ?>
        </table>

        <div id="Paser">
            <?
            $paging = new paging("./admin.template.php", "slot=counsel&type=counsel_list", $offset, $page_block, $totalnum, $page, $_opt);
            $paging->pagingArea("", "");
            ?>
        </div>

    </form>
</div>

<script language="JavaScript" type="text/JavaScript">
        function del_counsel(idx){
            if(confirm("정말 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다.")){
                location.href="./_action/counsel.do.php?Mode=del_counsel&idx="+idx;
            }
        }
</script>