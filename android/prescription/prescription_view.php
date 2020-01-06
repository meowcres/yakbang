<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
$ps_code  = $_REQUEST["ps_code"];
include_once "../inc/sub_header.php";

$qry_001  = " SELECT * ";
$qry_001 .= " FROM {$TB_PS} t1 ";
$qry_001 .= " WHERE PS_CODE = '{$ps_code}' ";

$res_001  = $db->exec_sql($qry_001);
$row_001  = $db->sql_fetch_array($res_001);

$qry_cnt  = " SELECT COUNT(*) ";
$qry_002  = " SELECT *, t1.REG_DATE AS date ";
$_from    = " FROM {$TB_PS_PHARMACY} t1 ";
$_from   .= " LEFT JOIN {$TB_PHARMACY} t2 ON ( t1.PHARMACY_CODE = t2.PHARMACY_CODE ) ";
$_where   = " WHERE t1.PS_CODE = '{$ps_code}' ";
$_where_002 = " WHERE t1.PS_CODE = '{$ps_code}' AND A_STATUS != '1' ";


// 처방약 테이블
$qry_003 = " SELECT COUNT(t1.IDX) ";
$from_003 .= " FROM {$TB_PS_PILL} AS t1 ";
$from_003 .= " LEFT JOIN {$TB_PILL} AS t2 ON (t1.PP_TITLE = t2.IDX) ";
$where_003 .= " WHERE PS_CODE = '{$ps_code}' ";
$res_003 = $db->exec_sql($qry_003 . $from_003 . $where_003);
$row_003 = $db->sql_fetch_array($res_003);
$total_pill = $row_003[0];


// 이미지
$qry_img = "SELECT * FROM {$TB_PS_IMAGE} WHERE PS_CODE='{$ps_code}'";
$res_img = $db->exec_sql($qry_img);
$row_img = $db->sql_fetch_array($res_img);

// 응답대기열
$res_cnt = $db->exec_sql($qry_cnt . $_from . $_where);
$row_cnt = $db->sql_fetch_array($res_cnt);
$totalnum = $row_cnt[0];

$res_cnt_002 = $db->exec_sql($qry_cnt . $_from . $_where_002);
$row_cnt_002 = $db->sql_fetch_array($res_cnt_002);
$totalnum_002 = $row_cnt_002[0];
?>

    <!-- content start -->
    <div class="coNtent">
        <div class="position_wrap">
            <span>스마트 처방조제</span>
            <span>처방전 전송</span>
        </div>
        <input type="hidden" id="ps_code" name="ps_code" value="<?= $ps_code ?>">
        <div class="inner_coNtbtnwrap">
            <div class="fixedbodycoNt">
                <div class="pspSend_wrap">
                    <table class="psptbl" summary="처방전 코드,생성일,처방전 형태순으로 정의">
                        <caption>처방전 내용</caption>
                        <colgroup>
                            <col width="32%">
                            <col width="68%">
                        </colgroup>
                        <tbody>
                        <tr>
                            <th scope="row">처방전</th>
                            <td><?= $ps_code ?></td>
                        </tr>
                        <tr>
                            <th scope="row">생성일</th>
                            <td><?= $row_001["REG_DATE"] ?></td>
                        </tr>
                        <tr>
                            <th scope="row">처방전 형태</th>
                            <td>사진<a href="" class="imglink">이미지</a></td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="middleTxx">응답 대기열 ( <?= $totalnum_002 ?> / <?= $totalnum ?> )</p>
                    <table class="pspintbl" summary="약국명,상태,진행시간,관리 형태순으로 정의">
                        <caption>처방약국</caption>
                        <colgroup>
                            <col width="*">
                            <col width="20%">
                            <col width="40%">
                        </colgroup>

                        <thead>
                        <tr>
                            <th scope="col">약국명</th>
                            <th scope="col">상태</th>
                            <th scope="col">경과시간</th>
                        </tr>
                        </thead>
                        
                        <tbody id="rt-list" class="rt-list">
                        <?php
                        if ($totalnum > 0) {
                            $res_002 = $db->exec_sql($qry_002 . $_from . $_where);
                            while ($row_002 = $db->sql_fetch_array($res_002)) {
                                $d_date = strtotime($row_002["date"]);
                                $dd_date = strtotime(date("Ymd H:i:s"));
                                $total_time = $dd_date - $d_date;

                                $days = floor($total_time / 86400);
                                $time = $total_time - ($days * 86400);
                                $hours = floor($time / 3600);
                                $time = $time - ($hours * 3600);
                                $min = floor($time / 60);
                                $sec = $time - ($min * 60);

                                if ($days == 0 && $hours == 0 && $min == 0) {
                                    $result_date = $sec . "초 경과";
                                } else if ($days == 0 && $hours == 0) {
                                    $result_date = $min . "분 " . $sec . "초 경과";
                                } else if ($days == 0) {
                                    $result_date = $hours . "시간 " . $min . "분 " . $sec . "초 경과";
                                } else {
                                    $result_date = $days . "일 " . $hours . "시간 " . $min . "분 " . $sec . "초 경과";
                                }
                                ?>
                                <tr>
                                    <th scope="row"><?= $row_002["PHARMACY_NAME"] ?></th>
                                    <td><?= $prescription_pharmacy_status_array[$row_002["A_STATUS"]] ?></td>
                                    <td><?= $result_date ?></td>
                                </tr>
                                <?
                            }
                            ?>
                            <?
                        } else {
                            ?>
                            <tr>
                                <td colspan="4">
                                    선택된 약국이 없습니다.
                                </td>
                            </tr>
                            <?
                        }
                        ?>
                        </tbody>
                    </table><br><br>



                    <table class="pspintbl" summary="처방약">
                        <colgroup>
                            <col width="*">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="30%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th scope="col">약<br>명칭</th>
                            <th scope="col">1회<br>투약</th>
                            <th scope="col">1일<br>투약</th>
                            <th scope="col">총<br>투약<br>일수</th>
                            <th scope="col">사용법</th>
                        </tr>
                        </thead>
                        
                        <tbody id="rt-list" class="rt-list">
                            <?php
                            if ($total_pill > 0) {
                                $sql = 'SELECT t1.*, t2.PILL_NAME ';
                                $result = $db->exec_sql($sql . $from_003 . $where_003);
                                while ($row_004 = $db->sql_fetch_array($result)) {
                                ?>

                            <tr>
                                <td align="center"><?= $row_004["PILL_NAME"] ?></td>
                                <td align="center"><?= $row_004["ONE_INJECTION"] ?></td>
                                <td align="center"><?= $row_004["DAY_INJECTION"] ?></td>
                                <td align="center"><?= $row_004["TOTAL_INJECTION"] ?></td>
                                <td align="center"><?= $row_004["PP_USAGE"] ?></td>
                            </tr>

                            <?
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="5" height="200" align="center">목록이 없습니다.</td>
                                </tr>
                                <?
                            }
                            ?>      
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="coNtBtn">
            <div class="coNtbtn_wrap">
                <!--<a href="javascript:void(0);" onclick="del_ps_pharmacy_all('<?/*= $ps_code */?>');" class="ecolor"><span
                            class="btnicon04">전체전송취소</span></a>-->
                            <a href="./prescription_list.php" class="ecolor"><span class="btnicon04">목록으로</span></a>
            </div>
        </div>
    </div>
    <!-- content end -->

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>