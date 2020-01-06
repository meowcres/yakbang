<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

$ps_code = $_REQUEST["ps_code"];

if (isNull($ps_code)) {
    alert_js('alert_move','정보가 옳바르지 않습니다','./photo_step_01.php');
    exit;
} else {
    $qry = "SELECT * FROM {$TB_PS} WHERE PS_CODE='{$ps_code}'";
    $res = $db->exec_sql($qry);
    $row = $db->sql_fetch_array($res);

    if ($row["PS_STATUS"] == "9") {
        // 준비단계 일때
        alert_js("move","","./photo_step_01.php");
        exit;
    } else if ($row["PS_STATUS"] == "2" || $row["PS_STATUS"] == "4" || $row["PS_STATUS"] == "6") {
        // 판독불가, 결제불가, 전송취소
        alert_js("move","","./cancel_prescription.php?ps_code=".$ps_code);
        exit;
    } else if ($row["PS_STATUS"] == "3") {
        // 진행중
        //alert_js("move","","../pharmacy/find_ylist.php?ps_code=".$ps_code);
        alert_js("move","","../pharmacy/find_map.php?ps_code=".$ps_code);
        exit;
    }
}

$up_cnt  = "UPDATE {$TB_PS_CNT} SET PUBLICATION_COUNT=PUBLICATION_COUNT+1 ";
@$db->exec_sql($up_cnt);


$d_date = strtotime($row["REG_DATE"]);
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
    <!-- content start -->
    <div class="coNtent">
        <form id="frm" name="frm" method="POST" style="height:100%;">
            <input type="hidden" id="chk_agree" name="chk_agree" value="y">
            <input type="hidden" id="ps_code" name="ps_code" value="<?= $ps_code ?>">
            <input type="hidden" id="user_id" name="user_id" value="<?= $_COOKIE["cookie_user_id"] ?>">

            <div class="position_wrap">
                <span>스마트 처방조제</span>
                <span>처방전 분석중</span>
            </div>
            <div class="inner_coNtbtnwrap">
                <div class="fixedbodycoNt">
                    <div class="iNfotxx" align="center">
                        <br><br><b>처방 코드</b><br><b><?= $ps_code ?></b> <br><br><br><br>
                        현재 전송하신 처방전을 분석중입니다<br><br><br><br>
                        분석요청 경과시간 : <?= $result_date ?>
                    </div>
                </div>
            </div>

            <div class="coNtBtn">
                <div class="coNtbtn_wrap">
                    <a href="javascript:void(0);" onclick="cancel_prescription('<?= $ps_code ?>');" class="ecolor"><span
                            class="btnicon04">전송취소</span></a>
                </div>
            </div>
        </form>
    </div>
    <!-- content end -->

    <style>
        /*layer mask*/
        .layer_mask2 {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height:calc(100% - 100px); height:-webkit-calc(100% - 100px); height:-moz-calc(100% - 100px);
            background: rgba(0, 0, 0, 0.1);
            z-index: 250;
        }

        /*page loading*/
        .loading_wrap2 {
            width: 60%;
            position: absolute;
            top: 50%;
            left: 50%;
            text-align: center;
            z-index: 450;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
        }

        .loading_wrap2 span {
            display: inline-block;
        }

        .loading_wrap2 .loader {
            border: 5px solid #777;
            border-radius: 50%;
            border-top: 5px solid #fff;
            width: 80px;
            height: 80px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            -moz-animation: spin 2s linear infinite;
        }

        .loading_wrap2 .loading_text {
            display: block;
            font-size: 18px;
            color: #fff;
            margin-top: 25px;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @-moz-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        $(document).ready(function () {
            $('<div class="layer_mask2"></div>').prependTo('body');
            $('.layer_mask2').html('<div class="loading_wrap2"><span class="loader"></span><span class="loading_text"></span></div>');
        });

        // 로딩
        $(window).load(function () {
            setInterval(function () {
                check_prescription('<?= $ps_code ?>');
            }, 5000);
        });

        function check_prescription(ps_code) {
            var _frm = new FormData();
            _frm.append("Mode","check_prescription");
            _frm.append("ps_code", ps_code);

            $.ajax({
                method: 'POST',
                url: '../_action/prescription.do.php',
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    console.log(_res);
                    switch (_res) {
                        case "2" :
                        case "4" :
                        case "6" :
                            location.href='./cancel_prescription.php?ps_code='+ ps_code ;
                            break;

                        case "3" :
                            location.href='../pharmacy/find_map.php?ps_code='+ ps_code ;
                            break;

                        case "9" :
                            location.href='./photo_step_01.php' ;
                            break;

                    }
                }
            });
        }

        function cancel_prescription(ps_code) {

            if (!confirm("전송하던 처방전을 취소할까요?")) {
                return false;
            }

            var _frm = new FormData();
            _frm.append("Mode","cancel_prescription");
            _frm.append("ps_code", ps_code);

            $.ajax({
                method: 'POST',
                url: '../_action/prescription.do.php',
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    console.log(_res);
                    switch (_res) {
                        case "100" :
                            location.href="./cancel_prescription.php?ps_code="+ ps_code;
                            break;

                        case "900" :
                            alert("Error");
                            break;

                    }
                }
            });

        }

    </script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>