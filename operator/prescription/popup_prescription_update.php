<?php

include_once "../../_core/_init.php" ;
include_once "../inc/in_top.php" ;

$ps_code = $_GET["PS_CODE"];
$op_id = $_GET["OP_ID"];

// 처방전 정보
$qry_001  = " SELECT t1.PS_STATUS, t1.PS_CODE, t1.REG_DATE, t2.PRE_STATUS, t3.PHYSICAL_NAME, t4.OP_ID";
$qry_001 .= " FROM {$TB_PS} t1 ";
$qry_001 .= " LEFT JOIN {$TB_PS_PRECLEANING} t2 ON (t1.PS_CODE = t2.PS_CODE)";
$qry_001 .= " LEFT JOIN {$TB_PS_IMAGE} t3 ON (t1.PS_CODE = t3.PS_CODE)  ";
$qry_001 .= " LEFT JOIN {$TB_OP} t4 ON (t2.OP_ID = t4.OP_ID)";
$qry_001 .= " LEFT JOIN {$TB_MEMBER} t5 ON (t1.USER_ID = t5.USER_ID)  ";
$qry_001 .= " WHERE t1.PS_CODE = '".$ps_code."' ";

$res_001  = $db->exec_sql($qry_001);
$row_001  = $db->sql_fetch_array($res_001);


// 처방전 상태를 확인 한다
if ($row_001["PS_STATUS"] != 1) {
    alert_js("alert_selfclose","정보가 옳바르지 않습니다","");
    exit;
}

if (isNull($row_001["PRE_STATUS"])) {
    $qry_002  = " INSERT INTO {$TB_PS_PRECLEANING} SET  ";
    $qry_002 .= "  PS_CODE = '".$ps_code."'  ";
    $qry_002 .= ", PRE_STATUS = 2  ";
    $qry_002 .= ", OP_ID = '".$op_id."'  ";
    $qry_002 .= ", S_DATE = now() ";

    $res_002  = $db->exec_sql($qry_002);
    $row_002  = $db->sql_fetch_array($res_002);
} else {
    if($row_001["PRE_STATUS"] == 2) {
        if ($op_id != $row_001["OP_ID"]) {
            alert_js("alert_selfclose", "해당 처방전은 다른 오퍼가 분석중입니다.", "");
            exit;
        }
    } else {
        alert_js("alert_selfclose", "해당 처방전은 이미 처리 진행이 되었습니다.", "");
        exit;
    }
}


// 처방약 정보
$_where[] = " PS_CODE = '".$ps_code."' ";
$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY IDX";

$qry_002 = "SELECT count(t1.PS_CODE) ";
$_from  = " FROM {$TB_PS_PILL} t1 ";
$_from .= " LEFT JOIN {$TB_PILL} AS t2 ON (t1.PP_TITLE = t2.IDX) ";


$res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry);
$row_002 = $db->sql_fetch_row($res_002);

