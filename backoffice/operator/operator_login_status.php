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

    $_where[] = " t1.IN_DATE BETWEEN '" . date("Y-m-d H:i:s", strtotime($_search["schReqSDate"])) . "' AND '" . date("Y-m-d H:i:s", strtotime("+1 days", strtotime($_search["schReqEDate"]) - 1)) . "' ";
} else {
    $_checked = "";
    $_disabled = "disabled";
}






// 키워드 단어검색
if (!isNull($_search["keyword"])) {
    $_where[] = $_search["keyfield"] . " = ('" . $_search["keyword"] . "')";
}

$_opt = "&search_status=" . $_search["status"] . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"] . "&schChkDate=" . $_search["schChkDate"] . "&schReqSDate=" . $_search["schReqSDate"]. "&schReqEDate=" . $_search["schReqEDate"];


$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY t1.IDX desc";
$_limit = " LIMIT " . $startNum . "," . $offset;


$qry_001 = "SELECT count(t1.OP_ID)  ";

$_from   = " FROM {$TB_OP_LOG} t1  ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);

$totalnum = $row_001[0];


unset($qry_001);
unset($res_001);
unset($row_001);
?>
<div id="Contents">
    <h1>OPERATOR &gt; 오퍼 관리 &gt; <strong>오퍼 로그인 현황</strong></h1>

    <? include_once "./operator/operator_login_search.php"; ?>

    <div class="left" style="margin-top:15px;"><b>오퍼 로그인 목록</b> ( 로그인 횟수 : <?= number_format($totalnum) ?> 번 )</div>
    <table>
        <colgroup>
            <col width="15%"/>
            <col width="15%"/>
            <col width="15%"/>
            <col width="20%"/>            
            <col width="*"/>
        </colgroup>
        <tr>
            <th>로그인 시간</th>
            <th>로그아웃 시간</th>
            <th>아이디</th>
            <th>로그인 IP</th>
            <th>접속세션</th>
        </tr>

        <?php
        if ($totalnum > 0) {
            $sql = 'SELECT t1.*';
            $result = $db->exec_sql($sql . $_from . $_whereqry . $_order . $_limit);
            while ($row_002 = $db->sql_fetch_array($result)) {
            ?>
        <tr>
            <td class="center"><?= $row_002['IN_DATE'] ?></td>
            <td class="center"><?= $row_002['OUT_DATE'] ?></td>
            <td class="center"><?= $row_002['OP_ID'] ?></td>
            <td class="center"><?= $row_002['OP_IP'] ?></td>
            <td class="center"><?= $row_002['SESSION_KEY'] ?></td>
        </tr>
        <?
            }
        } else {
            ?>
            <tr>
                <td colspan="5" height="200" class="center">목록이 없습니다.</td>
            </tr>
            <?
        }
        ?>      
    </table>

    <div align="center" style="padding-top:10px;">
        <?
        $_url = "&slot=operator&type=operator_login_status";
        $paging = new paging("./admin.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
        $paging->pagingArea("", "");
        ?>
    </div>

    <? $db->db_close(); ?>

</div>