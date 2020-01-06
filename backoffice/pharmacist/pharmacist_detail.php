<?
include_once "../_core/_lib/class.attach.php";

$page = isNull($_GET["page"]) ? "" : $_GET["page"];
$idx = isNull($_GET["idx"]) ? "" : $_GET["idx"];

if (isNull($_GET["idx"])) {
    alert_js("alert_back", "약사 정보가 옳바르지 않습니다.", "");
} else {

    $qry_001 = " SELECT t1.IDX, t1.*, t2.*  ";
    $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
    $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
    $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

    $_from = "FROM {$TB_MEMBER} t1 ";
    $_from .= "LEFT JOIN {$TB_MEMBER_INFO} t2 ON (t1.USER_ID = t2.ID_KEY) ";
    $_whereqry .= "WHERE t1.idx = '{$idx}' ";

    $res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
    $m_main = $db->sql_fetch_array($res_001);

    $member_sex = $m_main["USER_SEX"] == "M" ? "남성" : "여성";

    $att = new Attech_Works();
    $license_img = $att->getFile($TB_MEMBER, $m_main["mm_id"], "pharmacist_license");
    $pharmacist_img = $att->getFile($TB_MEMBER, $m_main["mm_id"], "pharmacist_img");

}

// 검색 변수
$search = array();
$_search["status"] = isNull($_GET["status"]) ? "" : $_GET["status"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];

// 주소이동변수
$url_opt = "&idx=" . $idx . "&page=" . $page . "&status=" . $_search["status"] . "&keyfield={$_search["keyfield"]}&keyword={$_search["keyword"]}&schChkDate={$_search["schChkDate"]}&schReqSDate={$_search["schReqSDate"]}&schReqEDate={$_search["schReqEDate"]}";

if ($_search["schChkDate"] == "Y") {
    $_checked = "checked";
    $_disabled = "";
} else {
    $_checked = "";
    $_disabled = "disabled";
}

?>
<div id="Contents">
    <h1>약사 관리 &gt; 약사목록 &gt; <strong>약사상세정보</strong></h1>
    <div class="mt20"><b>○ 약사정보</b></div>

    <table>
        <colgroup>
            <col style="width:8%"/>
            <col style="width:10%"/>
            <col style="width:*"/>
        </colgroup>
        <tbody>

        <tr>
            <th rowspan="9">기본정보</th>
            <th>약사 ID</th>
            <td><?= $m_main["mm_id"] ?></td>
        </tr>
        <tr>
            <th>약사명</th>
            <td><?= $m_main["mm_name"] ?></td>
        </tr>
        <tr>
            <th>상태</th>
            <td><?= $pharmacist_status_array[$m_main["USER_STATUS"]] ?></td>
        </tr>
        <tr>
            <th>생년월일</th>
            <td><?= $m_main["USER_BIRTHDAY"] ?></td>
        </tr>
        <tr>
            <th>성별</th>
            <td><?= $member_sex ?></td>
        </tr>
        <tr>
            <th>약사연락처</th>
            <td><?= $m_main["mm_phone"] ?></td>
        </tr>
        <tr>
            <th>약사 이미지</th>
            <td>
                <?php
                if (!isNull($pharmacist_img["IDX"])) {
                    ?><img src="../Web_Files/pharmacist/<?= $pharmacist_img["PHYSICAL_NAME"] ?>" width="100"><?
                } else {
                    ?>
                    약사 이미지 없음
                    <?
                }
                ?>
            </td>
        </tr>
        <tr>
            <th>등록일</th>
            <td><?= $m_main["REG_DATE"] ?></td>
        </tr>
        <tr>
            <th>최종수정일</th>
            <td><?= $m_main["UP_DATE"] ?></td>
        </tr>
        </tbody>
    </table>

    <div class="mt30 mb10">
        <input type="button" value="목록으로" class="Button btnGray w120"
               onClick="location.href='./admin.template.php?slot=pharmacist&type=pharmacist_list<?= $url_opt ?>'">&nbsp;
        <?
        foreach ($pharmacist_menu_array as $key => $val) {
            $_btn_class = $key == $_step ? "btnOrange" : "btnGray";
            ?><input type="button" value="<?= $val ?>" class="Button <?= $_btn_class ?> w120"
                     onClick="location.href='./admin.template.php?slot=pharmacist&type=pharmacist_detail&step=<?= $key . $url_opt ?>'">&nbsp;&nbsp;<?
        }
        ?>
    </div>

    <div>
        <?
        if (!isNull($_step)) {
            //echo $_step ;
            include_once "./pharmacist/detail.pharmacist_{$_step}.php";
        }
        ?>
    </div>
</div>

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

    //-->
</script>