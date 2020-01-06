<div id="Contents">
    <h1>OPERATOR &gt; 오퍼 관리 &gt; <strong>오퍼 등록</strong></h1>

    <div><b>○ 오퍼 기본정보</b></div>

    <form name="frm" method="post" enctype="multipart/form-data" action="./_action/operator.do.php" onSubmit="return chk_form(this);" style="display:inline;" target="actionForm">
        <input type="hidden" id="Mode" name="Mode" value="operator_add">
        <input type="hidden" id="chk_id" name="chk_id" value="">
        <table class="tbl1">
            <colgroup>
                <col width="12%"/>
                <col width="38%"/>
                <col width="12%"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>아이디</th>
                <td>
                    <input type="text" id="op_id" name="op_id"  class="w200">
                    <input type="button" value="중복체크" class="Small_Button btnOrange" onclick="chk_double_op_id();">
                </td>

                <th>상태</th>
                <td class="left">
                    <select id="op_status" name="op_status" class="w100">
                        <?php
                        foreach ($op_status_array as $key => $val) {
                            ?>
                            <option value="<?= $key ?>"><?= $val ?></option><?
                        }
                        ?>
                    </select> 상태
                </td>
            </tr>

            <tr>
                <th>비밀번호</th>
                <td><input type="password" id="op_pass" name="op_pass" class="w200"> &nbsp; ( 영문자 + 숫자 + 특수문자 8~20 )</td>

                <th>비밀번호 확인</th>
                <td><input type="password" id="re_pass" name="re_pass" class="w200"> &nbsp;</td>
            </tr>

            <tr>
                <th>이름</th>
                <td><input type="text" id="op_name" name="op_name" class="w200"></td>

                <th>등급</th>
                <td><input type="text" id="op_grade" name="op_grade" class="w200" value="1" maxlength="1"></td>
            </tr>

            <tr>
                <th>성별</th>
                <td>
                    <input type="radio" id="op_sex_m" name="op_sex" value="M" checked>&nbsp;<label for="user_sex_m">남성</label> &nbsp;&nbsp;
                    <input type="radio" id="op_sex_f" name="op_sex" value="F">&nbsp;<label for="user_sex_f">여성</label>
                </td>


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
            </tr>

            <tr>
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

                <th>이메일</th>
                <td class="left" colspan="3">
                    <input id="email_id" name="email_id" type="text" class="w200"/> @
                    <input id="email_domain" name="email_domain" type="text" class="w150"/>
                    <select id="selectDomin" name="selectDomin" class="wid30"
                            onChange="document.getElementById('email_domain').value = this.value; ">
                        <option value="">직접입력</option>
                        <?php
                        foreach ($email_array as $k => $v) {
                            echo "<option value='{$v}'>{$v}</option>";
                        }
                        ?> 
                    </select>
                </td>
            </tr>

            <tr>
                <th>접속권한시작일</th>
                <td>
                    <select id="start_year" name="start_year" class="w70">
                        <?php
                        //for ($i = 1920; $i <= date('Y'); $i++) {
                        for ($i = 1920; $i <= 2100; $i++) {
                            $select = ($i == 2019) ? "selected" : "";
                            echo "<option value='$i' $select>$i</option>";
                        }
                        ?>
                    </select> 년 &nbsp;

                    <select id="start_month" name="start_month" class="w50">
                        <?php
                        for ($i = 1; $i < 13; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == date("m") ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 월 &nbsp;

                    <select id="start_day" name="start_day" class="w50">
                        <?
                        for ($i = 1; $i < 32; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == date("d") ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 일 &nbsp;
                </td>

                <th>접속권한마감일</th>
                <td>
                    <select id="end_year" name="end_year" class="w70">
                        <?php
                        //for ($i = 1920; $i <= date('Y'); $i++) {
                        for ($i = 1920; $i <= 2100; $i++) {
                            $select = ($i == 2019) ? "selected" : "";
                            echo "<option value='$i' $select>$i</option>";
                        }
                        ?>
                    </select> 년 &nbsp;
                    <select id="end_month" name="end_month" class="w50">
                        <?php
                        for ($i = 1; $i < 13; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == date("m") ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 월 &nbsp;

                    <select id="end_day" name="end_day" class="w50">
                        <?
                        for ($i = 1; $i < 32; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == date("d") ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 일 &nbsp;
                </td>
            </tr>

            <tr>
                <th>관리 메모</th>
                <td colspan="3"><textarea id="admin_memo" name="admin_memo" style="width:99%;height100px;"></textarea></td>            
            </tr>

        </table>

        <div style="margin-top:20px;" class="center">
            <input type="submit" value="등록" class="Button btnGreen w100"> &nbsp;
            <input type="button" value="취소" class="Button btnRed w100" onClick="history.back();">
        </div>
    </form>

</div>

<script language="JavaScript" type="text/JavaScript">

function chk_double_op_id() {

    var ID = $("#op_id").val();

    if(ID == "") {
        alert("아이디를 입력해 주세요.");
    }

    var frm = new FormData();

    frm.append("Mode", "id_find");
    frm.append("chk_id", ID);

    $.ajax({
        type: 'POST',
        url: './_action/operator.do.php',
        processData: false,
        contentType: false,
        data: frm,
        success:function(_res) {
            console.log(_res);
            switch(_res) {
                case "100":
                alert("이미 사용되는 아이디 입니다");
                $("#chk_id").val("");                          
                return false;
                break;

                case "200":
                alert("사용 가능한 아이디 입니다");
                $("#chk_id").val(ID);
                return false;
                break;
            }
        }
    });
}

function chk_form(f) {

    // 아이디
    var ChkEng = /^[[a-z0-9]+$/;
    var op_id = $("#op_id").val();

    if ($("#op_id").val() == "") {
        alert("아이디를 입력해 주십시오");
        $("#op_id").focus();
        return false;
    } if(!ChkEng.test(op_id)) {
        alert("아이디는 영문자와 숫자 조합으로만 입력 가능합니다.");
        $("#op_id").val("").focus();
        return false;
    } if ($("#chk_id").val() == "") {
        alert("아이디를 중복체크 해 주십시오");
        return false;
    }


    // 비밀번호 
    var op_pass = $("#op_pass").val();
    var re_pass = $("#re_pass").val();

    if (op_pass == "") {
        alert("비밀번호를 입력 해 주십시오");
        $("#op_pass").val("").focus();
        return false;
    }

    if (!/^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,20}$/.test(op_pass)) {
        alert("비밀번호는 영문자와 숫자, 특수문자 조합으로 \n\n8~20자리를 사용해야 합니다.");
        $("#op_pass").val("").focus();
        return false;
    }

    if (/(\w)\1\1\1/.test(op_pass)) {
        alert("비밀번호에 같은 문자를 4번 이상 사용하실 수 없습니다.");
        $("#op_pass").val("").focus();
        return false;
    }

    if (op_pass != re_pass) {
        alert("비밀번호가 일치하지 않습니다. \n\n비밀번호를 확인 해 주세요");
        $("#re_pass").focus().val("");
        return false;
    }


    // 이름
    var op_name = $("#op_name").val();
    var ChkHangul = /^[ㄱ-ㅎㅏ-ㅣ가-힣]*$/;

    if($("#op_name").val() == "") {
        alert("이름을 입력해 주세요.");
        $("#op_name").focus();
        return false;
    } if(!ChkHangul.test(op_name)) {
        alert("이름은 한글만 입력 가능합니다.");
        $("#op_name").val("").focus();
        return false;
    } 


    // 전화번호
    var phone2 = $("#phone2").val();
    var phone3 = $("#phone3").val();
    var patternPhone = /^[0-9]+$/; 

    if(phone2 == "") {
        alert("전화번호를 입력해 주세요.");
        $("#phone2").focus();
        return false;
    } if(!phone2 || phone2.length < 3) {
        alert("전화번호 형식이 올바르지 않습니다.");
        $("#phone2").val("").focus();
        return false;
    } if(!patternPhone.test(phone2)) {
        alert("전화번호 형식이 올바르지 않습니다.");
        $("#phone2").val("").focus();
        return false;
    } 
    
    if(phone3 == "") {
        alert("전화번호를 입력해 주세요.");
        $("#phone3").focus();
        return false;
    } if(!phone3 || phone3.length < 4) {
        alert("전화번호 형식이 올바르지 않습니다.");
        $("#phone3").val("").focus();
        return false;
    } if(!patternPhone.test(phone3)) {
        alert("전화번호 형식이 올바르지 않습니다.");
        $("#phone3").val("").focus();
        return false;
    }


    // 이메일 
    if($("#email_id").val() == "") {
        alert("이메일 주소를 입력해 주세요.");
        $("#email_id").focus();
        return false;
    }

    var emailName = $("#email_id").val();
    var patternEmail = /^[a-z0-9]+$/; 
  
    if(!patternEmail.test(emailName)){
        alert("이메일 형식이 올바르지 않습니다.");
        $("#email_id").val("").focus();
        return false;
    }

    if($("#email_domain").val() == "") {
        alert("이메일 주소를 입력해 주세요.");
        $("#email_domain").focus();
        return false;
    }

    $("#frm").submit();

}

</script>