<?php

$qry_001 = " SELECT count(t1.IDX) ";
$qry_002 = " SELECT t1.IDX AS ID_KEY, t2.*, t3.PHARMACY_NAME ";
$qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
$_from = " FROM {$TB_MEMBER} t1 ";
$_from .= " LEFT JOIN {$TB_PP} t2 ON (t1.USER_ID = t2.USER_ID) ";
$_from .= " LEFT JOIN {$TB_PHARMACY} t3 ON ( t2.PHARMACY_CODE = t3.PHARMACY_CODE ) ";
$_where = " WHERE t1.IDX = '{$_pharmacist["idx"]}' AND t2.IDX IS NOT NULL ";
$_order = " ORDER BY t2.P_GRADE DESC, t2.P_STATUS ASC, t2.IDX DESC ";
$res_001 = $db->exec_sql($qry_001 . $_from . $_where);
$row_001 = $db->sql_fetch_array($res_001);

$totalnum = $row_001[0];

?>

<h3 class="h3_title">소속약국 ( <?= number_format($totalnum) ?> ) </h3>
<div class="adm_table_style02">
    <table>
        <colgroup>
            <col width="12%"/>
            <col width="7%"/>
            <col width="7%"/>
            <col width="10%"/>
            <col width="*"/>
            <col width="12%"/>
            <col width="12%"/>
        </colgroup>
        <tr>
            <th>등록일</th>
            <th>상태</th>
            <th>권한</th>
            <th>약사이름</th>
            <th>약국이름</th>
            <th>시작기간</th>
            <th>종료기간</th>
        </tr>
        <?
        if ($totalnum > 0) {

            $res_002 = $db->exec_sql($qry_002 . $_from . $_where . $_order);
            while ($row_002 = $db->sql_fetch_array($res_002)) {

                $del_ref = "./_action/pharmacist.do.php?Mode=del_pharmacy&idx=" . $row_002["IDX"];

                ?>
                <tr>
                    <td class="center"><?= $row_002["REG_DATE"] ?></td>
                    <td class="center"><?= $pharmacist_status_array[$row_002["P_STATUS"]] ?></td>
                    <td class="center"><?= $pharmacist_grade_array[$row_002["P_GRADE"]] ?></td>
                    <td class="center"><?= $row_002["mm_name"] ?></td>
                    <td class="center"><?= clear_escape($row_002["PHARMACY_NAME"]) ?></td>
                    <td class="center"><?= $row_002["S_DATE"] ?></td>
                    <td class="center"><?= $row_002["E_DATE"] ?></td>
                </tr>
                <?

            }

        } else {
            ?>
            <tr>
                <td colspan="10" height="200" class="center">등록된 약국이 없습니다.</td>
            </tr>
            <?
        }
        ?>
    </table>
</div>
</div>
</div>