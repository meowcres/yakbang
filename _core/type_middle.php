<?
include_once "../_core/_init.php";

$_sql = "SELECT * FROM {$M_TYPE_TB} WHERE large_idx in ('{$_GET["large_idx"]}') and type_status='y' order by line_up, idx";
$_res = $db->exec_sql($_sql);

$_msg = "" ;

while($_row=$db->sql_fetch_array($_res))
{
	$_msg = $_msg.$_row["idx"].":".$_row["middle_name"]."||" ;
}

echo $_msg ;
?>