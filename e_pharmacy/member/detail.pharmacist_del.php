<h3 class="h3_title">약국탈퇴</h3>
<div class="adm_table_style01">
    <form id="frm" name="frm" method="post" action="./_action/member.do.php" style="display:inline;" target="actionForm">
        <input type="hidden" id="Mode" name="Mode" value="member_del">
        <input type="hidden" id="ppidx" name="ppidx" value="<?=$_pharmacist["ppidx"]?>">
        <input type="hidden" id="idx" name="idx" value="<?=$_pharmacist["idx"]?>">

        <table>
            <colgroup>
                <col style="width:15%" />
                <col style="width:*" />
            </colgroup>
            <tbody>
            <tr>
                <th>비밀번호 확인</th>
                <td>
                    <input type="password" id="mm_pass" name="mm_pass" value="" />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding:20px;">
                    ○ 탈퇴 시 복구가 불가능합니다.
                </td>
            </tr>
            </tbody>
        </table><br>

        <div class="btn_area t_c">
            <input type="button" value="탈퇴 신청" onclick="chk_form()" class="btn_b btn21">
        </div>
    </form>
</div>
</div>
</div>

<script language='Javascrip' type='text/javascript'>
    <!--

    function chk_form() {

        var mm_pass = $("#mm_pass").val();

        if (mm_pass == "") {
            alert("비밀번호를 입력 해 주십시오");
            $("#mm_pass").val('');
            $("#mm_pass").focus();
            return false;
        }

        $("#frm").submit();
    }

    //-->
</script>