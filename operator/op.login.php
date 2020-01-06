<?php
include_once "../_core/_init.php";
include_once "../_core/_common/var.operator.php";
?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=1280 user-scalable=yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <title><?= $_SITE["site_up_name"] ?> OPERATOR</title>

    <link type="image/x-icon" rel="shortcut icon" href="./img/favicon.ico">
    <link type="image/x-icon" rel="icon" href="./img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="./css/login.css?ver=1"/>
    <script language="javascript" type="text/javascript" src="./js/jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="./js/js_common.js"></script>
</head>

<div class="pharmacist_wrap">
  <form id="loginform" name="loginform" method="post" action="./_action/login.do.php" onSubmit="return chkForm()" target="actionForm">
  <div class="pharmform">
    <div class="pharmBck">
      <div class="inpharmboxA">

        <input type="hidden" name="Mode" id="Mode" value="login">
        <div class="logoimg"><img src="./img/logo.jpg"></div>
        <span>
          <label for="pharmacist_id">처방전 기록원 아이디</label>
          <input type="text" name="op_id" id="op_id">
        </span>
        <span>
          <label for="pharmacist_pass">처방전 기록원 비밀번호</label>
          <input type="password" name="op_pass" id="op_pass">
        </span>
        <input type="submit" value="LOGIN" class="login_Btn">
        <p class="chkbx">
          <input type="checkbox" id="idSaveCheck" name=""><label for="idSaveCheck">정보 기억하기</label>
        </p>
        <div class="verTxx">ver.2.0.2</div>

      </div>
      <div class="inpharmboxB">
        <img src="../_core/_files/ad/operator_ad.png" height="420">
      </div>
    </div>
  </div>
  </form>
</div>

<iframe name="actionForm" width="0" height="0" frameborder="0" style="display:none;"></iframe>
</body>
</html>

<script type="text/javascript">

$(document).ready(function(){
    // 저장된 쿠키값을 가져와서 ID 칸에 넣어준다. 없으면 공백으로 들어감.
    var userInputId = getCookie("userInputId");
    $("#op_id").val(userInputId); 
     
    if($("#op_id").val() != ""){ // 그 전에 ID를 저장해서 처음 페이지 로딩 시, 입력 칸에 저장된 ID가 표시된 상태라면,
        $("#idSaveCheck").attr("checked", true); // ID 저장하기를 체크 상태로 두기.
    }
     
    $("#idSaveCheck").change(function(){ // 체크박스에 변화가 있다면,
        if($("#idSaveCheck").is(":checked")){ // ID 저장하기 체크했을 때,
            var userInputId = $("#op_id").val();
            setCookie("userInputId", userInputId, 7); // 7일 동안 쿠키 보관
        }else{ // ID 저장하기 체크 해제 시,
            deleteCookie("userInputId");
        }
    });
     
    // ID 저장하기를 체크한 상태에서 ID를 입력하는 경우, 이럴 때도 쿠키 저장.
    $("#op_id").keyup(function(){ // ID 입력 칸에 ID를 입력할 때,
        if($("#idSaveCheck").is(":checked")){ // ID 저장하기를 체크한 상태라면,
            var userInputId = $("#op_id").val();
            setCookie("userInputId", userInputId, 7); // 7일 동안 쿠키 보관
        }
    });
});
 
function setCookie(cookieName, value, exdays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
    document.cookie = cookieName + "=" + cookieValue;
}
 
function deleteCookie(cookieName){
    var expireDate = new Date();
    expireDate.setDate(expireDate.getDate() - 1);
    document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
}
 
function getCookie(cookieName) {
    cookieName = cookieName + '=';
    var cookieData = document.cookie;
    var start = cookieData.indexOf(cookieName);
    var cookieValue = '';
    if(start != -1){
        start += cookieName.length;
        var end = cookieData.indexOf(';', start);
        if(end == -1)end = cookieData.length;
        cookieValue = cookieData.substring(start, end);
    }
    return unescape(cookieValue);
}











function chkForm() {
    if ($("#Mode").val() == "login") {
        if (!$.trim($("#op_id").val())) {
            alert("오퍼 ID를 입력해 주세요.");
            $("#op_id").focus();
            return false;
        }

        if (!$.trim($("#op_pass").val())) {
            alert("오퍼 PASSWORD를 입력해 주세요.");
            $("#op_pass").focus();
            return false;
        }
    }
    return true;
}






</script>

