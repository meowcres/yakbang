
<div><b>○ 회원삭제</b></div>
<form id="frm" name="frm" method="post" action="./_action/member.do.php" onSubmit="return chk_delForm();" style="display:inline;" target="actionForm">
    <input type="hidden" name="Mode" value="member_del">
    <input type="hidden" name="user_id" value="<?=$m_main["USER_ID"]?>">

    <input type="hidden" id="page"           name="page"           value="<?=$page?>">
    <input type="hidden" id="search_sex"     name="search_sex"     value="<?=$search["sex"]?>">
    <input type="hidden" id="keyfield"       name="keyfield"       value="<?=$search["keyfield"]?>">
    <input type="hidden" id="keyword"        name="keyword"        value="<?=$search["keyword"]?>">

    <table>
        <colgroup>
            <col style="width:15%" />
            <col style="width:*" />
        </colgroup>
        <tbody>
        <tr>
            <td colspan="2" style="padding:20px;">
                ○ 삭제시에는 회원에 관련된 모든 정보가 삭제 됩니다. ( 회원정보, 처방내역 등등 )
            </td>
        </tr>
        <tr>
            <th>관리자 비밀번호 확인</th>
            <td>
                <input type="password" id="mm_pass" name="mm_pass" value="" class="w120" />
            </td>
        </tr>
        </tbody>
    </table>


    <div class="w100p mt10 center">
        <input type="submit" value="회원 정보 삭제" class="Big_Button btnRed">
    </div>
</form>


<script language='Javascrip' type='text/javascript'>
    <!--

    function chk_delForm(){

        var mm_pass = $("#mm_pass").val();

        if(mm_pass == ""){
            alert("비밀번호를 입력 해 주십시오");
            $("#mm_pass").val('');
            $("#mm_pass").focus();
            return false;
        }

        if (confirm("회원 정보를 정말 삭제하시겠습니까?"))
        {
            return ;
        } else {
            return false;
        }



    }

    //-->
</script>