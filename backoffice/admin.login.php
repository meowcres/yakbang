<?php
include_once "../_core/_init.php";
include_once "../_core/_common/var.admin.php";
include_once "./inc/admin_top.php";
?>
</head>
<body class="login_content">
<div>
<form id="loginform" name="loginform" method="post" action="./_action/login.do.php" onSubmit="return chkForm()" target="actionForm">
<input type="hidden" name="Mode" value="login">
<div class="login_wrapper">
    <div class="admin_logo"><img src="./img/logo.jpg"></div>
    <div class="admin_input">
        <p class="input_id">
            <label for="user_login">ADMIN ID<br /><input type="text" name="admin_id" id="admin_id" class="input Text Eng" value="" size="20" /></label>
        </p>
        <p class="input_pass">
            <label for="user_login">ADMIN PASSWORD<br /><input type="password" name="admin_pass" id="admin_pass" class="input" value="" size="20" /></label>
        </p>
        <p class="input_btn" style="margin-bottom:20px;margin-top:30px;">
            <input type="submit" class="btn_login" value="LOGIN">
            <p style="font-size:12px;"><a href="../web/main/" style="color:#000" target="_top">← GO e약방</a></p>
        </p>
    </div>
</div>
</form>
<?php
include_once "./inc/admin_bottom.php";
?>
<script type="text/javascript">
function chkForm() {
    if(!$.trim($("#admin_id").val())){
        alert("관리자 아이디를 입력해 주세요.");
        $("#admin_id").focus();
        return false;
    }
    
    if(!$.trim($("#admin_pass").val())){
        alert("관리자 비밀번호를 입력해 주세요.");
        $("#admin_pass").focus();
        return false;
    }

    return true;
}

function attempt_focus(){
    setTimeout( 
        function(){ 
            try{
                d = document.getElementById('admin_id');
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