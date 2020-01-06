<?php
$phone_obj = explode("-", $_pharmacy["phone"]);
$email_obj = explode("@", $_pharmacy["email"]);


// 파일 클래스
$obj = new Attech_Works();
$img_obj = $obj->getFile($TB_PHARMACY, $_pharmacy["code"], "pharmacy_img");
$logo_obj = $obj->getFile($TB_PHARMACY, $_pharmacy["code"], "logo_img");
?>
<div id="content">
    <div class="sub_tit">약국관리 > 정보수정</div>
    <div id="cont">
        <div class="adm_cts">
            <h3 class="h3_title">기본 정보</h3>
            <div class="adm_table_style01">
                <table>
                    <colgroup>
                        <col style="width:10%"/>
                        <col style="width:40%"/>
                        <col style="width:50%"/>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>코 드</th>
                        <td><?= $_pharmacy["code"] ?></td>
                        <td rowspan="4">
                            <div id="basic_map" style="width:100%;height:150px;">1111</div>
                        </td>
                    </tr>
                    <tr>
                        <th>등록일</th>
                        <td><?= $_pharmacy["start_date"] ?></td>
                    </tr>
                    <tr>
                        <th>명 칭</th>
                        <td><?= $_pharmacy["name"] ?></td>
                    </tr>
                    <tr>
                        <th>주 소</th>
                        <td style="line-height:180%;">
                            <?= $_pharmacy["zipcode"] ?><br/>
                            <?= $_pharmacy["address"] ?><br/>
                            <?= $_pharmacy["addr_ext"] ?>
                        </td>
                    </tr>
                </table>
                <div style="padding-top:10px;">
                    ※ 명칭, 주소, 지도의 정보를 수정하려면 e약방에 문의 하여 주십시오
                </div>
            </div>


            <form id="ufrm" name="ufrm" method="post" action="./_action/pharmacy.do.php" style="display:inline;" target="actionForm" enctype="multipart/form-data">
                <input type="hidden" id="Mode" name="Mode" value="pharmacy_up">
                <input type="hidden" id="idx" name="idx" value="<?= $idx ?>">
                <input type="hidden" id="pharmacy_code" name="pharmacy_code" value="<?= $_pharmacy["code"] ?>">

                <h3 class="h3_title">연락처 정보</h3>
                <div class="adm_table_style01">
                    <table>
                        <colgroup>
                            <col style="width:10%"/>
                            <col style="width:40%"/>
                            <col style="width:10%"/>
                            <col style="width:40%"/>
                        </colgroup>

                        <tr>
                            <th>연락처</th>
                            <td>
                                <select id="phone1" name="phone1" class="wid20">
                                    <?
                                    foreach ($phone_array as $val) {
                                        $_selected = $val == $_phone_obj[0] ? "selected" : "";
                                        ?>
                                        <option value="<?= $val ?>" <?= $_selected ?>><?= $val ?></option><?
                                    }
                                    ?>
                                </select> -
                                <input type="text" id="phone2" name="phone2" value="<?= $phone_obj[1] ?>"
                                       class="wid20 onlyNumbers" maxlength="4"
                                       onkeyup="passTab('phone2','phone3',4);"> -
                                <input type="text" id="phone3" name="phone3" value="<?= $phone_obj[2] ?>"
                                       class="wid20 onlyNumbers" maxlength="4">
                            </td>
                            <th>이메일</th>
                            <td>
                                <input id="emailID" name="emailID" value="<?= $email_obj[0] ?>" type="text"
                                       class="wid30"/> @
                                <input id="emailDomain" name="emailDomain" value="<?= $email_obj[1] ?>" type="text"
                                       class="wid25"/>
                                <select id="selectDomin" name="selectDomin" class="wid25"
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
                    </table>
                </div>

                <h3 class="h3_title">상세 정보</h3>
                <div class="adm_table_style01">
                    <table>
                        <colgroup>
                            <col style="width:10%"/>
                            <col style="width:40%"/>
                            <col style="width:10%"/>
                            <col style="width:40%"/>
                        </colgroup>

                        <tr>
                            <th>운영시간</th>
                            <td>
                                <textarea id="operation_hours"
                                          name="operation_hours"><?= $_pharmacy["operation"] ?></textarea>
                            </td>
                            <th>약국소개</th>
                            <td>
                                <textarea id="introduction"
                                          name="introduction"><?= $_pharmacy["introduction"] ?></textarea>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <h3 class="h3_title">약국 이미지</h3>
                <div class="adm_table_style01">
                    <table>
                        <colgroup>
                            <col style="width:10%"/>
                            <col style="width:90%"/>
                        </colgroup>
                        <tbody>
                        <tr>
                            <th>약국 LOGO</th>
                            <td>
                                <?php
                                if (!isNull($logo_obj["IDX"])) {
                                    ?><img src="../_core/_files/pharmacy/<?= $logo_obj["PHYSICAL_NAME"] ?>"
                                           width="150"><?
                                } else {
                                ?>
                                이미지 없음
                                <? } ?>
                                <div style="padding:10px;">
                                    <input type="checkbox" id="del_logo_obj" name="del_logo_obj" value="<?=$logo_obj["PHYSICAL_NAME"]?>"/>
                                    <label for="del_logo_obj">약국 LOGO 삭제</label>
                                </div>
                                <div style="padding:10px;">
                                    <input type="hidden" id="hidden_logo_obj" name="hidden_logo_obj" value="<?=$logo_obj["PHYSICAL_NAME"]?>">
                                    <input type="file" id="up_logo_obj" name="up_logo_obj" value="" class="wid50">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>약국 IMAGE</th>
                            <td>
                                <?php
                                if (!isNull($img_obj["IDX"])) {
                                    ?><img src="../_core/_files/pharmacy/<?= $img_obj["PHYSICAL_NAME"] ?>"
                                           width="150"><?
                                } else {
                                ?>
                                이미지 없음
                                <? } ?>
                                <div style="padding:10px;">
                                    <input type="checkbox" id="del_img_obj" name="del_img_obj" value="<?=$img_obj["PHYSICAL_NAME"]?>"/>
                                    <label for="del_img_obj">약국 IMAGE 삭제</label>
                                </div>
                                <div style="padding:10px;">
                                    <input type="hidden" id="hidden_img_obj" name="hidden_img_obj" value="<?=$img_obj["PHYSICAL_NAME"]?>">
                                    <input type="file" id="up_img_obj" name="up_img_obj" value="" class="wid50">
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </form>
            <div class="btn_area t_c">
                <a onClick="chk_form()" class="btn_b btn21">약국정보수정</a>
            </div>
        </div>
    </div><!-- cont -->
