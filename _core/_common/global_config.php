<?php
/* 사이트 전역변수 */
$_SITE = array();
$sql_001 = "SELECT * FROM {$TB_CONFIG}";
$res_001 = $db->exec_sql($sql_001);
$row_001 = $db->sql_fetch_array($res_001);

$_SITE["id"] = $row_001["SITE_ID"];
$_SITE["title"] = clear_escape($row_001["SITE_TITLE"]);
$_SITE["type"] = clear_escape($row_001["SITE_TYPE"]);
$_SITE["image"] = $row_001["SITE_IMAGE"];
$_SITE["icon"] = $row_001["SITE_ICON"];
$_SITE["url"] = $row_001["SITE_URL"];
$_SITE["keywords"] = $row_001["SITE_KEYWORDS"];
$_SITE["description"] = clear_escape($row_001["SITE_DESCRIPTION"]);
$_SITE["site_up_name"] = clear_escape($row_001["SITE_UP_NAME"]);
$_SITE["site_down_name"] = clear_escape($row_001["SITE_DOWN_NAME"]);
$_SITE["business_number"] = clear_escape($row_001["BUSINESS_NUMBER"]);
$_SITE["sale_number"] = clear_escape($row_001["SALE_NUMBER"]);
$_SITE["owner"] = clear_escape($row_001["SITE_OWNER"]);
$_SITE["charge"] = clear_escape($row_001["SITE_CHARGE"]);
$_SITE["email"] = clear_escape($row_001["SITE_EMAIL"]);
$_SITE["address"] = clear_escape($row_001["SITE_ADDRESS"]);
$_SITE["copyright"] = clear_escape($row_001["SITE_COPYRIGHT"]);
$_SITE["phone"] = clear_escape($row_001["SITE_PHONE"]);
$_SITE["fax"] = clear_escape($row_001["SITE_FAX"]);
$_SITE["give_type"] = $row_001["GIVE_TYPE"];
$_SITE["point"] = $row_001["SITE_POINT"];
$_SITE["percent"] = $row_001["SITE_PERCENT"];
$_SITE["use_cookie"] = $row_001["USE_COOKIE"];

/* 사이트 맴버변수 */
$_MEMBER = array();
if (!isNull($_SESSION["s_idx"])) {
    /*
    $sql_002  = "SELECT t1.* ";
    $sql_002 .= "FROM {$TB_MEMBER} t1 ";
    $sql_002 .= "WHERE t1.idx = '{$_SESSION["s_idx"]}' ";

    $res_002     = $db->exec_sql($sql_002) ;
    $_MEMBER  = $db->sql_fetch_array($res_002);
    */
}

unset($sql_001);
unset($res_001);
unset($row_001);

unset($sql_002);
unset($res_002);

/* _referer 값 */
$_getUrl = urlencode($_SERVER['REQUEST_URI']);