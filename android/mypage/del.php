<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";
?>
    <div class="coNtent">
        <div class="position_wrap">
            <span>mypage</span>
            <span>회원탈퇴신청</span>
        </div>
        <div class="inner_coNtwrap">
            <div class="fixedbodycoNt">
                <div class="pspSend_wrap2">
                    <div class="login_wrap">
                        <input type="hidden" id="idx" name="idx" value="<?= $mm_row["IDX"] ?>">
                        <fieldset>
                            <div class="inp_field">
                                <label for="mm_pass">기존 비밀번호</label>
                                <input type="password" name="mm_pass" id="mm_pass" placeholder="기존 비밀번호를 입력하세요">
                            </div>
                            <div class="inp_field">
                                <input type="button" class="btnWg100" onclick="chk_form()" name="" value="회원탈퇴신청">
                            </div>
                        </fieldset>
                    </div>
                    <!-- content end -->
                </div>
            </div>
        </div>
    </div>

    <script language='Javascrip' type='text/javascript'>
        <!--

        function chk_form() {

            var mm_pass = $("#mm_pass").val();

            if (mm_pass == "") {
                alert("기존 비밀번호를 입력 해 주십시오");
                $("#mm_pass").val('');
                $("#mm_pass").focus();
                return false;
            }

            if (confirm("정말 회원탈퇴신청을 하시겠습니까? \n\n 탈퇴시 복구가 불가능합니다. ")) {

                // 폼 보내기
                var idx = $('#idx').val();

                var _frm = new FormData();

                _frm.append("Mode", "member_del");
                _frm.append("idx", idx);
                _frm.append("mm_pass", mm_pass);

                $.ajax({
                    method: 'POST',
                    url: "../_action/mypage.do.php",
                    processData: false,
                    contentType: false,
                    data: _frm,
                    success: function (_res) {
                        console.log(_res);
                        switch (_res) {
                            case "0" :
                                alert("회원탈퇴 신청을 완료하였습니다.");
                                location.href = "../_logout.php";
                                break;
                            case "1" :
                                alert("기존 비밀번호가 일치하지 않습니다.");
                                break;
                            default :
                                alert(_res);
                                break;
                        }
                    }
                });
            }
        }

        //-->
    </script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>