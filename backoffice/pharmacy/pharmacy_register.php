<?php
$pharmacy_code = "py".mktime();
?>
<div id="Contents">
    <h1>약국관리 &gt; 약국 관리 &gt; <strong>약국 등록</strong></h1>

    <div><b>○ 약국 정보</b></div>

    <form name="frm" method="post" enctype="multipart/form-data" action="./_action/pharmacy.do.php"
          onSubmit="return chk_form(this);" style="display:inline;" target="actionForm">
        <input type="hidden" id="Mode" name="Mode" value="pharmacy_add">
        <input type="hidden" id="pharmacy_code" name="pharmacy_code" value="<?=$pharmacy_code?>">
        <table class="tbl1">
            <colgroup>
                <col width="12%"/>
                <col width="38%"/>
                <col width="12%"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>관리번호</th>
                <td class="left">
                    <input id="pharmacy_number" name="pharmacy_number" type="text" class="w90p"/>
                </td>
                <th>약국상태</th>
                <td class="left">
                    <select id="pharmacy_status" name="pharmacy_status" class="w100">
                        <?php
                        foreach ($pharmacy_status_array as $key => $val) {
                            ?>
                            <option value="<?= $key ?>" <?= $key == 4 ? "selected" : "" ?> > <?= $val ?> </option><?
                        }
                        ?>
                    </select> 상태
                </td>
            </tr>


            <tr>
                <th>약국명</th>
                <td class="left" colspan="3">
                    <input id="pharmacy_name" name="pharmacy_name" type="text" class="w90p"/>
                </td>
            </tr>
            
            
            <tr>
                <th>주소</th>
                <td class="left">
                    <input id="zipcode" name="zipcode" type="text" class="w70" readonly/> 
                    <input type="button" value="주소검색" class="Small_Button btnOrange" onclick="daumPostcode()"> <br>
                    <input id="address" name="address" type="text" class="w90p mt5" readonly/><br>
                    <input id="address_ext" name="address_ext" type="text" class="w90p mt5"/>
                </td>
                <th rowspan="4">위치(지도)</th>
                <td class="left" rowspan="4">
                  <div id="map" class="w90p h200" style="display:none;"></div>
                </td>
            </tr>


            <tr>
                <th>GPS</th>
                <td>
                    위도 - <input type="text" value="" id="latitude"   name="latitude"   class="w150" readonly /> &nbsp;&nbsp;
                    경도 - <input type="text" value="" id="longtitude" name="longtitude" class="w150" readonly />
                </td>
            </tr>

            <tr>
                <th>약국 연락처</th>
                <td>
                    <select id="phone1" name="phone1" class="w70">
                        <?
                        foreach ($phone_array as $val) {
                            
                            ?>
                            <option value="<?= $val ?>" ><?= $val ?></option><?
                        }
                        ?>
                    </select> -
                    <input type="text" id="phone2" name="phone2" value="" class="w50 onlyNumbers" maxlength="4"
                           onkeyup="passTab('phone2','phone3',4);"> -
                    <input type="text" id="phone3" name="phone3" value="" class="w50 onlyNumbers" maxlength="4">
                </td>
            </tr>
            <tr>
                <th>약국 메일</th>
                <td>
                    <input id="emailID" name="emailID" type="text" class="w220"/> @
                    <input id="emailDomain" name="emailDomain" type="text" class="w150"/>
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
            <tr>
                <th>운영시간</th>
                <td>
                      <textarea id="operation_hours" name="operation_hours" class="w90p h150"></textarea>
                </td>
                <th>약국소개</th>
                <td>
                      <textarea id="introduction" name="introduction" class="w90p h150"></textarea>
                </td>
            </tr>
        </table>

        <div class="mt10"><b>○ 이미지 정보</b></div>
        <table class="tbl1">
            <colgroup>
                <col width="12%"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>약국 로고</th>
                <td class="left">
                    <input type="file" id="logo_img" name="logo_img" class="w70p"/>
                </td>
            </tr>

            <tr>
                <th>약국 이미지</th>
                <td class="left">
                    <input type="file" id="pharmacy_img" name="pharmacy_img" class="w70p"/>
                </td>
            </tr>
       </table>


       <div class="mt10"><b>○ 관리자 참고 정보</b></div>
        <table class="tbl1">
            <colgroup>
                <col width="12%"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>참고 정보</th>
                <td class="left">
                    <textarea id="admin_cmt" name="admin_cmt" class="w90p h150"></textarea>
                </td>
            </tr>
       </table>

        <div style="margin-top:20px;" class="center">
            <input type="submit" value="등록" class="Button btnGreen w100"> &nbsp;
            <input type="button" value="취소" class="Button btnRed w100" onClick="history.back();">
        </div>
    </form>

</div>




<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=aae9bbac4d27fc532a36565aae5cbc80&libraries=services"></script>
<script>
    var mapContainer = document.getElementById('map'), // 지도를 표시할 div
        mapOption = {
            center: new daum.maps.LatLng(37.537187, 127.005476), // 지도의 중심좌표
            level: 5 // 지도의 확대 레벨
        };

    //지도를 미리 생성
    var map = new daum.maps.Map(mapContainer, mapOption);
    //주소-좌표 변환 객체를 생성
    var geocoder = new daum.maps.services.Geocoder();
    //마커를 미리 생성
    var marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(37.537187, 127.005476),
        map: map
    });


    function daumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {

                document.getElementById('zipcode').value = data.zonecode;
                document.getElementById("address").value = data.roadAddress;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("address_ext").focus();

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




<script language="JavaScript" type="text/JavaScript">

    function chk_form(f) {

        if ($("#pharmacy_code").val() == "") {
            alert("코드정보가 옳바르지 않습니다. 등록이 불가능합니다.");
            return false;
        }

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

</script>