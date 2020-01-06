<?

$pill_qry = " SELECT COUNT(PS_CODE) ";
$pill_from .= " FROM {$TB_PS_PILL} AS t1 ";
$pill_from .= " LEFT JOIN {$TB_PILL} AS t2 ON (t1.PP_TITLE = t2.IDX) ";
$pill_from .= " WHERE t1.PS_CODE = '{$ps_code}' ";
$pill_res = $db->exec_sql($pill_qry.$pill_from);
$pill_row = $db->sql_fetch_row($pill_res);

$total_pill = $pill_row[0];

?>

<div class="titNtxt" style="content:''; top:0; dispaly: block; clear: both;">
    <h3 class="h3_title" style="display:inline-block">처방약 등록</h3>

    <div style="display:inline-block; float:right;">
     <input type="button" value="약검사" onClick="openWin('./prescription/popup_pill_list.php?ps_code=<?=$ps_code?>&pharmacy_code=<?=$row_001["PHARMACY_CODE"]?>','pill_list',1000,800,'scrollbars=no');" class="btn_s btn15">
      <!--input type="button" value="약등록" onClick="openWin('../../backoffice/pharmacy/popup_pill_add.php','pill_register',1000,260,'scrollbars=no');" class="btn_s btn15"-->
    </div>
</div> 

<div class="adm_table_style02">
    <table>
        <colgroup>
            <col width="20%"/>
            <col width="5%"/>
            <col width="6%"/>
            <col width="6%"/>
            <col width="30%"/>
            <col width="*"/>
            <col width="12%"/>
        </colgroup>
        <tr>
            <th>약품명</th>
            <th>1회<br>투약량</th>
            <th>1일<br>투여횟수</th>
            <th>총 <br>투약일수</th>
            <th>사용법</th>
            <th>대체복약 내용</th>
            <th>관리</th>
        </tr>

        <?php
        if ($total_pill> 0) {
            $pill_sql = " SELECT t1.*, t2.PILL_NAME ";
            $result_pill = $db->exec_sql($pill_sql.$pill_from);
            while ($row_pill = $db->sql_fetch_array($result_pill)) {

            ?>
            <tr>
                <td align="center">
                    <?php 
                        if ($row_pill["PILL_NAME"] == "") {
                            echo $row_pill["PP_TITLE"];
                        } else {
                            echo $row_pill["PILL_NAME"];
                        }     
                    ?>                
                </td>

                <td align="center">
                    <input type="text" id="one_injection_<?= $row_pill["IDX"] ?>" name="one_injection_<?= $row_pill["IDX"] ?>" style="width:99%" value="<?= $row_pill["ONE_INJECTION"] ?>" 
                           onblur="update_pop_prescription('<?= $row_pill["IDX"]?>', 'one_injection');">
                </td>

                <td align="center">
                    <input type="text" id="day_injection_<?= $row_pill["IDX"] ?>" name="day_injection_<?= $row_pill["IDX"] ?>" style="width:99%" value="<?= $row_pill["DAY_INJECTION"] ?>" 
                           onblur="update_pop_prescription('<?= $row_pill["IDX"]?>', 'day_injection');">
                </td>

                <td align="center">
                    <input type="text" id="total_injection_<?= $row_pill["IDX"] ?>" name="total_injection_<?= $row_pill["IDX"] ?>" style="width:99%" value="<?= $row_pill["TOTAL_INJECTION"] ?>" 
                           onblur="update_pop_prescription('<?= $row_pill["IDX"]?>', 'total_injection');">
                </td>

                <td align="center">
                    <input type="text" id="pp_usage_<?= $row_pill["IDX"] ?>" name="pp_usage_<?= $row_pill["IDX"] ?>" style="width:99%" value="<?= $row_pill["PP_USAGE"] ?>" 
                           onblur="update_pop_prescription('<?= $row_pill["IDX"]?>', 'pp_usage');">
                </td>

                <td align="center">
                    <input type="text" id="pp_cmt_<?= $row_pill["IDX"] ?>" name="pp_cmt_<?= $row_pill["IDX"] ?>" style="width:99%" value="<?= $row_pill["PP_CMT"] ?>" 
                           onblur="update_pop_prescription('<?= $row_pill["IDX"]?>', 'pp_cmt');">
                </td>

                <td align="center">
                    <?php
                    switch ($row_pill["PP_TYPE"]) {
                        case("2"):
                            ?>
                            <a href="javascript:void(0);" onclick="del_pill('<?= $row_pill["IDX"] ?>', '<?= $row_pill["PS_CODE"] ?>');" class="btn_s btn14">삭제</a>
                            <?
                            break;

                        default:
                            ?>
                            <a href="javascript:void(0);" onclick="openWin('./prescription/popup_prescription_update.php?idx=<?=$row_pill["IDX"]?>&ps_code=<?=$row_pill["PS_CODE"]?>&pharmacy_code=<?=$row_001["PHARMACY_CODE"]?> ', 
                                    'prescription_update',1000,400,'scrollbars=yes')" class="btn_s btn13">대체복약</a>&nbsp;
                            <a href="javascript:void(0);" onclick="del_pill('<?= $row_pill["IDX"] ?>', '<?= $row_pill["PS_CODE"] ?>');" class="btn_s btn14">삭제</a>
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
                <td colspan="8" height="200" align="center">목록이 없습니다.</td>
            </tr>
            <?
        }
        ?> 

    </table>
</div>
<script>

function update_pop_prescription(idx, fieldn) {

    var _frm = new FormData();

    _frm.append("Mode", "update_pill_unit");
    _frm.append("p_idx", idx);
    _frm.append("p_field", fieldn.toUpperCase());
    _frm.append("p_val", $("#"+fieldn+"_"+idx).val());

    $.ajax({
        method: 'POST',
        url: './_action/prescription.do.php',
        processData: false,
        contentType: false,
        data: _frm,
        success: function (_res) {
        }
    });

}

function del_pill(idx, ps_code) {
    if (confirm("정말 삭제하시겠습니까? \n\n 삭제 후에는 복구가 불가능합니다.")) {
        actionForm.location.href = "./_action/prescription.do.php?Mode=del_pill&idx=" + idx + "&ps_code=" + ps_code;
    }
}

</script>