<?php

$qry_sel = " SELECT t1.* ";
$qry_from = " FROM {$TB_PHARMACY} t1 ";
$qry_where = " WHERE t1.PHARMACY_CODE = '{$pharmacy_code}' ";

$qry_001 = ($qry_sel . $qry_from . $qry_where);

$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

?>

<div>
    <div style="float:left;width:40%">
        <form id="frm" name="frm" method="post" action="./_action/pharmacy.do.php" style="display:inline;" target="actionForm" enctype="multipart/form-data">
            <input type="hidden" id="Mode" name="Mode" value="pharmacy_ykiho_regist">
            <input type="hidden" id="pharmacy_code" name="pharmacy_code" value="<?= $row_001["PHARMACY_CODE"] ?>">

            <table>
                <colgroup>
                    <col style="width:17%"/>
                    <col style="width:*"/>
                </colgroup>

                <tbody>
                <tr>
                    <th>심평원 번호</th>
                    <td>
                        <input id="ykiho_number" name="ykiho_number" type="text" value="<?= $row_001["YKIHO"] ?>"
                               style="width:90%"/>&nbsp;&nbsp;
                        <input type="button" value="등록" onclick="chk_up_form();" class="Small_Button btnGreen w80">
                    </td>
                </tr>
                </tbody>
            </table>

        </form>
    </div>

    <div style="float:right;width:58%">
        <iframe src="./pharmacy/in_hira_pharmacy_list.php" frameborder="0" scrolling="no" style="width:100%;height:720px;"></iframe>
    </div>
</div>


<script language="JavaScript" type="text/JavaScript">

    function chk_up_form() {

        if ($("#ykiho_number").val() == "") {
            alert("심평원 번호를 입력 해 주십시오");
            $("#ykiho_number").focus();
            return false;
        }

        $("#frm").submit();

    }

    //-->
</script>
