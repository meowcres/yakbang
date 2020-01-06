<?php
include_once "../_core/_lib/class.attach.php";

$ps_code = $_REQUEST["ps_code"];

// 리스트 조건절
$qry_where_array[] = "t1.PHARMACY_CODE = '{$_pharmacy["code"]}' AND t1.PS_CODE = '{$ps_code}' ";

$qry_where = count($qry_where_array) ? " WHERE " . implode(' AND ', $qry_where_array) : "";
$qry_order = " ORDER BY t2.REG_DATE DESC";
$qry_limit = " LIMIT " . $startNum . "," . $offset;

$qry_001 = "SELECT t1.*, t2.*, t3.*, t4.PHYSICAL_NAME, t1.IDX AS idx ";
$qry_001 .= ", CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
$qry_001 .= ", t2.REG_DATE AS date ";

$qry_from = "FROM {$TB_PS_PHARMACY} t1 ";
$qry_from .= "LEFT JOIN {$TB_PS} t2 ON (t1.PS_CODE = t2.PS_CODE) ";
$qry_from .= "LEFT JOIN {$TB_MEMBER} t3 ON (t2.USER_ID = t3.USER_ID) ";
$qry_from .= "LEFT JOIN {$TB_PS_IMAGE} t4 ON (t2.PS_CODE = t4.PS_CODE)  ";

$res_001 = $db->exec_sql($qry_001 . $qry_from . $qry_where);
$row_001 = $db->sql_fetch_array($res_001);

?>

<div id="content">
    <div class="sub_tit">처방전관리 > 처방전목록 > 처방전상세</div>
    <div id="cont">
        <div class="adm_cts">
            <h3 class="h3_title">처방전 정보</h3>
            <div class="adm_table_style01">
                <table>
                    <colgroup>
                        <col style="width:10%"/>
                        <col style="width:15%"/>
                        <col style="width:35%"/>
                        <col style="width:15%"/>
                        <col style="width:*"/>
                    </colgroup>
                    <tbody>

                    <tr>
                        <th rowspan="8">기본 정보</th>
                        <th>회원명</th>
                        <td><?= $row_001["mm_name"] ?></td>
                        <th rowspan="8">처방전 사진</th>
                        <td rowspan="8">
                            <img src="../../Web_Files/prescription/<?= $row_001["PHYSICAL_NAME"] ?>" onerror="this.src='http://yakbang.org/web/images/noimage.gif';" width="100%">
                            <a href="javascript:void(0);"  onclick="window.open('../../Web_Files/prescription/<?= $row_001["PHYSICAL_NAME"] ?>','window_name','width=100%,scrollbars=yes');">                 
                            <input type="button" id="picView" value="원본보기" class="btn btn13 wid30" style="text-align:center;margin-top:10px;">                                                        
                        </td>
                    </tr>
                    <!--<tr>
                        <th>회원 상태</th>
                        <td><? /*= $member_status_array[$row_001["USER_STATUS"]] */ ?></td>
                    </tr>-->
                    <tr>
                        <th>처방전 코드</th>
                        <td><?= $row_001["PS_CODE"] ?></td>
                    </tr>
                    <tr>
                        <th>처방전 상태</th>
                        <td>
                            <!--<select id="a_status" name="a_status" class="wid20">
                                <option value="1" <?php /*if ($row_001["A_STATUS"] == 1) {
                                    echo "selected";
                                } */ ?>>신청중
                                </option>
                                <option value="2" <?php /*if ($row_001["A_STATUS"] == 2) {
                                    echo "selected";
                                } */ ?>>조제가능
                                </option>
                                <option value="3" <?php /*if ($row_001["A_STATUS"] == 3) {
                                    echo "selected";
                                } */ ?>>대체조제
                                </option>
                                <option value="4" <?php /*if ($row_001["A_STATUS"] == 4) {
                                    echo "selected";
                                } */ ?>>조제불가
                                </option>
                            </select>
                            <input type="button" id="up_status" name="up_status" value="변경"
                                   onclick="up_status('<? /*= $row_001["idx"] */ ?>');">-->
                            <input type="button" class="btn_s btn13" onclick="up_status('<?= $row_001["idx"] ?>', '2');"
                                   value="조제가능">&nbsp;
                            <input type="button" class="btn_s btn13" onclick="up_status('<?= $row_001["idx"] ?>', '3');"
                                   value="대체조제">&nbsp;
                            <input type="button" class="btn_s btn14" onclick="up_status('<?= $row_001["idx"] ?>', '4');"
                                   value="조제불가">
                        </td>
                    </tr>
                    <tr>
                        <th>처방전 타입</th>
                        <td><?= $prescription_type_array[$row_001["SEND_TYPE"]] ?></td>
                    </tr>
                    <tr>
                        <th>등록일</th>
                        <td><?= $row_001["date"] ?></td>
                    </tr>
                    <tr>
                        <th>수정일</th>
                        <td><?= $row_001["UP_DATE"] ?></td>
                    </tr>
                    <tr>
                        <th>완료일</th>
                        <td><?= $row_001["COMPLETE_DATE"] ?></td>
                    </tr>
                    </tbody>
                </table>

                <!--<div class="mt30 mb10">
                    <input type="button" value="목록으로" class="btn btn01"
                           onClick="location.href='./pharmacy.template.php?slot=prescription&type=prescription_list<? /*= $url_opt */ ?>'">&nbsp;
                    <? /*
                    foreach ($prescription_menu_array as $key => $val) {
                        $_btn_class = $key == $_step ? "btn21" : "btn01";
                        */ ?><input type="button" value="<? /*= $val */ ?>" class="btn <? /*= $_btn_class */ ?>"
                                 onClick="location.href='./pharmacy.template.php?slot=prescription&type=prescription_detail&step=<? /*= $key . $url_opt */ ?>'">&nbsp;&nbsp;<? /*
                    }
                    */ ?>
                </div>-->
                <br><br>

                <div>
                    <?
                    if (!isNull($_step)) {
                        //echo $_step ;
                        include_once "./prescription/detail.prescription_{$_step}.php";
                    }
                    ?>
                </div>
                <div class="btn_area t_c">
                    <input type="button" value="목록으로" class="btn_b btn01"
                           onClick="location.href='./pharmacy.template.php?slot=prescription&type=prescription_list<?= $url_opt ?>'">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function up_status(idx, a_status) {
        if (confirm("변경하시겠습니까?")) {
            location.href = "./_action/prescription.do.php?Mode=up_status&idx=" + idx + "&a_status=" + a_status;
        }
    }
</script>