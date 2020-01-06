<?php
include_once "../_core/_lib/class.attach.php";


$qry_001  = " SELECT *, DATE_FORMAT(START_DATE, '%Y-%d-%m') AS S_DATE, DATE_FORMAT(END_DATE, '%Y-%d-%m') AS E_DATE ";
$qry_001 .= " FROM {$TB_OP} ";
$qry_001 .= " WHERE OP_STATUS = '2' AND OP_ID = '".$_opKey["id"]."' ";

$res_001  = $db->exec_sql($qry_001);
$row_001  = $db->sql_fetch_array($res_001);

?>

<div id="content">
    <div class="sub_tit">내 정보관리 > 내 정보 수정</div>
    <div id="cont">
        <div class="adm_cts">
            <h3 class="h3_title">기본 정보</h3>
            <div class="adm_table_style01">

                <form id="frm" name="frm" method="post" action="./_action/member.do.php" onSubmit="return chkForm()" target="actionForm">
                <input type="hidden" id="Mode" name="Mode" value="member_modify">
                <input type="hidden" id="op_id" name="op_id" value="<?= $row_001["OP_ID"] ?>">

                <table>
                    <colgroup>
                        <col style="width:15%"/>
                        <col style="width:35%"/>
                        <col style="width:15%"/>
                        <col style="width:*"/>
                    </colgroup>
                    <tbody>

                        <tr height="55">
                            <th>아이디</th>
                            <td><?= $row_001["OP_ID"] ?></td>

                             <th>이름</th>
                             <td><?= $row_001["OP_NAME"] ?></td>

                        </tr>

                        <tr>
                            <th>비밀번호</th>
                            <td><input type="password" id="op_pass" name="op_pass" value="<?= $row_001["OP_PASS"] ?>"></td>

                            <th>비밀번호 확인</th>
                            <td><input type="password" id="re_pass" name="re_pass" value="<?= $row_001["OP_PASS"] ?>"></td>
                        </tr>

                        <tr>
                            <th>성별</th>
                            <td>
                                <?php
                                $checked = $row_001["OP_SEX"] == M ? "checked" : "";

                                ?>
                                <input type="radio" id="op_sex_m" name="op_sex" value="M" <?= $row_001['OP_SEX'] == M ? "checked" : ""; ?>> <label for="user_sex_m">남성</label> &nbsp;&nbsp;
                                <input type="radio" id="op_sex_f" name="op_sex" value="F" <?= $row_001['OP_SEX'] == F ? "checked" : ""; ?>> <label for="user_sex_f">여성</label>
                            </td>

                            <th>연락처</th>
                            <td>
                                <select id="phone1" name="phone1" class="wid20">
                                    <?
                                    foreach ($phone_array as $val) {
                                        $_selected = $val == explode("-", $row_001['OP_HP'])[0] ? "selected" : "";
                                        ?>
                                        <option value="<?= $val ?>" <?= $_selected ?>><?= $val ?></option><?
                                    }
                                    ?>
                                </select>&nbsp;-&nbsp
                                <input type="text" id="phone2" name="phone2" value="<?= explode("-", $row_001['OP_HP'])[1] ?>" class="wid20" maxlength="4" onkeyup="passTab('phone2','phone3',4);">&nbsp;-&nbsp;
                                <input type="text" id="phone3" name="phone3" value="<?= explode("-", $row_001['OP_HP'])[2] ?>" class="wid20" maxlength="4">
                            </td>
                        </tr>

                        <tr>
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

                            <th>이메일</th>
                            <td class="left" colspan="3">
                                <input id="email_id" name="email_id" type="text" value="<?= explode("@", $row_001['OP_EMAIL'])[0] ?>" style="width:32%" size="20" />&nbsp;@&nbsp;
                                <select name="selectDomin" onChange="document.getElementById('email_domain').value = this.value; " style="width:27%" >
                                    <option value="">직접입력</option>
                                    <?
                                    while(list($key,$value) = each($email_array)){
                                        echo "<option value='{$value}'>{$value}</option>";
                                    }
                                    ?>
                                </select>
                                <input id="email_domain" name="email_domain" type="text" value="<?= explode("@", $row_001['OP_EMAIL'])[1]?>" style="width:32%"  size="20" />
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div style="margin-top:20px;" align="center">
                    <input type="submit" value="정보수정" class="btn btn16 wid15 mt10">
                </div>
                </form>

            </div>
        </div>
    </div>
</div>

            
<script>

function chkForm() {

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

}


</script>