</div><!-- content e -->

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=5db1e0e4b2a5da4f9541471458d0774d&libraries=services"></script>
<script>
    var basic_mapContainer = document.getElementById('basic_map'), // 지도를 표시할 div
        basic_mapOption = {
            center: new daum.maps.LatLng(<?=$_pharmacy["lati"]?>, <?=$_pharmacy["longti"]?>), // 지도의 중심좌표
            level: 5 // 지도의 확대 레벨
        };

    //지도를 미리 생성
    var basic_map = new daum.maps.Map(basic_mapContainer, basic_mapOption);

    //마커를 미리 생성
    var marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(<?=$_pharmacy["lati"]?>, <?=$_pharmacy["longti"]?>),
        map: basic_map
    });


    function chk_form() {
        if ($("#phone2").val() == "") {
            alert("연락처를 입력 해 주십시오");
            $("#phone2").val('');
            $("#phone2").focus();
            return false;
        }

        if ($("#phone3").val() == "") {
            alert("연락처를 입력 해 주십시오");
            $("#phone3").val('');
            $("#phone3").focus();
            return false;
        }

        if ($("#emailID").val() == "") {
            alert("이메일을 입력 해 주십시오");
            $("#emailID").val('');
            $("#emailID").focus();
            return false;
        }

        if ($("#emailDomain").val() == "") {
            alert("이메일을 입력 해 주십시오");
            $("#emailDomain").val('');
            $("#emailDomain").focus();
            return false;
        }

        $("#ufrm").submit();
    }
</script>

