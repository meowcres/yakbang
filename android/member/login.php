<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
$__member_chk = "no_member";
include_once "../_member.php";
?>
<div class="coNtent">
    <div class="position_wrap">
        <span>member</span>
        <span>로그인</span>
    </div>
    <div class="inner_coNtwrap">
        <div class="fixedbodycoNt">
            <div class="pspSend_wrap2">
                <div class="login_wrap">
                    <form method="POST" id="logForm" name="logForm">
                        <fieldset>
                            <legend>로그인폼</legend>
                            <div class="inp_field">
                                <label for="">이메일 아이디</label>
                                <input type="text" name="log_id" id="log_id" placeholder="이메일을 입력하세요.">
                            </div>
                            <div class="inp_field">
                                <label for="syrup_pass">비밀번호</label>
                                <input type="password" name="log_pass" id="log_pass" placeholder="비밀번호를 입력하세요.">
                            </div>
                            <div class="inp_field">
                                <input type="button" onclick="login()" class="btnWg100" name="" value="로그인"
                                       title="로그인 버튼">
                            </div>
                            <div class="inp_field">
                                <a href="./join.php" class="btngL_W100">회원가입</a>
                            </div>
                        </fieldset>
                    </form>
                    <div class="idpass_find">
                        <a href="./idpassfind.php">아이디 / 비밀번호 찾기</a>
                    </div>
                    <!--
                    <ul class="loginLink">
                        <li><a href=""><span class="ico_00">네이버 간편 / 로그인</span></a></li>
                        <li><a href=""><span class="ico_01">카카오톡 간편 / 로그인</span></a></li>
                        <li><a href=""><span class="ico_02">페이스북 간편 / 로그인</span></a></li>
                        <li><a href=""><span class="ico_03">구글 간편 / 로그인</span></a></li>
                    </ul>
                    -->
                </div>
                <!-- content end -->
            </div>
        </div>
    </div>
</div>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>

<script>
    function login() {

        if ($("#log_id").val() == "") {
            alert("아이디를 입력 해 주세요");
            $("#log_id").focus();
            return false;
        }
        if ($("#log_pass").val() == "") {
            alert("비밀번호를 입력 해 주세요");
            $("#log_pass").focus();
            return false;
        }

        var _frm = new FormData();

        _frm.append("Mode", "user_login");
        _frm.append("log_id", $("#log_id").val());
        _frm.append("log_pass", $("#log_pass").val());

        $.ajax({
            method: 'POST',
            url: '../_action/login.do.php',
            processData: false,
            contentType: false,
            data: _frm,
            success: function (_res) {
                //console.log(_res);
                switch (_res) {
                    case "100" :
                        location.href='../main/main.php';
                        break;

                    case "200" :
                        alert($("#log_id").val() + " 아이디는 로그인 할 수 없습니다");
                        break;

                    case "300" :
                        alert("아이디, 비밀번호를 확인하여 주십시오!");
                        break;
                }
            }
        });

        $("#logForm").submit();

    }
</script>
