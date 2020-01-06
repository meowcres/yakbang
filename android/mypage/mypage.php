<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";
?>
<?php
if ($mm_type == 1) {
    ?>
    <div class="coNtent2">
        <div class="mybtnWrap">
            <h2>마이페이지</h2>
            <ul class="inwrap">
                <li><a href="./update.php" class="img1">정보수정</a></li>
                <li><a href="./pass.php" class="img2">비밀번호수정</a></li>
                <li><a href="./mentor_list.php" class="img3">멘토리스트</a></li>
                <!--<li><a href="./dm.php" class="img4">쪽지</a></li>-->
                <li><a href="./apply_pharmacist_step01.php" class="img4">약사신청</a></li>
                <li><a href="../_logout.php" class="img6">로그아웃</a></li>
                <li><a href="./del.php" class="img5">회원탈퇴</a></li>
            </ul>
        </div>
        <!-- content end -->
    </div>
    <?
} else if ($mm_type == 2) {
    ?>
    <div class="coNtent2">
        <div class="mybtnWrap">
            <h2>마이페이지</h2>
            <ul class="inwrap">
                <li><a href="./update.php" class="img1">정보수정</a></li>
                <li><a href="./pass.php" class="img2">비밀번호수정</a></li>
                <li><a href="./mentee_list.php" class="img3">멘티리스트</a></li>
                <!--<li><a href="./dm.php" class="img4">쪽지</a></li>-->
                <li><a href="../member/apply_pharmacy.php" class="img4">약국신청</a></li>
                <li><a href="../_logout.php" class="img6">로그아웃</a></li>
                <li><a href="./del.php" class="img5">회원탈퇴</a></li>
            </>
        </div>
        <!-- content end -->
    </div>
    <?
}
?>
<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>