$totalnum = $row_002[0];

    ?>

    <div>
        <h3 class="h3_title"><?= $pharmacy_name ?> 처방전 등록</h3>
        <form method="post" id="frm" name="frm" method="post" action="../_action/prescription.do.php" onSubmit="return chk_form(this);" target="actionForm">
        <input type="hidden" id="Mode" name="Mode" value="prescription_update">
        <input type="hidden" id="ps_code" name="ps_code" value="<?= $row_001["PS_CODE"] ?>">

        <table>
            <colgroup>
                <col style="width:40%"/>
                <col style="width:10%"/>
                <col style="width:20%"/>
                <col style="width:10%"/>
                <col style="width:20%"/>
            </colgroup>
            <tbody>
                <tr>
                    <th style="text-align:center">처방전 사진</th>
                    <th style="text-align:center" colspan="4">처방전 내역</th>
                </tr>
                
                <tr>
                    <td rowspan="4" style="text-align:center">
                        <?php
                        if (!isNull($row_001["PS_CODE"])) {
                            ?>
                                <img src="../../Web_Files/prescription/<?= $row_001["PHYSICAL_NAME"] ?>" onerror="this.src='http://yakbang.org/web/images/noimage.gif';" width="100%">
                            <?
                        }
                        ?>

                        <a href="javascript:void(0);"  onclick="window.open('../../Web_Files/prescription/<?= $row_001["PHYSICAL_NAME"] ?>','window_name','width=100%,scrollbars=yes');">                 
                        <input type="button" id="picView" value="원본보기" class="btn btn13 wid30" style="text-align:center;margin-top:10px;">                   
                    </td>
                    
                    <th style="text-align:center">처방전 코드</th>
                    <td><?= $row_001["PS_CODE"] ?></td>

                    <th style="text-align:center">요청일</th>
                    <td><?= $row_001["REG_DATE"] ?></td>
                </tr>

                <tr>
                    <th style="text-align:center">오퍼 분석</th>
                    <td align="left" colspan="3">
                        <input type="radio" id="pre_status_3" name="pre_status" value="3" <?= $row_001['PRE_STATUS'] == 3 ? "checked" : ""; ?>>&nbsp;<label for="pre_Status_3">완료</label> &nbsp;&nbsp;
                        <input type="radio" id="pre_status_5" name="pre_status" value="5" <?= $row_001['PRE_STATUS'] == 5 ? "checked" : ""; ?>>&nbsp;<label for="pre_Status_5">판독불가</label>
                    </td>    
                </tr>


                <tr>
                    <th colspan="4" style="text-align:center">
                        처방전 &nbsp;
                        <input type="button" value="약검사" onClick="openWin('./popup_pill_list.php?ps_code=<?= $ps_code ?>','pill_list',1000,800,'scrollbars=no');">
                        <!--input type="button" value="약등록" onClick="openWin('../..//backoffice/pharmacy/popup_pill_add.php','pill_register',1000,800,'scrollbars=no');"-->
                    </th>
                </tr>
                <tr height="400">
                    <td colspan="4" style="vertical-align:top;">

                        <table>
                            <colgroup>
                                <col style="width:*"/>
                                <col style="width:8%"/>
                                <col style="width:8%"/>
                                <col style="width:8%"/>
                                <col style="width:20%"/>
                                <col style="width:8%"/>
                            </colgroup>
                        
                            <tbody>
                                <tr>
                                    <th style="text-align:center">처방약</th>
                                    <th style="text-align:center">1회<br>투약량</th>
                                    <th style="text-align:center">1일<br>투여횟수</th>
                                    <th style="text-align:center">총<br>투약일수</th>
                                    <th style="text-align:center">사용법</th>
                                    <th style="text-align:center">삭제</th>
                                </tr>
           
                                <?php
                                if ($totalnum > 0) {

                                    $sql = 'SELECT t1.*, t2.PILL_NAME ';
                                    $result = $db->exec_sql($sql . $_from . $_whereqry . $_order . $_limit);

                                    while ($row_006 = $db->sql_fetch_array($result)) {
                                      ?>
                                      <tr>
                                        <td>
                                            <input type="hidden" id="idx_<?= $row_006["IDX"] ?>" name="idx_<?= $row_006["IDX"] ?>" value="<?= $row_006["IDX"] ?>" readonly>
                                            <input type="hidden" id="pp_title" name="pp_title" value="<?= $row_006["PILL_NAME"] ?>" readonly><?= $row_006["PILL_NAME"] ?>
                                        </td>
                                        <td>
                                        <input type="text" id="one_injection_<?= $row_006["IDX"] ?>" name="one_injection_<?= $row_006["IDX"] ?>" style="width:99%" 
                                        
                                        value="<?= $row_006["ONE_INJECTION"] ?>" onblur="update_pop_prescription('<?= $row_006["IDX"]?>', 'one_injection');"></td>




                                        <td><input type="text" id="day_injection_<?= $row_006["IDX"] ?>" name="day_injection_<?= $row_006["IDX"] ?>" style="width:99%" value="<?= $row_006["DAY_INJECTION"] ?>" onblur="update_pop_prescription('<?= $row_006["IDX"]?>', 'day_injection');" ></td>
                                        <td><input type="text" id="total_injection_<?= $row_006["IDX"] ?>" name="total_injection_<?= $row_006["IDX"] ?>" style="width:99%" value="<?= $row_006["TOTAL_INJECTION"] ?>" onblur="update_pop_prescription('<?= $row_006["IDX"]?>', 'total_injection');" ></td>
                                        <td><input type="text" id="pp_usage_<?= $row_006["IDX"] ?>" name="pp_usage_<?= $row_006["IDX"] ?>" style="width:99%" value="<?= $row_006["PP_USAGE"] ?>" onblur="update_pop_prescription('<?= $row_006["IDX"]?>', 'pp_usage');" ></td>



                                        <td>                
                                            <input type="button" value="삭제" onClick="pill_del('<?= $row_006["IDX"] ?>')" style="width:100%;height:24px;background-color:#ff0000;color:white;border-radius:5px;">
                                        </td>
                                      </tr>
                                      <?
                                    }

                                } else {
                                   ?>
                                   <tr>
                                      <td colspan="6" style="height:300px;text-align:center">처방된 약이 없습니다</td>
                                   </tr>
                                   <?
                                }
                                ?>    
                            </tbody>
                        </table>                   
                    </td>
                </tr>

      
            </tbody>
        </table>

        <div style="margin-top:20px;" align="center">
            <input type="submit" value="등록" class="btn btn16 wid15 mt10" style="cursor:pointer;">&nbsp;
            <input type="button" id="frmClose" value="창닫기" class="btn btn14 wid15 mt10" onClick="self.close();" style="cursor:pointer;">
        </div>
        </form>
    </div>







<script language="javascript">
function pill_del(idx) {
    if(confirm("정말로 삭제하시겠습니까?")) {
        actionForm.location.href = '../_action/prescription.do.php?Mode=delete_pill&idx=' + idx;
    }
}

function update_pop_prescription(idx, fieldn) {

    var _frm = new FormData();

    _frm.append("Mode", "update_pill_unit");
    _frm.append("p_idx", idx);
    _frm.append("p_field", fieldn.toUpperCase());
    _frm.append("p_val", $("#"+fieldn+"_"+idx).val());

    $.ajax({
        method: 'POST',
        url: '../_action/prescription.do.php',
        processData: false,
        contentType: false,
        data: _frm,
        success: function (_res) {
        }
    });

}

function chk_form(f) {
    var pre_status = $('input[name="pre_status"]:checked').val();

    if(pre_status == undefined) {
        alert("분석 결과를 선택해주시기 바랍니다");
        return false;
    }
    return true;
}

</script>


<?
include_once "../inc/in_bottom.php";
?>