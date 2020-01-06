<!-- header start -->
<div class="sub_header">
	<a href="javascript:history.back();" class="htop_prev">이전페이지</a>
	<img src="../images/common/elogo.png" alt="e약방 로고 이미지">
    <?php
    if(isNull($_COOKIE["cookie_user_id"])) {
        ?>
        <a href="../member/login.php" class="htop_icoN">
            <img src="../images/common/toplink.png" alt="e약방">
        </a>
        <?php
    }else{
        ?>
        <a href="../prescription/prescription_list.php" class="htop_icoN">
            <img src="../images/common/toplink.png" alt="e약방">
        </a>
        <?php
    }
    ?>
</div>
<!-- header end -->
<!-- container start -->
<div class="sub_container">