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
$_search["keyfield1"] = isNull($_GET["keyfield1"]) ? "" : $_GET["keyfield1"];
$_search["keyword1"] = isNull($_GET["keyword1"]) ? "" : $_GET["keyword1"];
$_search["keyfield2"] = isNull($_GET["keyfield2"]) ? "" : $_GET["keyfield2"];
$_search["keyword2"] = isNull($_GET["keyword2"]) ? "" : $_GET["keyword2"];
$_search["keyfield3"] = isNull($_GET["keyfield3"]) ? "" : $_GET["keyfield3"];
$_search["keyword3"] = isNull($_GET["keyword3"]) ? "" : $_GET["keyword3"];

$_where[] = "1";

// 키워드 단어검색
if (!isNull($_search["keyword1"])) {
    $_where[] = $_search["keyfield1"] . " = HEX(AES_ENCRYPT('" . $_search["keyword1"] . "','" . SECRET_KEY . "'))";
}
if (!isNull($_search["keyword2"])) {
    $_where[] = $_search["keyfield2"] . " = HEX(AES_ENCRYPT('" . $_search["keyword2"] . "','" . SECRET_KEY . "'))";
}

// 키워드 범위검색
if (!isNull($_search["keyword3"])) {
    $_where[] = "instr({$_search["keyfield3"]}, '{$_search["keyword3"]}') >0 ";
}


$_opt = "&keyfield1=" . $_search["keyfield1"] . "&keyword1=" . $_search["keyword1"] . "&keyfield2=" . $_search["keyfield2"] . "&keyword2=" . $_search["keyword2"] . "&keyfield3=" . $_search["keyfield3"] . "&keyword3=" . $_search["keyword3"];


$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
//$_limit = " LIMIT " . $startNum . "," . $offset;


$sel_cnt = " SELECT count(*)  ";

// 받은 메세지
$qry_001 = " SELECT t1.*, t2.*, t1.IDX AS id ";
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
<div id="Contents">
    <h1> 쪽지 관리 &gt; <strong>쪽지 목록</strong></h1>

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
                <th rowspan="2">단어 검색어</th>
                <td>
                    <select id="keyfield1" name="keyfield1" class="w100">
                        <option value="t3.USER_NAME" <? if ($_search["keyfield1"] == "t3.USER_NAME") echo "selected"; ?>>보낸사람
                        </option>
                    </select>

                    <input type="text" id="keyword1" name="keyword1" value="<?= $_search["keyword1"] ?>" class="w50p">
                </td><br>
            </tr>
            <tr>
                <td>
                    <select id="keyfield2" name="keyfield2" class="w100">
                        <option value="t2.USER_NAME" <? if ($_search["keyfield2"] == "t2.USER_NAME") echo "selected"; ?>>받는사람
                        </option>
                    </select>

                    <input type="text" id="keyword2" name="keyword2" value="<?= $_search["keyword2"] ?>" class="w50p">
                </td><br>
            </tr>
            <tr>
                <th>범위 검색어</th>
                <td>
                    <select id="keyfield3" name="keyfield3" class="w100">
                        <option value="t1.MESSAGE" <? if ($_search["keyfield3"] == "t1.MESSAGE") {
                            echo "selected";
                        } ?>>내용
                        </option>
                    </select>
                    <input type="text" id="keyword3" name="keyword3" value="<?= $_search["keyword3"] ?>"
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

    <div class="left" style="margin-top:15px;"><b>쪽지 목록</b> ( 검색 인원 : <?= number_format($totalnum) ?> 개 )</div>
    <table>
        <colgroup>
            <col width="15%"/>
            <col width="5%"/>
            <col width="15%"/>
            <col width="5%"/>
            <col width="*"/>
            <col width="10%"/>
            <col width="10%"/>
            <col width="5%"/>
        </colgroup>
        <tr>
            <th>보낸 사람</th>
            <th>보낸 상태</th>
            <th>받는 사람</th>
            <th>받는 상태</th>
            <th>쪽지 내용</th>
            <th>보낸 시간</th>
            <th>읽은 시간</th>
            <th>관리</th>
        </tr>
        <?
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
                    <td class="center"><?= $row_001["s_name"] ?> (<?= clear_escape($row_001["s_id"]) ?>)</td>
                    <td class="center"><?= $s_status ?></td>
                    <td class="center"><?= $row_001["r_name"] ?> (<?= clear_escape($row_001["r_id"]) ?>)</td>
                    <td class="center"><?= $r_status ?></td>
                    <td class="center"><?= nl2br(clear_escape($row_001["MESSAGE"])) ?></td>
                    <td class="center"><?= $row_001["S_DATE"] ?></td>
                    <td class="center"><?= $row_001["R_DATE"] ?></td>
                    <td class="center">
                        <input type="button" value="삭제" onclick="dm_del('<?= $row_001["id"] ?>');"
                               class="Small_Button btnRed w50 h24">
                    </td>
                </tr>
                <?
            }
        } else {
            ?>
            <tr>
                <td colspan="8" style='height:200px;' class='center'>쪽지가 없습니다.</td>
            </tr>
            <?
        }
        ?>
    </table>

    <div align="center" style="padding-top:10px;">
        <?
        $_url = "&slot=dm&type=dm_list";
        $paging = new paging("./admin.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
        $paging->pagingArea("", "");
        ?>
    </div>

    <? $db->db_close(); ?>

</div>

<script>
    function dm_del(idx) {
        if (confirm("정말 삭제하시겠습니까? \n\n 삭제 후에는 복구가 불가능합니다.")) {
            //console.log(idx);
            // 폼 보내기
            var _frm = new FormData();

            _frm.append("Mode", "dm_del");
            _frm.append("idx", idx);

            $.ajax({
                method: 'POST',
                url: "./_action/member.do.php",
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    console.log(_res);
                    switch (_res) {
                        case "0" :
                            location.href = "./admin.template.php?slot=dm&type=dm_list";
                            break;
                        default :
                            alert("실패");
                            break;
                    }
                }
            });
        }
    }
</script>