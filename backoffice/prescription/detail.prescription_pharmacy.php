<?

$qry_cnt  = " SELECT count(t1.IDX) ";
$qry_001  = " SELECT t1.IDX AS idx, t1.*, t2.* ";
$_from    = " FROM {$TB_PS_PHARMACY} t1 ";
$_from   .= " LEFT JOIN {$TB_PHARMACY} t2 ON ( t1.PHARMACY_CODE = t2.PHARMACY_CODE ) ";
$_where   = " WHERE t1.PS_CODE = '{$ps_code}' ";
$_order   = " ORDER BY t1.IDX DESC ";
$res_cnt  = $db->exec_sql($qry_cnt . $_from . $_where);
$row_cnt  = $db->sql_fetch_array($res_cnt);

$totalnum = $row_cnt[0];

?>
<div class="left" style="margin-top:15px;"><b>○ 처방약국 목록</b> ( <?= number_format($totalnum) ?> 개 )</div>
<table>
    <colgroup>
        <col width="15%"/>
        <col width="10%"/>
        <col width="15%"/>
        <col width="*"/>
        <col width="15%"/>
        <col width="10%"/>
    </colgroup>
    <tr>
        <th>코드</th>
        <th>상태</th>
        <th>약국코드</th>
        <th>약국이름</th>
        <th>약국주소</th>
        <th>약국연락처</th>
    </tr>
    <?
    if ($totalnum > 0) {

        $res_001 = $db->exec_sql($qry_001 . $_from . $_where . $_order);
        while ($row_001 = $db->sql_fetch_array($res_001)) {
            if ($row_001["A_STATUS"] == 5) {
                $status = "<font color='0000FF'>".$prescription_pharmacy_status_array[$row_001["A_STATUS"]]."</font>";
            } else if ($row_001["A_STATUS"] == 4) {
                $status = "<font color='FF0000'>".$prescription_pharmacy_status_array[$row_001["A_STATUS"]]."</font>";
            } else {
                $status = "<font color='008080'>".$prescription_pharmacy_status_array[$row_001["A_STATUS"]]."</font>";
            }
            ?>
            <tr>
                <td class="center"><?= $row_001["PS_CODE"] ?></td>
                <td class="center"><?= $status ?></td>
                <td class="center"><?= $row_001["PHARMACY_CODE"] ?></td>
                <td class="center"><?= $row_001["PHARMACY_NAME"] ?></td>
                <td class="center"><?= $row_001["ADDRESS"] ?></td>
                <td class="center"><?= $row_001["PHARMACY_PHONE"] ?></td>
            </tr>
            <?

        }

    } else {
        ?>
        <tr>
            <td colspan="10" height="200" class="center">처방전에 등록된 약국이 없습니다.</td>
        </tr>
        <?
    }
    ?>
</table>

</div>