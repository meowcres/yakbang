<?php
include_once "../../_core/_init.php";
include_once "../../_core/_lib/class.attach.php";
include_once "../../_core/_common/var.opator.php";


$_res = "" ;

$f_qry  = " SELECT t1.PS_CODE, t1.PS_STATUS, t1.REG_DATE, IFNULL(t2.PRE_STATUS,1) as preStatus ";
$f_qry .= " FROM {$TB_PS} t1   ";
$f_qry .= " LEFT JOIN {$TB_PS_PRECLEANING} t2 ON (t1.PS_CODE = t2.PS_CODE)  ";
$f_qry .= " LEFT JOIN {$TB_PS_IMAGE} t3 ON (t1.PS_CODE = t3.PS_CODE)  ";
$f_qry .= " WHERE t1.PS_STATUS = 1 AND t1.SEND_TYPE = 1 ";
$f_qry .= " ORDER BY t1.REG_DATE desc";

$f_res = $db->exec_sql($f_qry);
while ($f_row = $db->sql_fetch_array($f_res)) {

  if ($f_row["preStatus"] == 1 || $f_row["preStatus"] == 4) {

    $_res .= "<li>".$pre_status_array[$f_row["preStatus"]] ;
    
    if ($f_row["PS_CODE"] > 1) {
      $_res .= " / 김말동";
    }

    $_res .= "<br>";
    $_res .= "<b>".$f_row["PS_CODE"]."</b><br>";
    $_res .= $f_row["REG_DATE"];
    $_res .= "</li>";

  }

}

echo $_res;

$db->db_close();