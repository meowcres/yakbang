<?
include_once "../../_core/_init.php" ;
include_once "../../_core/_common/var.admin.php" ;
include_once "../inc/in_top.php" ;

if (isNull($_GET["idx"])) {
    alert_js("alert_selfclose","정보가 정확하지 않습니다","");
    exit;
}else{
    $idx_key = $_GET["idx"];
    $p_code = $_GET["p_code"];

    $pharmacy_qry = "SELECT PHARMACY_NAME FROM {$TB_PHARMACY} WHERE PHARMACY_CODE='{$p_code}'";
    $pharmacy_res = $db->exec_sql($pharmacy_qry);
    $pharmacy_row = $db->sql_fetch_array($pharmacy_res);

    $pharmacy_name = clear_escape($pharmacy_row["PHARMACY_NAME"]);
}

$qry_001  = " SELECT t1.REG_DATE as R_DATE , t1.*, t2.*, t3.*  ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";
$qry_001 .= " FROM {$TB_PP} t1 " ;
$qry_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON (t1.USER_ID = t2.USER_ID) " ;
$qry_001 .= " LEFT JOIN {$TB_MEMBER_INFO} t3 ON (t1.USER_ID = t3.ID_KEY) " ;
$qry_001 .= " WHERE t1.IDX = '{$idx_key}' " ;

$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

$member_sex = $row_001["USER_SEX"] == "M" ? "남성" : "여성" ;
$member_age = date("Y") - substr($row_001["USER_BIRTHDAY"],0,4) ;
?>

    <div class="adm_table_style02">
        <h3 class="h3_title "><?=$pharmacy_name?> 전문약사 정보관리</h3>
        <form id="sfrm" name="sfrm" method="POST" action="../_action/pharmacist.do.php" target="actionForm">
            <input type="hidden" id="Mode" name="Mode" value="up_pharmacist">
            <input type="hidden" id="idx" name="idx" value="<?=$idx_key?>">
            <div>&nbsp;○ 등록일 : <?= $row_001["R_DATE"] ?></div>
            <table>
                <colgroup>
                    <col style="width:10%" />
                    <col style="width:15%" />
                    <col style="width:30%" />
                    <col style="width:15%" />
                    <col style="width:30%" />
                </colgroup>
                <tbody>
                <tr>
                    <th rowspan="3">약사정보</th>
                    <th>약사번호</th>
                    <td colspan="3"><?= $row_001["LICENSE_NUMBER"] ?></td>
                </tr>
                <tr>
                    <th>상태</th>
                    <td>
                        <select id="p_status" name="p_status">
                            <option value="1" <?= $row_001["P_STATUS"] == 1 ? "selected" : "" ?>>약사활동</option>
                            <option value="4" <?= $row_001["P_STATUS"] == 4 ? "selected" : "" ?>>활동정지</option>
                        </select>
                    <th>등급</th>
                    <td>
                        <select id="p_grade" name="p_grade">
                            <?php
                            foreach ($pharmacist_grade_array as $key => $val) {
                                $_selected = $key == $row_001["P_GRADE"] ? "selected" : "" ;
                                ?><option value="<?=$key?>" <?=$_selected?>><?= $val?></option>
                                <?
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>유지기간</th>
                    <td colspan="3">
                        <?= $row_001["S_DATE"] ?> ~ <?= $row_001["E_DATE"] ?>
                    </td>
                </tr>
                <tr>
                    <th rowspan="2">회원정보</th>
                    <th>아이디</th>
                    <td><?= $row_001["mm_id"] ?></td>
                    <th>이름</th>
                    <td><?= clear_escape($row_001["mm_name"]) ?> ( <?=$member_sex?> / <?=$member_age?> )</td>
                </tr>
                <tr>
                    <th>연락처</th>
                    <td><?= clear_escape($row_001["mm_phone"]) ?></td>
                    <th>생년월일</th>
                    <td><?= $row_001["USER_BIRTHDAY"] ?></td>
                </tr>
                </tbody>
            </table>
            <div class="center w100p">
                <input type="submit" value="정보수정" class="btn btn16 w100 mt10"> &nbsp;
                <input type="button" value="창닫기" onClick="self.close();" class="btn btn03 w100 mt10">
            </div>
        </form>
    </div>

    <script>
        <!--
        function del_pp(idx){
            if(confirm("전문약사를 제외 시키겠습니까?")){
                var url = "../_action/pharmacy.do.php?Mode=del_pharmacist_popup&idx="+idx ;
                actionForm.location.href=url ;
            }
        }


        $(document).ready(function () {
            var dates = $("#s_date, #e_date").datepicker({
                dateFormat: 'yy-mm-dd',
                changeYear: true,
                changeMonth: true,
                showMonthAfterYear: true,
                onSelect: function (selectedDate) {
                    var option = this.id == "s_date" ? "minDate" : "maxDate",
                        instance = $(this).data("datepicker"),
                        date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                    dates.not(this).datepicker("option", option, date);
                }
            });

        });




        //-->
    </script>

<?
include_once "../inc/in_bottom.php";
?>