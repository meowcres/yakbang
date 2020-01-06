<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

if ($_POST["chk_agree"] != "y") {
    alert_js("alert_move", "정보가 옳바르지 않습니다.", './photo_step_01.php');
    exit;
}

$qry_001 = "SELECT * FROM {$TB_PS_IMAGE} WHERE PS_CODE='{$_POST["ps_code"]}'";
$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);
?>
    <!-- content start -->
    <div class="coNtent">
        <div class="position_wrap">
            <span>스마트 처방조제</span>
            <span>처방전 전송동의</span>
            <span>촬영하기</span>
            <span>이미지 확인</span>
        </div>
        <div class="inner_coNtbtnwrap">
            <div class="fixedbodycoNt">
                <?php
                if (!isNull($row_001["PHYSICAL_NAME"])) {
                    ?>
                    <img src="../../Web_Files/prescription/<?= $row_001["PHYSICAL_NAME"] ?>" style="width:100%;">
                    <?
                }
                ?>

            </div>
        </div>
        <div class="coNtBtn">
            <div class="coNtbtn_wrap">
                <a href="javascript:void(0);" onclick="clear_ps('<?= $_POST["ps_code"] ?>');" class="ecolor"><span
                            class="btnicon00">재촬영 하기</span></a>
                <!--<a href="../pharmacy/find_map.php?ps_code=<? /*= $_POST["ps_code"] */ ?>" class="ecolor_plus"><span class="btnicon01">처방전 전송</span></a>-->
                <a href="javascript:void(0);" onclick="send_op();" class="ecolor_plus"><span
                            class="btnicon01">처방전 전송</span></a>
            </div>
        </div>
    </div>
    <input type="hidden" id="ps_code" name="ps_code" value="<?= $_POST["ps_code"] ?>">
    <!-- content end -->

    <script>
        function send_op() {
            var _frm = new FormData();
            var ps_code = $("#ps_code").val();
            _frm.append("Mode", "send_op");
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
                            location.href = "../prescription/ready_prescription.php?ps_code=" + ps_code;
                            break;

                        default :
                            alert("Error");
                            break;
                    }
                }
            });
        }

        function clear_ps() {
            if (confirm("재촬영 하시겠습니까?")) {
                var _frm = new FormData();
                _frm.append("Mode", "re_prescription_file");
                _frm.append("ps_code", $("#ps_code").val());

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
                                location.href = "./photo_step_01.php";
                                break;

                            case "200" :
                                alert("재촬영에 실패하였습니다.");
                                location.href = "./photo_step_01.php";
                                break;

                            case "900" :
                                alert("Error");
                                location.href = "./photo_step_01.php";
                                break;
                        }
                    }
                });
            }
        }
    </script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>