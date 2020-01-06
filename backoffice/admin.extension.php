<?php
if (md5($_GET["_iraeKey_"]) == "7e7e5dfa2820f88112ae26a2e4c7cdf4") {
    include_once "../_core/_init.php" ;
    include_once "../_core/_common/var.admin.php" ;
    include_once "./inc/admin_top.php" ;
    include_once "./inc/admin_header.php" ;
    include_once "./inc/admin_gnb.php" ;
    include_once "./inc/admin_lnb_extension.php" ;
    include_once "./_extension/controller.".$_type.".php";
    include_once "./_extension/".$_type.".php" ;
    include_once "./inc/admin_bottom.php";
}