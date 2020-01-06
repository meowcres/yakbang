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

$_where[] = "AD_TYPE = '1' ";

// 상태
if (!isNull($_search["status"])) {
    $_where[] = " AD_STATUS = '{$_search["status"]}' ";
}
$_status[$_search["status"]] = "selected";

// 분류
if (!isNull($_search["type"])) {
    $_where[] = " AD_TYPE = '{$_search["type"]}' ";
}

// 키워드 검색
if (!isNull($_search["keyword"])) {
    $_where[] = "instr({$_search["keyfield"]}, '{$_search["keyword"]}') >0 ";

}

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY IDX DESC";
$_limit = " LIMIT " . $startNum . "," . $offset;


$qry_001  = " SELECT   ";
$qry_001 .= " count(*) ";

$_from  = " FROM {$TB_AD} ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];

$_opt = "&search_status=" . $_search["status"] . "&search_type=" . $_search["type"]  . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"];


?>

<div id="Contents">
    <h1>광고관리 > TOP 광고 > <strong>TOP 광고 목록</strong></h1><br>

    <form id="sfrm" name="sfrm" method="GET" action="./admin.template.php">
        <input type="hidden" id="slot" name="slot" value="<?= $_slot ?>">
        <input type="hidden" id="type" name="type" value="<?= $_type ?>">
        <input type="hidden" id="search_type" name="search_type" value="1">
		
         <table class='tbl1'>
            <colgroup>
                <col width="10%">
                <col width="10%">
                <col width="*">
            </colgroup>
            <tr>
                <th rowspan="3">검색조건</th>
                <th>구분</th>
                <td>
                    <select id="search_status" name="search_status" onChange="sfrm.submit();" class="w150">
                        <option value="">전체</option>
                        <option value="y" <?= $_status["y"] ?>>활성</option>
                        <option value="n" <?= $_status["n"] ?>>비활성</option>
                    </select>&nbsp;&nbsp;
                 </td>
            </tr>
            <tr>
                <th>검색어</th>
                <td>
                    <select id="keyfield" name="keyfield">
                        <option value="AD_TITLE" <? if ($_search["keyfield"] == "AD_TITLE") {
                            echo "selected";
                        } ?>>제목
                        </option>
                        <option value="AD_TXT_1" <? if ($_search["keyfield"] == "AD_TXT_1") {
                            echo "selected";
                        } ?>>내용1
                        </option>
                        <option value="AD_TXT_2" <? if ($_search["keyfield"] == "AD_TXT_2") {
                            echo "selected";
                        } ?>>내용2
                        </option>
                        <option value="AD_TXT_3" <? if ($_search["keyfield"] == "AD_TXT_3") {
                            echo "selected";
                        } ?>>내용3
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
                <col width="7%"/>
                <col width="*"/>
                <col width="7%"/>
                <col width="10%"/>
            </colgroup>

            <tr>
                <th>No</th>
				<th>등록일</th>
                <th>상태</th>
                <th>제목</th>
                <th>클릭수</th>
                <th>관리</th>
            </tr>
            <?
            if ($totalnum > 0) {

                $qry_002 = "SELECT * ";
                $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order . $_limit);

                $_j = 0;
                while ($row_002 = $db->sql_fetch_array($res_002)) {

                    $_jul = $totalnum - ($startNum + $_j);
                    $_status_view = $row_002["AD_STATUS"] == "y" ? "<font color='#3333FF'><b>활성</b></font>" : "<font color='#ff0000'>비활성</font>";

                    $up_url = "./admin.template.php?slot=ad&type=ad_top_update&idx=".$row_002["IDX"]."&page=".$page.$_opt ;
                    ?>
                    <tr>
                        <td class="center"><?= $_jul ?></td>
						<td class="center"><?= date("Y-m-d", strtotime($row_002["REG_DATE"])) ?></td>
                        <td class="center" style="padding:5px;"><?= $_status_view ?></td>
                        <td style="line-height:180%;">
                            <?= clear_escape($row_002["AD_TITLE"]) ?><br>

                        </td>
                        <td class="center"><?= number_format($row_002["HIT"]) ?></td>
                        <td class="center">
                            <input type="button" value="관리" class="Small_Button btnGreen w50 h24" onClick="location.href='<?=$up_url?>'">&nbsp;
                            <input type="button" value="삭제" class="Small_Button btnRed w50 h24"
                                   onClick="del_top('<?= $row_002["IDX"] ?>', '<?= $row_002["AD_TYPE"] ?>');">
                        </td>
                    </tr>
                    <?
                    $_j++;
                }
            } else {
                ?>
                <tr>
                    <td colspan="7" style='height:200px;' class='center'>등록된 TOP 광고가 없습니다.</td>
                </tr>
                <?
            }
            ?>
        </table>

        <div id="Paser">
            <?
            $paging = new paging("./admin.template.php", "slot=ad&type=ad_top_list", $offset, $page_block, $totalnum, $page, $_opt);
            $paging->pagingArea("", "");
            ?>
        </div>

    </form>
</div>

<script language="JavaScript" type="text/JavaScript">
<!--
function del_top(n, p){
  if(confirm("정말 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다.")){

    location.href="./_action/ad.do.php?mode=del_top&idx="+n+"&ad_type="+p;

  }

}
</script>