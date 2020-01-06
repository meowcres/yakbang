<?php
include_once "../_core/_lib/class.attach.php";

$att = new Attech_Works();
$license_img = $att->getFile($TB_MEMBER, $_pharmacist["id"], "pharmacist_license");
$pharmacist_img = $att->getFile($TB_MEMBER, $_pharmacist["id"], "pharmacist_img");

$qry_001  = " SELECT * ";
$qry_001 .= ", CAST(AES_DECRYPT(UNHEX(USER_PHONE),'" . SECRET_KEY . "') as char) as phone ";
$qry_001 .= " FROM {$TB_MEMBER_INFO} ";
$qry_001 .= " WHERE ID_KEY = '{$_pharmacist["key"]}' ";

$res_001  = $db->exec_sql($qry_001);
$row_001  = $db->sql_fetch_array($res_001);

?>

<div id="content">
    <div class="sub_tit">내 정보관리 > 내 정보관리</div>
    <div id="cont">
        <div class="adm_cts">
            <h3 class="h3_title">약사 정보</h3>
            <div class="adm_table_style01">
                <table>
                    <colgroup>
                        <col style="width:10%"/>
                        <col style="width:15%"/>
                        <col style="width:*"/>
                    </colgroup>
                    <tbody>

                    <tr>
                        <th rowspan="9">기본정보</th>
                        <th>약사 ID</th>
                        <td><?= $_pharmacist["id"] ?></td>
                    </tr>
                    <tr>
                        <th>약사명</th>
                        <td><?= $_pharmacist["name"] ?></td>
                    </tr>
                    <tr>
                        <th>상태</th>
                        <td><?= $pharmacist_status_array[$_pharmacist["p_status"]] ?></td>
                    </tr>
                    <tr>
                        <th>생년월일</th>
                        <td><?= $row_001["USER_BIRTHDAY"] ?></td>
                    </tr>
                    <tr>
                        <th>성별</th>
                        <td><?= $row_001["USER_SEX"] == M ? "남성" : "여성" ?></td>
                    </tr>
                    <tr>
                        <th>약사연락처</th>
                        <td><?= $row_001["phone"] ?></td>
                    </tr>
                    <tr>
                        <th>약사 이미지</th>
                        <td>
                            <?php
                            if (!isNull($pharmacist_img["IDX"])) {
                                ?><img src="../Web_Files/pharmacist/<?= $pharmacist_img["PHYSICAL_NAME"] ?>" width="100"><?
                            } else { ?>
                                약사 이미지 없음
                            <? }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>등록일</th>
                        <td><?= $_pharmacist["reg_date"] ?></td>
                    </tr>
                    <tr>
                        <th>최종수정일</th>
                        <td><?= $_pharmacist["up_date"] ?></td>
                    </tr>
                    </tbody>
                </table>

                <div class="mt30 mb10">
                    <?
                    foreach ($pharmacist_menu_array as $key => $val) {
                        $_btn_class = $key == $_step ? "btn21" : "btn01";
                        ?><input type="button" value="<?= $val ?>" class="btn <?=$_btn_class?>"
                                 onClick="location.href='./pharmacy.template.php?slot=member&type=pharmacist_detail&step=<?= $key . $url_opt ?>'">&nbsp;&nbsp;<?
                    }
                    ?>
                </div><br>

                <div>
                    <?
                    if (!isNull($_step)) {
                        //echo $_step ;
                        include_once "./member/detail.pharmacist_{$_step}.php";
                    }
                    ?>
                </div>
            </div>
        </div>