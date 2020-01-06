<?
include_once "../_core/_lib/class.attach.php";

$pharmacy_code = "py" . mktime();

$idx = $_GET["idx"];
$page = isNull($_GET["page"]) ? "" : $_GET["page"];

if (isNull($_GET["idx"])) {
    alert_js("alert_back", "약국 정보가 옳바르지 않습니다.", "");
} else {

    $qry_001 = "SELECT t1.*, CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id  ";
    $qry_001 .= "FROM {$TB_AP} t1 ";
    $qry_001 .= "WHERE t1.IDX = '{$idx}' ";

    $res_001 = $db->exec_sql($qry_001);
    $row_001 = $db->sql_fetch_array($res_001);

    // 파일 클래스
    $obj = new Attech_Works();
    $img_obj = $obj->getFile($TB_PHARMACY, $pharmacy_code, "pharmacy_img");
    $logo_obj = $obj->getFile($TB_PHARMACY, $pharmacy_code, "logo_img");
}

// 상태값 출력
if($row_001["APPLY_STATUS"] == 1) {
    $status = "신청중";
} else if ($row_001["APPLY_STATUS"] == 2) {
    $status = "등록완료";
} else if ($row_001["APPLY_STATUS"] == 3) {
    $status = "승인불가";
}

// 검색 변수
$search = array();

$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];

// 주소이동변수
$url_opt = "&pcode=" . $pharmacy_code . "&page=" . $page . "&keyfield={$_search["keyfield"]}&keyword={$_search["keyword"]}&schChkDate={$_search["schChkDate"]}&schReqSDate={$_search["schReqSDate"]}&schReqEDate={$_search["schReqEDate"]}";

if ($_search["schChkDate"] == "Y") {
    $_checked = "checked";
    $_disabled = "";
} else {
    $_checked = "";
    $_disabled = "disabled";
}

$_status[$_search["status"]] = "selected";

// 파일 클래스
$obj = new Attech_Works();
$img_obj = $obj->getFile($TB_AP, $idx, "apply_pharmacy_img");
$logo_obj = $obj->getFile($TB_AP, $idx, "apply_logo_img");

$_pic_url = "../_core/_files/apply/";

$no_apply = "./_action/pharmacy.do.php?Mode=no_apply&idx=" . $idx;

