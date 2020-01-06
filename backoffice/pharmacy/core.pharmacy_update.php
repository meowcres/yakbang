<?php
$pharmacy_code = isNull($_GET["pcode"]) ? "" : $_GET["pcode"];
$page = isNull($_GET["page"]) ? "" : $_GET["page"];

// 검색 변수
$search = array();
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];

// 주소이동변수
$url_opt = "&pcode=" . $pharmacy_code . "&_page=" . $_page . "&keyfield={$_search["keyfield"]}&keyword={$_search["keyword"]}&schChkDate={$_search["schChkDate"]}&schReqSDate={$_search["schReqSDate"]}&schReqEDate={$_search["schReqEDate"]}";

if ($_search["schChkDate"] == "Y") {
    $_checked = "checked";
    $_disabled = "";
} else {
    $_checked = "";
    $_disabled = "disabled";
}

$_status[$_search["status"]] = "selected";

$_pic_url = "../Web_Files/pharmcy/";

$qry_sel       = " SELECT t1.*, t2.PHYSICAL_NAME ";
$qry_from      = " FROM {$TB_PHARMACY} t1 ";
$qry_join      = " LEFT JOIN {$TB_ATTECH_FILES} t2 ON (t1.PHARMACY_CODE = t2.REFERENCE_CODE) ";
$qry_where_001 = " WHERE t1.PHARMACY_CODE = '{$pharmacy_code}' ";
$qry_where_002 = " WHERE t1.PHARMACY_CODE = '{$pharmacy_code}' AND t2.TYPE_CODE = 'logo_img' ";
$qry_where_003 = " WHERE t1.PHARMACY_CODE = '{$pharmacy_code}' AND t2.TYPE_CODE = 'pharmacy_img' ";

$qry_001 = ($qry_sel .$qry_from .$qry_join .$qry_where_001);
$qry_002 = ($qry_sel .$qry_from .$qry_join .$qry_where_002);
$qry_003 = ($qry_sel .$qry_from .$qry_join .$qry_where_003);

$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

$res_002 = $db->exec_sql($qry_002);
$row_002 = $db->sql_fetch_array($res_002);

$res_003 = $db->exec_sql($qry_003);
$row_003 = $db->sql_fetch_array($res_003);

?>

