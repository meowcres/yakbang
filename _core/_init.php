<?
ob_start();
session_start();
header("Content-Type: text/html; charset=utf-8");

/* basic config set */
define("ROOT_DIR",   dirname(str_replace("\\", "/", __FILE__)));
define("LIB_DIR",    ROOT_DIR . "/_lib");
define("COMMON_DIR", ROOT_DIR . "/_common");
define("HTML_DIR",   ROOT_DIR . "/_html");
define("LOG_DIR",    ROOT_DIR . "/_log");
define("FILE_DIR",   ROOT_DIR . "/_files");
define("DATABASE",   "mysql");
define("SITE_KEY",   "EY");
define("SECRET_KEY", "edirqkd");

/* PHP config set */
ini_set("include_path", LIB_DIR.":".COMMON_DIR);

/* basic page */
require("var.common.php"); // 공통 변수
require("lib.common.php"); // 공통 함수
require("class.".DATABASE.".php");
require("class.paging.php");
require("class.paging_front.php");

/* database connection */
$db = new db() ;
$db->db_open() ;

/* 전체 페이지에서 사용되는 공통 정보 페이지 */
require("global_config.php");