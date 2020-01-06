<?php
include_once "../_core/_init.php";
include_once "../_core/_common/var.admin.php";
include_once "./inc/admin_auth.php";
include_once "./inc/admin_top.php";
include_once "./inc/admin_header.php";
include_once "./inc/admin_gnb.php";
include_once "./inc/admin_lnb.php";
include_once "./_controller/".$_slot.".".$_type.".php";

if (is_file("./".$_slot."/".$_type.".php")) {
    include_once "./".$_slot."/".$_type.".php" ;
} else {
    alert_js("move","'비' 정상적인 접속입니다!!!","./admin.login.php");
}

include_once "./inc/admin_bottom.php";