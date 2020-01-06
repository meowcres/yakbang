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
$_search["type"] = isNull($_GET["search_type"]) ? "" : $_GET["search_type"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];

$_where[] = "1";


// 상태
if (!isNull($_search["status"])) {
    $_where[] = " t1.N_STATUS = '{$_search["status"]}' ";
}
$_status[$_search["status"]] = "selected";


// 분류
if (!isNull($_search["type"])) {
    $_where[] = " t1.N_TYPE = '{$_search["type"]}' ";
}


// 키워드 검색
if (!isNull($_search["keyword"])) {
    $_where[] = "instr({$_search["keyfield"]}, '{$_search["keyword"]}') >0 ";

}

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY t1.N_STATUS DESC, t1.IDX DESC";
$_limit = " LIMIT " . $startNum . "," . $offset;


$qry_001  = " SELECT   ";
$qry_001 .= " count(*) ";

$_from  = " FROM {$TB_NOTICE} t1 ";
$_from .= " LEFT JOIN {$TB_CODE} t2 ON (t1.N_TYPE=t2.CD_KEY) ";


$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];

$_opt = "&search_status=" . $_search["status"] . "&search_type=" . $_search["type"] . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"];

?>

<div id="Contents">
    <h1>커뮤니티 > 게시판 > <strong>공지사항 목록</strong></h1>

    <div class="right">
        <input type="button" value="공지사항 등록" class="Small_Button btnRed w120 h32"
               onClick="location.href='./admin.template.php?slot=board&type=notice_register'">
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
                <th>분류조건</th>
                <td>
                    <strong>구분</strong>
                    <select id="search_status" name="search_status" onChange="sfrm.submit();" class="w100">
                        <option value="">전체</option>
                        <option value="y" <?= $_status["y"] ?>>공지</option>
                        <option value="n" <?= $_status["n"] ?>>일반</option>
                    </select>&nbsp;&nbsp;
                    <strong>분류</strong>
                    <select id="search_type" name="search_type" onChange="sfrm.submit();" class="w100">
                        <option value="">전체</option>
                        <?php
                        $qry_type = "SELECT * FROM {$TB_CODE} WHERE CD_STATUS='y' AND CD_TYPE='NOTICE' ORDER BY ORDER_SEQ";
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
                <th>검색어</th>
                <td>
                    <select id="keyfield" name="keyfield">
                        <option value="t1.N_WRITE" 
                        <? 
                        if ($_search["keyfield"] == "t1.N_WRITE") {
                            echo "selected";
                        } 
                        ?>
                        >작성자
                        </option>
                        <option value="t1.N_TITLE" <? if ($_search["keyfield"] == "t1.N_TITLE") {
                            echo "selected";
                        } ?>>제목
                        </option>
                        <option value="t1.N_CONTENTS" <? if ($_search["keyfield"] == "t1.N_CONTENTS") {
                            echo "selected";
                        } ?>>내용
                        </option>
                    </select>&nbsp;
                    <input type="text" id="keyword" name="keyword" value="<?= $_search["keyword"] ?>"
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
                <col width="10%"/>
                <col width="*"/>
                <col width="10%"/>
                <col width="5%"/>
                <col width="10%"/>
                <col width="10%"/>
            </colgroup>

            <tr>
                <th>No</th>
                <th>분류</th>
                <th>NEWS 정보</th>
                <th>작성자</th>
                <th>클릭수</th>
                <th>등록일</th>
                <th>관리</th>
            </tr>
            <?
            if ($totalnum > 0) {

                $qry_002 = "SELECT t1.*, t2.CD_TITLE ";
                $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order . $_limit);

                $_j = 0;
                while ($row_002 = $db->sql_fetch_array($res_002)) {

                    $_jul = $totalnum - ($startNum + $_j);
                    $_status_view = $row_002["N_STATUS"] == "y" ? "<font color='#3333FF'>[ <b>공지</b> ]</font>" : "<font color='#6b6b6b'>[ 일반 ]</font>";

                    $up_url = "./admin.template.php?slot=board&type=notice_update&idx=".$row_002["IDX"]."&page=".$page.$_opt ;
                    ?>
                    <tr>
                        <td class="center"><?= $_jul ?></td>
                        <td class="center" style="padding:5px;"><?= clear_escape($row_002["CD_TITLE"]) ?></td>
                        <td style="line-height:180%;">
                            <?= $_status_view ?>
                            <?= clear_escape($row_002["N_TITLE"]) ?><br>
                            <div style="color:#8d8d8d;"><?= $row_002["N_ADDR"] ?></div>
                        </td>
                        <td class="center"><?= clear_escape($row_002["N_WRITE"]) ?></td>
                        <td class="center"><?= number_format($row_002["HIT"]) ?></td>
                        <td class="center"><?= clear_escape($row_002["REG_DATE"]) ?></td>
                        <td class="center">
                            <input type="button" value="관리" class="Small_Button btnGreen w50 h24" onClick="location.href='<?=$up_url?>'">&nbsp;
                            <input type="button" value="삭제" class="Small_Button btnRed w50 h24"
                                   onClick="confirm_process('actionForm','공지사항 정보를 삭제하시겠습니까? \n\n삭제 후에는 복구가 불가능합니다. ','./_action/board.do.php?mode=del_notice&idx=<?= $row_002["IDX"] ?>')">
                        </td>
                    </tr>
                    <?
                    $_j++;
                }
            } else {
                ?>
                <tr>
                    <td colspan="7" style='height:200px;' class='center'>등록된 공지사항이 없습니다.</td>
                </tr>
                <?
            }
            ?>
        </table>

        <div id="Paser">
            <?
            $paging = new paging("./admin.template.php", "slot=board&type=notice_list", $offset, $page_block, $totalnum, $page, $_opt);
            $paging->pagingArea("", "");
            ?>
        </div>

    </form>
</div>