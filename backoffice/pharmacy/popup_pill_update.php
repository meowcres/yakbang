<?php

include_once "../../_core/_init.php" ;
include_once "../inc/in_top.php" ;

$idx = $_GET["idx"];

$qry_001 = " SELECT * FROM {$TB_PILL} WHERE IDX = '{$idx}' ";
$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

?>


<div>
    <h3 class="h3_title"><?= $pharmacy_name ?> 처방약 수정</h3>


    <form id="frm" name="frm" method="post" action="../_action/pharmacy.do.php" onSubmit="return chkForm()" target="actionForm">
    <input type="hidden" name="Mode" value="pill_update">
    <input type="hidden" name="idx" value="<?=$idx?>">

    <table>
        <colgroup>
            <col width="10%"/>
            <col width="20%"/>
            <col width="20%"/>
            <col width="*%"/>
            <col width="10%"/>
            <col width="5%"/>
            <col width="8%"/>
            <col width="5%"/>
        </colgroup>

        <tbody>
        <tr>
            <th style="text-align:center;">처방약 코드</th>
            <th style="text-align:center;">처방약 명</th>
            <th style="text-align:center;">제조사</th>
            <th style="text-align:center;">약효분류</th>
            <th style="text-align:center;">복지부<br>분류코드</th>
            <th style="text-align:center;">판매상태</th>
        </tr>

        <tr>
            <td style="text-align:center;"><input type="text" id="pill_code" name="pill_code" value="<?=$row_001["PILL_CODE"]?>"></td>
            <td style="text-align:center;"><input type="text" id="pill_name" name="pill_name" value="<?=$row_001["PILL_NAME"]?>"></td>
            <td style="text-align:center;"><input type="text" id="pill_company" name="pill_company" value="<?=$row_001["PILL_COMPANY"]?>"></td>
            <td style="text-align:center;"><input type="text" id="pill_medical_name" name="pill_medical_name" value="<?=$row_001["PILL_MEDICAL_NAME"]?>"></td>
            <td style="text-align:center;"><input type="text" id="pill_medical_code" name="pill_medical_code" value="<?=$row_001["PILL_MEDICAL_CODE"]?>"></td>
            <td style="text-align:center;">
                <select id="pill_status" name="pill_status">
                    <option value="1" <?=$row_001["PILL_STATUS"] == "1" ? "selected" : ""?> >판매중</option>
                    <option value="2" <?=$row_001["PILL_STATUS"] == "2" ? "selected" : ""?> >판매중단</option>
                </select>
            </td>
        </tr>
  
        </tbody>
    </table>

    <div style="margin-top:20px;" align="center">
        <input type="submit" value="수정" class="btn btn16 wid15 mt10" style="cursor:pointer;">&nbsp;
        <input type="button" id="frmClose" value="창닫기" class="btn btn14 wid15 mt10" onClick="self.close();" style="cursor:pointer;">
    </div>
    </form>


</div>

<script>
</script>

<?
include_once "../inc/in_bottom.php";
?>