<div id="header">
    <div class="header">
        <h1>
            <a href="./pharmacy.template.php?slot=main&type=default"><strong><?= $_pharmacy["name"] ?></strong></a><span></span>
        </h1>
		<div class="headselect">
			<?php
			$qry_001 = " SELECT t1.*, t2.PHARMACY_NAME, t3.USER_SEX ";
			$qry_001 .= " FROM {$TB_PP} t1 ";
			$qry_001 .= " LEFT JOIN {$TB_PHARMACY} t2 ON (t1.PHARMACY_CODE = t2.PHARMACY_CODE) ";
			$qry_001 .= " WHERE USER_ID = HEX(AES_ENCRYPT('" . $_SESSION["pharmacy"]["id"] . "','" . SECRET_KEY . "')) ";
			$qry_001 .= " ORDER BY t1.P_GRADE DESC, t2.PHARMACY_NAME ";
			?>
			<select name="pharmacy_select" id="pharmacy_select" onchange="go_main(this.value, '<?= $_SESSION["pharmacy"]["id"] ?>' )">
				<option value="">소속 약국 선택</option>
				<?php
				$res_001 = $db->exec_sql($qry_001);
				while ($row_001 = $db->sql_fetch_array($res_001)) {
					$grade = $row_001["P_GRADE"] == 1 ? "협동약사" : "메인약사";
                    $sex = $row_001["USER_SEX"];
					?>
					<!--<option value="../pharmacy.template.php?slot=main&type=dashboard.php?p_code=<?/*= $row_001["PHARMACY_CODE"] */ ?>">-->
					<option value="<?= $row_001["PHARMACY_CODE"] ?>" <?= $row_001["PHARMACY_CODE"] == $_pmyKey["code"] ? "selected" : "" ?> >
						<?= $row_001["PHARMACY_NAME"] ?> ( <?= $grade ?> )
					</option>
					<?
				}
				?>
			</select>
		</div>
        <div class="lnb">
            <?php
            if ($_pharmacist["grade"] == "2") {
                ?>
                <a href="./pharmacy.template.php?slot=member&type=update" style="background:#1985f2;">메인약사</a>
                <?
            } else {
                ?>
                <a href="./pharmacy.template.php?slot=member&type=update" style="background:#10968c;">협동약사</a>
                <?
            }
            ?>
            <a href="./_action/login.do.php?Mode=logout">LOGOUT</a>
        </div>
    </div>

    <div id="gnb">
        <ul>
            <?
            foreach (${"_pharmacyMenu" . $_pharmacist["grade"]} as $key => $val) {
                if ($_slot == $key) {
                    ?>
                    <li><span class="on"><?= $val[0] ?></span></li><?
                } else {
                    ?>
                    <li><a href="<?= $val[1] ?>"><?= $val[0] ?></a></li><?
                }
            }
            reset($_pharmacyMenu);
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
                        <h2>약국관리</h2>
                        <ul>
                            <li><a href="./pharmacy.template.php?slot=pharmacy&type=information"
                                   <?php if ($_type == "information"){ ?>class="on"<?php } ?>>약국정보</a></li>
                            <li><a href="./pharmacy.template.php?slot=pharmacy&type=update"
                                   <?php if ($_type == "update"){ ?>class="on"<?php } ?>>약국정보수정</a></li>
                        </ul>
                    </div>
                    <?php
                    break;


                case("pharmacist"):
                    ?>
                    <div>
                        <h2>약사관리</h2>
                        <ul>
                            <li><a href="./pharmacy.template.php?slot=pharmacist&type=pharmacist_list"
                                   <?php if ($_type == "pharmacist_list"){ ?>class="on"<?php } ?>>약사목록</a></li>
                            <li><a href="./pharmacy.template.php?slot=pharmacist&type=pharmacist_apply_list"
                                   <?php if ($_type == "pharmacist_apply_list"){ ?>class="on"<?php } ?>>약사등록신청</a></li>
                        </ul>
                    </div>
                    <?php
                    break;


                case("prescription"):
                    ?>
                    <div>
                        <h2>처방전관리</h2>
                        <ul>
                            <li><a href="./pharmacy.template.php?slot=prescription&type=prescription_list"
                                   <?php if ($_type == "prescription_list"){ ?>class="on"<?php } ?>>처방전목록</a></li>
                            <!--li><a href="./admin.member.php?slot=member&type=agreement&step=1"
                                   <?php if ($_type == "agreement" && $_step == "1"){ ?>class="on"<?php } ?>>처방약제통계</a>
                            </li-->
                        </ul>
                    </div>
                    <?php
                    break;


                case("calculate"):
                    ?>
                    <div>
                        <h2>정산관리</h2>
                        <ul>
                            <li><a href="./pharmacy.template.php?slot=calculate&type=calculate_list" <?php if ($_type == "calculate_list"){ ?>class="on"<?php } ?>>정산현황</a></li>     
                            <li><a href="./pharmacy.template.php?slot=calculate&type=application_list" <?php if ($_type == "application_list"){ ?>class="on"<?php } ?>>정산현황</a></li>     
                            <!--li><a href="./admin.application.php?slot=application&type=application_list" <?php if ($_type == "application_list" || $_type == "application_core"){ ?>class="on"<?php } ?>>정산요청</a></li-->
                        </ul>
                    </div>
                    <?php
                    break;


                case("counsel"):
                    ?>
                    <div>
                        <h2>상담관리</h2>
                        <ul>
                            <li><a href="./pharmacy.template.php?slot=counsel&type=counsel_list"
                                   <?php if ($_type == "counsel_list"|| $_type == "counsel_detail" ){ ?>class="on"<?php } ?>>상담목록</a></li>
                        </ul>
                    </div>
                    <?php
                    break;


                case("dm"):
                    ?>
                    <div>
                        <h2>쪽지관리</h2>
                        <ul>
                            <li><a href="./pharmacy.template.php?slot=dm&type=mentee_list"
                                   <?php if ($_type == "mentee_list" || $_type == "dm_detail"){ ?>class="on"<?php } ?>>멘티목록</a>
                            </li>
                            <li><a href="./pharmacy.template.php?slot=dm&type=receive_dm_list"
                                   <?php if ($_type == "receive_dm_list"){ ?>class="on"<?php } ?>>받은쪽지함</a>
                            </li>
                            <li><a href="./pharmacy.template.php?slot=dm&type=send_dm_list"
                                   <?php if ($_type == "send_dm_list"){ ?>class="on"<?php } ?>>보낸쪽지함</a>
                            </li>
                        </ul>
                    </div>
                    <?php
                    break;


                case("member"):
                    ?>
                    <div>
                        <h2>내 정보관리</h2>
                        <ul>
                            <li><a href="./pharmacy.template.php?slot=member&type=pharmacist_detail&step=information"
                                   <?php if ($_type == "pharmacist_detail"){ ?>class="on"<?php } ?>>내 정보관리</a></li>
                            <li><a href="./pharmacy.template.php?slot=member&type=pharmacist_detail&step=pass"
                                   <?php if ($_type == "popup_register"){ ?>class="on"<?php } ?>>비밀번호 수정</a></li>
                        </ul>
                    </div>
                    <?php
                    break;

            }
            ?>
        </div><!-- snb e -->

        <script>
            function go_main(p_code, user_id) {
                if (p_code !== "") {
                    location.href = "./_action/login.do.php?Mode=go_main&p_code=" + p_code + "&user+id=" + user_id;
                }
            }
        </script>