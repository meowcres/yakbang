<?
include_once "../../_core/_init.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/in_top.php";

$idx = $_GET["idx"];
$ps_code = $_GET["ps_code"];
$pharmacy_code = $_GET["pharmacy_code"];

$qry_002  = " SELECT t1.*, t2.PILL_NAME FROM {$TB_PS_PILL} AS t1 ";
$qry_002 .= " LEFT JOIN {$TB_PILL} AS t2 ON (t1.PP_TITLE = t2.PILL_CODE) ";
$qry_002 .= " WHERE t1.IDX = '{$idx}' ";

$res_002 = $db->exec_sql($qry_002);
$row_002 = $db->sql_fetch_array($res_002);
?>

    <div class="adm_table_style02">
        <h3 class="h3_title "><?= $pharmacy_name ?> 대체복약 등록</h3>
        <form id="sfrm" name="sfrm" method="POST" action="../_action/prescription.do.php" target="actionForm">
            <input type="hidden" name="Mode" value="add_pill_popup">
            <input type="hidden" name="parent_idx" value="<?= $idx ?>">
            <input type="hidden" name="ps_code" value="<?=$ps_code?>">
            <input type="hidden" name="pp_type" value="2">
            <input type="hidden" name="pharmacy_code" value="<?=$pharmacy_code?>">

            <table>
                <colgroup>
                    <col style="width:15%"/>
                    <col style="width:*"/>
                    <col style="width:15%"/>
                    <col style="width:*"/>
                </colgroup>
                <tbody>

                <tr>
                    <th>처방약품명</th>
                    <td>
                        <input type="text" value="<?=$row_002["PILL_NAME"]?>" style="width:95%;" readonly>
                    </td>
   
                    <th>대체약품명</th>
                    <td>
                        <input type="text" id="pp_title" name="pp_title" style="width:95%;" >
                    </td>
                </tr>

                <tr>
                    <th>1회 투약량</th>
                    <td>
                        <input type="number" id="one_injection" name="one_injection" style="width:95%;">
                    </td>
    
                    <th>1일 투여횟수</th>
                    <td>
                        <input type="number" id="day_injection" name="day_injection" style="width:95%;">
                    </td>                
                </tr>

                <tr>
                    <th>총 투약일수</th>
                    <td>
                        <input type="number" id="total_injection" name="total_injection" style="width:95%;">
                    </td>

                    <th>대체복약 내용</th>
                    <td>
                        <textarea id="pp_cmt" name="pp_cmt" style="width:95%;"></textarea>
                    </td>
                </tr>

                <tr>
                    <th>사용법</th>
                    <td colspan="3">
                        <textarea id="pp_usage" name="pp_usage" style="width:95%;"></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
            <div class="center w100p">
                <input type="submit" value="등록" class="btn btn16 w100 mt10"> &nbsp;
                <input type="button" value="닫기" onClick="self.close();" class="btn btn03 w100 mt10">
            </div>
        </form>
    </div>

<?
include_once "../inc/in_bottom.php";
?>