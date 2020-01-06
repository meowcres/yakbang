<?php
include_once "../../_core/_init.php";
include_once "../inc/in_top.php";

$user_id = $_REQUEST["user_id"];

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

$_where[] = " t1.SEND_ID = '{$user_id}' ";

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
    $_where[] = "t1.mm_status='{$_search["status"]}'";
}
$_status[$_search["status"]] = "selected";


// 키워드 검색
if (!isNull($_search["keyword"])) {
    $_where[] = $_search["keyfield"] . " = HEX(AES_ENCRYPT('" . $_search["keyword"] . "','" . SECRET_KEY . "'))";
}

$_opt = "&search_status={$_search["status"]}&keyfield={$_search["keyfield"]}&keyword={$_search["keyword"]}&schChkDate={$_search["schChkDate"]}&schReqSDate={$_search["schReqSDate"]}&schReqEDate={$_search["schReqEDate"]}";


$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
//$_limit = " LIMIT " . $startNum . "," . $offset;


$sel_cnt = " SELECT count(*)  ";

// 받은 메세지
$qry_001 = " SELECT t1.*, t2.* ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t1.SEND_ID),'" . SECRET_KEY . "') as char) as s_id ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t1.RECEIVE_ID),'" . SECRET_KEY . "') as char) as r_id ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as r_name ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as s_name ";
$from_001 = " FROM {$TB_DM} t1 ";
$from_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.RECEIVE_ID = t2.USER_ID ) ";
$from_001 .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.SEND_ID = t3.USER_ID ) ";
$order_001 = " ORDER BY t1.S_DATE DESC ";

$res_cnt = $db->exec_sql($sel_cnt . $from_001 . $_whereqry);
$row_cnt = $db->sql_fetch_row($res_cnt);
$totalnum = $row_cnt[0];

?>
    <div id="Popup_Contents" style="padding:10px;">
        <h1>회원관리 &gt; 쪽지관리 &gt; <strong> 보낸 쪽지 목록</strong></h1>
            <table class="tbl1" summary="보낸 쪽지 목록">
                <colgroup>
                    <col width="15%"/>
                    <col width="6%"/>
                    <col width="15%"/>
                    <col width="6%"/>
                    <col width="*"/>
                    <col width="12%"/>
                    <col width="12%"/>
                </colgroup>
                <tr>
                    <th>보낸 사람</th>
                    <th>보낸 상태</th>
                    <th>받는 사람</th>
                    <th>받는 상태</th>
                    <th>쪽지 내용</th>
                    <th>보낸 시간</th>
                    <th>읽은 시간</th>
                </tr>
                <?php
                if ($totalnum > 0) {
                    $res_001 = $db->exec_sql($qry_001 . $from_001 . $_whereqry . $order_001);
                    while ($row_001 = $db->sql_fetch_array($res_001)) {
                        if ($row_001["S_STATUS"] == 1) {
                            $s_status = "<font color=008080>읽음</font>";
                        } else if ($row_001["S_STATUS"] == 2) {
                            $s_status = "<font color=0000FF>안읽음</font>";
                        } else if ($row_001["S_STATUS"] == 3) {
                            $s_status = "<font color=FF0000>삭제</font>";
                        }
                        if ($row_001["R_STATUS"] == 1) {
                            $r_status = "<font color=008080>읽음</font>";
                        } else if ($row_001["R_STATUS"] == 2) {
                            $r_status = "<font color=0000FF>안읽음</font>";
                        } else if ($row_001["R_STATUS"] == 3) {
                            $r_status = "<font color=FF0000>삭제</font>";
                        }
                        ?>
                        <tr>
                            <td class="center"><?= $row_001["s_name"] ?>(<?= clear_escape($row_001["s_id"]) ?>)</td>
                            <td class="center"><?= $s_status ?></td>
                            <td class="center"><?= $row_001["r_name"] ?>(<?= clear_escape($row_001["r_id"]) ?>)</td>
                            <td class="center"><?= $r_status ?></td>
                            <td class="center"><?= nl2br(clear_escape($row_001["MESSAGE"])) ?></td>
                            <td class="center"><?= $row_001["S_DATE"] ?></td>
                            <td class="center"><?= $row_001["R_DATE"] ?></td>
                        </tr>
                        <?
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7" style='height:200px;' class='center'>보낸 쪽지가 없습니다.</td>
                    </tr>
                    <?
                }
                ?>
            </table>
            <div style="margin-top:30px;text-align:center;">
                <input type="button" id="frmClose" value="창닫기" class="btnGray w100 h28" onClick="self.close();"
                       style="cursor:pointer;">
            </div>
    </div>
<?php
include_once "../inc/in_bottom.php";