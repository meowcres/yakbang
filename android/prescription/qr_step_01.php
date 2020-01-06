<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";

$a_qry = "SELECT A_CONTENTS FROM {$TB_STIPULATION} WHERE A_TYPE = '1' AND IDX = '8'";
$a_res = $db->exec_sql($a_qry);
while($a_row = $db->sql_fetch_row($a_res)){
    $a_content = nl2br(clear_escape($a_row[0]));
}
?>
    <!-- content start -->
    <div class="coNtent">
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
        <div class="coNtBtn">
            <div class="coNtbtn_wrap">
                <a href="./qr_step_02.php" class="ecolor"><span class="btnicon03">동의하고 QR촬영</span></a>
            </div>
        </div>
    </div>
    <!-- content end -->

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>