<?
include_once "../_core/_lib/class.attach.php";

$page = isNull($_GET["page"]) ? "" : $_GET["page"];

if (isNull($_GET["ps_code"])) {
    alert_js("alert_back", "처방전 정보가 옳바르지 않습니다.", "");
} else {
    $ps_code = $_GET["ps_code"];

    $_sel = " SELECT t1.*, t2.*, t3.*, t1.REG_DATE AS date ";
    $_sel .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
    $_sel .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
    $_sel .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";
    $_from = " FROM {$TB_PS} t1 ";
    $_from .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.USER_ID = t2.USER_ID ) ";
    $_from .= " LEFT JOIN {$TB_MEMBER_INFO} t3 ON ( t1.USER_ID = t3.ID_KEY ) ";
    $_where .= " WHERE t1.PS_CODE = '{$ps_code}' ";

    $res_001 = $db->exec_sql($_sel . $_from . $_where);
    $ps_main = $db->sql_fetch_array($res_001);

    // 파일 클래스
    $qry_img = " SELECT PHYSICAL_NAME FROM {$TB_PS_IMAGE} WHERE PS_CODE = '{$ps_code}' ";
    $res_img = $db->exec_sql($qry_img);
    $row_img = $db->sql_fetch_row($res_img);
    $prescription_img = $row_img[0];
}

// 검색 변수
$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["type"] = isNull($_GET["search_type"]) ? "" : $_GET["search_type"];
$_search["keyfield1"] = isNull($_GET["keyfield1"]) ? "" : $_GET["keyfield1"];
$_search["keyword1"] = isNull($_GET["keyword1"]) ? "" : $_GET["keyword1"];
$_search["keyfield2"] = isNull($_GET["keyfield2"]) ? "" : $_GET["keyfield2"];
$_search["keyword2"] = isNull($_GET["keyword2"]) ? "" : $_GET["keyword2"];
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];

// 주소이동변수
$url_opt = "&ps_code=" . $ps_code . "&page=" . $page . "&search_status=" . $_search["status"] . "&search_type=" . $_search["type"] . "&keyfield1=" . $_search["keyfield1"] . "&keyword1=" . $_search["keyword1"] . "&keyfield2=" . $_search["keyfield2"] . "&keyword2=" . $_search["keyword2"] . "&schChkDate=" . $_search["schChkDate"] . "&schReqSDate=" . $_search["schReqSDate"]. "&schReqEDate=" . $_search["schReqEDate"];

$_pic_url = "../_core/_files/member/user";

?>
<div id="Contents">
    <h1>처방전관리 &gt; 처방전 관리 &gt; 처방전 목록 &gt; <strong>처방전 상세정보</strong></h1>
    <div class="mt20"><b>○ 처방전 정보</b></div>

    <table>
        <colgroup>
            <col style="width:8%"/>
            <col style="width:10%"/>
            <col style="width:*"/>
        </colgroup>
        <tbody>

        <tr>
            <th rowspan="10">기본 정보</th>
            <th>회원 ID</th>
            <td><?= $ps_main["mm_id"] ?></td>
        </tr>
        <tr>
            <th>회원명</th>
            <td><?= $ps_main["mm_name"] ?></td>
        </tr>
        <tr>
            <th>회원 상태</th>
            <td><?= $member_status_array[$ps_main["USER_STATUS"]] ?></td>
        </tr>
        <tr>
            <th>처방전 코드</th>
            <td><?= $ps_main["PS_CODE"] ?></td>
        </tr>
        <tr>
            <th>처방전 상태</th>
            <td><?= $prescription_status_array[$ps_main["PS_STATUS"]] ?></td>
        </tr>
        <tr>
            <th>처방전 타입</th>
            <td><?= $prescription_type_array[$ps_main["SEND_TYPE"]] ?></td>
        </tr>
        <tr>
            <th>등록일</th>
            <td><?= $ps_main["date"] ?></td>
        </tr>
        <tr>
            <th>수정일</th>
            <td><?= $ps_main["UP_DATE"] ?></td>
        </tr>
        <tr>
            <th>완료일</th>
            <td><?= $ps_main["COMPLETE_DATE"] ?></td>
        </tr>
        <tr>
            <th>처방전 이미지</th>
            <td>
                <?php
                if (!isNull($prescription_img)) {
                    ?>
                    <div style="margin-top: 10px; margin-bottom: 10px;">
                        <a href="../Web_Files/prescription/<?= $prescription_img ?>" download>처방전 이미지 다운로드</a>
                    </div>
                    <?
                } else {
                    ?>
                    <div style="margin-top: 10px; margin-bottom: 10px;">
                        처방전 이미지 없음
                    </div>
                    <?
                }
                ?>
            </td>
        </tr>
        </tbody>
    </table>

    <div class="mt30 mb10">
        <input type="button" value="목록으로" class="Button btnGray w120"
               onClick="location.href='./admin.template.php?slot=prescription&type=prescription_list<?= $url_opt ?>'">&nbsp;
        <?
        foreach ($prescription_menu_array as $key => $val) {
            $_btn_class = $key == $_step ? "btnOrange" : "btnGray";
            ?><input type="button" value="<?= $val ?>" class="Button <?= $_btn_class ?> w120"
                     onClick="location.href='./admin.template.php?slot=prescription&type=prescription_detail&step=<?= $key . $url_opt ?>'">&nbsp;&nbsp;<?
        }
        ?>
    </div>

    <div>
        <?
        if (!isNull($_step)) {
            //echo $_step ;
            include_once "./prescription/detail.prescription_{$_step}.php";
        }
        ?>
    </div>
</div>