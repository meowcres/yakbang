    <div class="footer">
        <nav>
            <?php
            // 약사 로그인 시 하단 바
            if ($mm_type == 2) {
                ?>
                <a href="../prescription/photo_step_01.php" class="fticon1">
                    <span class="icimg">
                        <img src="../images/common/footlink05.png" alt="스마트처방 아이콘">
                    </span>
                </a>
                <a href="../find/find_step1.php" class="fticon2">
                    <span class="icimg">
                        <img src="../images/common/footlink02.png" alt="찾기 아이콘">
                    </span>
                </a>
                <a href="../main/main.php" class="fticon3">
                    <span class="icimg">
                        <img src="../images/common/footlink01.png" alt="홈 아이콘">
                    </span>
                </a>
                <a href="../counsel/counsel_list.php" class="fticon4">
                    <span class="icimg">
                        <img src="../images/common/footlink03.png" alt="상담 아이콘">
                    </span>
                </a>
                <?
            } else {
                ?>
                <a href="../prescription/photo_step_01.php" class="fticon1">
                    <span class="icimg">
                        <img src="../images/common/footlink05.png" alt="스마트처방 아이콘">
                    </span>
                </a>
                <a href="../find/find_step1.php" class="fticon2">
                    <span class="icimg">
                        <img src="../images/common/footlink02.png" alt="찾기 아이콘">
                    </span>
                </a>
                <a href="../main/main.php" class="fticon3">
                    <span class="icimg">
                        <img src="../images/common/footlink01.png" alt="홈 아이콘">
                    </span>
                </a>
                <a href="../counsel/counsel_list.php" class="fticon4">
                    <span class="icimg">
                        <img src="../images/common/footlink03.png" alt="상담 아이콘">
                    </span>
                </a>
                <?
            }

            if ($_MEMBER["id"] == "") {
                ?>
                <a href="../member/login.php" class="fticon5">
                    <span class="icimg">
                        <img src="../images/common/footlink04.png" alt="마이페이지 아이콘">
                    </span>
                </a>
                <?
            } else {
                ?>
                <a href="../mypage/mypage_main.php" class="fticon5">
                    <span class="icimg">
                        <img src="../images/common/footlink04.png" alt="마이페이지 아이콘">
                    </span>
                </a>
                <?
            }
            ?>
        </nav>
    </div>
</div>

<?php
$agree_qry = "SELECT IDX, A_CONTENTS FROM {$TB_STIPULATION} WHERE A_TYPE = '1'";
$agree_res = $db->exec_sql($agree_qry);
while ($agree_row = $db->sql_fetch_row($agree_res)) {
    $agree_txt[$agree_row[0]] = nl2br(clear_escape($agree_row[1]));
}
?>
<div class="agreement_layer">

    <h2>서비스 약관<a href="" class="htop_prev preVBTn">이전페이지</a></h2>
    <ul class="dkTabMenu00 agreeMent">
        <li class="open"><a href="agreemEnt00" id="show_Fullslide00">서비스<br/>이용약관</a></li>
        <li><a href="agreemEnt01" id="show_Fullslide01">개인정보<br/>처리방침</a></li>
        <li><a href="agreemEnt02" id="show_Fullslide02">개인정보<br/>제3자 제공 동의</a></li>
        <li><a href="agreemEnt03" id="show_Fullslide03">개인정보 수집<br/>이용동의</a></li>
        <li><a href="agreemEnt04" id="show_Fullslide04">위치기반<br/>이용약관</a></li>
    </ul>
    <div class="showfield" id="agreemEnt00">
        <div class="scrollOver">
            <div class="agreeMenTwrap">
                <?= $agree_txt[1] ?>
            </div>
        </div>
    </div>

    <div class="showfield" id="agreemEnt01">
        <div class="scrollOver">
            <div class="agreeMenTwrap">
                <?= $agree_txt[2] ?>
            </div>
        </div>
    </div>

    <div class="showfield" id="agreemEnt02">
        <div class="scrollOver">
            <div class="agreeMenTwrap">
                <?= $agree_txt[3] ?>
            </div>
        </div>
    </div>

    <div class="showfield" id="agreemEnt03">
        <div class="scrollOver">
            <div class="agreeMenTwrap">
                <?= $agree_txt[4] ?>
            </div>
        </div>
    </div>

    <div class="showfield" id="agreemEnt04">
        <div class="scrollOver">
            <div class="agreeMenTwrap">
                <?= $agree_txt[5] ?>
            </div>
        </div>
    </div>

</div>

<?php
$qry_001 = "SELECT * FROM {$TB_PS_IMAGE} WHERE PS_CODE='{$ps_code}'";
$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);
?>
<div class="fslide">
    <div class="fslide_coNt">
        <img src="../../Web_Files/prescription/<?= $row_001["PHYSICAL_NAME"] ?>" style="width:100%; max-height:100%">
    </div>
    <a href="" class="closeBBtn">close</a>
</div>