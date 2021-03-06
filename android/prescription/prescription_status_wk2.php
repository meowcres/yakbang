<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";

$ps_code = $_REQUEST["ps_code"];

$qry_001 = " SELECT * ";
$qry_001 .= " FROM {$TB_PS} t1 ";
$qry_001 .= " WHERE PS_CODE = '{$ps_code}' ";

$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

$qry_cnt = " SELECT COUNT(*) ";
$qry_002 = " SELECT *, t1.REG_DATE AS date ";
$_from = " FROM {$TB_PS_PHARMACY} t1 ";
$_from .= " LEFT JOIN {$TB_PHARMACY} t2 ON ( t1.PHARMACY_CODE = t2.PHARMACY_CODE ) ";
$_where = " WHERE t1.PS_CODE = '{$ps_code}' ";
$_where_002 = " WHERE t1.PS_CODE = '{$ps_code}' AND A_STATUS != '1' ";

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
        <input type="hidden" id="ps_code" name="ps_code" value="<?=$ps_code?>">
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
                            <col width="32%">
                            <col width="20%">
                            <col width="28%">
                            <col width="20%">
                        </colgroup>
                        <thead>
                        <tr>
                            <th scope="col">약국명</th>
                            <th scope="col">상태</th>
                            <th scope="col">진행시간</th>
                            <th scope="col">관리</th>
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

                                $days = floor($total_time/86400);
                                $time = $total_time - ($days*86400);
                                $hours = floor($time/3600);
                                $time = $time - ($hours*3600);
                                $min = floor($time/60);
                                $sec = $time - ($min*60);

                                if ( $days == 0 && $hours == 0 && $min == 0 ) {
                                    $result_date = $sec . "초 경과";
                                } else if ( $days == 0 && $hours == 0 ) {
                                    $result_date = $min . "분 " . $sec . "초 경과";
                                } else if ( $days == 0 ) {
                                    $result_date = $hours . "시간 " . $min . "분 " . $sec . "초 경과";
                                } else {
                                    $result_date = $days . "일 " . $hours . "시간 " . $min . "분 " . $sec . "초 경과";
                                }
                                ?>
                                <tr>
                                    <th scope="row"><?= $row_002["PHARMACY_NAME"] ?></th>
                                    <td id="array0" class="array0"><?= $prescription_pharmacy_status_array[$row_002["A_STATUS"]] ?></td>
                                    <td id="array1" class="array1"><?= $result_date ?></td>
                                    <?php
                                    if ($row_002["A_STATUS"] == 1) {
                                        ?>
                                        <td><a href="javascript:void(0);"
                                               onclick="del_ps_pharmacy('<?= $ps_code ?>', '<?= $row_002["PHARMACY_CODE"] ?>')"
                                               class="cancleBtn">취소</a></td>
                                        <?
                                    } else if ($row_002["A_STATUS"] == 2) {
                                        ?>
                                        <td>
                                            <a href="./prescription_payment.php?ps_code=<?= $ps_code ?>&p_code=<?= $row_002["PHARMACY_CODE"] ?>"
                                               class="paymentBtn">결제요청</a></td>
                                        <?
                                    } else if ($row_002["A_STATUS"] == 3) {
                                        ?>
                                        <td>
                                            <a href="./prescription_substitute.php?ps_code=<?= $ps_code ?>&p_code=<?= $row_002["PHARMACY_CODE"] ?>"
                                               class="replaceBtn">대체조제</a></td>
                                        <?
                                    } else if ($row_002["A_STATUS"] == 4) {
                                        ?>
                                        <td><a href="javascript:void(0);" class="cancleBtn">조제불가</a></td>
                                        <?
                                    } else if ($row_002["A_STATUS"] == 5) {
                                        ?>
                                        <td><a href="javascript:void(0);" class="paymentBtn">결제완료</a></td>
                                        <?
                                    }
                                    ?>
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
                    </table>
                </div>
            </div>
        </div>
        <div class="coNtBtn">
            <div class="coNtbtn_wrap">
                <a href="javascript:void(0);" onclick="del_ps_pharmacy_all('<?= $ps_code ?>');" class="ecolor"><span
                        class="btnicon04">전체전송취소</span></a>
            </div>
        </div>
    </div>
    <!-- content end -->
    <script>
        function del_ps_pharmacy_all(ps_code) {
            if (confirm("전송을 전부 취소하시겠습니까?")) {
                var _frm = new FormData();

                _frm.append("Mode", "del_ps_pharmacy_all");
                _frm.append("ps_code", ps_code);

                $.ajax({
                    method: 'POST',
                    url: "../_action/prescription.do.php",
                    processData: false,
                    contentType: false,
                    data: _frm,
                    success: function (_res) {
                        console.log(_res);
                        switch (_res) {
                            case "0" :
                                location.href = "../prescription/prescription_status.php?ps_code=" + ps_code;
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

    <script>
        function del_ps_pharmacy(ps_code, p_code) {
            if (confirm("전송을 취소하시겠습니까?")) {
                var _frm = new FormData();

                _frm.append("Mode", "del_ps_pharmacy");
                _frm.append("ps_code", ps_code);
                _frm.append("p_code", p_code);

                $.ajax({
                    method: 'POST',
                    url: "../_action/prescription.do.php",
                    processData: false,
                    contentType: false,
                    data: _frm,
                    success: function (_res) {
                        console.log(_res);
                        switch (_res) {
                            case "0" :
                                location.href = "../prescription/prescription_status.php?ps_code=" + ps_code;
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

    <script type="text/javascript">
        $(document).ready(function () {

            ajax_call = function () {

                var ps_code = $('#ps_code').val();

                var _frm = new FormData();

                _frm.append("Mode", "ajax_call2");
                _frm.append("ps_code", ps_code);

                $.ajax({
                    type: 'POST',
                    url: '../_action/prescription.do.php',
                    processData: false,
                    contentType: false,
                    data: _frm,
                    dataType: "json",
                    success: function (_res) {
                        var a0 = "";
                        var a1 = "";
                        /*_res.forEach(function (element, index, array) {
                            a0 += element.array0;
                            a1 += element.array1;
                        })*/
                        alert(_res);
                        /*$("#array0").html(a0);
                        $("#array1").html(a1);*/
                    }
                });
            };

            var interval = 1000;
            setInterval(ajax_call, interval);
        });
    </script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>