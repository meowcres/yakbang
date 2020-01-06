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
$_order = " ORDER BY t1.REG_DATE desc";
$_limit = " LIMIT " . $startNum . "," . $offset;


$qry_001 = "SELECT count(t1.OP_ID)  ";

$_from   = " FROM {$TB_OP} t1  ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);

$totalnum = $row_001[0];


unset($qry_001);
unset($res_001);
unset($row_001);
?>
<div id="Contents">
    <h1>OPERATOR &gt; 오퍼 관리 &gt; <strong>오퍼 목록</strong></h1>

    <? include_once "./operator/operator_search.php"; ?>

    <div class="left" style="margin-top:15px;"><b>오퍼 목록</b> ( 검색 인원 : <?= number_format($totalnum) ?> 명 )</div>
    <table>
        <colgroup>
            <col width="9%"/>
            <col width="4%"/>
            <col width="8%"/>
            <col width="7%"/>
            <col width="4%"/>
            <col width="4%"/>
            <col width="6%"/>
            <col width="6%"/>
            <col width="14%"/> <!--이메일-->
            <col width="9%"/>
            <col width="9%"/>
            <col width="5%"/>
            <col width="9%"/>
            <col width="*"/>
        </colgroup>
        <tr>
            <th>등록일</th>
            <th>상태</th>
            <th>아이디</th>
            <th>이름</th>
            <th>성별</th>
            <th>등급</th>
            <th>생년월일</th>
            <th>연락처</th>
            <th>이메일</th>                
            <th>접속권한시작일</th>
            <th>접속권한종료일</th>
            <th>로그인횟수</th>
            <th>마지막로그인</th>
            <th>관리</th>
        </tr>

        <?php
        if ($totalnum > 0) {
            $sql = 'SELECT t1.*';
            $result = $db->exec_sql($sql . $_from . $_whereqry . $_order . $_limit);
            while ($row_002 = $db->sql_fetch_array($result)) {
                $information_ref = "./admin.template.php?slot=operator&type=operator_detail_update&op_id=" . $row_002["OP_ID"] . $_opt;
                $del_ref = "./_action/operator.do.php?Mode=del_op_list&op_id=" . $row_002["OP_ID"];
                $op_sex = $row_002["OP_SEX"] == "M" ? "남성" : "여성" ;
            ?>
        <tr>
            <td class="center"><?= $row_002['REG_DATE'] ?></td>
            <td class="center"><?= $op_status_array[$row_002['OP_STATUS']] ?></td>
            <td class="center"><?= $row_002['OP_ID'] ?></td>
            <td class="center"><?= $row_002['OP_NAME'] ?></td>
            <td class="center"><?= $op_sex ?></td>
            <td class="center"><?= $row_002['OP_GRADE'] ?></td>
            <td class="center"><?= $row_002['OP_BIRTH'] ?></td>
            <td class="center"><?= $row_002['OP_HP'] ?></td>
            <td class="center"><?= $row_002['OP_EMAIL'] ?></td>
            <td class="center"><?= $row_002['START_DATE'] ?></td>
            <td class="center"><?= $row_002['END_DATE'] ?></td>
            <td class="center"><?= $row_002['LOGIN_COUNT'] ?></td>
            <td class="center"><?= $row_002['LAST_DATE'] ?></td>
            <td class="center">
                <input type="button" value="수정" class="Small_Button btnGreen" onClick="location.href='<?= $information_ref ?>'">&nbsp;
                <input type="button" value="삭제" class="Small_Button btnRed" onClick="confirm_process('actionForm','오퍼 정보를 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다.','<?= $del_ref ?>');">
            </td>
        </tr>
        <?
            }
        } else {
            ?>
            <tr>
                <td colspan="14" height="200" class="center">목록이 없습니다.</td>
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