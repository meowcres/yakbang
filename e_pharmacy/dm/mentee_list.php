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

}

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order   = " ORDER BY t1.REG_DATE DESC ";
$_limit   = " LIMIT " . $startNum . "," . $offset;

$qry_001  = " SELECT count(*) ";
$_from    = " FROM {$TB_MENTOR} t1";
$_from   .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.MENTEE_ID = t2.USER_ID ) ";
$_from   .= " LEFT JOIN {$TB_MEMBER_INFO} t3 ON ( t2.USER_ID = t3.ID_KEY ) ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];

$_opt = "&search_status=" . $_search["status"] . "&search_type=" . $_search["type"] . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"];
?>

<div id="content">
    <div class="sub_tit">쪽지관리 > 멘티목록</div>
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
            <h3 class="h3_title mt40">멘티 목록 ( <?= number_format($totalnum) ?> )</h3>
            <form id='frm' name='frm'>
                <input type="hidden" id="Mode" name="Mode" value="">
                <div class="adm_table_style02">
                    <table>
                        <colgroup>
                            <col width="10%"/>
                            <col width="*"/>
                            <col width="15%"/>
                            <col width="8%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th>새로운 메세지</th>
                            <th>멘티 이름</th>
                            <th>등록일</th>
                            <th>관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($totalnum > 0) {
                            $qry_002  = " SELECT t1.*, t2.*, t1.REG_DATE AS date ";
                            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
                            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

                            $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order );
                            while ($row_002 = $db->sql_fetch_array($res_002)) {
                                $qry_003 = " SELECT count(*) ";
                                $qry_003 .= " FROM {$TB_DM} ";
                                $qry_003 .= " WHERE SEND_ID = '{$row_002["USER_ID"]}' AND RECEIVE_ID = '{$_pharmacist["key"]}' AND R_STATUS = '2' ";
                                $res_003 = $db->exec_sql($qry_003);
                                $row_003 = $db->sql_fetch_row($res_003);
                                if ($row_003[0] > 0) {
                                    $status = "<font color='FF0000'>".$row_003[0]."</font>";
                                } else {
                                    $status = "<font color='0000FF'>없음</font>";
                                }
                                ?>
                                <tr>
                                    <td class="center"><?= $status ?></td>
                                    <td class="center"><?= $row_002["mm_name"] ?></td>
                                    <td class="center"><?= $row_002["date"] ?></td>
                                    <td class="center">
                                        <input type="button" value="쪽지함" class="btn_S btn12" onclick="dm_detail('<?=$row_002["MENTEE_ID"]?>', '<?=$row_002["MENTOR_ID"]?>');">
                                    </td>
                                </tr>
                                <?
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5" height="200" class="center">등록된 멘티가 없습니다.</td>
                            </tr>
                            <?
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <div id="b_page_no">
                <?
                $paging = new paging("./admin.template.php", "slot=dm&type=mentee_list", $offset, $page_block, $totalnum, $page, $_opt);
                $paging->pagingArea("", "");
                ?>
            </div>
            <br><br><br><br>
        </div>
    </div>
</div>

<script>
    function dm_detail(mentee_id, mentor_id) {
        // 폼 보내기
        var _frm = new FormData();

        _frm.append("Mode", "dm_read");
        _frm.append("mentee_id", mentee_id);
        _frm.append("mentor_id", mentor_id);

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
                        location.href = "./pharmacy.template.php?slot=dm&type=dm_detail&mentee_id="+mentee_id + "&mentor_id=" + mentor_id;
                        break;
                    default :
                        alert("실패");
                        break;
                }
            }
        });
    }
</script>