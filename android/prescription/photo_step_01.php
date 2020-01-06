<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

$a_qry = "SELECT A_CONTENTS FROM {$TB_STIPULATION} WHERE A_TYPE = '1' AND IDX = '8'";
$a_res = $db->exec_sql($a_qry);
while($a_row = $db->sql_fetch_row($a_res)){
    $a_content = nl2br(clear_escape($a_row[0]));
}

$qry_cnt = "SELECT PUBLICATION_COUNT FROM {$TB_PS_CNT} ";
$res_cnt = $db->exec_sql($qry_cnt);
$row_cnt = $db->sql_fetch_row($res_cnt);

$ps_code = "P".STR_PAD($row_cnt[0],6,'0',STR_PAD_LEFT)."-".date("ymdHis");

$up_cnt  = "UPDATE {$TB_PS_CNT} SET PUBLICATION_COUNT=PUBLICATION_COUNT+1 ";
@$db->exec_sql($up_cnt);
?>
<!-- content start -->
<div class="coNtent">
    <form id="frm" name="frm" method="POST" style="height:100%;">
        <input type="hidden" id="chk_agree" name="chk_agree" value="y">
        <input type="hidden" id="ps_code" name="ps_code" value="<?= $ps_code ?>">
        <input type="hidden" id="user_id" name="user_id" value="<?= $_COOKIE["cookie_user_id"] ?>">

        <div class="position_wrap">
            <span>스마트 처방조제</span>
            <span>처방전 전송동의</span>
        </div>
        <div class="inner_coNtbtnwrap">
            <div class="fixedbodycoNt">
				<div class="iNfotxx">
				<?= $a_content ?>
				</div>
            </div>
        </div>
        <?php
        if (isNull($_COOKIE["cookie_user_id"])) {
            ?>
            <div class="coNtBtn">
                <div id="noMemberBtn" class="coNtbtn_wrap">
                    <a href="javascript:void(0);" class="ecolor"><span class="btnicon02">동의하고 사진촬영</span></a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="coNtBtn">
                <div id="photoBtn" class="coNtbtn_wrap">
                    <a href="javascript:void(0);" class="ecolor"><span class="btnicon02">동의하고 사진촬영</span></a>
                </div>
            </div>
            <?php
        }
        ?>
        <input type="file" id="preScriptionFile" name="preScriptionFile" capture="camera" style="display:none;">
    </form>
</div>
<!-- content end -->

<script>
    $("#noMemberBtn").click(function(){
        alert("로그인 후 이용하실 수 있습니다");
        location.href='../member/login.php';
        return false;
    });

    $("#photoBtn").click(function(){
        $("input[name='preScriptionFile']").click();
    });

    $("#preScriptionFile").change(function(){

        var $image_file = $("input[name=preScriptionFile]");
        var _file = $image_file[0].files[0];
        
        if(_file !== null) {
            
            var _frm = new FormData();
            _frm.append("Mode","update_prescription_file");
            _frm.append("ps_code", $("#ps_code").val());
            _frm.append("user_id", $("#user_id").val());
            _frm.append("send_type", "1");
            _frm.append("image_file", _file);

            //alert($image_file[0].files[0].name);
            
            $.ajax({
                method: 'POST',
                url: '../_action/prescription.do.php',
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    //alert(_res);
                    //console.log(_res);
                    switch (_res) {
                        case "100" :
                            $("#frm").attr("action","photo_step_02.php");
                            $("#frm").submit();
                            break;

                        case "200" :
                            alert("처방전에 오류가 있습니다");
                            break;

                        case "300" :
                            alert("처방전 작성에 문제가 발생하였습니다");
                            break;

                        case "900" :
                            alert("Error");
                            break;
                    }
                }
            });

        } else {

            alert("이미지가 없습니다");

        }

    });
</script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>