<?

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

$_where[] = " t1.PS_STATUS = 1 ";
$_where[] = " t1.SEND_TYPE = 1 ";
$_where[] = " t1.REG_DATE >= (CURDATE() - INTERVAL 24 HOUR) ";

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_group = " GROUP BY t1.PS_CODE ";
$_order = " ORDER BY t1.REG_DATE desc ";
$_limit = " LIMIT " . $startNum . "," . $offset;


$qry_001 = "SELECT count(t1.PS_CODE)  ";

$_from   = " FROM {$TB_PS} t1   ";
$_from  .= " LEFT JOIN {$TB_PS_PRECLEANING} t2 ON (t1.PS_CODE = t2.PS_CODE)  ";
$_from  .= " LEFT JOIN {$TB_PS_IMAGE} t3 ON (t1.PS_CODE = t3.PS_CODE)  ";
$_from  .= " LEFT JOIN {$TB_OP} t4 ON (t2.OP_ID = t4.OP_ID)  ";
$_from  .= " LEFT JOIN {$TB_MEMBER} t5 ON (t1.USER_ID = t5.USER_ID)  ";


$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry . $_order . $_limit);
$row_001 = $db->sql_fetch_row($res_001);

$totalnum = $row_001[0];

//$pre_status = isNull($row_002["PRE_STATUS"]) ? '대기' : $row_002["PRE_STATUS"];

unset($qry_001);
unset($res_001);
unset($row_001);
?>

<div id="content">
    <div class="sub_tit">처방전 리스트 > 처방전 리스트</div>
    <div id="cont">
        
        <div class="adm_cts">
            <h3 class="h3_title">현황 
                <span style="font-weight:20;">( 처방전 목록 : <?= number_format($totalnum) ?> 건 )</span>           
            </h3>

            <div class="adm_table_style01">

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
                            <th>담당오퍼</th>
                            <th>관리</th>
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
                            <td align="center"><?= $row_002["OP_NAME"] ?></td>
                            <td align="center">
                                <?php
                                switch ($row_002["PRE_STATUS"]) {
                                    case(""):
                                    case("1"):
                                        ?>
                                        <input type="button" style="width:100px;height:24px;background-color:#51c33a;color:white;border-radius:5px;" id="pre_status_btn"
                                               onClick="openWin('./prescription/popup_prescription_update.php?PS_CODE=<?= $row_002["PS_CODE"] ?>&OP_ID=<?= $_op["OP_ID"] ?>','preupdate',1000,800,'scrollbars=no');"
                                               value="<?= $pre_status_array[$row_002["PRE_STATUS"]] ?>" >
                                        <?
                                        break;

                                    default:
                                        ?>
                                        <input type="button" style="width:100px;height:24px;background-color:#167bd9;color:white;border-radius:5px;" id="pre_status_btn"
                                               value="<?= $pre_status_array[$row_002["PRE_STATUS"]] ?>" disabled >
                                        <?
                                }
                                ?>
                            </td>
                        </tr>

                        <?
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" height="200" align="center">목록이 없습니다.</td>
                            </tr>
                            <?
                        }
                        ?>      
                    </tbody>
                </table>

            </div>
        </div>


        <div align="center" style="padding-top:10px;height:120px;">
            <?
            $_url = "&slot=prescription&type=prescription_list";
            $paging = new paging("./op.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
            $paging->pagingArea("", "");
            ?>
        </div>

        <? $db->db_close(); ?>

    </div>
</div>
<br><br><br><br><br><br><br>

