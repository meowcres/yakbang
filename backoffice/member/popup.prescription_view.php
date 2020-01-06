<?php
include_once "../../_core/_init.php";
include_once "../inc/in_top.php";

$ps_code = $_REQUEST["ps_code"];

// 처방약국 & 처뱡약사 정보
$qry_001 = " SELECT t1.*, t2.*, CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as pharma_name ";
$from_001  = " FROM {$TB_PS_PILL} AS t1 ";
$from_001 .= " LEFT JOIN {$TB_PHARMACY} AS t2 ON (t1.PP_PHARMACY = t2.PHARMACY_CODE) ";
$from_001 .= " LEFT JOIN {$TB_MEMBER} AS t3 ON (t1.PP_PHARMACIST = t3.USER_ID) ";
$where_001 = " WHERE t1.PS_CODE = '{$ps_code}' ";
$res_001 = $db->exec_sql($qry_001.$from_001.$where_001);
$row_001 = $db->sql_fetch_array($res_001);

// 처방전 상세
$qry_002 = " SELECT COUNT(t1.IDX) ";
$from_002  = " FROM {$TB_PS_PILL} AS t1 ";
$from_002 .= " LEFT JOIN {$TB_PILL} AS t2 ON (t1.PP_TITLE = t2.IDX) ";
$where_002 = " WHERE t1.PS_CODE = '{$ps_code}' ";
$order_002 = " ORDER BY t1.IDX DESC ";

$res_002 = $db->exec_sql($qry_002 . $from_002 . $where_002);
$row_002 = $db->sql_fetch_row($res_002);
$totalnum = $row_002[0];

?>
    <div id="Popup_Contents" style="padding:10px;">
        <h1>처방전내역 &gt;<strong> 처방전 상세 목록 (처방전 코드 : <?=$ps_code?> | 처방약국 : <?=$row_001["PHARMACY_NAME"]?> | 처방약사 : <?=$row_001["pharma_name"]?>)</strong></h1>
        <table class="tbl1" summary="처방전 목록">
            <colgroup>
                <col width="5%"/>
                <col width="7%"/>
                <col width="*"/>
                <col width="8%"/>
                <col width="8%"/>
                <col width="8%"/>
                <col width="30%"/>
            </colgroup>
            <tr>
                <th>No</th>
                <th>분류</th>
                <th>약이름</th>
                <th>1회 투약량</th>
                <th>1일 투여횟수</th>
                <th>총 투여일수</th>
                <th>내용</th>
            </tr>
            <?php
            if ($totalnum > 0) {
                $j = 1;
                $qry_002  = " SELECT t1.*, t2.PILL_NAME ";
                $res_002 = $db->exec_sql($qry_002.$from_002.$where_002.$order_002);
                while ($row_002 = $db->sql_fetch_array($res_002)) {
                    $pp_type = $row_002["PP_TYPE"] == '1' ? "<font color='4285F4'>처방약</font>" : "<font color='ff0000'>대체약</font>";        
                    $pp_usage = $row_002["PP_TYPE"] == '1' ? $row_002["PP_USAGE"] : $row_002["PP_CMT"];        
                    $pp_pill = $row_002["PARENT_IDX"] == '' ? $row_002["PILL_NAME"] : $row_002["PP_TITLE"];        
                        ?>
                    <tr>
                        <td class="center"><?=$j?></td>
                        <td class="center"><?=$pp_type?></td>
                        <td class="center"><?=$pp_pill?></td>
                        <td class="center"><?=$row_002["ONE_INJECTION"]?>개</td>
                        <td class="center"><?=$row_002["DAY_INJECTION"]?>회</td>
                        <td class="center"><?=$row_002["TOTAL_INJECTION"]?>일</td>
                        <td class="center"><?=$pp_usage?></td>
                    </tr>
                        <?
                    $j++;
                }
            } else {
                ?>
                <tr>
                    <td colspan="5" height="200" class="center">등록된 처방전이 없습니다.</td>
                </tr>
                <?
            }
            ?>
        </table>

        <div style="margin-top:30px;text-align:center;">
            <input type="button" id="frmClose" value="창닫기" class="btnGray w100 h28" onClick="self.close();" style="cursor:pointer;">
        </div>
    </div>
<?php
include_once "../inc/in_bottom.php";