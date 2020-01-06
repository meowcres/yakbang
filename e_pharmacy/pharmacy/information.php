<?php
$phone_obj = explode("-", $_pharmacy["phone"]);
$email_obj = explode("@", $_pharmacy["email"]);

// 파일 클래스
$obj = new Attech_Works();
$img_obj = $obj->getFile($TB_PHARMACY, $_pharmacy["code"], "pharmacy_img");
$logo_obj = $obj->getFile($TB_PHARMACY, $_pharmacy["code"], "logo_img");
?>
<div id="content">
    <div class="sub_tit">약국관리 > 약국정보</div>
    <div id="cont">
        <div class="adm_cts">
            <h3 class="h3_title">약국 정보</h3>
            <div class="adm_table_style01">
                <table>
                    <colgroup>
                        <col style="width:10%"/>
                        <col style="width:40%"/>
                        <col style="width:10%"/>
                        <col style="width:40%"/>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th>코 드</th>
                        <td><?= $_pharmacy["code"] ?></td>
                        <th>등록일</th>
                        <td><?= $_pharmacy["start_date"] ?></td>
                    </tr>
                    <tr>
                        <th>명 칭</th>
                        <td colspan="3"><?= $_pharmacy["name"] ?></td>
                    </tr>
                    <tr>
                        <th>주 소</th>
                        <td style="line-height:180%;">
                            <?= $_pharmacy["zipcode"] ?><br/>
                            <?= $_pharmacy["address"] ?><br/>
                            <?= $_pharmacy["addr_ext"] ?>
                        </td>
                        <td colspan="2" rowspan="3">
                            <div id="basic_map" style="width:100%;height:150px;">1111</div>
                        </td>
                    </tr>
                    <tr>
                        <th>연락처</th>
                        <td>
                            <?= $_pharmacy["phone"] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>이메일</th>
                        <td>
                            <?= $_pharmacy["email"] ?>
                        </td>
                    </tr>
                    <tr>
                        <th>운영시간</th>
                        <td>
                            <?= nl2br($_pharmacy["operation"]) ?>
                        </td>
                        <th>약국소개</th>
                        <td>
                            <?= nl2br($_pharmacy["introduction"]) ?>
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
                              ?><img src="../Web_Files/pharmacy/<?= $logo_obj["PHYSICAL_NAME"] ?>" width="150"><?
                            } else {
                            ?>
                                이미지 없음
                            <? } ?>
                        </td>
                    </tr>
                    <tr>
                        <th>약국 IMAGE</th>
                        <td>
                            <?php
                            if (!isNull($img_obj["IDX"])) {
                              ?><img src="../Web_Files/pharmacy/<?= $img_obj["PHYSICAL_NAME"] ?>" width="150"><?
                            } else {
                            ?>
                                이미지 없음
                            <? } ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <br/><br/><br/><br/>
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
</script>