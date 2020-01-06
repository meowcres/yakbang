<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";

$ps_code = $_REQUEST["ps_code"];
$p_code = $_REQUEST["p_code"];

$qry_001 = " SELECT * ";
$qry_001 .= " FROM {$TB_PS} t1 ";
$qry_001 .= " WHERE PS_CODE = '{$ps_code}' ";

$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

$qry_002 = " SELECT * ";
$qry_002 .= " FROM {$TB_PHARMACY} t1 ";
$qry_002 .= " WHERE PHARMACY_CODE = '{$p_code}' ";

$res_002 = $db->exec_sql($qry_002);
$row_002 = $db->sql_fetch_array($res_002);

$qry_003 = " SELECT * ";
$qry_003 .= " FROM {$TB_PS_PILL} ";
$qry_003 .= " WHERE PS_CODE = '{$ps_code}' AND PP_TYPE = '1' ";
$qry_003 .= " ORDER BY PARENT_IDX, IDX";
?>
    <!-- content start -->
    <div class="coNtent">
        <div class="position_wrap">
            <span>스마트 처방조제</span>
            <span>대체복약 내역</span>
        </div>
        <div class="inner_coNtwrap">
            <div class="fixedbodycoNt">
                <div class="pspSend_wrap2">
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
                    <p class="middleTxx">대체 복약 내역</p>
                    <div class="replace_wrap">
                        <div class="replce_head">
                            <span>조제약</span>
                            <span>대체복약</span>
                            <span>비고</span>
                        </div>
                        <ul class="oNoffshow">
                            <?php
                            $res_003 = $db->exec_sql($qry_003);
                            while ($row_003 = $db->sql_fetch_array($res_003)) {
                                $qry_004 = " SELECT * ";
                                $qry_004 .= " FROM {$TB_PS_PILL} ";
                                $qry_004 .= " WHERE PS_CODE = '{$ps_code}' AND PP_TYPE = '2' ";
                                $res_004 = $db->exec_sql($qry_004);
                                while ($row_004 = $db->sql_fetch_array($res_004)) {
                                    if ($row_004["PARENT_IDX"] == $row_003["IDX"]) {
                                        $i = stripslashes($row_004["PP_TITLE"]);
                                        $j = nl2br(stripslashes($row_004["PP_CMT"]));
                                    } else {
                                        $i = "";
                                        $j = "";
                                    }
                                }
                                ?>
                                <li>
                                    <a href=""><span><?= stripslashes($row_003["PP_TITLE"]) ?></span><span><?= $i ?></span>
                                        <?php
                                        if ($i !== "") {
                                        ?>
                                        <span class="confirm"><em>상세보기</em></span></a>
                                    <div class="openshow">
                                        <?= stripslashes($row_003["PP_TITLE"]) ?> - <?= nl2br(stripslashes($row_003["PP_CMT"])) ?><BR><BR>
                                        대체복약 : <?=$i?> - <?= $j ?>
                                    </div>
                                    <?
                                    } else {
                                        ?>
                                        <span class="confirm"></span></a>
                                        <?
                                    }
                                    ?>

                                </li>
                                <?
                            }
                            ?>
                            <!--<li>
                                <a href=""><span>A알약</span><span>B알약</span><span class="confirm"><em>상세보기</em></span></a>
                                <div class="openshow">
                                    A 알약 : 아세티 테이민 효과<BR><BR>
                                    대체복약 : B 알약 - 동일 효과 - 효능
                                </div>
                            </li>
                            <li>
                                <a href=""><span>C알약</span><span>D알약</span><span class="confirm"><em>상세보기</em></span></a>
                                <div class="openshow">
                                    content
                                </div>
                            </li>
                            <li>
                                <a href=""><span>E알약</span><span>F알약</span><span class="confirm"><em>상세보기</em></span></a>
                                <div class="openshow">
                                    content
                                </div>
                            </li>-->
                        </ul>
                    </div>
                    <div class="coNtBtn">
                        <div class="coNtbtn_wrap">
                            <a href="./prescription_status.php?ps_code=<?=$ps_code?>" class="ecolor"><span class="btnicon00">목록으로</span></a>
                            <a href="./prescription_payment.php?ps_code=<?=$ps_code?>&p_code=<?=$p_code?>" class="ecolor_plus"><span
                                        class="btnicon01">결제요청</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content end -->

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>