<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
$ps_code = $_REQUEST['ps_code'];
include_once "../inc/sub_header.php";
include_once "../_member.php";


$qry_cnt = " SELECT COUNT(*) ";
$qry_sel = " SELECT * ";
$qry_001 = " FROM {$TB_PS} ";
$qry_001 .= " WHERE USER_ID = '{$mm_row["USER_ID"]}' ";
$qry_001 .= " ORDER BY REG_DATE DESC ";

$res_cnt = $db->exec_sql($qry_cnt . $qry_001);
$row_cnt = $db->sql_fetch_array($res_cnt);
$totalnum = $row_cnt[0];
?>
    <!-- content start -->
    <div class="coNtent">
        <div class="position_wrap">
            <span>스마트 처방조제</span>
            <span>e처방전</span>
        </div>
        <div class="inner_coNtwrap">
            <div class="fixedbodycoNt">
                <div class="pspSend_wrap2">
                    <table class="pspintbl" summary="신청일,e처방전 코드,상태순으로 정의">
                        <caption>처방약국</caption>
                        <colgroup>
                            <col width="37%">
                            <col width="*">
                            <col width="10%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th scope="col">신청일</th>
                            <th scope="col">e처방전 코드</th>
                            <th scope="col">상태</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($totalnum > 0) {

                            $res_001 = $db->exec_sql($qry_sel . $qry_001);
                            while ($row_001 = $db->sql_fetch_array($res_001)) {
                                $status = $prescription_status_array[$row_001["PS_STATUS"]];
                                ?>
                                <tr>
                                    <th scope="row"><?= $row_001["REG_DATE"] ?></th>
                                    <td><?= $row_001["PS_CODE"] ?></td>
                                    <!--td onClick="location.href='./prescription_flow.php?ps_code=<?= $row_001["PS_CODE"] ?>'"-->
                                        <?
                                        if ($row_001["PS_STATUS"] == 3) {
                                            ?>
                                                <td onClick="location.href='./prescription_status.php?ps_code=<?=$row_001["PS_CODE"]?>'">
                                            <?
                                        } else {
                                            ?>
                                                <td onClick="location.href='./prescription_view.php?ps_code=<?=$row_001["PS_CODE"]?>'">
                                            <?
                                        }
                                        ?>

                                        <?
                                        if ($row_001["PS_STATUS"] == 9) {
                                            ?>
                                            <span class="confirmBtn w90px"><?= $status ?></span>
                                            <?
                                        } else {
                                            ?>
                                            <span class="paymentBtn w90px"><?= $status ?></span>
                                            <?
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?
                            }

                        }
                        ?>
                        <!--<tr>
                            <th scope="row">19.06.10</th>
                            <td>EP-001202010</td>
                            <td onClick="location.href='./prescription_flow.php'"><span class="paymentBtn w90px">STEP. 01</span>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">19.06.10</th>
                            <td>EP-001202010</td>
                            <td onClick="location.href='./prescription_flow.php'"><span
                                        class="confirmBtn w90px">완료</span></td>
                        </tr>-->
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
        <?php
        if (isNull($ps_code)) {
            ?>
            <div class="coNtBtn">
                <div class="coNtbtn_wrap">
                    <a href="#none" onclick="history.back();" class="ecolor"><span
                                class="btnicon04">돌아가기</span></a>
                </div>
            </div>
            <?
        } else {
            ?>
            <div class="coNtBtn">
                <div class="coNtbtn_wrap">
                    <a href="./prescription_status.php?ps_code=<?= $ps_code ?>" class="ecolor"><span
                                class="btnicon04">처방전 현황</span></a>
                </div>
            </div>
            <?
        }
        ?>
    </div>
    <!-- content end -->

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>