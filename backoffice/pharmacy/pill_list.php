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

    $_where[] = " t1.UP_DATE BETWEEN '" . date("Y-m-d H:i:s", strtotime($_search["schReqSDate"])) . "' AND '" . date("Y-m-d H:i:s", strtotime("+1 days", strtotime($_search["schReqEDate"]) - 1)) . "' ";
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
$_order = " ORDER BY IDX desc ";
$_limit = " LIMIT " . $startNum . "," . $offset;


$qry_001 = " SELECT count(t1.IDX) ";

$_from   = " FROM {$TB_PILL} t1  ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);

$totalnum = $row_001[0];

unset($qry_001);
unset($res_001);
unset($row_001);


?>
<div id="Contents">
    <h1>의약품관리 &gt; 의약품관리 &gt; <strong>의약품 목록</strong></h1>

    <? include_once "./pharmacy/pill_search.php"; ?>

    <div class="left" style="margin-top:15px;">
        <b>의약품 리스트</b> ( 검색 의약품 : <?= number_format($totalnum) ?> 개 )   
        <!--input type="button" value="약물 등록" class="Small_Button btnGreen" onclick="openWin('./pharmacy/popup_pill_add.php','pill_update',1000,400,'scrollbars=yes')"-->
     </div>

    <table>
        <colgroup>
            <col width="5%" />
            <col width="12%" />
            <col width="10%" />
            <col width="*" />
            <col width="8%" />
            <col width="10%" />
            <col width="6%" />
            <col width="7%" />
            <col width="10%" />
        </colgroup>

        <tbody>
        <tr>
            <th style="text-align:center;">No.</th>
            <th style="text-align:center;">분류명</th>
            <th style="text-align:center;">제형구분명</th>
            <th style="text-align:center;">일반명</th>
            <th style="text-align:center;">일반명코드</th>
            <th style="text-align:center;">투여경로명</th>
            <th style="text-align:center;">함량내용</th>
            <th style="text-align:center;">약효분류코드</th>
            <th style="text-align:center;">단위</th>
        <?
        if ($totalnum > 0) {

            $qry_002  = " SELECT t1.* ";
            $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order . $_limit);
            while ($row_002 = $db->sql_fetch_array($res_002)) {

                $del_ref = "./_action/pharmacy.do.php?Mode=del_pill&pill_code=" . $row_002["PILL_CODE"];

                    ?>
                    <tr>
                        <td class="center"><?= $row_002["IDX"] ?></td>
                        <td class="center"><?= $row_002["PILL_CATEGORY"] ?></td>
                        <td class="center"><?= $row_002["PILL_CLASS"] ?></td>
                        <td class="left" style="padding-left:10px;"><?= $row_002["PILL_NAME"] ?></td>
                        <td class="center"><?= $row_002["PILL_CODE"] ?></td>                       
                        <td class="center"><?= $row_002["PILL_INJECTION"] ?></td>
                        <td class="center"><?= $row_002["PILL_MATERIAL"] ?></td>
                        <td class="center"><?= $row_002["PILL_MEDICINE_CODE"] ?></td>
                        <td class="center"><?= $row_002["PILL_UNIT"] ?></td>

                            <!--input type="button" value="수정" class="Small_Button btnGreen" onClick="openWin('./pharmacy/popup_pill_update.php?idx=<?=$row_002["IDX"]?>','pillUpdate',1000,270,'scrollbars=no');">&nbsp;
                            <input type="button" value="삭제" class="Small_Button btnRed" onClick="confirm_process('actionForm','해당 약품을 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다.','<?= $del_ref ?>');"-->
                            
                            <!--input type="button" value="상세보기" class="Small_Button btnGreen" onClick="openWin('./pharmacy/popup_pill_view.php?idx=<?=$row_002["IDX"]?>','pillUpdate',1200,300,'scrollbars=no');"-->
                    </tr>
                    <?                    
            }

        } else {
            ?>
            <tr>
                <td colspan="9" height="200" class="center">등록된 약물이 없습니다.</td>
            </tr>
            <?
        }
        ?>
    </table>

    <div align="center" style="padding-top:10px;">
        <?
        $_url = "&slot=pharmacy&type=pill_list";
        $paging = new paging("./admin.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
        $paging->pagingArea("", "");
        ?>
    </div>

    <? $db->db_close(); ?>

</div>