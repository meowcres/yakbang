<?
include_once "../inc/in_top.php" ;
include_once "../../_core/_init.php" ;

$_sql  = " SELECT *, t1.IDX AS idx, t1.REG_DATE AS date " ;
$_sql .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
$_sql .= " FROM {$TB_PUSH} t1 " ;
$_sql .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.USER_ID = t2.USER_ID ) ";
$_sql .= " WHERE t1.IDX = '".$_REQUEST["idx"]."' ";

$_res = $db->exec_sql($_sql);
$_row = $db->sql_fetch_array($_res);

?>
<link type="text/css" rel="stylesheet" href="../resources/css/iframe.css" >
<style>
    .searchBox{width:100%;border-collapse:collapse; border-spacing:0; border:1px solid #eaeaea; font-size:12px; line-height:24px; background:#fff;}
    .searchBox th{text-align:center;padding:6px 0; color:#000; border:1px solid #dddddd; background:#eeeeee; font-weight:700;}
    .searchBox td{padding:4px 15px; color:#5a5450; border:1px solid #dddddd; }
    .searchBox input, .searchBox select{padding:3px;}

    .custbtn{width:50px; height:26px; background-color:#B9BAAB; color:#fff;}
    .custbtn2{width:50px; height:26px; background-color:#E46575; color:#fff;}
    .custbtn3{width:60px; height:26px; background-color:#C6A0C9; color:#fff;}
</style>

<div id="Wrap">
    <div id="buyframeList_form1" style="padding:10px;">

        <h3 style="padding:0 0 12px 5px;">◎ 푸시 메시지</h3>
        <table id="groupTable" class="searchBox" cellspacing="0">
            <tr>
                <th>발송번호.<?=$_row["idx"]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?=$_row["mm_name"]?>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<?=$_row["date"]?></th>
            </tr>
            <tr>
                <td style="height:80px;"><?=nl2br(stripslashes($_row["P_MSG"]))?></td>
            </tr>
        </table>

    </div>
</div>

</body>
</html>