<?php
include_once "../_core/_lib/class.attach.php";


$qry_1  = " SELECT * ";
$qry_1 .= " FROM {$TB_OP} ";
$qry_1 .= " WHERE OP_STATUS = '2' AND OP_ID = '".$_opKey["id"]."' ";

$res_1  = $db->exec_sql($qry_1);
$row_1  = $db->sql_fetch_array($res_1);



$offset = 20;
$page_block = 10;
$startNum = "";
$totalnum = "";
$page = "";
$_page = isNull($_REQUEST["page"]) ? $_clean["page"] : $_REQUEST["page"];

if (!isNull($_page)) {
    $page = $_page;
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

$qry_001 = "SELECT count(t1.PS_CODE)  ";

$_from   = " FROM {$TB_PS} t1   ";
$_from  .= " LEFT JOIN {$TB_PS_PRECLEANING} t2 ON (t1.PS_CODE = t2.PS_CODE)  ";
$_from  .= " LEFT JOIN {$TB_PS_IMAGE} t3 ON (t1.PS_CODE = t3.PS_CODE)  ";
$_from  .= " LEFT JOIN {$TB_OP} t4 ON (t2.OP_ID = t4.OP_ID)  ";
$_from  .= " LEFT JOIN {$TB_MEMBER} t5 ON (t1.USER_ID = t5.USER_ID)  ";

$_where[] = " t1.PS_STATUS = 1   ";
$_where[] = " t2.PRE_STATUS IS NULL   ";
$_where[] = " t1.REG_DATE >= (CURDATE() - INTERVAL 24 HOUR) ";

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY t1.REG_DATE desc";
$_limit = " LIMIT " . $startNum . "," . $offset;

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry . $_order . $_limit);
$row_001 = $db->sql_fetch_row($res_001);

$totalnum = $row_001[0];


// 오늘자 전체 처방건수
$qry_002  = "SELECT count(t1.PS_CODE)  ";
$qry_002 .= " FROM {$TB_PS} t1   ";
$qry_002 .= " LEFT JOIN {$TB_PS_PRECLEANING} t2 ON (t1.PS_CODE = t2.PS_CODE)  ";
$qry_002 .= " WHERE t1.SEND_TYPE = 1 AND NOT t1.PS_STATUS = 6  ";

$res_002 = $db->exec_sql($qry_002);
$todayTotal = $db->sql_fetch_row($res_002);


// 오늘자 처방 건수
$qry_003  = "SELECT count(t1.PS_CODE)  ";
$qry_003 .= " FROM {$TB_PS} t1   ";
$qry_003 .= " LEFT JOIN {$TB_PS_PRECLEANING} t2 ON (t1.PS_CODE = t2.PS_CODE)  ";
$qry_003 .= " WHERE t1.SEND_TYPE = 1 AND t2.PRE_STATUS = 3 AND DATE_FORMAT(t1.REG_DATE, '%Y-%m-%d') = CURRENT_DATE() ";

$res_003 = $db->exec_sql($qry_003);
$todayComplete = $db->sql_fetch_row($res_003);


// 오늘자 판독불가 건수
$qry_004  = "SELECT count(t1.PS_CODE)  ";
$qry_004 .= " FROM {$TB_PS} t1   ";
$qry_004 .= " LEFT JOIN {$TB_PS_PRECLEANING} t2 ON (t1.PS_CODE = t2.PS_CODE)  ";
$qry_004 .= " WHERE t1.SEND_TYPE = 1 AND t2.PRE_STATUS = 5 AND DATE_FORMAT(t1.REG_DATE, '%Y-%m-%d') = CURRENT_DATE() ";

$res_004 = $db->exec_sql($qry_004);
$todayImpossible = $db->sql_fetch_row($res_004);


// 오늘자 처리중 건수
$qry_005  = "SELECT count(t1.PS_CODE)  ";
$qry_005 .= " FROM {$TB_PS} t1   ";
$qry_005 .= " LEFT JOIN {$TB_PS_PRECLEANING} t2 ON (t1.PS_CODE = t2.PS_CODE)  ";
$qry_005 .= " WHERE t1.SEND_TYPE = 1 AND t2.PRE_STATUS = 2 AND DATE_FORMAT(t1.REG_DATE, '%Y-%m-%d') = CURRENT_DATE() ";

$res_005 = $db->exec_sql($qry_005);
$todayProcess = $db->sql_fetch_row($res_005);

unset($qry_001);
unset($res_001);
unset($row_001);
?>

