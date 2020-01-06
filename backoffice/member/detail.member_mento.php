<?php
$qry_001  = " SELECT count(*) ";
$_from    = " FROM {$TB_MENTOR} t1";
$_from   .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.MENTOR_ID = t2.USER_ID ) ";
$_from   .= " LEFT JOIN {$TB_MEMBER_INFO} t3 ON ( t2.USER_ID = t3.ID_KEY ) ";
$_where   = " WHERE t1.MENTEE_ID = '{$m_main["USER_ID"]}' ";
$_order   = " ORDER BY t1.REG_DATE DESC ";

$res_001  = $db->exec_sql($qry_001 . $_from . $_where);
$row_001  = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];
?>

<div class="left" style="margin-top:15px;"><b>○ 멘토 리스트</b> ( 검색 인원 : <?= number_format($totalnum) ?> 명 )</div>
<table>
    <colgroup>
        <col width="5%"/>
        <col width="20%"/>
        <col width="*"/>
        <col width="15%"/>
        <col width="15%"/>
    </colgroup>
    <tr>
        <th>No</th>
        <th>멘티 아이디</th>
        <th>멘티 이름</th>
        <th>멘티 연락처</th>
        <th>등록일</th>
    </tr>
    <?
    if ($totalnum > 0) {
        $j = 0;
        $qry_002  = " SELECT t1.*, t2.*, t1.REG_DATE AS date ";
        $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
        $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
        $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

        $res_002 = $db->exec_sql($qry_002 . $_from . $_where . $_order );
        while ($row_002 = $db->sql_fetch_array($res_002)) {
            $_j = $totalnum - $j;
                ?>
                <tr>
                    <td class="center"><?= $_j ?></td>
                    <td class="center"><?= $row_002["mm_id"] ?></td>
                    <td class="center"><?= $row_002["mm_name"] ?></td>
                    <td class="center"><?= $row_002["mm_phone"] ?></td>
                    <td class="center"><?= $row_002["date"] ?></td>
                </tr>
                <?
            $j++;
        }
    } else {
        ?>
        <tr>
            <td colspan="5" height="200" class="center">등록된 멘토가 없습니다.</td>
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
