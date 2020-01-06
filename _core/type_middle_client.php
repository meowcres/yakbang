<?
include_once "../_core/_init.php";

$_sql = "SELECT * FROM {$M_TYPE_TB} WHERE large_idx in ('{$_POST["large_idx"]}') and type_status='y' order by line_up, idx";
$_res = $db->exec_sql($_sql);

echo '<select name="middle_idx" id="middle_idx" style="position:relative;float:left;display:inline-block;margin-right:5px;width:150px;height:26px;border:1px solid #ccc;color:#333;">
		<option value=""> ::: 중분류 선택 :::</option>';

while($_row=$db->sql_fetch_array($_res))
{
	echo '<option value="'.$_row['idx']."\">"; 
	echo $_row["middle_name"];
	echo '</option>';
}

echo '</select>';
?>