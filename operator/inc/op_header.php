<div id="header">
    <div class="header">

        <div class="lnb">
            <a style="background:#10968c;"><?= $_op["OP_NAME"] ?>님 &nbsp(기간 : <?= $_op["S_DATE"] ?> ~ <?= $_op["E_DATE"] ?> )</a>
            <a href="./_action/login.do.php?Mode=logout">LOGOUT</a>
        </div>
    </div>


    <div id="gnb">
        <ul>
            <?
            foreach (${"_opMenu" . $_op["grade"]} as $key => $val) {
                if ($_slot == $key) {
                    ?>
                    <li><span class="on"><?= $val[0] ?></span></li><?
                } else {
                    ?>
                    <li><a href="<?= $val[1] ?>"><?= $val[0] ?></a></li><?
                }
            }
            reset($_opMenu);
            ?>
        </ul>
    </div>

</div><!-- header e -->



<div id="container">
    <div id="contents">
        <div id="snb">
            <?php
            switch ($_slot) {

                case("pharmacy"):
                    ?>
                    <div>
                        <h2>DASHBOARD</h2>
                        <ul>
                            <li>
                                <a href="./op.template.php?slot=dashboard&type=dashboard_list"<?php if ($_type == "dashboard_list"){ ?>class="on"<?php } ?>>DASHBOARD</a>
                            </li>
                        </ul>
                    </div>
                    <?php
                    break;


                case("prescription"):
                    ?>
                    <div>
                        <h2>처방전 리스트</h2>
                        <ul>
                            <li>
                                <a href="./op.template.php?slot=prescription&type=prescription_list"<?php if ($_type == "prescription_list"){ ?>class="on"<?php } ?>>처방전 리스트</a>
                            </li>
                            <li>
                                <a href="./op.template.php?slot=prescription&type=prescription_list_own"<?php if ($_type == "prescription_register"){ ?>class="on"<?php } ?>>내 처방전 목록</a>
                            </li>
                        </ul>
                    </div>
                    <?php
                    break;


                case("member"):
                    ?>

                    <!--
                    <div>
                        <h2>내 정보관리</h2>
                        <ul>
                            <li><a href="./op.template.php?slot=member&type=member_detail&step=information"<?php if ($_type == "member_detail"){ ?>class="on"<?php } ?>>내 정보관리</a></li>
                            <li><a href="./op.template.php?slot=member&type=member_detail_pass" <?php if ($_type == "member_detail_pass"){ ?>class="on"<?php } ?>>비밀번호 수정</a></li>
                        </ul>
                    </div>
                    -->
                    <?php
                    break;

            }
            ?>
        </div><!-- snb e -->