?>
<div id="Contents">
    <h1>신청서 관리 &gt; 약국신청서목록 &gt; <strong>상세정보</strong></h1>
    <div class="mt20"><b>○ 약국 정보</b></div>
    <form name="frm" id="frm" method="post" enctype="multipart/form-data" action="./_action/pharmacy.do.php"
          style="display:inline;" target="actionForm">
        <input type="hidden" id="Mode" name="Mode" value="req_pharmacy_add">
        <input type="hidden" id="pharmacy_code" name="pharmacy_code" value="<?= $pharmacy_code ?>">
        <input type="hidden" id="idx" name="idx" value="<?= $idx ?>">
        <table>
            <colgroup>
                <col style="width:8%"/>
                <col style="width:8%"/>
                <col style="width:40%"/>
                <col style="width:8%"/>
                <col style="width:*"/>
            </colgroup>
            <tbody>
            <tr>
                <th rowspan="6">기본정보</th>
                <th>아이디</th>
                <td colspan="3"><?= $row_001["mm_id"] ?></td>
            </tr>
            <tr>
                <th>약국명</th>
                <td><?= clear_escape($row_001["PHARMACY_NAME"]) ?></td>
                <th>상태</th>
                <td colspan="3"><?= $status ?></td>
                <input id="pharmacy_name" name="pharmacy_name" type="hidden"
                       value="<?= clear_escape($row_001["PHARMACY_NAME"]) ?>"/>
            </tr>
            <tr>
                <th>약국 주소</th>
                <td colspan="3" style="line-height:180%;">
                    <?= $row_001["ZIPCODE"] ?><br><input id="zipcode" name="zipcode" value="<?= $row_001["ZIPCODE"] ?>"
                                                         type="hidden"/>
                    <?= $row_001["ADDRESS"] ?><br><input id="address" name="address" type="hidden"
                                                         value="<?= $row_001["ADDRESS"] ?>"/>
                    <?= clear_escape($row_001["ADDRESS_EXT"]) ?><input id="address_ext" name="address_ext" type="hidden"
                                                                       value="<?= clear_escape($row_001["ADDRESS_EXT"]) ?>"/>
                    <input type="hidden" value="<?= $row_001["LATITUDE"] ?>" id="latitude" name="latitude"/>
                    <input type="hidden" value="<?= $row_001["LONGTITUDE"] ?>" id="longtitude" name="longtitude"/>
                </td>
                <!--th rowspan="4">위치(지도)</th>
                <td class="left" rowspan="4">
                    <div id="map" class="w90p h200" style="display:none;"></div>
                </td-->
            </tr>
            <tr>
                <th>약국 연락처</th>
                <td colspan="3"><?= $row_001["PHARMACY_PHONE"] ?></td>
                <input type="hidden" id="pharmacy_phone" name="pharmacy_phone"
                       value="<?= $row_001["PHARMACY_PHONE"] ?>">
            </tr>
            <tr>
                <th>약국 이메일</th>
                <td colspan="3"><?= $row_001["PHARMACY_EMAIL"] ?></td>
                <input type="hidden" id="pharmacy_email" name="pharmacy_email"
                       value="<?= $row_001["PHARMACY_EMAIL"] ?>">
            </tr>

            <tr>
                <th>신청일</th>
                <td colspan="3"><?= $row_001["APPLY_DATE"] ?></td>
            </tr>
            </tbody>
        </table>

        <!--div class="mt10"><b>○ 이미지 정보</b></div-->
        <div class="mt10"><b>○ 추가 정보</b></div>
        <table class="tbl1">
            <colgroup>
                <col width="8%"/>
                <col width="8%"/>
                <col width="40%"/>
                <col width="*"/>
            </colgroup>
            <!--tr>
                <th rowspan="4">추가정보</th>
                <th>로고이미지</th>
                <td colspan="2">
                    <?php
                    if (!isNull($logo_obj["IDX"])) {
                        ?><img src="../_core/_files/apply/<?= $logo_obj["PHYSICAL_NAME"] ?>" width="150"><?
                    }
                    ?>
                </td>
                <input type="hidden" id="logo_img" name="logo_img" value="<?= $logo_obj["PHYSICAL_NAME"] ?>">
            </tr>
            <tr>
                <th>약국이미지</th>
                <td colspan="2">
                    <?php
                    if (!isNull($img_obj["IDX"])) {
                        ?><img src="../_core/_files/apply/<?= $img_obj["PHYSICAL_NAME"] ?>" width="300"><?
                    }
                    ?>
                </td>
                <input type="hidden" id="pharmacy_img" name="pharmacy_img" value="<?= $img_obj["PHYSICAL_NAME"] ?>">
            </tr-->
            <tr>
                <th rowspan="2">추가정보</th>
                <th>영업시간</th>
                <td colspan="2">
                    <?= nl2br(clear_escape($row_001["OPERATING_HOURS"])) ?>
                </td>
                <input type="hidden" id="operation_hours" name="operation_hours"
                       value="<?= $row_001["OPERATING_HOURS"] ?>">
            </tr>
            <tr>
                <th>약국소개</th>
                <td colspan="2">
                    <?= nl2br(clear_escape($row_001["INTRODUCTION"])) ?>
                </td>
                <input type="hidden" id="introduction" name="introduction"
                       value="<?= $row_001["INTRODUCTION"] ?>">
            </tr>
        </table>
    </form>
    <div class="w100p center">
    <?php
    if ($row_001["APPLY_STATUS"] == 1) {
        ?>

            <input type="button" value="약국 등록" onclick="yes_form();" class="Button btnGreen w120 mt10">&nbsp;&nbsp;
            <input type="button" value="승인 불가" onclick="location.href=' <?= $no_apply ?> '"
                   class="Button btnRed w120 mt10">&nbsp;&nbsp;

        <?
    } else if ($row_001["APPLY_STATUS"] == 3) {
        ?>
        <input type="button" value="약국 등록" onclick="yes_form();" class="Button btnGreen w120 mt10">&nbsp;&nbsp;
        <?
    }
    ?>
        <input type="button" value="목록으로" onclick="history.back();" class="Button btnGray w120 mt10">
    </div>
</div>


<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=5db1e0e4b2a5da4f9541471458d0774d&libraries=services"></script>
<script>
    var basic_mapContainer = document.getElementById('basic_map'), // 지도를 표시할 div
        basic_mapOption = {
            center: new daum.maps.LatLng(<?=$row_001["LATITUDE"]?>, <?=$row_001["LONGTITUDE"]?>), // 지도의 중심좌표
            level: 5 // 지도의 확대 레벨
        };

    //지도를 미리 생성
    var basic_map = new daum.maps.Map(basic_mapContainer, basic_mapOption);

    //마커를 미리 생성
    var marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(<?=$row_001["LATITUDE"]?>, <?=$row_001["LONGTITUDE"]?>),
        map: basic_map
    });
</script>

<script language="JavaScript" type="text/JavaScript">
    function yes_form() {
        if ($("#pharmacy_code").val() == "") {
            alert("코드정보가 옳바르지 않습니다. 등록이 불가능합니다.");
            return false;
        }
        $("#frm").submit();
    }
</script>