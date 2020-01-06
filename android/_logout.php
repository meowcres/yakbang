<?php
include_once "../../_core/_init.php";
setcookie('cookie_user_id', '', time()-(3600*24*365), "/");
// 쿠키명 testCookie 사용불가, 만료됨
header("Location:./main/main.php");