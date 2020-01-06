<?php

$qry_cnt = " SELECT count(t1.IDX) ";
$qry_001 = " SELECT t1.IDX AS idx, t1.*, t2.*, t3.* ";
$qry_001 .= ", CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as p_name ";
$_from = " FROM {$TB_PS_PILL} t1 ";
$_from .= " LEFT JOIN {$TB_PHARMACY} t2 ON ( t1.PP_PHARMACY = t2.PHARMACY_CODE ) ";
$_from .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.PP_PHARMACIST = t3.USER_ID ) ";
$_where = " WHERE t1.PS_CODE = '{$ps_code}' ";
$_order = " ORDER BY t1.PARENT_IDX ";
$res_cnt = $db->exec_sql($qry_cnt . $_from . $_where);
$row_cnt = $db->sql_fetch_array($res_cnt);

$totalnum = $row_cnt[0];

?>

<h3 class="h3_title">처방약 목록 ( <?= number_format($totalnum) ?> ) </h3>
<div class="adm_table_style02">
    <table>
        <colgroup>
            <col width="10%"/>
            <col width="8%"/>
            <col width="15%"/>
            <col width="5%"/>
            <col width="5%"/>
            <col width="5%"/>
            <col width="*"/>
            <col width="12%"/>
            <col width="12%"/>
            <col width="12%"/>
        </colgroup>
        <tr>
            <th>처방전 코드</th>
            <th>처방 타입</th>
            <th>약품명</th>
            <th>1회 투약량</th>
            <th>1일 투여횟수</th>
            <th>총 투약일수</th>
            <th>사용법</th>
            <th>대체복약 처방약국</th>
            <th>대체복약 처방약사</th>
            <th>대체복약 내용</th>
        </tr>
        <?
        if ($totalnum > 0) {

            $res_001 = $db->exec_sql($qry_001 . $_from . $_where . $_order);
            while ($row_001 = $db->sql_fetch_array($res_001)) {
                ?>
                    <tr>
                        <td class="center"><?= $row_001["PS_CODE"] ?></td>
                        <td class="center"><?= $status ?></td>
                        <td class="center"><?= $row_001["PP_TITLE"] ?></td>
                        <td class="center"><?= $row_001["ONE_INJECTION"] ?></td>
                        <td class="center"><?= $row_001["DAY_INJECTION"] ?></td>
                        <td class="center"><?= $row_001["TOTAL_INJECTION"] ?></td>
                        <td class="center"><?= $row_001["PP_USAGE"] ?></td>
                        <td class="center"><?= $row_001["PHARMACY_NAME"] ?></td>
                        <td class="center"><?= $row_001["p_name"] ?></td>
                        <td class="center"><?= $row_001["PP_CMT"] ?></td>
                    </tr>
                <?
            }
        } else {
            ?>
            <tr>
                <td colspan="11" height="200" class="center">등록된 처방약이 없습니다.</td>
            </tr>
            <?
        }
        ?>
    </table>
</div>
<script>
    function del_pill(idx, ps_code) {
        if (confirm("정말 삭제하시겠습니까? \n\n 삭제 후에는 복구가 불가능합니다.")) {
            location.href = "./_action/prescription.do.php?Mode=del_pill&idx=" + idx + "&ps_code=" + ps_code;
        }
    }
</script>