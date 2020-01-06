<script language="javascript">
$(document).ready(function(){
    $("input").focus(function(){
        $(this).addClass("Focusing");
    });

    $("input").blur(function(){
        var txtvalue = $(this).val();
        if (txtvalue == "") {
            $(this).removeClass("Focusing") ;
        }
    });
});
</script>
</head>

<body>
<div id="Wrap">
    <div id="Header">
        <img src="./img/top_logo.jpg" height="32">
        <div style="margin-top:5px;padding-right:10px">
            <b><?=$_admin["name"]?></b> 께서 로그인하셨습니다. <input type="button" value="로그아웃" onClick="actionForm.location.href='./_action/login.do.php?Mode=logout';" style="cursor:pointer;"/>
        </div>
    </div>