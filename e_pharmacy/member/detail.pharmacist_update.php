<h3 class="h3_title">정보수정</h3>
<div class="adm_table_style01">
    <form id="frm" name="frm" method="post" action="./_action/member.do.php" style="display:inline;"
          target="actionForm" enctype="multipart/form-data">
        <input type="hidden" id="Mode" name="Mode" value="member_up">
        <input type="hidden" id="idx" name="idx" value="<?= $_pharmacist["idx"] ?>">
        <input type="hidden" id="user_id" name="user_id" value="<?= $row_001["ID_KEY"] ?>">
        <input type="hidden" id="mm_id" name="mm_id" value="<?= $_pharmacist["id"] ?>">
        <input type="hidden" id="license_img" name="license_img" value="<?= $license_img["PHYSICAL_NAME"] ?>">
        <input type="hidden" id="pharmacist_img" name="pharmacist_img" value="<?= $pharmacist_img["PHYSICAL_NAME"] ?>">
        <table>
            <colgroup>
                <col style="width:10%"/>
                <col style="width:15%"/>
                <col style="width:*"/>
            </colgroup>
            <tbody>
            <tr>
                <th rowspan="5">기본 정보</th>
                <th>약사명</th>
                <td>
                    <input id="user_name" name="user_name" type="text" value="<?= $_pharmacist["name"] ?>"/>
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
                    <input type="radio" id="user_sex_m" name="user_sex"
                           value="M" <?= $row_001["USER_SEX"] == M ? "checked" : ""; ?>> <label
                            for="user_sex_m">남성</label> &nbsp;&nbsp;
                    <input type="radio" id="user_sex_f" name="user_sex"
                           value="F" <?= $row_001["USER_SEX"] == F ? "checked" : ""; ?>> <label
                            for="user_sex_f">여성</label>
                </td>
            </tr>
            <tr>
                <th>약사연락처</th>
                <td>
                    <select id="phone1" name="phone1" class="wid20">
                        <?
                        foreach ($phone_array as $val) {
                            $_selected = $val == explode("-", $row_001["phone"])[0] ? "selected" : "";
                            ?>
                            <option value="<?= $val ?>" <?= $_selected ?>><?= $val ?></option><?
                        }
                        ?>
                    </select>&nbsp;&nbsp;-&nbsp;&nbsp;
                    <input type="text" id="phone2" name="phone2" class="wid20"
                           value="<?= explode("-", $row_001["phone"])[1] ?>" maxlength="4"
                           onkeyup="passTab('phone2','phone3',4);">&nbsp;&nbsp;-&nbsp;&nbsp;
                    <input type="text" id="phone3" name="phone3" class="wid20"
                           value="<?= explode("-", $row_001["phone"])[2] ?>" maxlength="4">
                </td>
            </tr>
            <tr>
                <th>약사 이미지</th>
                <td>
                    <?php
                    if (!isNull($pharmacist_img["PHYSICAL_NAME"])) {
                        ?>
                        <div style="padding:10px;">
                            <img src="../Web_Files/pharmacist/<?= $pharmacist_img["PHYSICAL_NAME"] ?>"
                                 width="100">
                        </div>
                        <div style="padding:10px 0;">
                            <input type="checkbox" id="del_pharmacist" name="del_pharmacist"
                                   value="<?= $pharmacist_img["PHYSICAL_NAME"] ?>"/>
                            <label for="del_pharmacist">약사 이미지 삭제</label>
                        </div>
                        <?
                    } else {
                        ?>
                        약사 이미지 없음
                    <? } ?>
                    <div style="padding:10px 0;">
                        <input type="hidden" id="hidden_pharmacist" name="hidden_pharmacist"
                               value="<?= $pharmacist_img["PHYSICAL_NAME"] ?>"/>
                        <input type="file" id="up_pharmacist" name="up_pharmacist" value="" class="wid50">

                    </div>
                </td>
            </tr>
            <tr>
                <th rowspan="2">약사 면허 정보</th>
                <th>약사면허</th>
                <td><input id="license_number" name="license_number" type="text"
                           value="<?= $row_001["LICENSE_NUMBER"] ?>"></td>
            </tr>
            <tr>
                <th>라이센스 이미지</th>
                <td>
                    <?php
                    if (!isNull($license_img["PHYSICAL_NAME"])) {
                        ?>
                        <div style="padding:10px;">
                            <img src="../Web_Files/pharmacist_license/<?= $license_img["PHYSICAL_NAME"] ?>"
                                 width="200">
                        </div>
                        <div style="padding:10px 0;">
                            <input type="checkbox" id="del_license" name="del_license"
                                   value="<?= $license_img["PHYSICAL_NAME"] ?>"/>
                            <label for="del_license">라이센스 이미지 삭제</label>
                        </div>
                        <?
                    } else {
                        ?>
                        라이센스 이미지 없음
                    <? } ?>
                    <div style="padding:10px 0;">
                        <input type="hidden" id="hidden_license" name="hidden_license"
                               value="<?= $license_img["PHYSICAL_NAME"] ?>"/>
                        <input type="file" id="up_license" name="up_license" value="" class="wid50">

                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </form><br>
    <div class="btn_area t_c">
        <input type="button" value="정보 수정" onclick="chk_up_form();" class="btn_b btn21">
    </div>
</div>

<script language="JavaScript" type="text/JavaScript">

    function chk_up_form() {

        if ($("#user_name").val() == "") {
            alert("약사명을 입력 해 주십시오");
            $("#user_name").val('');
            $("#user_name").focus();
            return false;
        }

        $("#frm").submit();
    }

    //-->
</script>