<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";
?>
    <div class="coNtent">
        <div class="position_wrap">
            <span>mypage</span>
            <span>비밀번호 수정</span>
        </div>
        <div class="inner_coNtwrap">
            <div class="fixedbodycoNt">
                <div class="pspSend_wrap2">
                    <div class="login_wrap">
                        <input type="hidden" id="user_id" name="user_id" value="<?= $mm_row["USER_ID"] ?>">
                        <input type="hidden" id="idx" name="idx" value="<?= $mm_row["IDX"] ?>">
                        <fieldset>
                            <div class="inp_field">
                                <label for="mm_pass">기존 비밀번호</label>
                                <input type="password" name="mm_pass" id="mm_pass" placeholder="기존 비밀번호를 입력하세요">
                            </div>
                            <div class="inp_field">
                                <label for="user_pass">새로운 비밀번호</label>
                                <input type="password" name="user_pass" id="user_pass"
                                       placeholder="영문자 + 숫자 + 특수문자 8~20">
                            </div>
                            <div class="inp_field">
                                <label for="re_pass">새로운 비밀번호 확인</label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="영문자 + 숫자 + 특수문자 8~20">
                            </div>
                            <div class="inp_field">
                                <input type="button" class="btnWg100" onclick="chk_form()" name="" value="비밀번호 수정">
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
            var user_pass = $("#user_pass").val();
            var re_pass = $("#re_pass").val();

            if (mm_pass == "") {
                alert("기존 비밀번호를 입력 해 주십시오");
                $("#mm_pass").val('');
                $("#mm_pass").focus();
                return false;
            }

            if (user_pass == "") {
                alert("새로운 비밀번호를 입력 해 주십시오");
                $("#user_pass").val('');
                $("#user_pass").focus();
                return false;
            }

            if (user_pass != re_pass) {
                alert("비밀번호가 일치하지 않습니다. \n\n비밀번호를 확인 해 주세요");
                $("#user_pass").focus();
                return false;
            }

            if (!/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,20}$/.test(user_pass)) {
                alert('비밀번호는 영문자와 숫자, 특수문자 조합으로 \n\n8~20자리를 사용해야 합니다.');
                return false;
            }

            var chk_num = user_pass.search(/[0-9]/g);
            var chk_eng = user_pass.search(/[a-z]/ig);

            if (chk_num < 0 || chk_eng < 0) {
                alert('비밀번호는 숫자와 영문자를 혼용하여야 합니다.');
                return false;
            }

            if (/(\w)\1\1\1/.test(user_pass)) {
                alert('비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다.');
                return false;
            }

            // 폼 보내기
            var idx = $('#idx').val();
            var mm_pass = $('#mm_pass').val();
            var user_pass = $('#user_pass').val();

            var _frm = new FormData();

            _frm.append("Mode", "member_pass");
            _frm.append("idx", idx);
            _frm.append("mm_pass", mm_pass);
            _frm.append("user_pass", user_pass);

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
                            alert("비밀번호를 수정하였습니다.");
                            location.href = "../mypage/mypage.php";
                            break;
                        case "1" :
                            alert("기존 비밀번호가 일치하지 않습니다.");
                            break;
                        default :
                            alert("에러");
                            break;
                    }
                }
            });
        }

        //-->
    </script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>