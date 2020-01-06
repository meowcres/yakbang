<?
include_once "../_core/_init.php";

$_sql = "SELECT * FROM {$EDU_SCHEDULE_TB} WHERE edu_code in ('{$_GET["idx"]}') order by schedule_title";
$_res = $db->exec_sql($_sql);

$_msg = "" ;

while($_row=$db->sql_fetch_array($_res))
{
	$_msg = $_msg.$_row["idx"].":[".$_row["idx"]."] ".stripslashes($_row["schedule_title"])."||" ;
}

echo $_msg ;
?>