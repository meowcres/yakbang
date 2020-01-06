<div class="footer">
    <nav class="fotlink">
        <?php
        if (isNull($_SESSION["member"]["id"])) {
            ?>
            <a href="../member/login_form.html">MEMBER</a>
            <?
        } else {
            ?>
            <!--<a href="../_action/login.do.php?mode=logout" target="actionForm">LOGOUT</a>-->
            <a href="../mypage/user_information.html">MYPAGE</a>
            <?
        }
        ?>
        <!--<a href="../member/login_form.html">MEMBER</a>-->
        <a href="show_info00" class="showLayer">개인정보취급정보</a>
        <a href="show_info01" class="showLayer">이용약관</a>
        <a href="show_info02" class="showLayer">위치기반서비스</a>
        <a href="../community/faq.html">FAQ</a>
    </nav>
    <div class="addresswrap">
        <div class="section_wrap pcfooter">
            <address>
                (주)이팜헬스케어&nbsp&nbsp|&nbsp&nbsp대표 : 이복기&nbsp&nbsp|&nbsp&nbsp주소 : 서울특별시 강남구<br>
                사업자등록번호 : 110-11-111111&nbsp&nbsp|&nbsp&nbsp통신판매업신고 : 서울강남-0034&nbsp&nbsp|&nbsp&nbsp<a
                        href="">사업자정보확인</a><br>
                E-mail : ceo@eyacbang.co.kr<br>
                © 2019 이팜헬스케어 Co., Ltd. All rights reserved.
            </address>
            <div class="googapp">
                <a href=""><img src="../images/googleicon.png" alt="Google Play icon"></a>
                <a href=""><img src="../images/appicon.png" alt="Google Play icon"></a>
            </div>
        </div>
        <div class="section_wrap mfooter">
            <address>
                (주)이팜헬스케어&nbsp&nbsp|&nbsp&nbsp대표 : 이복기&nbsp&nbsp|&nbsp&nbsp주소 : 서울특별시 강남구<br>
                사업자등록번호 : 110-11-111111&nbsp&nbsp|&nbsp&nbsp통신판매업신고 : 서울강남-0034&nbsp&nbsp<br><a href="">사업자정보확인</a><br>
                E-mail : ceo@eyacbang.co.kr<br>
                © 2019 이팜헬스케어 Co., Ltd. All rights reserved.
            </address>
            <div class="googapp">
                <a href=""><img src="../images/googleicon.png" alt="Google Play icon"></a>
                <a href=""><img src="../images/appicon.png" alt="Google Play icon"></a>
            </div>
        </div>
    </div>
</div>