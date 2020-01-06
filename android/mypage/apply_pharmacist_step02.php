<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

?>
<!-- content start -->
<div class="coNtent">
    <div class="position_wrap">
        <span>My Page</span>
        <span>약사신청</span>
    </div>

    <div class="inner_coNtbtnwrap">
        <div class="fixedbodycoNt">
            <div class="pspSend_wrap">

                <p class="middleTxx">약사정보입력</p>


                <form id="frm" name="frm" method="POST" style="height:100%;" enctype="multipart/form-data" action="../_action/mypage.do.php" style="display:inline;" target="actionForm">
                    <input type="hidden" id="Mode" name="Mode" value="apply_pharmacist_add">
                    <input type="hidden" id="idx" name="idx" value="<?= $mm_row["IDX"] ?>">
                    <input type="hidden" id="user_id" name="user_id" value="<?= $mm_row["USER_ID"] ?>">
                    <input type="hidden" id="pharmacist_request" name="pharmacist_request" value="yes">

                    <table class="psptbl" >
                        <caption>약사자격정보</caption>
                        <colgroup>
                            <col width="32%">
                            <col width="68%">
                        </colgroup>

                        <tbody>
                            <tr>
                                <th scope="row">약사번호</th>
                                <td><input type="text" id="license_number" name="license_number"></td>
                            </tr>                           
                        </tbody>
                    </table><br><br>

                    <div>약사 자격증은 이메일로 보내주시기 바랍니다.</div>
                </form>
            </div>
        </div>

        <!-- overflow scroll -->
    </div>
    <!-- in content -->
    <div class="coNtBtn">
        <div class="coNtbtn_wrap">
            <a href="javascript:void(0);" onclick="chk_form();" class="ecolor"><span class="btnicon04">약사 신청</span></a>      
        </div>
    </div>
</div>
<!-- content end -->


<script language="JavaScript" type="text/JavaScript">
$("#photoBtn").click(function(){
    $("input[name='license_paper']").click();
});


function chk_form() {

    if ($("#license_number").val() == "") {
        alert("약사 자격 번호를 입력 해 주십시오");
        $("#license_number").val('');
        $("#license_number").focus();
        return false;
    }

    var idx = $('#idx').val();
    var user_id = $('#user_id').val();
    var pharmacist_request = $('#pharmacist_request').val();
    var license_number = $('#license_number').val();

    var _frm = new FormData();

    _frm.append("Mode", "apply_pharmacist_add");
    _frm.append("idx", idx);
    _frm.append("user_id", user_id);
    _frm.append("pharmacist_request", pharmacist_request);
    _frm.append("license_number", license_number);

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
                    alert("약사 신청 접수가 완료되었습니다.");
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

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>