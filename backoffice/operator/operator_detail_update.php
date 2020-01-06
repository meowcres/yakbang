<?php



$OP_ID = $_REQUEST["op_id"];

$qry_001  = " SELECT t1.* ";
$qry_001 .= " FROM {$TB_OP} t1 ";
$qry_001 .= " WHERE t1.OP_ID = '" . $OP_ID . "' ";


$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

$totalnum = $row_001[0];


?>
<div id="Contents">
    <h1>OPERATOR &gt; 오퍼 관리 &gt; <strong>오퍼 수정</strong></h1>

    <div><b>○ 오퍼 기본정보</b></div>

    <form name="frm" method="post" enctype="multipart/form-data" action="./_action/operator.do.php" onSubmit="return chk_form(this);" style="display:inline;" target="actionForm">
        <input type="hidden" id="Mode" name="Mode" value="operator_modify">
        <input type="hidden" id="op_id" name="op_id" value="<?= $row_001['OP_ID']?>">
        <table class="tbl1">
            <colgroup>
                <col width="12%"/>
                <col width="38%"/>
                <col width="12%"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>아이디</th>
                <td><?= $row_001['OP_ID']?></td>

                <th>상태</th>
                <td class="left">
                    <select id="op_status" name="op_status" class="w100">                        
                        <?php
                        foreach ($op_status_array as $key => $val) {
                            $_selected = $key == $row_001['OP_STATUS'] ? "selected" : "";
                            ?>
                            <option value="<?= $key ?>" <?= $_selected ?>><?= $val ?></option><?
                        }
                        ?>
                    </select> 상태
                </td>
            </tr>

            <tr>
                <th>비밀번호</th>
                <td><input type="password" id="op_pass" name="op_pass" value="<?= $row_001['OP_PASS'] ?>" class="w200"> &nbsp; ( 영문자 + 숫자 + 특수문자 8~20 )</td>

                <th>비밀번호 확인</th>
                <td><input type="password" id="re_pass" name="re_pass" value="<?= $row_001['OP_PASS'] ?>" class="w200"> &nbsp; ( 영문자 + 숫자 + 특수문자 8~20 )</td></td>
            </tr>

            <tr>
                <th>이름</th>
                <td><input type="text" id="op_name" name="op_name" value="<?= $row_001['OP_NAME'] ?>" class="w200"></td>

                <th>등급</th>
                <td><input type="text" id="op_grade" name="op_grade" value="<?= $row_001['OP_GRADE'] ?>" class="w200"></td>
            </tr>

            <tr>
                <th>성별</th>
                <td>
                    <?php
                    $checked = $row_001["USER_SEX"] == M ? "checked" : "";

                    ?>
                    <input type="radio" id="op_sex_m" name="op_sex" value="M" <?= $row_001['OP_SEX'] == M ? "checked" : ""; ?>> <label for="user_sex_m">남성</label> &nbsp;&nbsp;
                    <input type="radio" id="op_sex_f" name="op_sex" value="F" <?= $row_001['OP_SEX'] == F ? "checked" : ""; ?>> <label for="user_sex_f">여성</label>
                </td>


                <th>생년월일</th>
                <td>
                    <select id="birth_year" name="birth_year" class="wid20">
                        <?php
                        for ($i = 1920; $i <= date('Y'); $i++) {
                            $select = $i == explode("-", $row_001['OP_BIRTH'])[0] ? "selected" : "";
                            echo "<option value='$i' $select>$i</option>";
                        }
                        ?>
                    </select> 년 &nbsp;

                    <select id="birth_month" name="birth_month" class="wid20">
                        <?php
                        for ($i = 1; $i < 13; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == explode("-", $row_001['OP_BIRTH'])[1] ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 월 &nbsp;

                    <select id="birth_day" name="birth_day" class="wid20">
                        <?
                        for ($i = 1; $i < 32; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == explode("-", $row_001['OP_BIRTH'])[2] ? "selected" : "";
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
                            $_selected = $val == explode("-", $row_001['OP_HP'])[0] ? "selected" : "";
                            ?>
                            <option value="<?= $val ?>" <?= $_selected ?>><?= $val ?></option><?
                        }
                        ?>
                    </select> -
                    <input type="text" id="phone2" name="phone2" value="<?= explode("-", $row_001['OP_HP'])[1] ?>" class="w50 onlyNumbers" maxlength="4" onkeyup="passTab('phone2','phone3',4);"> -
                    <input type="text" id="phone3" name="phone3" value="<?= explode("-", $row_001['OP_HP'])[2] ?>" class="w50 onlyNumbers" maxlength="4">
                </td>

                <th>이메일</th>
                <td class="left" colspan="3">
                    <input id="email_id" name="email_id" type="text" value="<?= explode("@", $row_001['OP_EMAIL'])[0] ?>" class="Text Eng" size="20" /> @
                    <select name="selectDomin" onChange="document.getElementById('email_domain').value = this.value; ">
                        <option value="">직접입력</option>
                        <?
                        while(list($key,$value) = each($email_array)){
                            echo "<option value='{$value}'>{$value}</option>";
                        }
                        ?>
                    </select>
                    <input id="email_domain" name="email_domain" type="text" value="<?= explode("@", $row_001['OP_EMAIL'])[1]?>" class="Text Eng" size="20" />
                </td>
            </tr>

            <tr>
                <th>접속권한시작일</th>
                <td>
                    <select id="start_year" name="start_year" class="wid20">
                        <?php
                        for ($i = 1920; $i <= 2100; $i++) {
                            $select = $i == explode("-", $row_001['START_DATE'])[0] ? "selected" : "";
                            echo "<option value='$i' $select>$i</option>";
                        }
                        ?>
                    </select> 년 &nbsp;

                    <select id="start_month" name="start_month" class="wid20">
                        <?php
                        for ($i = 1; $i < 13; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == explode("-", $row_001['START_DATE'])[1] ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 월 &nbsp;

                    <select id="start_day" name="start_day" class="wid20">
                        <?
                        for ($i = 1; $i < 32; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == explode("-", $row_001['START_DATE'])[2] ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 일 &nbsp;
                </td>

                <th>접속권한마감일</th>
                <td>
                    <select id="end_year" name="end_year" class="wid20">
                        <?php
                        for ($i = 1920; $i <= 2100; $i++) {
                            $select = $i == explode("-", $row_001['END_DATE'])[0] ? "selected" : "";
                            echo "<option value='$i' $select>$i</option>";
                        }
                        ?>
                    </select> 년 &nbsp;

                    <select id="end_month" name="end_month" class="wid20">
                        <?php
                        for ($i = 1; $i < 13; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == explode("-", $row_001['END_DATE'])[1] ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 월 &nbsp;

                    <select id="end_day" name="end_day" class="wid20">
                        <?
                        for ($i = 1; $i < 32; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == explode("-", $row_001['END_DATE'])[2] ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 일 &nbsp;
                </td>
            </tr>

            <tr>
                <th>관리 메모</th>
                <td colspan="3"><textarea id="admin_memo" name="admin_memo" style="width:99%;height100px;"><?= $row_001['ADMIN_MEMO'] ?></textarea></td>            
            </tr>

        </table>

        <div style="margin-top:20px;" class="center">
            <input type="submit" value="수정" class="Button btnGreen w100"> &nbsp;
            <input type="button" value="목록" class="Button btnRed w120" onClick="location.href='./admin.template.php?slot=operator&type=operator_list&<?= $_opt ?>'">
        </div>
    </form>
</div>




<script language="JavaScript" type="text/JavaScript">


function chk_form(f) {

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