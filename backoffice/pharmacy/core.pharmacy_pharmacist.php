<?
$_where[] = "t1.PHARMACY_CODE='{$pharmacy_code}' ";

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY t1.P_GRADE DESC, R_DATE";

$qry_001 = "SELECT count(t1.IDX)  ";

$_from   = " FROM {$TB_PP} t1  ";
$_from  .= " LEFT JOIN {$TB_MEMBER} t2 ON (t2.USER_ID = t1.USER_ID)  ";
$_from  .= " LEFT JOIN {$TB_MEMBER_INFO} t3 ON (t3.ID_KEY = t1.USER_ID)  ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);

$totalnum = $row_001[0];

unset($qry_001);
unset($res_001);
unset($row_001);
?>

    <table>
        <colgroup>
            <col width="12%"/>
            <col width="7%"/>
            <col width="7%"/>
            <col width="12%"/>
            <col width="*"/>
            <col width="15%"/>
            <col width="5%"/>
            <col width="5%"/>
            <col width="10%"/>
            <col width="8%"/>
        </colgroup>
        <tr>
            <th>등록일</th>
            <th>상태</th>
            <th>권한</th>
            <th>승인기간</th>
            <th>아이디 (이메일)</th>
            <th>약사이름</th>
            <th>성별</th>
            <th>나이</th>
            <th>연락처</th>
            <th>관리</th>
        </tr>
        <?
        if ($totalnum > 0) {

            $qry_002  = " SELECT t1.IDX as IDX_KEY, t1.REG_DATE as R_DATE, t1.*, t2.*, t3.*  ";
            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

            $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order . $_limit);
            while ($row_002 = $db->sql_fetch_array($res_002)) {

                $information_ref = "./admin.member.php?slot=member&type=member_detail&step=information&email=" . $row_002["email"] . $_opt;
                $del_ref = "./_action/pharmacy.do.php?Mode=del_pharmacist&idx=" . $row_002["IDX_KEY"];

                $member_sex = $row_002["USER_SEX"] == "M" ? "남성" : "여성" ;
                $member_age = date("Y") - substr($row_002["USER_BIRTHDAY"],0,4) ;
                    ?>
                    <tr>
                        <td class="center"><?= $row_002["R_DATE"] ?></td>
                        <td class="center"><?= $pharmacist_status_array[$row_002["P_STATUS"]] ?></td>
                        <td class="center"><?= $pharmacist_grade_array[$row_002["P_GRADE"]] ?></td>
                        <td class="center"><?= $row_002["S_DATE"] ?> ~ <?= $row_002["E_DATE"] ?></td>
                        <td class="center"><?= $row_002["mm_id"] ?></td>
                        <td class="center"><?= $row_002["mm_name"] ?></td>
                        <td class="center"><?= $member_sex ?></td>
                        <td class="center"><?= number_format($member_age) ?></td>
                        <td class="center"><?= $row_002["mm_phone"] ?></td>
                        <td class="center">
                            <input type="button" value="관리" class="Small_Button btnGreen"
                                   onClick="openWin('./pharmacy/popup_pharmacist_update.php?idx=<?=$row_002["IDX_KEY"]?>&p_code=<?=$pharmacy_code?>','pharmacist_update',1000,400,'scrollbars=yes')">&nbsp;
                            <input type="button" value="삭제" class="Small_Button btnRed"
                                   onClick="confirm_process('actionForm','약국에서 전문약사 정보를 제외 시겠습니까?','<?= $del_ref ?>');">
                        </td>
                    </tr>
                    <?                    
                
            }

        } else {
            ?>
            <tr>
                <td colspan="10" height="200" class="center">등록된 전문 약사가 없습니다.</td>
            </tr>
            <?
        }
        ?>
    </table>
    
    <div>
      <input type="button" value="전문약사 등록" class="Button btnGreen mt10" onClick="openWin('./pharmacy/popup_pharmacist_register.php?p_code=<?=$pharmacy_code?>','pharmacist_register',1000,600,'scrollbars=yes')">
    </div>
</div>