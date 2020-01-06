<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";
?>
<div class="coNtent">
    <div class="position_wrap">
        <span>mypage</span>
        <span>정보수정</span>
    </div>
    <div class="inner_coNtwrap">
        <div class="fixedbodycoNt">
            <div class="pspSend_wrap2">
                <div class="login_wrap">
                    <input type="hidden" id="Mode" name="Mode" value="member_up">
                    <input type="hidden" id="idx" name="idx" value="<?= $mm_row["IDX"] ?>">
                    <input type="hidden" id="user_id" name="user_id" value="<?= $mm_row["USER_ID"] ?>">
                    <fieldset>
                        <div class="inp_field">
                            <label>아이디<span class="imporTbullet">*</span></label>
                            <input type="text" value="<?= $mm_id ?>" readonly>
                        </div>
                        <p class="validation">아이디는 변경이 불가능합니다.</p>
                        <div class="inp_field">
                            <label for="user_name">이름<span class="imporTbullet">*</span></label>
                            <input type="text" name="user_name" id="user_name" value="<?= $mm_name ?>">
                        </div>
                        <div class="inp_field">
                            <label for="phone1">연락처<span class="imporTbullet">*</span></label>
                            <div class="phone_wrap">
                                <span class="selectBox">
                                    <label for="phone1"><?=$userPhone_obj[0]?></label>
                                    <select id="phone1" name="phone1">
                                        <?
                                        foreach ($phone_array as $val) {
                                            $_selected = $val == $userPhone_obj[0] ? "selected" : "";
                                            ?>
                                            <option value="<?= $val ?>"<?= $_selected ?>><?= $val ?></option>
                                            <?
                                        }
                                        ?>
                                    </select>
                                </span>
                                <em>-</em>
                                <span>
                                    <input type="tel" id="phone2" name="phone2"
                                           value="<?= explode("-", $mm_row["mm_phone"])[1] ?>" maxlength="4"
                                           onkeyup="passTab('phone2','phone3',4);">
                                </span>
                                <em>-</em>
                                <span>
                                    <input type="tel" id="phone3" name="phone3"
                                           value="<?= explode("-", $mm_row["mm_phone"])[2] ?>" maxlength="4">
                                </span>
                            </div>
                        </div>
                        <div class="inp_field">
                            <span class="flabel">생년월일</span>
                            <div class="inner_Two">
                                <div class="inner_Left">
                                    <input type="text" name="birth_year" id="birth_year" maxlength="4"
                                           title="년도 기입창" value="<?= explode("-", $mm_row["USER_BIRTHDAY"])[0] ?>">
                                    <em>/</em>
                                    <input type="text" name="birth_month" id="birth_month" maxlength="2"
                                           title="월 기입창"
                                           value="<?= explode("-", $mm_row["USER_BIRTHDAY"])[1] ?>">
                                    <em>/</em>
                                    <input type="text" name="birth_day" id="birth_day" maxlength="2" title="일 기입창"
                                           value="<?= explode("-", $mm_row["USER_BIRTHDAY"])[2] ?>">
                                </div>
                                <div class="inner_Right">
                                    <input type="radio" name="user_sex" id="user_sex_m"
                                           value="M" <?= $mm_row["USER_SEX"] == M ? "checked" : ""; ?>>
                                    <label for="user_sex_m">남성</label>
                                    <input type="radio" name="user_sex" id="user_sex_f"
                                           value="F" <?= $mm_row["USER_SEX"] == F ? "checked" : ""; ?>>
                                    <label for="user_sex_f">여성</label>
                                </div>
                            </div>
                        </div>
                        <div class="inp_field">
                            <a href="javascript:void(0);" onclick="chk_form();" class="btnWg100">정보수정</a>
                        </div>
                    </fieldset>
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
    function chk_form() {

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

        // 회원가입 폼 보내기
        var idx = $('#idx').val();
        var user_id = $('#user_id').val();
        var user_name = $('#user_name').val();
        var phone1 = $('#phone1').val();
        var phone2 = $('#phone2').val();
        var phone3 = $('#phone3').val();
        var birth_year = $('#birth_year').val();
        var birth_month = $('#birth_month').val();
        var birth_day = $('#birth_day').val();
        var user_sex = $('input[name="user_sex"]:checked').val();

        var _frm = new FormData();

        _frm.append("Mode", "member_up");
        _frm.append("idx", idx);
        _frm.append("user_id", user_id);
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
            url: "../_action/mypage.do.php",
            processData: false,
            contentType: false,
            data: _frm,
            success: function (_res) {
                console.log(_res);
                switch (_res) {
                    case "0" :
                        alert("정보를 수정하였습니다.");
                        location.href = "../mypage/mypage.php";
                        break;
                    default :
                        alert(_res);
                        break;
                }
            }
        });

    }


</script>
