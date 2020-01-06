<?
$_slot = "";
$_page = "";

############### 페이지 정보 ####################
$_slot = isNull($_REQUEST["slot"]) ? $_clean["slot"] : $_REQUEST["slot"] ;
$_step = isNull($_REQUEST["step"]) ? $_clean["step"] : $_REQUEST["step"] ;
$_page = isNull($_REQUEST["page"]) ? $_clean["page"] : $_REQUEST["page"] ;

$_slot = isNull($_slot) ? "main" : $_slot ;
$_step = isNull($_step) ? "list" : $_step ;
?>