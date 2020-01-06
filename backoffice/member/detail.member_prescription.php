<?php
$qry_001  = " SELECT count(t1.PS_CODE) ";
$_from    = " FROM {$TB_PS} AS t1 ";
$_from   .= " LEFT JOIN {$TB_PS_PHARMACY} AS t2 ON (t1.PS_CODE = t2.PS_CODE) ";
$_from   .= " LEFT JOIN {$TB_PHARMACY} AS t3 ON (t2.PHARMACY_CODE = t3.PHARMACY_CODE) ";
$_where   = " WHERE t1.USER_ID = '{$m_main["USER_ID"]}' ";
$_order   = " ORDER BY t1.REG_DATE DESC ";

$res_001  = $db->exec_sql($qry_001 . $_from . $_where);
$row_001  = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];

?>

<div class="left" style="margin-top:15px;"><b>○ 처방내역관리</b> ( 처방전 : <?= number_format($totalnum) ?> 개 )</div>
<table>
    <colgroup>
        <col width="5%"/>
        <col width="12%"/>
        <col width="12%"/>
        <col width="8%"/>
        <col width="15%"/>
        <col width="*"/>
        <col width="10%"/>
        <col width="6%"/>
    </colgroup>
    <tr>
        <th>No</th>
        <th>등록일</th>
        <th>처방전 코드</th>
        <th>상태</th>
        <th>처뱡악국</th>
        <th>처뱡악국 주소</th>
        <th>처뱡악국 연락처</th>
        <th>상세보기</th>

    </tr>
    <?
    if ($totalnum > 0) {
        $j = 0;
        $qry_002 = " SELECT t1.PS_CODE, t1.PS_STATUS, t1.REG_DATE, t1.COMPLETE_DATE, t3.PHARMACY_NAME, t3.ZIPCODE, t3.ADDRESS, t3.ADDRESS_EXT, t3.PHARMACY_PHONE ";
        $res_002 = $db->exec_sql($qry_002 . $_from . $_where . $_order );
        while ($row_002 = $db->sql_fetch_array($res_002)) {
            $_j = $totalnum - $j;
                ?>
                <tr>
                    <td class="center"><?=$_j?></td>
                    <td class="center"><?=$row_002["REG_DATE"]?></td>
                    <td class="center"><?=$row_002["PS_CODE"]?></td>
                    <td class="center"><?=$prescription_status_array[$row_002["PS_STATUS"]]?></td>
                    <td class="center"><?=$row_002["PHARMACY_NAME"]?></td>
                    <td class="center">(<?=$row_002["ZIPCODE"]?>)&nbsp;<?=$row_002["ADDRESS"]?>&nbsp;<?=$row_002["ADDRESS_EXT"]?></td>
                    <td class="center"><?=$row_002["PHARMACY_PHONE"]?></td>
                    <td class="center"><input type="button" value="상세보기" class="Small_Button btnGreen" onClick="popup_detail('<?=$row_002["PS_CODE"]?>');"></td>
                </tr>
                <?
            $j++;
        }
    } else {
        ?>
        <tr>
            <td colspan="8" height="200" class="center">등록된 처방전이 없습니다.</td>
        </tr>
        <?
    }
    ?>
</table>

<div align="center" style="padding-top:10px;">
    <?
    $_url = "&slot=pharmacist&type=pharmacist_detail&step=mentee";
    $paging = new paging("./admin.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
    $paging->pagingArea("", "");
    ?>
</div>

<? $db->db_close(); ?>



<script>

function popup_detail(ps_code) {
    var url = "./member/popup.prescription_view.php?ps_code=" + ps_code;
    window.open(url,"", "width=1200, height=500");
}

</script>