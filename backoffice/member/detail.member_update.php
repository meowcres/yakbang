<?

include_once "../_core/_init.php";
include_once "../_core/_lib/class.attach.php";

$idx = isNull($_GET["idx"]) ? "" : $_GET["idx"];
$page = isNull($_GET["page"]) ? "" : $_GET["page"];

// 검색 변수
$search = array();
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];

// 주소이동변수
$url_opt = "&idx=" . $idx . "&page=" . $page . "&keyfield={$_search["keyfield"]}&keyword={$_search["keyword"]}&schChkDate={$_search["schChkDate"]}&schReqSDate={$_search["schReqSDate"]}&schReqEDate={$_search["schReqEDate"]}";

if ($_search["schChkDate"] == "Y") {
    $_checked = "checked";
    $_disabled = "";
} else {
    $_checked = "";
    $_disabled = "disabled";
}

$_status[$_search["status"]] = "selected";

$qry_001  = " SELECT t1.IDX, t1.*, t2.*  ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

$_from = "FROM {$TB_MEMBER} t1 ";
$_from .= "LEFT JOIN {$TB_MEMBER_INFO} t2 ON (t1.USER_ID = t2.ID_KEY) ";
$_whereqry = "WHERE t1.idx = '{$idx}' ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);


$row_001 = $db->sql_fetch_array($res_001);



?>
<div><b>○ 정보수정</b></div>
<div>
    <form id="frm" name="frm" method="post" action="./_action/member.do.php" style="display:inline;"
          target="actionForm" enctype="multipart/form-data" >
        <input type="hidden" id="Mode" name="Mode" value="member_up">
        <input type="hidden" id="idx" name="idx" value="<?= $row_001["IDX"] ?>">
        <input type="hidden" id="user_id" name="user_id" value="<?= $row_001["USER_ID"] ?>">

        <table>
            <colgroup>
                <col style="width:8%"/>
                <col style="width:10%"/>
                <col style="width:*"/>
            </colgroup>
            <tbody>
            <tr>
                <th rowspan="5">기본정보</th>
                <th>회원명</th>
                <td>
                    <input id="user_name" name="user_name" type="text" value="<?= $row_001["mm_name"]?>" class="w90p"/>
                </td>
            </tr>
            <tr>
                <th>상태</th>
                <td>
                    <select id="user_status" name="user_status" class="w100">
                        <?php
                        foreach ($member_status_array as $key => $val) {
                            $_selected = $key == $row_001["USER_STATUS"] ? "selected" : "";
                            ?>
                            <option value="<?= $key ?>" <?=$_selected?>><?= $val ?></option><?
                        }
                        ?>
                    </select> 상태
                </td>
            </tr>
            <tr>
                <th>생년월일</th>
                <td>
                    <select id="birth_year" name="birth_year" class="wid20">
                        <?php
                        for ($i = 1920; $i <= date('Y'); $i++) {
                            $select = $i == explode("-", $row_001["USER_BIRTHDAY"])[0] ? "selected" : "";
                            echo "<option value='$i' $select>$i</option>";
                        }
                        ?>
                    </select> 년 &nbsp;
                    <select id="birth_month" name="birth_month" class="wid20">
                        <?php
                        for ($i = 1; $i < 13; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == explode("-", $row_001["USER_BIRTHDAY"])[1] ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 월 &nbsp;
                    <select id="birth_day" name="birth_day" class="wid20">
                        <?
                        for ($i = 1; $i < 32; $i++) {
                            $j = sprintf("%02d", $i);
                            $select = $i == explode("-", $row_001["USER_BIRTHDAY"])[2] ? "selected" : "";
                            echo "<option value='$j' $select>$i</option>";
                        }
                        ?>
                    </select> 일 &nbsp;
                </td>
            </tr>
            <tr>
                <th>성별</th>
                <td>
                    <?php
                    $checked = $row_001["USER_SEX"] == M ? "checked" : "";

                    ?>
                    <input type="radio" id="user_sex_m" name="user_sex" value="M" <?=$row_001["USER_SEX"] == M ? "checked" : "";?>> <label
                            for="user_sex_m">남성</label> &nbsp;&nbsp;
                    <input type="radio" id="user_sex_f" name="user_sex" value="F" <?=$row_001["USER_SEX"] == F ? "checked" : "";?>> <label
                            for="user_sex_f">여성</label>
                </td>
            </tr>
            <tr>
                <th>연락처</th>
                <td>
                    <select id="phone1" name="phone1" class="w70">
                        <?
                        foreach ($phone_array as $val) {
                            $_selected = $val == explode("-", $row_001["mm_phone"])[0] ? "selected" : "";
                            ?>
                            <option value="<?= $val ?>" <?= $_selected ?>><?= $val ?></option><?
                        }
                        ?>
                    </select> -
                    <input type="text" id="phone2" name="phone2" value="<?= explode("-", $row_001["mm_phone"])[1] ?>" class="w50 onlyNumbers" maxlength="4"
                           onkeyup="passTab('phone2','phone3',4);"> -
                    <input type="text" id="phone3" name="phone3" value="<?= explode("-", $row_001["mm_phone"])[2] ?>" class="w50 onlyNumbers" maxlength="4">
                </td>
            </tr>
            </tbody>
        </table>
    </form>

    <div class="w100p center">
        <input type="button" value="정보 수정" onclick="chk_up_form();" class="Button btnGreen w120 mt10">
    </div>

</div>


<script language="JavaScript" type="text/JavaScript">

    function chk_up_form() {

        if ($("#user_name").val() == "") {
            alert("회원명을 입력 해 주십시오");
            $("#user_name").val('');
            $("#user_name").focus();
            return false;
        }

        $("#frm").submit();
    }

    //-->
</script>