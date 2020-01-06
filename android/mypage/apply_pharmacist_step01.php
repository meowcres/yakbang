<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

$a_qry = "SELECT A_CONTENTS FROM {$TB_STIPULATION} WHERE A_TYPE = '2' AND IDX = '6'";
$a_res = $db->exec_sql($a_qry);
while($a_row = $db->sql_fetch_row($a_res)){
    $a_content = nl2br(clear_escape($a_row[0]));
}

?>




<?php
if ($mm_request == "yes") {
    ?>





    <script>
    $(document).ready(function(){
        alert("약사 신청이 이미 접수 되어있습니다");
        location.href='../member/login.php';
        return false;
    });
    </script>
    <?
} else if ($mm_request == "no") {
    ?>
    <!-- content start -->
    <div class="coNtent">
        <div class="position_wrap">
            <span>약사신청약관</span>
            <span>약사신청약관 동의</span>
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
                    <a href="javascript:void(0);" class="ecolor"><span>동의하고 약사 신청하기</span></a>
                </div>
            </div>
            <?php
        } else {
            ?>
            <div class="coNtBtn">
                <div id="applyBtn" class="coNtbtn_wrap">
                    <a href="./apply_pharmacist_step02.php" class="ecolor"><span>동의하고 약사 신청하기</span></a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <!-- content end -->
    <?
}
?>



<script>
$("#noMemberBtn").click(function(){
    alert("로그인 후 이용하실 수 있습니다");
    location.href='../member/login.php';
    return false;
});


</script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>