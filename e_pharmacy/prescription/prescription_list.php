<?php
// 페이지 분할 변수
$offset = 20;
$page_block = 10;
$startNum = "";
$totalnum = "";
$page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

if (!isNull($page)) {
    $page = $page;
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

// 리스트 조건절
$qry_where_array[] = "t1.PHARMACY_CODE = '{$_pharmacy["code"]}'";

$qry_where = count($qry_where_array) ? " WHERE " . implode(' AND ', $qry_where_array) : "";
$qry_order = " ORDER BY t2.REG_DATE DESC";
$qry_limit = " LIMIT " . $startNum . "," . $offset;

$qry_cnt = "SELECT ";
$qry_cnt .= "count(*) ";

$qry_from = "FROM {$TB_PS_PHARMACY} t1 ";
$qry_from .= "LEFT JOIN {$TB_PS} t2 ON (t1.PS_CODE = t2.PS_CODE) ";
$qry_from .= "LEFT JOIN {$TB_MEMBER} t3 ON (t2.USER_ID = t3.USER_ID) ";

$res_cnt = $db->exec_sql($qry_cnt . $qry_from . $qry_where);
$row_cnt = $db->sql_fetch_row($res_cnt);
$totalnum = $row_cnt[0];

// 주소이동변수
$url_opt = "";
?>

<div id="content">
    <div class="sub_tit">처방전관리 > 처방전목록</div>
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
                            <th>요청날짜 &nbsp; <input type="checkbox" id="schChkDate" name="schChkDate" value="Y"
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
                                <b>상태</b> &nbsp;:&nbsp;
                                <select id="search_region" name="search_region" class="wid10"
                                        onChange="srFrm.submit();">
                                    <option value="">전체</option>
                                </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <b>유형</b> &nbsp;:&nbsp;
                                <select id="search_region" name="search_region" class="wid10"
                                        onChange="srFrm.submit();">
                                    <option value="">전체</option>
                                    <option value="i" <?php if ($search["region"] == "i") {
                                        echo 'selected';
                                    } ?>>이미지
                                    </option>
                                    <option value="o" <?php if ($search["region"] == "o") {
                                        echo 'selected';
                                    } ?>>QR
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
                                    } ?>>처방전 번호
                                    </option>
                                    <option value="t1.MM_NAME" <?php if ($search["keyfield"] == "t1.MM_NAME") {
                                        echo 'selected';
                                    } ?>>담당약사
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

            <h3 class="h3_title mt40">처방전 목록 ( <?= number_format($totalnum) ?> )</h3>

            <div class="adm_table_style02">
                <table>
                    <colgroup>
                        <col style="width:15%"/>
                        <col style="width:12%"/>
                        <col style="width:10%"/>
                        <col style="width:10%"/>
                        <col style="*"/>
                        <col style="width:10%"/>
                    </colgroup>
                    <thead>
                    <tr>
                        <th>요청날짜</th>
                        <th>코드</th>
                        <th>상태</th>
                        <th>타입</th>
                        <th>이름</th>
                        <th>관리</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($totalnum > 0) {

                        $qry_001 = "SELECT t1.*, t2.* ";
                        $qry_001 .= ", CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                        $qry_001 .= ", t2.REG_DATE AS date ";


                        $res_001 = $db->exec_sql($qry_001 . $qry_from . $qry_where . $qry_order . $qry_limit);

                        $count_num = 0;
                        while ($row_001 = $db->sql_fetch_array($res_001)) {
                            if ($row_001["A_STATUS"] == 5) {
                                $status = "<font color='0000FF'>" . $prescription_pharmacy_status_array[$row_001["A_STATUS"]] . "</font>";
                            } else if ($row_001["A_STATUS"] == 4) {
                                $status = "<font color='FF0000'>" . $prescription_pharmacy_status_array[$row_001["A_STATUS"]] . "</font>";
                            } else {
                                $status = "<font color='008080'>" . $prescription_pharmacy_status_array[$row_001["A_STATUS"]] . "</font>";
                            }
                            if ($row_001["A_STATUS"] == 5) {
                                ?>
                                <tr>
                                    <td><?= $row_001['date'] ?></td>
                                    <td><?= $row_001['PS_CODE'] ?></td>
                                    <td><?= $status ?></td>
                                    <td><?= $prescription_type_array[$row_001['SEND_TYPE']] ?></td>
                                    <td><?= $row_001['mm_name'] ?></td>
                                    <td>
                                        <a href="./pharmacy.template.php?slot=prescription&type=prescription_detail_view&step=pill&p_code=<?= $_pharmacy["code"] ?>&ps_code=<?= $row_001['PS_CODE'] ?>"
                                           class="btn_s btn13">관리</a>                                    
                                    </td>
                                </tr>
                                <?
                            } else {
                                ?>
                                <tr>
                                    <td><?= $row_001['date'] ?></td>
                                    <td><?= $row_001['PS_CODE'] ?></td>
                                    <td><?= $status ?></td>
                                    <td><?= $prescription_type_array[$row_001['SEND_TYPE']] ?></td>
                                    <td><?= $row_001['mm_name'] ?></td>
                                    <td>
                                        <a href="./pharmacy.template.php?slot=prescription&type=prescription_detail&step=pill&p_code=<?= $_pharmacy["code"] ?>&ps_code=<?= $row_001['PS_CODE'] ?>"
                                           class="btn_s btn13">관리</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    } else {
                        ?>
                        <tr>
                            <td class="t_c" colspan="9" height="250">등록된 처방전이 없습니다.</td>
                        </tr>
                        <?php
                    }
                    ?>

                    </tbody>
                </table>
            </div>

            <div class="b_page_no">
                <?php
                $paging = new paging("./admin.member.php", "slot=member&type=member_list", $offset, $page_block, $totalnum, $page, $url_opt);
                $paging->pagingArea("", "");
                ?>
            </div>

            <br><br><br><br>
        </div>
    </div><!-- cont -->
</div><!-- content e -->