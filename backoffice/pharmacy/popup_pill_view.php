<?php

include_once "../../_core/_init.php" ;
include_once "../inc/in_top.php" ;

$idx = $_GET["idx"];

$qry_001 = " SELECT * FROM {$TB_PILL} WHERE IDX = '{$idx}' ";
$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

?>


<div>
    <h3 class="h3_title"><?= $pharmacy_name ?> 의약품 상세보기</h3>

    <table>
        <colgroup>
            <col width="8%"/>
            <col width="12%"/>
            <col width="10%"/>
            <col width="8%"/>
            <col width="8%"/>
            <col width="8%"/>
            <col width="8%"/>
            <col width="5%"/>
            <col width="*"/>
            <col width="8%"/>
            <col width="8%"/>
        </colgroup>

        <tbody>
        <tr>
            <th style="text-align:center;">품목기준코드</th>
            <th style="text-align:center;">제품명</th>
            <th style="text-align:center;">업체명</th>
            <th style="text-align:center;">허가일</th>
            <th style="text-align:center;">품목구분</th>
            <th style="text-align:center;">허가번호</th>
            <th style="text-align:center;">취소/취하</th>            
            <th style="text-align:center;">주성분</th>
            <th style="text-align:center;">첨가제</th>
            <th style="text-align:center;">품목분류</th>
            <th style="text-align:center;">제조/수입</th>
        </tr>

        <tr>
            <td style="text-align:center;"><?=$row_001["PILL_IDX"]?></td>
            <td style="text-align:center;"><?=$row_001["PILL_NAME"]?></td>
            <td style="text-align:center;"><?=$row_001["PILL_COMPANY"]?></td>
            <td style="text-align:center;"><?=$row_001["PILL_ACCEPT_DATE"]?></td>
            <td style="text-align:center;"><?=$row_001["PILL_CLASS"]?></td>
            <td style="text-align:center;"><?=$row_001["PILL_ACCEPT_NUMBER"]?></td>
            <td style="text-align:center;"><?=$row_001["PILL_ACCEPT_STATUS"]?></td>
            <td style="text-align:center;"><?=$row_001["PILL_COMPONENT"]?></td>
            <td style="text-align:center;"><?=$row_001["PILL_ADDITIVE"]?></td>
            <td style="text-align:center;"><?=$row_001["PILL_CATEGORY"]?></td>
            <td style="text-align:center;"><?=$row_001["PILL_SALES_METHOD"]?></td>
        </tr>
  
        </tbody>
    </table>

    <div style="margin-top:20px;" align="center">
        <input type="button" id="frmClose" value="창닫기" class="btn btn14 wid15 mt10" onClick="self.close();" style="cursor:pointer;">
    </div>

</div>

<script>
</script>

<?
include_once "../inc/in_bottom.php";
?>