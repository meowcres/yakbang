<div id="Contents">
    <h1>약사관리 &gt; 약사 관리 &gt; <strong>약사 등록</strong></h1>

    <div><b>○ 약사 기본정보</b></div>

    <form name="frm" method="post" enctype="multipart/form-data" action="./_action/pharmacist.do.php"
          onSubmit="return chk_form(this);" style="display:inline;" target="actionForm">
        <input type="hidden" id="Mode" name="Mode" value="pharmacist_add">
        <input type="hidden" id="chk_id" name="chk_id" value="">
        <table class="tbl1">
            <colgroup>
                <col width="12%"/>
                <col width="38%"/>
                <col width="12%"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>약사상태</th>
                <td class="left">
                    <select id="user_status" name="user_status" class="w100">
                        <?php
                        foreach ($pharmacist_status_array as $key => $val) {
                            ?>
                            <option value="<?= $key ?>"><?= $val ?></option><?
                        }
                        ?>
                    </select> 상태
                </td>
                <th>회원구분</th>
                <td class="left"><?= $member_type_array[2] ?></td>
            </tr>

            <tr>
                <th>아이디 (이메일)</th>
                <td class="left" colspan="3">
                    <input id="emailID" name="emailID" type="text" class="w200"/> @
                    <input id="emailDomain" name="emailDomain" type="text" class="w150"/>
                    <select id="selectDomin" name="selectDomin" class="wid30"
                            onChange="document.getElementById('emailDomain').value = this.value; ">
                        <option value="">직접입력</option>
                        <?php
                        foreach ($email_array as $k => $v) {
                            echo "<option value='{$v}'>{$v}</option>";
                        }
                        ?>
                    </select>
                    <input type="button" value="중복체크" class="Small_Button btnOrange" onclick="chk_double_member_id();">


                </td>
            </tr>

            <tr>
                <th>비밀번호</th>
                <td><input type="password" value="" id="user_pass" name="user_pass" class="w200"/> &nbsp; ( 영문자 + 숫자 +
                    특수문자 8~20 )
                </td>
                <th>비밀번호 확인</th>
                <td><input type="password" value="" id="re_pass" name="re_pass" class="w200"/> &nbsp; ( 영문자 + 숫자 + 특수문자
                    8~20 )
                </td>
            </tr>

            <tr>
                <th>이 름</th>
                <td><input type="text" value="" id="user_name" name="user_name" class="w200"/></td>
                <th>연 락 처</th>
                <td>
                    <select id="phone1" name="phone1" class="w70">
                        <?
                        foreach ($phone_array as $val) {
                            $_selected = $val == $_phone_obj[0] ? "selected" : "";
                            ?>
                            <option value="<?= $val ?>" <?= $_selected ?>><?= $val ?></option><?
                        }
                        ?>
                    </select> -
                    <input type="text" id="phone2" name="phone2" value="" class="w50 onlyNumbers" maxlength="4"
                           onkeyup="passTab('phone2','phone3',4);"> -
                    <input type="text" id="phone3" name="phone3" value="" class="w50 onlyNumbers" maxlength="4">
                </td>
            </tr>

            <tr>
                <th>생년월일</th>
                <td>
                    <select id="birth_year" name="birth_year" class="w70">
                        <?php
                        for ($i = 1920; $i <= date('Y'); $i++) {
                            $select = ($i == 2000) ? "selected" : "";
                            echo "<option value='$i' $select>$i</option>";
                        }
                        ?>
                    </select> 년 &nbsp;
                    <select id="birth_month" name="birth_month" class="w50">
                        <?php
                        for ($i = 1; $i < 13; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == date("m") ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 월 &nbsp;
                    <select id="birth_day" name="birth_day" class="w50">
                        <?
                        for ($i = 1; $i < 32; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == date("d") ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 일 &nbsp;
                </td>
                <th>성별</th>
                <td>
                    <input type="radio" id="user_sex_m" name="user_sex" value="M" checked> <label
                            for="user_sex_m">남성</label> &nbsp;&nbsp;
                    <input type="radio" id="user_sex_f" name="user_sex" value="F"> <label for="user_sex_f">여성</label>
                </td>
            </tr>
            <tr>
                <th>약사 이미지</th>
                <td class="left" colspan="3">
                    <input type="file" id="pharmacist_img" name="pharmacist_img" class="w50p"/>
                </td>
            </tr>
        </table><br />

        <div><b>○ 약사 자격 정보</b></div>

        <table class="tbl1">
            <colgroup>
                <col width="12%"/>
                <col width="*"/>
            </colgroup>

            <tr>
                <th>약사 번호</th>
                <td class="left">
                    <input type="text" id="pharmacist_license" name="pharmacist_license" class="w200"/>
                </td>
            </tr>
            

            <tr>
                <th>자격증 사본</th>
                <td class="left">
                    <input type="file" id="license_paper" name="license_paper" class="w50p"/>
                </td>
            </tr>
        </table>

        <div style="margin-top:20px;" class="center">
            <input type="submit" value="등록" class="Button btnGreen w100"> &nbsp;
            <input type="button" value="취소" class="Button btnRed w100" onClick="history.back();">
        </div>
    </form>

</div>


<script language="JavaScript" type="text/JavaScript">

    function chk_double_member_id() {

        var email_id = $("#emailID").val();
        var email_domain = $("#emailDomain").val();

        if (email_id == "") {
            alert("이메일 아이디를 입력하여 주십시오");
            $("#emailID").focus();
            return false;
        }

        if (email_domain == "") {
            alert("이메일 주소를 입력하여 주십시오");
            $("#emailDomain").focus();
            return false;
        }

        var email = email_id + "@" + email_domain;
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(email)) {
            actionForm.location.href = './_action/member.do.php?Mode=double_check_id&email=' + email;
        } else {
            alert("이메일 주소를 정확히 입력하여 주십시오");
            $("#chk_id").val('');
            $("#emailID").val('');
            $("#emailDomain").val('');
            $("#emailID").focus();
            return false;
        }
    }


    function chk_form(f) {

        if ($("#chk_id").val() == "") {
            alert("아이디(이메일 주소)를 중복체크 해 주십시오");
            $("#emailID").val('');
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

        if ($("#user_name").val() == "") {
            alert("이름을 입력 해 주십시오");
            $("#user_name").val('');
            $("#user_name").focus();
            return false;
        }

        if ($("#pharmacist_license").val() == "") {
            alert("약사 번호를 입력 해 주십시오");
            $("#pharmacist_license").val('');
            $("#pharmacist_license").focus();
            return false;
        }

        $("#frm").submit();

    }

</script>