<?php
include_once "../_core/_init.php";
include_once "../_core/_common/var.pharmacy.php";
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=1280 user-scalable=yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title><?= $_SITE["site_up_name"] ?> PHARMACY</title>
    <link type="image/x-icon" rel="shortcut icon" href="./img/favicon.ico">
    <link type="image/x-icon" rel="icon" href="./img/favicon.ico">

    <link rel="stylesheet" type="text/css" href="./css/login.css?ver=1"/>

    <script language="javascript" type="text/javascript" src="./js/jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="./js/js_common.js"></script>

    <!--[if lt IE 9]>
    <script src="js/jquery_html5shiv.js"></script>
    <![endif]-->
</head>

<div class="pharmacist_wrap">
    <form id="loginform" name="loginform" method="post" action="./_action/login.do.php" onSubmit="return chkForm()"
          target="actionForm">

        <div class="pharmform">
            <div class="pharmBck">
                <div class="inpharmboxA">
                    <?php
                    // 로그인 하지 않았을때
                    if (isNull($_SESSION["pharmacy"]["id"])) {
                        ?>
                        <input type="hidden" name="Mode" id="Mode" value="login">
                        <div class="logoimg"><img src="./img/logo.jpg"></div>

                        <span>
					<label for="pharmacist_id">전문약사 ID</label>
					<input type="text" name="pharmacist_id" id="pharmacist_id">
				</span>

                        <span>
					<label for="pharmacist_pass">전문약사 PASSWORD</label>
					<input type="password" name="pharmacist_pass" id="pharmacist_pass">
				</span>

                        <input type="submit" value="LOGIN" class="login_Btn">
                        <p class="chkbx">
                            <input type="checkbox" id="infoRemember" name=""><label for="infoRemember">정보 기억하기</label>
                        </p>
                        <div class="verTxx">ver.2.0.2</div>
                        <?php
                    } else {
                        $qry_001 = " SELECT t1.*, t2.PHARMACY_NAME ";
                        $qry_001 .= " FROM {$TB_PP} t1 ";
                        $qry_001 .= " LEFT JOIN {$TB_PHARMACY} t2 ON (t1.PHARMACY_CODE = t2.PHARMACY_CODE) ";
                        $qry_001 .= " WHERE USER_ID = HEX(AES_ENCRYPT('" . $_SESSION["pharmacy"]["id"] . "','" . SECRET_KEY . "')) ";
                        $qry_001 .= " ORDER BY t1.P_GRADE DESC, t2.PHARMACY_NAME ";

                        $qry_002 = " SELECT LAST_LOGIN ";
                        $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                        $qry_002 .= " FROM {$TB_MEMBER} ";
                        $qry_002 .= " WHERE USER_ID = HEX(AES_ENCRYPT('" . $_SESSION["pharmacy"]["id"] . "','" . SECRET_KEY . "')) ";

                        $res_002 = $db->exec_sql($qry_002);
                        $row_002 = $db->sql_fetch_array($res_002);

                        ?>
                        <input type="hidden" name="Mode" value="logout">
                        <div class="logoimg"><img src="./img/logo.jpg"></div>

                        <div class="inphartxx">
                            <em>안녕하세요 <?= $row_002["mm_name"] ?> 약사님</em><br/>
                            마지막 로그인 날짜 . <?= $row_002["LAST_LOGIN"] ?>
                        </div>

                        <div class="inpharselect">
                            <!--<label for="pharmacy_id">소속 약국 선택</label>-->
                            <select name="pharmacy_select" id="pharmacy_select" onchange="go_main( this.value, '<?= $_SESSION["pharmacy"]["id"] ?>', '<?=$_slot?>' )">
                                <option value="">소속 약국 선택</option>
                                <?php
                                $res_001 = $db->exec_sql($qry_001);
                                while ($row_001 = $db->sql_fetch_array($res_001)) {
                                    $grade = $row_001["P_GRADE"] == 1 ? "협동약사" : "메인약사";
                                    ?>
                                    <option value="<?= $row_001["PHARMACY_CODE"] ?>">
                                        <?= $row_001["PHARMACY_NAME"] ?> ( <?= $grade ?> )
                                    </option>
                                    <?
                                }
                                ?>

                            </select>
                        </div>

                        <input type="submit" onclick="logout()" value="LOGOUT" class="login_Btn">
                        <div class="verTxx">ver.2.0.2</div>
                        <?php
                    }
                    ?>
                </div>
                <div class="inpharmboxB">
                    <img src="../_core/_files/ad/pharmacy_ad.png" height="420">
                </div>
            </div>
        </div>
    </form>
</div>
<iframe name="actionForm" width="0" height="0" frameborder="0" style="display:none;"></iframe>
</body>
</html>

<script type="text/javascript">
    function chkForm() {
        if ($("#Mode").val() == "login") {
            if (!$.trim($("#pharmacist_id").val())) {
                alert("약사 ID를 입력해 주세요.");
                $("#pharmacist_id").focus();
                return false;
            }

            if (!$.trim($("#pharmacist_pass").val())) {
                alert("약사 PASSWORD를 입력해 주세요.");
                $("#pharmacist_pass").focus();
                return false;
            }
        }
        return true;
    }

    function attempt_focus() {
        setTimeout(
            function () {
                try {
                    d = document.getElementById('pharmacist_id');
                    d.focus();
                    d.select();
                } catch (e) {
                }
            }, 200);
    }

    attempt_focus();

    if (typeof Onload == 'function') {
        Onload();
    }

    function go_main(p_code, user_id, slot) {
        if (p_code !== "") {
            location.href = "./_action/login.do.php?Mode=go_main&p_code=" + p_code + "&user+id=" + user_id + "&slot=" + slot;
        }
    }

</script>

<!--<script>
    function logout() {
        location.href = "./_action/login.do.php?Mode=logout;
    }
</script>-->