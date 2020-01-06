<?
/*$offset = 20;
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
}*/

// 검색 변수
/*$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["type"] = isNull($_GET["search_type"]) ? "" : $_GET["search_type"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];

$_where[] = " ( t1.MENTOR_ID = '{$_pharmacist["key"]}' ) ";

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

}*/

//$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";

//$_opt = "&search_status=" . $_search["status"] . "&search_type=" . $_search["type"] . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"];

$mentee_id = $_REQUEST["mentee_id"];
$mentor_id = $_REQUEST["mentor_id"];

$qry_cnt = " SELECT COUNT(*) ";
$qry_sel = " SELECT * ";
$qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t1.SEND_ID),'" . SECRET_KEY . "') as char) as s_id ";
$qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t1.RECEIVE_ID),'" . SECRET_KEY . "') as char) as r_id ";
$qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as s_name ";
$qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as r_name ";
$qry_001 = " FROM {$TB_DM} t1 ";
$qry_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.SEND_ID = t2.USER_ID ) ";
$qry_001 .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.RECEIVE_ID = t3.USER_ID ) ";
$qry_001 .= " WHERE ( t1.SEND_ID = '{$mentee_id}' AND t1.RECEIVE_ID = '{$mentor_id}' ) OR ( t1.SEND_ID = '{$mentor_id}' AND t1.RECEIVE_ID = '{$mentee_id}' ) ";
$qry_001 .= " ORDER BY t1.S_DATE ";

$res_cnt = $db->exec_sql($qry_cnt . $qry_001);
$row_cnt = $db->sql_fetch_row($res_cnt);
$totalnum = $row_cnt[0];

?>

