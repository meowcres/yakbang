<?
$offset = 20;
$page_block = 10;
$startNum = "";
$totalnum = "";
$page = "";
$_page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];


if (!isNull($_page)) {
    $page = $_page;
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

// 검색 변수
$_search = array();
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];

$_where[] = "1";

if ($_search["schChkDate"] == "Y") {
    $_checked = "checked";
    $_disabled = "";

    $_where[] = " t1.START_DATE BETWEEN '" . date("Y-m-d H:i:s", strtotime($_search["schReqSDate"])) . "' AND '" . date("Y-m-d H:i:s", strtotime("+1 days", strtotime($_search["schReqEDate"]) - 1)) . "' ";
} else {
    $_checked = "";
    $_disabled = "disabled";
}


// 키워드 검색
if (!isNull($_search["keyword"])) {
    $_where[] = $_where[] = "instr({$_search["keyfield"]}, '{$_search["keyword"]}') >0 ";
}

$_opt =  "&keyfield={$_search["keyfield"]}&keyword={$_search["keyword"]}&schChkDate={$_search["schChkDate"]}&schReqSDate={$_search["schReqSDate"]}&schReqEDate={$_search["schReqEDate"]}";


$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY t1.IDX desc, t1.PHARMACY_NAME";
$_limit = " LIMIT " . $startNum . "," . $offset;


$qry_001 = " SELECT count(t1.IDX) ";

$_from   = " FROM {$TB_PHARMACY} t1  ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);

$totalnum = $row_001[0];

//echo "==================".$qry_001 . $_from . $_whereqry;

unset($qry_001);
unset($res_001);
unset($row_001);



?>
<div id="Contents">
    <h1>약국관리 &gt; 약국 관리 &gt; <strong>약국목록</strong></h1>

    <? include_once "./pharmacy/pharmacy_search.php"; ?>

    <div class="left" style="margin-top:15px;"><b>약국 리스트</b> ( 검색 인원 : <?= number_format($totalnum) ?> 명 )</div>
    <table>
        <colgroup>
            <col width="5%"/>
            <col width="10%"/>
            <col width="5%"/>
            <col width="5%"/>
            <col width="*"/>
            <col width="20%"/>
            <col width="12%"/>
            <col width="7%"/>
            <col width="7%"/>
        </colgroup>
        <tr>
            <th>관리번호</th>
            <th>약국코드</th>
            <th>상태</th>
            <th>심평원</th>
            <th>약국명</th>
            <th>도로명</th>
            <th>연락처</th>
            <th>소속된 약사수</th>
            <th>관리</th>
        </tr>
        <?
        if ($totalnum > 0) {

            $qry_002  = " SELECT t1.*, (SELECT COUNT(IDX) FROM {$TB_PP} WHERE PHARMACY_CODE = t1.PHARMACY_CODE) as in_count  ";
            $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order . $_limit);

            while ($row_002 = $db->sql_fetch_array($res_002)) {
                $chk_ykiho = $row_002["YKIHO"] == '' ? "<font color='#ff0000'><b>미등록</b></font>" : "<font color='#0099ff'>등록완료</font>";
                $information_ref = "./admin.template.php?slot=pharmacy&type=pharmacy_core&step=information&pcode=" . $row_002["PHARMACY_CODE"] . $_opt."&page=".$page;
                $del_ref = "./_action/pharmacy.do.php?Mode=del_pharmacy_list&pcode=" . $row_002["PHARMACY_CODE"];

                    ?>
                    <tr>
                        <td class="center"><?= $row_002["PHARMACY_NUMBER"] ?></td>
                        <td class="center"><?= $row_002["PHARMACY_CODE"] ?></td>
                        <td class="center"><?= $pharmacy_status_array[$row_002["PHARMACY_STATUS"]] ?></td>
                        <td class="center"><?= $chk_ykiho ?></td>
                        <td class="center"><?= clear_escape($row_002["PHARMACY_NAME"]) ?></td>
                        <td style="padding-left:10px"><?= $row_002["ADDRESS"] ?></td>
                        <td class="center"><?= $row_002["PHARMACY_PHONE"] ?></td>
                        <td class="center"><?= number_format($row_002["in_count"]) ?></td>
                        <td class="center">
                            <input type="button" value="관리" class="Small_Button btnGreen w80"
                                   onClick="location.href='<?= $information_ref ?>'">
                        </td>
                    </tr>
                    <?                    

            }

        } else {
            ?>
            <tr>
                <td colspan="8" height="200" class="center">등록된 약국이 없습니다.</td>
            </tr>
            <?
        }
        ?>
    </table>

    <div align="center" style="padding-top:10px;">
        <?
        $_url = "&slot=pharmacy&type=pharmacy_list";
        $paging = new paging("./admin.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
        $paging->pagingArea("", "");
        ?>
    </div>

    <? $db->db_close(); ?>

</div>