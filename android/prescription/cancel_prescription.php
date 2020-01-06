<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

$ps_code = $_REQUEST["ps_code"];

if (isNull($ps_code)) {
    alert_js('alert_move', '정보가 옳바르지 않습니다', './photo_step_01.php');
    exit;
} else {
    $qry = " SELECT t1.*, t2.PHYSICAL_NAME FROM {$TB_PS} t1 ";
    $qry .= " LEFT JOIN {$TB_PS_IMAGE} t2 ON (t1.PS_CODE = t2.PS_CODE) ";
    $qry .= " WHERE t1.PS_CODE='{$ps_code}' ";
    $res = $db->exec_sql($qry);
    $row = $db->sql_fetch_array($res);
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
                <span>취소된 처방전</span>
            </div>           
            
           
            <div class="fixedbodycoNt">
                <div class="iNfotxx" align="center">
                    <br>+ <b>처방 코드</b> +<br><b><?= $ps_code ?></b><br><br>
                    현재 처방전은 취소 되었습니다<br>
                    마감 시간 : <?= $row["COMPLETE_DATE"] ?>
                    <br><br>+ <b>처방전 이미지</b> +<br>
                    <?php
                    if (isNull($row["PHYSICAL_NAME"])) {
                        ?>
                        이미지 없음
                        <?
                    } else {
                        ?>
                        <img src="../../Web_Files/prescription/<?= $row["PHYSICAL_NAME"] ?>" width="60%"><br>
                        <input type="button" value="이미지 삭제" onclick="ps_img_del('<?=$row["PHYSICAL_NAME"]?>');" 
                               style="background-color:#13d191;color:white;width:200px;height:50px;margin-top:10px;">
                        <?
                    }
                    ?>

                </div>
            </div>            
           
                       
            <!--div class="inner_coNtbtnwrap">
                <div class="fixedbodycoNt">
                    <div class="iNfotxx" align="center">
                        <br>+ <b>처방 코드</b> +<br><b><?= $ps_code ?></b><br><br>
                        현재 처방전은 취소 되었습니다<br><br>
                        마감 시간 : <?= $row["COMPLETE_DATE"] ?>
                        <br><br><br>+ <b>처방전 이미지</b> +<br>
                        <?php
                        if (isNull($row["PHYSICAL_NAME"])) {
                            ?>
                            이미지 없음
                            <?
                        } else {
                            ?>
                            <img src="../../_core/_files/prescription/<?= $row["PHYSICAL_NAME"] ?>" width="100%">
                            <?
                        }
                        ?>

                    </div>
                </div>
            </div>

            <div class="coNtBtn">
                <div class="coNtbtn_wrap">
                    <a href="javascript:void(0);" onclick="location.href='./photo_step_01.php';" class="ecolor"><span class="btnicon00">처방전 재전송</span></a>
                    <a href="javascript:void(0);" onclick="ps_img_del('<?=$row["PHYSICAL_NAME"]?>');" class="ecolor_plus"><span class="btnicon01">이미지 삭제<?=$row["PHYSICAL_NAME"]?></span></a>
                </div>
            </div-->
        </form>
    </div>
    <!-- content end -->

    <script>
        function cancel_prescription(ps_code) {

            var _frm = new FormData();
            _frm.append("Mode", "cancel_prescription");
            _frm.append("ps_code", ps_code);

            $.ajax({
                method: 'POST',
                url: '../_action/prescription.do.php',
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    //console.log(_res);
                    switch (_res) {
                        case "100" :
                            location.href = "./cancel_prescription.php?ps_code=" + ps_code;
                            break;

                        case "900" :
                            alert("Error");
                            break;

                    }
                }
            });

        }

        $("#preScriptionFile").change(function () {

            var $image_file = $("input[name=preScriptionFile]");
            var _file = $image_file[0].files[0];

            if (_file !== null) {

                var _frm = new FormData();
                _frm.append("Mode", "update_prescription_file");
                _frm.append("ps_code", $("#ps_code").val());
                _frm.append("user_id", $("#user_id").val());
                _frm.append("send_type", "1");
                _frm.append("image_file", _file);

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
                                $("#frm").attr("action", "photo_step_02.php");
                                $("#frm").submit();
                                break;

                            case "200" :
                                alert("처방전에 오류가 있습니다");
                                break;

                            case "300" :
                                alert("처방전 작성에 문제가 발생하였습니다");
                                break;

                            case "900" :
                                alert("Error");
                                break;

                        }
                    }
                });

            } else {

                alert("이미지가 없습니다");

            }

        });

        function ps_img_del(physical_name) {

            var _frm = new FormData();
            _frm.append("Mode", "cancel_prescription_img_del");
            _frm.append("physical_name", physical_name);

            $.ajax({
                method: 'POST',
                url: '../_action/prescription.do.php',
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    //console.log(_res);
                    switch (_res) {
                        case "100" :
                            alert("처방전 이미지가 삭제되었습니다.");
                            location.reload();
                            break;

                        default :
                            alert("처방전 이미지 삭제이 실패하였습니다.");
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