<div id="content">
    <div class="sub_tit">쪽지관리 > 멘티목록 > 쪽지목록</div>
    <div id="cont">
        <div class="adm_cts">

            <h3 class="h3_title">검색설정 </h3>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" id="srFrm">
                <input type="hidden" id="sh_slot" name="slot" value="<?= $_slot ?>">
                <input type="hidden" id="sh_type" name="type" value="<?= $_type ?>">
                <div class="adm_table_style01 pb20">
                    <table>
                        <colgroup>
                            <col style="width:10%"/>
                            <col style="width:10%"/>
                            <col style="width:*"/>
                        </colgroup>
                        <tbody>
                        <tr>
                            <th rowspan="4">검색조건</th>
                            <th>승인날짜 &nbsp; <input type="checkbox" id="schChkDate" name="schChkDate" value="Y"
                                                   onClick="dateDisable();" <?= $_checked ?>></th>
                            <td>
                                <input type="text" name="schReqSDate" id="schReqSDate" readonly
                                       value="<?= $schReqSDate ?>"
                                       class="wid15" <?= $_disabled ?>/> 일 부터 &nbsp;&nbsp;
                                <input type="text" name="schReqEDate" id="schReqEDate" readonly
                                       value="<?= $schReqEDate ?>"
                                       class="wid15" <?= $_disabled ?>/> 일 까지
                            </td>
                        </tr>
                        <tr>
                            <th>구 분</th>
                            <td>
                                <b>성별</b> &nbsp;:&nbsp;
                                <select id="search_sex" name="search_sex" class="wid10" onChange="srFrm.submit();">
                                    <option value="">전체</option>
                                    <option value="M" <?php if ($search["sex"] == "M") {
                                        echo 'selected';
                                    } ?>>남성
                                    </option>
                                    <option value="F" <?php if ($search["sex"] == "F") {
                                        echo 'selected';
                                    } ?>>여성
                                    </option>
                                </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <b>유형</b> &nbsp;:&nbsp;
                                <select id="search_region" name="search_region" class="wid10"
                                        onChange="srFrm.submit();">
                                    <option value="">전체</option>
                                    <option value="i" <?php if ($search["region"] == "i") {
                                        echo 'selected';
                                    } ?>>메인약사
                                    </option>
                                    <option value="o" <?php if ($search["region"] == "o") {
                                        echo 'selected';
                                    } ?>>협동약사
                                    </option>
                                </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <th>조건검색</th>
                            <td colspan="3">
                                <select name="keyfield" class="wid15">
                                    <option value="t1.MM_NAME" <?php if ($search["keyfield"] == "t1.MM_NAME") {
                                        echo 'selected';
                                    } ?>>이름
                                    </option>
                                    <option value="t1.MM_EMAIL" <?php if ($search["keyfield"] == "t1.MM_EMAIL") {
                                        echo 'selected';
                                    } ?>>이메일
                                    </option>
                                    <option value="t2.MM_HP" <?php if ($search["keyfield"] == "t2.MM_HP") {
                                        echo 'selected';
                                    } ?>>연락처
                                    </option>
                                    <option value="t2.MM_HP" <?php if ($search["keyfield"] == "t2.MM_HP") {
                                        echo 'selected';
                                    } ?>>약사면허
                                    </option>
                                </select>
                                <input name="keyword" type="text" class="wid40" value="<?= $search["keyword"] ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th>검 색</th>
                            <td colspan="3">
                                <a class="btn btn04" onclick="srFrm.submit();">검색</a>&nbsp;&nbsp;
                                <a class="btn btn01"
                                   onclick="location.href='./pharmacy.template.php?slot=<?= $_slot ?>&type=<?= $_type ?>'">초기화</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </form>
            <h3 class="h3_title mt40">쪽지 목록 ( <?= number_format($totalnum) ?> )</h3>
            <div class="adm_table_style02">
                <table>
                    <colgroup>
                        <col width="10%"/>
                        <col width="8%"/>
                        <col width="10%"/>
                        <col width="8%"/>
                        <col width="*"/>
                        <col width="15%"/>
                        <col width="15%"/>
                    </colgroup>
                    <thead>
                    <tr>
                        <th>보낸 사람</th>
                        <th>보낸 상태</th>
                        <th>받는 사람</th>
                        <th>받는 상태</th>
                        <th>쪽지 내용</th>
                        <th>보낸 시간</th>
                        <th>읽은 시간</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($totalnum > 0) {
                        $res_001 = $db->exec_sql($qry_sel . $qry_001);
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
                                <td class="center"><?= $row_001["s_name"] ?></td>
                                <td class="center"><?= $s_status ?></td>
                                <td class="center"><?= $row_001["r_name"] ?></td>
                                <td class="center"><?= $r_status ?></td>
                                <td class="center"><?= $row_001["MESSAGE"] ?></td>
                                <td class="center"><?= $row_001["S_DATE"] ?></td>
                                <td class="center"><?= $row_001["R_DATE"] ?></td>
                            </tr>
                            <?
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7" height="200" class="center">쪽지가 없습니다.</td>
                        </tr>
                        <?
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <h3 class="h3_title mt40">쪽지 등록</h3>
            <div class="adm_table_style01">
                <table>
                    <colgroup>
                        <col style="width:15%"/>
                        <col style="width:35%"/>
                        <col style="width:15%"/>
                        <col style="*"/>
                    </colgroup>
                    <tr>
                        <th>작성자</th>
                        <td>
                            <input id="r_write" name="r_write" value="<?= $_pharmacist["name"] ?>" type="text"
                                   readonly>
                        </td>
                        <th>등록일</th>
                        <td>
                            <input id="reg_date" name="reg_date" value="<?= date('Y-m-d') ?>" type="text"
                                   readonly>
                        </td>
                    </tr>
                    <tr>
                        <th>쪽지 내용</th>
                        <td colspan="3">
                            <textarea id="message" name="message"></textarea>
                        </td>
                    </tr>

                </table>
            </div>
            <br>
            <div class="btn_area t_c">
                <a onClick="dm_add('<?= $mentor_id ?>', '<?= $mentee_id ?>')" class="btn_b btn21">작 성</a>
                <a onClick="location.href='./pharmacy.template.php?slot=dm&type=mentee_list'"
                   class="btn_b btn01">목 록</a>
            </div>
            <!--<div id="b_page_no">
                <? /*
                $paging = new paging("./admin.template.php", "slot=dm&type=mentee_list", $offset, $page_block, $totalnum, $page, $_opt);
                $paging->pagingArea("", "");
                */ ?>
            </div>-->
            <br><br><br><br>
        </div>
    </div>
</div>

<script>
    function dm_add(send_id, receive_id) {

        // 폼 보내기
        var message = $('#message').val();
        var _frm = new FormData();

        _frm.append("Mode", "dm_add");
        _frm.append("send_id", send_id);
        _frm.append("receive_id", receive_id);
        _frm.append("message", message);

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
                        location.href = "./pharmacy.template.php?slot=dm&type=dm_detail&mentee_id="+receive_id + "&mentor_id=" + send_id;
                        break;
                    default :
                        alert("실패");
                        break;
                }
            }
        });
    }
</script>