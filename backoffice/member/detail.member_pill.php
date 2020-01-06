<div><b>○ 알약현황</b></div>

<div class="left" style="margin-top:15px;"><b>○ 회원 리스트</b> ( 검색 인원 : <?= number_format($totalnum) ?> 명 )</div>
<table>
    <colgroup>
        <col width="10%"/>
        <col width="6%"/>
        <col width="17%"/>
        <col width="*"/>
        <col width="12%"/>
        <col width="13%"/>
        <col width="6%"/>
        <col width="8%"/>
    </colgroup>
    <tr>
        <th>가입일</th>
        <th>상태</th>
        <th>아이디 (이메일)</th>
        <th>회원이름</th>
        <th>연락처</th>
        <th>로그인 정보</th>
        <th>약사신청여부</th>
        <th>관리</th>
    </tr>
    <?
    if ($totalnum > 0) {

        $qry_002  = " SELECT t1.IDX, t1.*, t2.*  ";
        $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
        $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
        $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

        $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order . $_limit);
        while ($row_002 = $db->sql_fetch_array($res_002)) {

            $information_ref = "./admin.template.php?slot=member&type=member_detail&step=information&idx=" . $row_002["IDX"] . $_opt;
            $del_ref = "./_action/member.do.php?Mode=del_member_list&u_id=" . $row_002["USER_ID"];

            $member_sex = $row_002["USER_SEX"] == "M" ? "남성" : "여성" ;

            $request_status = $row_002["PHARMACIST_REQUEST"] == "yes" ? "신청중" : "--" ;

            if ($row_002["USER_STATUS"] == "1") {
                ?>
                <tr>
                    <td class="center"><?= $row_002["REG_DATE"] ?></td>
                    <td class="center"><?= $member_status_array[$row_002["USER_STATUS"]] ?></td>
                    <td class="center"><?= $row_002["mm_id"] ?></td>
                    <td style="padding-left:10px;"><?= $row_002["mm_name"] ?> ( <?= $member_sex ?> ) birth. <?= $row_002["USER_BIRTHDAY"] ?></td>
                    <td class="center"><?= $row_002["mm_phone"] ?></td>
                    <td style="padding-left:10px;"><?= "( ".number_format($row_002["LOG_COUNT"])." ) : ". $row_002["LAST_LOGIN"] ?></td>
                    <td class="center"><?= $request_status ?></td>
                    <td class="center">
                        <input type="button" value="관리" class="Small_Button btnGreen"
                               onClick="location.href='<?= $information_ref ?>'">&nbsp;
                        <input type="button" value="삭제" class="Small_Button btnRed"
                               onClick="confirm_process('actionForm','회원 정보를 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다.','<?= $del_ref ?>');">
                    </td>
                </tr>
                <?
            } else {
                ?>
                <tr>
                    <td class="center"><?= $row_002["REG_DATE"] ?></td>
                    <td class="center"><?= $member_status_array[$row_002["USER_STATUS"]] ?></td>
                    <td colspan="5" class="left" style="line-height:180%;">
                        <b>[ 활동중지시간 :
                            <?php
                            if ($row_002["USER_STATUS"] == "2") {
                                echo $row_002["DIAPAUSE_DATE"] ;
                            } else if ($row_002["USER_STATUS"] == "3") {
                                echo $row_002["WITHDRAW_DATE"] ;
                            } else if ($row_002["USER_STATUS"] == "6") {
                                echo $row_002["UP_DATE"] ;
                            }
                            ?>
                            ] <?= $row_002["mm_name"] ?> ( <?= $row_002["mm_id"] ?> )</b>
                    </td>
                    <td class="center">
                        <input type="button" value="관리" class="Small_Button btnGreen"
                               onClick="location.href='<?= $information_ref ?>'">&nbsp;
                        <input type="button" value="삭제" class="Small_Button btnRed"
                               onClick="confirm_process('actionForm','회원 정보를 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다.','<?= $del_ref ?>');">
                    </td>
                </tr>
                <?
            }

        }

    } else {
        ?>
        <tr>
            <td colspan="9" height="200" class="center">등록된 회원이 없습니다.</td>
        </tr>
        <?
    }
    ?>
</table>

<div align="center" style="padding-top:20px;margin-bottom:5px;">
    <?
    $_url = "&slot=member&type=member_list";
    $paging = new paging("./admin.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
    $paging->pagingArea("", "");
    ?>
</div>