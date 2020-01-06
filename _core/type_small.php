<?
include_once "../_core/_init.php";

$_sql = "SELECT * FROM {$S_TYPE_TB} WHERE middle_idx in ('{$_GET["middle_idx"]}') and type_status='y' order by line_up, idx";
$_res = $db->exec_sql($_sql);

$_msg = "" ;

while($_row=$db->sql_fetch_array($_res))
{
	$_msg = $_msg.$_row["idx"].":".$_row["small_name"]."||" ;
}

echo $_msg ;
?>