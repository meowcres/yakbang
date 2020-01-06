<form id="frm" name="frm" method="post" action="./_action/pharmacy.do.php" onSubmit="return chk_delForm();"
      style="display:inline;" target="actionForm">
    <input type="hidden" id="Mode" name="Mode" value="del_prescription">
    <input type="hidden" id="ps_code" name="ps_code" value="<?= $ps_main["PS_CODE"] ?>">

    <table>
        <colgroup>
            <col style="width:15%"/>
            <col style="width:*"/>
        </colgroup>
        <tbody>
        <tr>
            <td colspan="2" style="padding:20px;">
                ○ 삭제시에는 처방전에 관련된 모든 정보가 삭제 됩니다. ( 처방전정보, 처방약국, 처방약 등등 )
            </td>
        </tr>
        <tr>
            <th>관리자 비밀번호 확인</th>
            <td>
                <input type="password" id="mm_pass" name="mm_pass" value="" class="w120"/>
            </td>
        </tr>
        </tbody>
    </table>


    <div class="w100p mt10 center">
        <input type="submit" value="처방전 정보 삭제" class="Big_Button btnRed">
    </div>
</form>


<script language='Javascrip' type='text/javascript'>
    <!--

    function chk_delForm() {

        var mm_pass = $("#mm_pass").val();

        if (mm_pass == "") {
            alert("비밀번호를 입력 해 주십시오");
            $("#mm_pass").val('');
            $("#mm_pass").focus();
            return false;
        }

        if (confirm("약국 정보를 정말 삭제하시겠습니까?")) {
            return;
        } else {
            return false;
        }


    }

    //-->
</script>