<div id="content">
    <div class="sub_tit">DASHBOARD</div>
    <div id="cont">
        
        <div class="adm_cts">
            <h3 class="h3_title">현황</h3>
            <div class="adm_table_style01">
                <table>
                    <colgroup>
                        <col style="width:15%"/>
                        <col style="width:40%"/>
                        <col style="width:15%"/>
                        <col style="width:*"/>
                    </colgroup>

                    <tbody>
                        <tr>
                            <th>아이디</th>
                            <td><?= $row_1["OP_ID"] ?></td>

                            <th>전체 처방건수</th>
                            <td align="center"><font color="red"><b><?=$todayTotal[0]?> 건</b></font></td>
                        </tr>

   
                        <tr>
                            <th>이름</th>
                            <td><?= $row_1["OP_NAME"] ?></td>
                         
                            <th>오늘 처방건수</th>
                            <td align="center">( 완료 : <?=$todayComplete[0]?> 건 / 판독 불가 : <?=$todayImpossible[0]?> 건 </td>
                        </tr>

                        <tr>
                            <th>접속권한일</th>
                            <td><?= $row_1["START_DATE"] ?> ~ <?= $row_1["END_DATE"] ?></td>
                         
                            <th>오늘 미처리건수</th>
                            <td align="center">( 대기 : <?=$totalnum?> 건 / 처리중 : <?=$todayProcess[0]?> 건 )</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div><br><br>
 


        <div class="adm_cts">
            <h3 class="h3_title">현황 
                <span style="font-weight:20;">( 처방전 목록 : <?= number_format($totalnum) ?> 건 )</span>           
            </h3>

            <div class="adm_table_style01">

                <input type="hidden" name="Mode" id="Mode" value="prescription_update">
                <table>
                    <colgroup>
                        <col style="width:18%"/>                        
                        <col style="width:10%"/>
                        <col style="width:*"/>
                        <col style="width:15%"/>
                        <col style="width:15%"/>
                        <col style="width:15%"/>
                    </colgroup>

                    <tbody>
                        <tr height="40">
                            <th>요청일</th>
                            <th>처방전 사진</th>
                            <th>처방전 코드</th>
                            <th>환자정보</th>
                            <th>처방전 상태</th>
                        </tr>

                        <?php
                        if ($totalnum > 0) {
                            $sql = 'SELECT t1.PS_CODE, t1.PS_STATUS, t1.REG_DATE, t2.PRE_STATUS, t3.PHYSICAL_NAME, t4.OP_NAME, CAST(AES_DECRYPT(UNHEX(t5.USER_NAME), "'.SECRET_KEY.'") as char) as mm_name ';
                            $result = $db->exec_sql($sql . $_from . $_whereqry . $_order . $_limit);
                            while ($row_002 = $db->sql_fetch_array($result)) {
                            ?>

                        <tr>
                            <td align="center"><?= $row_002["REG_DATE"] ?></td>
                            <td align="center">
                                <?php
                                if (!isNull($row_002["PS_CODE"])) {
                                    ?><img src="../../Web_Files/prescription/<?= $row_002["PHYSICAL_NAME"] ?>" onerror="this.src='http://yakbang.org/web/images/noimage.gif';" height="30"><?
                                }
                                ?>                            
                            </td>
                            <td align="center"><?= $row_002["PS_CODE"] ?></td>
                            <td align="center"><?= $row_002["mm_name"] ?></td>
                            <td align="center">
                                <input type="hidden" id="ps_code" name="ps_code" value="<?= $row_002["PS_CODE"] ?>">
                                <input type="hidden" id="pre_status" name="pre_status" value="<?= $row_002["PRE_STATUS"] ?>">
                                <input type="button" style="width:100px;height:24px;background-color:#51c33a;color:white;border-radius:5px;" id="pre_status_btn"
                                       onClick="openWin('./prescription/popup_prescription_update.php?PS_CODE=<?= $row_002["PS_CODE"] ?>&OP_ID=<?= $_op["OP_ID"] ?>','preupdate',1000,800,'scrollbars=no');"
                                       value="<?= $pre_status_array[$row_002["PRE_STATUS"]] ?>" >    
                            </td>
                        </tr>

                        <?
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="5" height="200" align="center">분석 요청 중인 처방전이 없습니다</td>
                            </tr>
                            <?
                        }
                        ?>      
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<script>
setInterval(function() {
    location.reload();
}, 5000); 
</script>