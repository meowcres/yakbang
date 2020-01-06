<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
?>
<div class="coNtent">
    <div class="position_wrap">
        <span>MEMBER</span>
        <span>회원가입</span>
    </div>
    <div class="inner_coNtwrap">
        <div class="fixedbodycoNt">
            <div class="pspSend_wrap2">
                <div class="login_wrap">
                    <form method="POST" id="frm" name="frm" action="../_action/member.do.php" target="actionForm">
                        <input type="hidden" id="Mode" name="Mode" value="member_add">
                        <input type="hidden" id="chk_id" name="chk_id" value="">
                        <fieldset>
                            <legend>회원가입폼</legend>
                            <div class="inp_field">
                                <label for="user_id">이메일<span class="imporTbullet">*</span></label>
                                <input type="text" name="user_id" id="user_id" placeholder="example@eyacbang.com">
                            </div>
                            <p class="validation" id="id_msg">이메일을 입력해주세요</p>
                            <div class="inp_field">
                                <label for="user_pass">비밀번호<span class="imporTbullet">*</span></label>
                                <input type="password" name="user_pass" id="user_pass" placeholder="8-20자로 입력해주세요.">
                            </div>
                            <div class="inp_field">
                                <label for="re_pass">비밀번호 확인<span class="imporTbullet">*</span></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="비밀번호를 한번 더 입력해주세요.">
                            </div>
                            <p class="validation" id="pass_msg">비밀번호를 입력해주세요</p>
                            <div class="inp_field">
                                <label for="user_name">이름<span class="imporTbullet">*</span></label>
                                <input type="text" name="user_name" id="user_name" placeholder="이약방">
                            </div>
                            <div class="inp_field">
								<label for="phone1">연락처<span class="imporTbullet">*</span></label>
								<div class="phone_wrap">
									<span class="selectBox">
										<label for="phone1">02</label>
										<select id="phone1" name="phone1">
											<?
											foreach ($phone_array as $val) {
												?>
												<option value="<?= $val ?>"><?= $val ?></option>
												<?
											}
											?>
										</select>
									</span>
									<em>-</em>
									<span><input type="tel" id="phone2" name="phone2" value="" maxlength="4"
										   onkeyup="passTab('phone2','phone3',4);"></span>
									<em>-</em>
									<span><input type="tel" id="phone3" name="phone3" value="" maxlength="4"></span>
								</div>
                            </div>
                            <div class="inp_field">
                                <span class="flabel">생년월일</span>
                                <div class="inner_Two">
                                    <div class="inner_Left">
                                        <input type="text" name="birth_year" id="birth_year" maxlength="4"
                                               title="년도 기입창"
                                               placeholder="YYYY">
                                        <em>/</em>
                                        <input type="text" name="birth_month" id="birth_month" maxlength="2"
                                               title="월 기입창"
                                               placeholder="MM">
                                        <em>/</em>
                                        <input type="text" name="birth_day" id="birth_day" maxlength="2" title="일 기입창"
                                               placeholder="DD">
                                    </div>
                                    <div class="inner_Right">
                                        <input type="radio" name="user_sex" id="user_sex_m" value="M" checked >
                                        <label for="user_sex_m">남성</label>

                                        <input type="radio" name="user_sex" id="user_sex_f" value="F">
                                        <label for="user_sex_f">여성</label>
                                    </div>
                                </div>
                            </div>
                            <div class="inp_field">
                                <span class="flabel maRtop20">이용약관 동의</span>
                                <ul class="agreAreaList">
                                    <li>
                                        <input type="checkbox" name="all_chk" id="all_chk">
                                        <label for="all_chk">모든 약관에 전체동의합니다.</label>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="" id="inp_chk00" class="agreechk">
                                        <label for="inp_chk00">e약방 이용약관 동의<em>(필수)</em></label>
                                        <a href="show_Fullslide00" class="infoLink showLayerForm">약관보기</a>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="" id="inp_chk01" class="agreechk">
                                        <label for="inp_chk01">개인정보 수집이용 동의<em>(필수)</em></label>
                                        <a href="show_Fullslide01" class="infoLink showLayerForm">약관보기</a>
                                    </li>
                                    <li>
                                        <input type="checkbox" name="" id="inp_chk03" class="agreechk">
                                        <label for="inp_chk03">마케팅 정보 메일 SMS 수신 동의<em>(선택)</em></label>
                                    </li>
                                </ul>
                            </div>
                            <div class="inp_field">
                                <a href="javascript:void(0);" onclick="chk_form();" class="btnWg100">다음</a>
                            </div>
                        </fieldset>
                    </form>
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


    $("#user_id").keyup(function () {

        if ($("#user_id").val().length >= 4) {

            // 이메일 정규식
            if ($("#user_id").val().length > 30) {
                alert('이메일의 길이는 4~30자 내외 입니다.');
                $("#id_msg").html("이메일을 입력하세요");
                $("#user_id").val('');
                $("#chk_id").val('');
                return false;
            }

            // 이메일 형식 정규식
            var email = $("#user_id").val();
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (!filter.test(email)) {
                $("#id_msg").html("이메일 형식이 올바르지 않습니다.");
                $("#chk_id").val('');
                return false;
            }


            // 아이디 중복 체크하기 ( 실시간 메시지 띄우기 )
            var user_id = $('#user_id').val();
            var user_sex = $('input[name="user_sex"]:checked').val();
            var _frm = new FormData();

            _frm.append("Mode", "double_check_id");
            _frm.append("user_id", user_id);
            _frm.append("user_sex", user_sex);

            $.ajax({
                method: 'POST',
                url: "../_action/member.do.php",
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    console.log(_res);
                    switch (_res) {
                        case "200" :
                            $("#id_msg").html("사용 가능한 이메일 입니다");
                            $("#chk_id").val(user_id);
                            break;

                        case "300" :
                            $("#id_msg").html("이미 사용중인 이메일 입니다");
                            $("#chk_id").val('');
                            break;

                        case "400" :
                            alert("이메일의 첫글자는 영문이어야 합니다");
                            $("#id_msg").html("이메일을 확인하여 주세요");
                            $("#user_id").val('');
                            $("#chk_id").val('');
                            break;
                    }
                }
            });
        }
    });

    // 비밀번호 체크 메시지 띄우기
    $("#re_pass").keyup(function () {

        if ($("#re_pass").val().length >= 6) {

            var user_pass = $('#user_pass').val();
            var re_pass = $('#re_pass').val();

            if (user_pass.length < 6) {
                $("#pass_msg").html("비밀번호가 너무 짧습니다");
                $("#user_pass").val('');
                return false;
            }
            if (user_pass == re_pass) {
                $("#pass_msg").html("비밀번호가 일치합니다");
            } else {
                $("#pass_msg").html("비밀번호가 일치하지 않습니다");
            }
        }
    });

    // 폼 체크 정규식 및 폼 보내기
    function chk_form() {

        var email = $("#user_id").val();
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (!filter.test(email)) {
            alert("이메일 형식이 올바르지 않습니다.");
            $("#id_msg").html("이메일 형식이 올바르지 않습니다.");
            $("#user_id").focus();
            return false;
        }
        if ($("#chk_id").val() == "") {
            alert("이메일을 확인해 주세요");
            $("#user_id").focus();
            return false;
        }
        if ($("#user_id").val() == "") {
            alert("이메일을 입력해 주세요");
            $("#user_id").val('');
            $("#user_id").focus();
            return false;
        }
        var user_pass = $("#user_pass").val();
        var re_pass = $("#re_pass").val();
        if (user_pass == "") {
            alert("비밀번호를 입력 해 주십시오");
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
            $("#user_pass").val('');
            $("#user_pass").focus();
            return false;
        }
        var chk_num = user_pass.search(/[0-9]/g);
        var chk_eng = user_pass.search(/[a-z]/ig);
        if (chk_num < 0 || chk_eng < 0) {
            alert('비밀번호는 숫자와 영문자를 혼용하여야 합니다.');
            $("#user_pass").val('');
            $("#user_pass").focus();
            return false;
        }
        if (/(\w)\1\1\1/.test(user_pass)) {
            alert('비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다.');
            $("#user_pass").val('');
            $("#user_pass").focus();
            return false;
        }
        if ($("#user_name").val() == "") {
            alert("이름을 입력해 주세요");
            $("#user_name").focus();
            return false;
        }
        if ($("#phone2").val() == "") {
            alert("연락처를 입력해 주세요");
            $("#phone2").focus();
            return false;
        }
        if ($("#phone3").val() == "") {
            alert("연락처를 입력해 주세요");
            $("#phone3").focus();
            return false;
        }
        if ($("#birth_year").val() == "") {
            alert("생년월일을 입력해 주세요");
            $("#birth_year").focus();
            return false;
        }
        var birth_year = $("#birth_year").val();
        if (!/^[0-9]+$/.test(birth_year)) {
            alert("생년월일은 숫자만 입력 가능합니다.");
            $("#birth_year").val('');
            $("#birth_year").focus();
            return false;
        }
        if ($("#birth_month").val() == "") {
            alert("생년월일을 입력해 주세요");
            $("#birth_month").focus();
            return false;
        }
        var birth_month = $("#birth_month").val();
        if (!/^[0-9]+$/.test(birth_month)) {
            alert("생년월일은 숫자만 입력 가능합니다.");
            $("#birth_month").val('');
            $("#birth_month").focus();
            return false;
        }
        if ($("#birth_day").val() == "") {
            alert("생년월일을 입력해 주세요");
            $("#birth_day").focus();
            return false;
        }
        var birth_day = $("#birth_day").val();
        if (!/^[0-9]+$/.test(birth_day)) {
            alert("생년월일은 숫자만 입력 가능합니다.");
            $("#birth_day").val('');
            $("#birth_day").focus();
            return false;
        }

        if ($('input[name="user_sex"]').is(":checked") != true) {
            alert("성별을 체크해 주세요."); 
            return false;
        }

        if ($('input:checkbox[id="inp_chk00"]').is(":checked") != true) {
            alert("이용약관을 동의하여 주십시오");
            return false;
        }
        if ($('input:checkbox[id="inp_chk01"]').is(":checked") != true) {
            alert("개인정보 수집에 동의하여 주십시오");
            return false;
        }

        // 회원가입 폼 보내기
        var chk_id = $('#chk_id').val();
        var user_pass = $('#user_pass').val();
        var user_name = $('#user_name').val();
        var phone1 = $('#phone1').val();
        var phone2 = $('#phone2').val();
        var phone3 = $('#phone3').val();
        var birth_year = $('#birth_year').val();
        var birth_month = $('#birth_month').val();
        var birth_day = $('#birth_day').val();
        var user_sex = $('input[name="user_sex"]:checked').val();

        var _frm = new FormData();

        _frm.append("Mode", "member_add");
        _frm.append("chk_id", chk_id);
        _frm.append("user_pass", user_pass);
        _frm.append("user_name", user_name);
        _frm.append("phone1", phone1);
        _frm.append("phone2", phone2);
        _frm.append("phone3", phone3);
        _frm.append("birth_year", birth_year);
        _frm.append("birth_month", birth_month);
        _frm.append("birth_day", birth_day);
        _frm.append("user_sex", user_sex);

        $.ajax({
            method: 'POST',
            url: "../_action/member.do.php",
            processData: false,
            contentType: false,
            data: _frm,
            success: function (_res) {
                console.log(_res);
                switch (_res) {
                    case "1" :
                        alert("회원가입에 성공하였습니다.");
                        location.href = "../main/main.php";


                        break;
                    default :
                        alert("실패");
                        break;
                }
            }
        });


        //$("#frm").submit();

    }


</script>
