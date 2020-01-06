<h3 class="h3_title">비밀번호 수정</h3>
<div class="adm_table_style01">
    <form id="frm" name="frm" method="post" action="./_action/member.do.php" style="display:inline;" target="actionForm">
        <input type="hidden" id="Mode" name="Mode" value="member_pass">
        <input type="hidden" id="idx" name="idx" value="<?= $_pharmacist["idx"] ?>">
        <table>
            <colgroup>
                <col style="width:15%"/>
                <col style="width:35%"/>
                <col style="width:15%"/>
                <col style="width:35%"/>
            </colgroup>
            <tbody>
            <tr>
                <th>새로운 비밀번호</th>
                <td>
                    <input type="password" id="user_pass" name="user_pass" value="" /> <br>
                    ( 영문자 + 숫자 + 특수문자 8~20 )
                </td>
                <th>새로운 비밀번호 확인</th>
                <td>
                    <input type="password" id="re_pass" name="re_pass" value="" /> <br>
                    ( 영문자 + 숫자 + 특수문자 8~20 )
                </td>
            </tr>
            </tbody>
        </table><br>
        <div class="btn_area t_c">
            <input type="button" onClick="chk_form()" value="비밀번호 변경" class="btn_b btn21">
        </div>
    </form>
</div>
</div>
</div>

<script language='Javascrip' type='text/javascript'>
    <!--

    function chk_form() {

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
        $("#frm").submit();
    }

    //-->
</script>