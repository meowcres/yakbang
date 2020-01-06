<?php
/**
 *  CONTROLLER
 **/

// 페이징 변수
$offset = 20;
$page_block = 10;
$startNum = "";
$totalnum = "";
$page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

if ($page > 1) {
    $page = $_page;
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

// 검색 변수
$search = array();
$search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];

$where_array[] = "t1.CD_TYPE IN ('NOTICE')";
$where_array[] = "t1.CD_DEPTH IN ('1')";

// 활동상태
if (!isNull($search["status"])) {
    $where_array[] = "t1.CD_STATUS='{$search["status"]}'";
}
$_status[$search["status"]] = "SELECTED";

// 키워드 검색
if (!isNull($search["keyword"])) {
    $where_array[] = "instr(t1.CD_TITLE,'{$search["keyword"]}')>0";
}

// 쿼리 조건절
$qry_where = count($where_array) ? " WHERE " . implode(' AND ', $where_array) : "";
$qry_order = " ORDER BY t1.CD_STATUS, t1.ORDER_SEQ";
$qry_limit = " LIMIT " . $startNum . "," . $offset;

// 목록수
$qry_001 = " SELECT           ";
$qry_001 .= " count(*)         ";

$qry_from = " FROM {$TB_CODE} t1 ";

$res_001 = $db->exec_sql($qry_001 . $qry_from . $qry_where);
$row_001 = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];

// 주소이동변수
$url_opt = "&search_status=" . $search["status"] . "&keyword=" . $search["keyword"];

?>
<div id="Contents">
    <h1>커뮤니티 &gt; 분류관리 &gt; <strong> 공지사항 분류관리</strong></h1>

    <div class="right">
        <input type="button" value="공지사항 분류 등록" class="btnGreen w120 h32"
               onClick="openWin('./board/popup.type_notice_register.php','typeRegister',700,270,'scrollbars=no');">
    </div>
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
                <th rowspan="3">검색조건</th>
                <th>상태조건</th>
                <td>
                    <select id="search_status" name="search_status" onChange="sfrm.submit();" class="w100">
                        <option value="">전체</option>
                        <option value="y" <?= $_status["y"] ?>>활성</option>
                        <option value="n" <?= $_status["n"] ?>>비활성</option>
                    </select>&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <th>검색어</th>
                <td>
                    <input type="text" id="keyword" name="keyword" value="<?= $search["keyword"] ?>" class="w50p">
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
    <table class='tbl1'>
        <colgroup>
            <col width="4%">
            <col width="5%">
            <col width="4%">
            <col width="7%">
            <col width="*">
            <col width="12%">
        </colgroup>

        <tbody>
        <tr>
            <th>No</th>
            <th>표시</th>
            <th>정렬</th>
            <th>분류코드</th>
            <th>공지사항 분류명</th>
            <th>수정 / 삭제</th>
        </tr>
        <?
        if ($totalnum > 0) {
            unset($qry_001);
            unset($res_001);
            unset($row_001);

            $qry_002 = "SELECT t1.* ";
            $res_002 = $db->exec_sql($qry_002 . $qry_from . $qry_where . $qry_order . $qry_limit);

            $j = 1;
            while ($row_002 = $db->sql_fetch_array($res_002)) {

                $line_number = $j + $startNum;
                $status_view = $row_002["CD_STATUS"] == "y" ? "<font color='#3333FF'><b>활성</b></font><br>" : "<font color='#FF3300'>비활성</font><br>";
                ?>
                <tr>
                    <td class="center"><?= $line_number ?></td>
                    <td class="center"><?= $status_view ?></td>
                    <td class="center"><?= $row_002["ORDER_SEQ"] ?></td>
                    <td class="center"><?= $row_002["CD_KEY"] ?></td>
                    <td>
                        <?= clear_escape($row_002["CD_TITLE"]) ?>
                    </td>
                    <td class="center">
                        <input type="button" value="수정" class="btnBlue w60 h24"
                               onClick="openWin('./board/popup.type_notice_update.php?CD_KEY=<?= $row_002['CD_KEY'] ?>','typeRegister',700,270,'scrollbars=no');">&nbsp;
                        <input type="button" value="삭제" class="btnRed w60 h24"
                               onClick="del_menu('<?= $row_002["CD_KEY"] ?>')">
                    </td>
                </tr>
                <?
                $j++;
            }
        } else {
            ?>
            <tr>
                <td colspan="6" class='center' style="height:150px;">등록된 공지사항 분류가 없습니다.</td>
            </tr>
            <?
        }
        ?>
        </tbody>
    </table>

    <div id="Paser">
        <?php
        $paging = new paging("./admin.template.php", "slot=".$_slot."&type=".$_type, $offset, $page_block, $totalnum, $page, $url_opt);
        $paging->pagingArea("", "");
        ?>
    </div>

</div>

<script language="javascript">
    <!--
    function del_menu(cdKey) {
        if (confirm("공지사항 분류정보를 삭제하겠습니까? \n\n삭제 후에는 복구가 불가능합니다.")) {
            actionForm.location.href = "./_action/board.do.php?mode=del_board_type&cd_key=" + cdKey;
            return;
        }
    }

    //-->
</script>

<? $db->db_close(); ?>
