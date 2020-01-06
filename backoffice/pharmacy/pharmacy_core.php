<?
include_once "../_core/_lib/class.attach.php";

$page = isNull($_GET["page"]) ? "" : $_GET["page"];

if (isNull($_GET["pcode"])) {
    alert_js("alert_back", "약국 정보가 옳바르지 않습니다.", "");
} else {
    $pharmacy_code = $_GET["pcode"];

    $qry_001 = "SELECT t1.*  ";
    $qry_001 .= "FROM {$TB_PHARMACY} t1 ";
    $qry_001 .= "WHERE t1.PHARMACY_CODE = '{$pharmacy_code}' ";

    $res_001 = $db->exec_sql($qry_001);
    $p_main = $db->sql_fetch_array($res_001);

    // 파일 클래스
    $obj = new Attech_Works();
    $img_obj = $obj->getFile($TB_PHARMACY, $pharmacy_code, "pharmacy_img");
    $logo_obj = $obj->getFile($TB_PHARMACY, $pharmacy_code, "logo_img");
}

// 심평원 동기화 유무
$chk_ykiho = $p_main["YKIHO"] == '' ? "미확인" : "등록완료";        

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

$_pic_url = "../_core/_files/member/user";

?>
<div id="Contents">
    <h1>약국관리 &gt; 약국 관리 &gt; <strong>약국상세정보</strong></h1>
    <div class="mt20"><b>○ 약국 정보</b></div>

    <table>
        <colgroup>
            <col style="width:8%"/>
            <col style="width:8%"/>
            <col style="width:40%"/>
            <col style="width:*"/>
        </colgroup>
        <tbody>
        <tr>
            <th rowspan="9">기본정보</th>
            <th>관리번호</th>
            <td colspan="2"><?= $p_main["PHARMACY_NUMBER"] ?></td>
        </tr>
        <tr>
            <th>약국코드</th>
            <td colspan="2"><?= $p_main["PHARMACY_CODE"] ?></td>
        </tr>
        <tr>
            <th>약국명</th>
            <td colspan="2"><?= clear_escape($p_main["PHARMACY_NAME"]) ?></td>
        </tr>
        <tr>
            <th>상태</th>
            <td><?= $pharmacy_status_array[$p_main["PHARMACY_STATUS"]] ?></td>
            <td rowspan="6" class="center">
                <div id="basic_map" class="w90p h200"></div>
            </td>
        </tr>
        <tr>
            <th>심평원</th>
            <td><?=$chk_ykiho?></td>
        </tr>
        <tr>
            <th>약국 주소</th>
            <td style="line-height:180%;">
                <?= $p_main["ZIPCODE"] ?><br>
                <?= $p_main["ADDRESS"] ?><br>
                <?= clear_escape($p_main["ADDRESS_EXT"]) ?>
            </td>
        </tr>
        <tr>
            <th>약국 연락처</th>
            <td><?= $p_main["PHARMACY_PHONE"] ?></td>
        </tr>
        <tr>
            <th>약국 이메일</th>
            <td><?= $p_main["PHARMACY_EMAIL"] ?></td>
        </tr>

        <tr>
            <th>등록일</th>
            <td><?= $p_main["START_DATE"] ?></td>
        </tr>
        </tbody>
    </table>

    <div class="mt30 mb10">
        <input type="button" value="목록으로" class="Button btnGray w120"
               onClick="location.href='./admin.template.php?slot=pharmacy&type=pharmacy_list<?= $url_opt ?>'">&nbsp;
        <?
        foreach ($pharmacy_menu_array as $key => $val) {
            $_btn_class = $key == $_step ? "btnOrange" : "btnGray";
            ?><input type="button" value="<?= $val ?>" class="Button <?= $_btn_class ?> w120"
                     onClick="location.href='./admin.template.php?slot=pharmacy&type=pharmacy_core&step=<?= $key . $url_opt ?>'">&nbsp;&nbsp;<?
        }
        ?>
    </div>

    <div>
        <?
        if (!isNull($_step)) {
            //echo $_step ;
            include_once "./pharmacy/core.pharmacy_{$_step}.php";
        }
        ?>
    </div>


</div>


<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=5db1e0e4b2a5da4f9541471458d0774d&libraries=services"></script>
<script>
    var basic_mapContainer = document.getElementById('basic_map'), // 지도를 표시할 div
        basic_mapOption = {
            center: new daum.maps.LatLng(<?=$p_main["LATITUDE"]?>, <?=$p_main["LONGTITUDE"]?>), // 지도의 중심좌표
            level: 5 // 지도의 확대 레벨
        };

    //지도를 미리 생성
    var basic_map = new daum.maps.Map(basic_mapContainer, basic_mapOption);

    //마커를 미리 생성
    var marker = new daum.maps.Marker({
        position: new daum.maps.LatLng(<?=$p_main["LATITUDE"]?>, <?=$p_main["LONGTITUDE"]?>),
        map: basic_map
    });
</script>


<script language="JavaScript" type="text/JavaScript">
    <!--
    //숫자만 입력
    $('.onlyNumbers').bind('keydown', function (e) {
        var keyCode = e.which;

        // 48-57 Standard Keyboard Numbers
        var isStandard = (keyCode > 47 && keyCode < 58);

        // 96-105 Extended Keyboard Numbers (aka Keypad)
        var isExtended = (keyCode > 95 && keyCode < 106);

        // 8 Backspace, 46 Forward Delete
        // 37 Left Arrow,   38 Up Arrow,        39 Right Arrow,
        // 40 Down Arrow
        var validKeyCodes = ',8,37,38,39,40,46,';
        var isOther = (-1 < validKeyCodes.indexOf(',' + keyCode + ','));
        if (isStandard || isExtended || isOther) {
            return true;
        } else {
            return false;
        }
    }).bind('blur', function () {
        // regular expression that matches everything that is
        // not a number
        var pattern = new RegExp('[^0-9]+', 'g');
        var $input = $(this);
        var value = $input.val();

        // clean the value using the regular expression
        value = value.replace(pattern, '');
        $input.val(value)
    });

    $(document).on("keyup", "input:text[number-only]", function () {
        $(this).val($(this).val().replace(/[^0-9]/gi, ""));
    });

    function chk_question_form() {

        if ($("#ns_pro").val() == "") {
            alert("뉴솔루션의 배점을 입력 해 주십시오");
            $("#ns_pro").val('');
            $("#ns_pro").focus();
            return false;
        }

        if ($("#judge_pro").val() == "") {
            alert("심사위원의 배점을 입력 해 주십시오");
            $("#judge_pro").val('');
            $("#judge_pro").focus();
            return false;
        }

        var nsPro = parseInt($("#ns_pro").val());
        var judgePro = parseInt($("#judge_pro").val());

        pro = parseInt(nsPro + judgePro);


        if (pro != 100) {
            alert("배점의 합이 100% 가 되어야 합니다.");
            return false;
        }

        $("#frm").submit();
    }

    function del_question(idx, ssCode) {
        if (confirm("평가항목을 삭제하겠습니까?")) {
            var url = "./_action/distribution.do.php?Mode=del_question&idx=" + idx + "&ss_code=" + ssCode;
            actionForm.location.href = url;
        }
    }

    //-->
</script>