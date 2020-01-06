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
    <title><?=$_SITE["site_up_name"]?> PHARMACY</title>
    <link type="image/x-icon" rel="shortcut icon" href="./img/favicon.ico">
    <link type="image/x-icon" rel="icon"          href="./img/favicon.ico">

    <link rel="stylesheet" type="text/css" href="./css/login.css?ver=1" />

    <script language="javascript" type="text/javascript" src="./js/jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="./js/js_common.js"></script>

    <!--[if lt IE 9]>
    <script src="js/jquery_html5shiv.js"></script>
    <![endif]-->
</head>

<div class="pharmacist_wrap">
    <form id="loginform" name="loginform" method="post" action="./_action/login.do.php" onSubmit="return chkForm()" target="actionForm">
        <input type="hidden" name="Mode" value="login">
        <div class="pharmform">
            <div class="pharmBck">
                <div class="inpharmboxA">
                    <div class="logoimg"><img src="./img/logo.jpg"></div>

                    <div class="inphartxx">
						<em>안녕하세요 김대호 약사님</em><br />
			            마지막 로그인 날짜 . 2019. 08. 26
					</div>

                    <div class="inpharselect">
						<label for="pharmacy_id">소속 약국 선택</label>
						<select>
							<option value="">온누리 약국</option>
						</select>
					</div>

                    <!--
                    <span>
                        <label for="pharmacy_id">PHARMACY CODE</label>
                        <input type="text" name="pharmacy_code" id="pharmacy_code">
                    </span>
                    -->

                    <input type="submit" value="LOGOUT" class="login_Btn">
					<div class="verTxx">ver.1.121.1225</div>
                </div>
                <div class="inpharmboxB">
                    <img src="../_core/_files/ad/test_ad.png" height="420">
                </div>
            </div>
        </div>
    </form>
</div>
<iframe name="actionForm" width="1000" height="200" frameborder="0" style="display:block;"> </iframe>
</body>
</html>

<script type="text/javascript">
    function chkForm() {

        /*
        if(!$.trim($("#pharmacy_code").val())){
            alert("약국 CODE를 입력해 주세요.");
            $("#pharmacy_code").focus();
            return false;
        }
        */

        if(!$.trim($("#pharmacist_id").val())){
            alert("약사 ID를 입력해 주세요.");
            $("#pharmacist_id").focus();
            return false;
        }

        if(!$.trim($("#pharmacist_pass").val())){
            alert("약사 PASSWORD를 입력해 주세요.");
            $("#pharmacist_pass").focus();
            return false;
        }

        return true;
    }

    function attempt_focus(){
        setTimeout(
            function(){
                try{
                    d = document.getElementById('pharmacist_id');
                    d.focus();
                    d.select();
                } catch(e){}
            }, 200);
    }
    attempt_focus();

    if (typeof Onload=='function') {
        Onload();
    }
</script>