<?php
include_once "../_core/_init.php";
include_once "../_core/_common/var.pharmacy.php";
include_once "../_core/_lib/class.attach.php";
include_once "./inc/pharmacy_auth.php";
include_once "./inc/pharmacy_top.php";
include_once "./inc/pharmacy_header.php";

if (is_file("./".$_slot."/".$_type.".php")) {
    include_once "./".$_slot."/".$_type.".php" ;
} else {
    alert_js("move","'비' 정상적인 접속입니다!!!","./pharmacy.login.php");
}

include_once "./inc/pharmacy_bottom.php";