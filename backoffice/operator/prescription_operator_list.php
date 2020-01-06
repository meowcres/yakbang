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
$_search["type"] = isNull($_GET["search_type"]) ? "1" : $_GET["search_type"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];

$_where[] = " 1 ";

if ($_search["schChkDate"] == "Y") {
    $_checked = "checked";
    $_disabled = "";

    $_where[] = " t1.reg_date BETWEEN '" . date("Y-m-d H:i:s", strtotime($_search["schReqSDate"])) . "' AND '" . date("Y-m-d H:i:s", strtotime("+1 days", strtotime($_search["schReqEDate"]) - 1)) . "' ";
} else {
    $_checked = "";
    $_disabled = "disabled";
}

// 활동상태
if (!isNull($_search["status"])) {
    $_where[] = "t1.OP_STATUS='{$_search["status"]}'";
}
$_status[$_search["status"]] = "selected";

// 키워드 단어검색
if (!isNull($_search["keyword"])) {
    $_where[] = $_search["keyfield"] . " = ('" . $_search["keyword"] . "')";
}

$_opt = "&search_status=" . $_search["status"] . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"] . "&schChkDate=" . $_search["schChkDate"] . "&schReqSDate=" . $_search["schReqSDate"]. "&schReqEDate=" . $_search["schReqEDate"];


$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY t1.IDX desc";
$_limit = " LIMIT " . $startNum . "," . $offset;


$qry_001 = "SELECT count(t1.IDX)  ";

$_from   = " FROM {$TB_PS_PRECLEANING} t1  ";
$_from  .= " LEFT JOIN {$TB_OP} t2 ON (t1.OP_ID = t2.OP_ID)  ";
$_from  .= " LEFT JOIN {$TB_PS} t3 ON (t1.PS_CODE = t3.PS_CODE)  ";
$_from  .= " LEFT JOIN {$TB_MEMBER} t4 ON (t3.USER_ID = t4.USER_ID)  ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);

$totalnum = $row_001[0];


unset($qry_001);
unset($res_001);
unset($row_001);
?>
<div id="Contents">
    <h1>OPERATOR &gt; 처방전 관리 &gt; <strong>오퍼 처방전 목록</strong></h1>

    <? include_once "./operator/operator_search.php"; ?>

    <div class="left" style="margin-top:15px;"><b>처방전 목록</b> ( 검색 처방전 : <?= number_format($totalnum) ?> 명 )</div>
    <table>
        <colgroup>
            <col width="10%"/>
            <col width="*"/>
            <col width="6%"/>
            <col width="10%"/>
            <col width="10%"/>
            <col width="10%"/>
            <col width="10%"/>
            <col width="10%"/>

            <col width="8%"/>
        </colgroup>
        <tr>
            <th>등록일</th>
            <th>처방전 코드</th>
            <th>상태</th>
            <th>담당 오퍼 아이디</th>
            <th>담당 오퍼 이름</th>
            <th>처방전 상태</th>
            <th>환자정보</th>
            <th>오퍼 결과</th>

            <th>관리</th>
        </tr>

        <?php
        if ($totalnum > 0) {
            $sql = 'SELECT t1.*, t2.*, t3.*, CAST(AES_DECRYPT(UNHEX(t4.USER_NAME), "'.SECRET_KEY.'") as char) as mm_name';
            $result = $db->exec_sql($sql . $_from . $_whereqry . $_order . $_limit);
            while ($row_002 = $db->sql_fetch_array($result)) {
                $information_ref = "./admin.template.php?slot=operator&type=operator_detail_update&op_id=" . $row_002["OP_ID"] . $_opt;
                $del_ref = "./_action/operator.do.php?Mode=del_prescription_list&ps_code=" . $row_002["PS_CODE"];
            ?>
        <tr>
            <td class="center"><?= $row_002['S_DATE'] ?></td>
            <td class="center"><?= $row_002['PS_CODE'] ?></td>
            <td class="center"><?= $pre_status_array[$row_002['PRE_STATUS']] ?></td>
            <td class="center"><?= $row_002['OP_ID'] ?></td>
            <td class="center"><?= $row_002['OP_NAME'] ?></td>

            <td class="center"><?= $prescription_status_array[$row_002["PS_STATUS"]] ?></td>
            <td class="center"><?= $row_002['mm_name'] ?></td>
            <td class="center"><?= $pre_status_array[$row_002["PRE_STATUS"]] ?></td>

            <td class="center">
                <!--input type="button" value="수정" class="Small_Button btnGreen" onClick="location.href='<?= $information_ref ?>'">&nbsp;-->
                <input type="button" value="삭제" class="Small_Button btnRed" onClick="confirm_process('actionForm','처방전 정보를 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다.','<?= $del_ref ?>');">
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
        $_url = "&slot=operator&type=operator_list";
        $paging = new paging("./admin.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
        $paging->pagingArea("", "");
        ?>
    </div>

    <? $db->db_close(); ?>

</div>