<div>
    <form id="frm" name="frm" method="post" action="./_action/pharmacy.do.php" style="display:inline;"
          target="actionForm" enctype="multipart/form-data" >
        <input type="hidden" id="Mode" name="Mode" value="pharmacy_up">
        <input type="hidden" id="idx" name="idx" value="<?= $row_001["IDX"] ?>">
        <input type="hidden" id="pharmacy_code" name="pharmacy_code" value="<?= $row_001["PHARMACY_CODE"] ?>">
        <input type="hidden" id="physical_name1" name="physical_name1" value="<?= $row_002["PHYSICAL_NAME"] ?>">
        <input type="hidden" id="physical_name2" name="physical_name2" value="<?= $row_003["PHYSICAL_NAME"] ?>">

        <table>
            <colgroup>
                <col style="width:8%"/>
                <col style="width:8%"/>
                <col style="width:40%"/>
                <col style="width:*"/>
            </colgroup>
            <tbody>
            <tr>
                <th rowspan="7">기본정보</th>
                <th>관리번호</th>
                <td colspan="2">
                    <input id="pharmacy_number" name="pharmacy_number" type="text" value="<?= $row_001["PHARMACY_NUMBER"]?>" class="w90p"/>
                </td>
            </tr>
            <tr>
                <th>약국명</th>
                <td colspan="2">
                    <input id="pharmacy_name" name="pharmacy_name" type="text" value="<?= $row_001["PHARMACY_NAME"]?>" class="w90p"/>
                </td>
            </tr>

            <tr>
                <th>상태</th>
                <td>
                    <select id="pharmacy_status" name="pharmacy_status" class="w100">
                        <?php
                        foreach ($pharmacy_status_array as $key => $val) {
                            $_selected = $key == $row_001["PHARMACY_STATUS"] ? "selected" : "";
                            ?>
                            <option value="<?= $key ?>" <?=$_selected?>><?= $val ?></option><?
                        }
                        ?>
                    </select> 상태
                </td>
                <td rowspan="6" class="center">
                    <div id="map" class="w90p h200"></div>
                </td>
            </tr>

            <tr>
                <th>약국 주소</th>
                <td>
                    <input id="zipcode" name="zipcode" type="text" value="<?= $row_001["ZIPCODE"]?>" class="w70" readonly/> 
                    <input type="button" value="주소검색" class="Small_Button btnOrange" onclick="daumPostcode()"> <br>
                    <input id="address" name="address" type="text" value="<?= $row_001["ADDRESS"]?>" class="w90p mt5" readonly/><br>
                    <input id="address_ext" name="address_ext" type="text" value="<?= $row_001["ADDRESS_EXT"]?>" class="w90p mt5"/>
                </td>
            </tr>

            <tr>
                <th>GPS</th>
                <td>
                    위도 - <input type="text" id="latitude"   name="latitude"   value="<?= $row_001["LATITUDE"]?>" class="w150" readonly /> &nbsp;&nbsp;
                    경도 - <input type="text" id="longtitude" name="longtitude" value="<?= $row_001["LONGTITUDE"]?>" class="w150" readonly />
                </td>
            </tr>

            <tr>
                <th>약국 연락처</th>
                <td>
                    <select id="phone1" name="phone1" class="w70">
                        <?
                        foreach ($phone_array as $val) {
                            $_selected = $val == explode("-", $row_001["PHARMACY_PHONE"])[0] ? "selected" : "";
                            ?>
                            <option value="<?= $val ?>" <?= $_selected ?>><?= $val ?></option><?
                        }
                        ?>
                    </select> -
                    <input type="text" id="phone2" name="phone2" value="<?= explode("-", $row_001["PHARMACY_PHONE"])[1] ?>" class="w50 onlyNumbers" maxlength="4"
                           onkeyup="passTab('phone2','phone3',4);"> -
                    <input type="text" id="phone3" name="phone3" value="<?= explode("-", $row_001["PHARMACY_PHONE"])[2] ?>" class="w50 onlyNumbers" maxlength="4">
                </td>
            </tr>

            <tr>
                <th>약국 이메일</th>
                <td>
                    <input id="emailID" name="emailID" type="text" value="<?= explode("@", $row_001["PHARMACY_EMAIL"])[0] ?>" class="w220"/> @
                    <input id="emailDomain" name="emailDomain" value="<?= explode("@", $row_001["PHARMACY_EMAIL"])[1] ?>" type="text" class="w150"/>
                    <select id="selectDomin" name="selectDomin" class="wid30"
                            onChange="document.getElementById('emailDomain').value = this.value; ">
                        <option value="">직접입력</option>
                        <?php
                        foreach ($email_array as $k => $v) {
                            echo "<option value='{$v}'>{$v}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>            

            </tbody>
        </table>

        

        <table>
        <colgroup>
                <col style="width:8%"/>
                <col style="width:8%"/>
                <col style="width:*"/>
            </colgroup>
          <tr>
                <th rowspan="2">이미지 정보</th>
                <th>LOGO IMAGE</th>
                <td>
<?php
    if (!isNull($row_002["PHYSICAL_NAME"])) {
?>
                <div style="padding:10px;">
                    <img src="<?=$_pic_url.$row_002["PHYSICAL_NAME"]?>" width="300">
                </div>
                <div style="padding:10px 0;">
                    <input type="checkbox" id="del_file1" name="del_file1" value="Y"/>
                    <label for="del_file1">LOGO IMAGE 삭제</label>
                </div>
<?php
    } else {
?>
        <input type="file" id="logo_img" class="uploadBtn" name="logo_img" style="width:80%;">
<?php
    }
?>
        </td>
          </tr>
          <tr>
                <th>약국 IMAGE</th>
                <td>
<?php
    if (!isNull($row_003["PHYSICAL_NAME"])) {
?>
                <div style="padding:10px;">
                    <img src="<?=$_pic_url.$row_003["PHYSICAL_NAME"]?>" width="300">
                </div>
                <div style="padding:10px 0;">
                    <input type="checkbox" id="del_file2" name="del_file2" value="Y"/>
                    <label for="del_file2">약국 IMAGE 삭제</label>
                </div>
<?php
    } else {
?>
        <input type="file" id="pharmacy_img" class="uploadBtn" name="pharmacy_img" style="width:80%;">
<?php
    }
?>
                </td>
            </tr>
        </table>



        <table>
        <colgroup>
                <col style="width:8%"/>
                <col style="width:8%"/>
                <col style="width:38%"/>
                <col style="width:8%"/>
                <col style="width:38%"/>
            </colgroup>
          <tr>
                <th>추가 정보</th>
                <th>영업시간</th>
                <td>
                    <textarea id="operation_hours" name="operation_hours" class="w90p h150"><?= $row_001["OPERATION_HOURS"]?></textarea>
                </td>
                <th>약국소개</th>
                <td>
                    <textarea id="introduction" name="introduction" class="w90p h150"><?= $row_001["INTRODUCTION"]?></textarea>
                </td>
            </tr>
        </table>


        <table>
        <colgroup>
                <col style="width:8%"/>
                <col style="width:8%"/>
                <col style="width:*"/>
            </colgroup>
          <tr>
                <th>관리 정보</th>
                <th>관리 메모</th>
                <td>
                    <textarea id="admin_cmt" name="admin_cmt" class="w90p h150"><?= $row_001["ADMIN_CMT"]?></textarea>
                </td>
            </tr>
        </table>

    </form>

    <div class="w100p center">
    <input type="button" value="정보 수정" onclick="chk_up_form();" class="Button btnGreen w120 mt10">
    </div>

</div>


<script language="JavaScript" type="text/JavaScript">

    function chk_up_form() {

        if ($("#pharmacy_name").val() == "") {
            alert("약국의 이름을 입력 해 주십시오");
            $("#pharmacy_name").val('');
            $("#pharmacy_name").focus();
            return false;
        }

        if ($("#zipcode").val() == "") {
            alert("약국주소 검색을 진행 해 주십시오");
            return false;
        }

        $("#frm").submit();

    }

    //-->
</script>
<script>


    function daumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {

                document.getElementById('zipcode').value = data.zonecode;
                document.getElementById("address").value = data.roadAddress;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("address_ext").focus();
                document.getElementById('address_ext').select();

                // 주소로 상세 정보를 검색
                geocoder.addressSearch(data.address, function(results, status) {
                    // 정상적으로 검색이 완료됐으면
                    if (status === daum.maps.services.Status.OK) {

                        var result = results[0]; //첫번째 결과의 값을 활용

                        $("#longtitude").val(result.x);
                        $("#latitude").val(result.y);

                        // 해당 주소에 대한 좌표를 받아서
                        var coords = new daum.maps.LatLng(result.y, result.x);
                        // 지도를 보여준다.
                        mapContainer.style.display = "block";
                        map.relayout();
                        // 지도 중심을 변경한다.
                        map.setCenter(coords);
                        // 마커를 결과값으로 받은 위치로 옮긴다.
                        marker.setPosition(coords)
                    }
                });
            }
        }).open();
    }
</script>