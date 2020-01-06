<?
include_once "../_core/_lib/class.attach.php";

$_sql = " SELECT * ";
$_sql .= " FROM {$TB_FCM_VIEW} ";

$_res = $db->exec_sql($_sql);
$_row = $db->sql_fetch_array($_res);

$att = new Attech_Works();
$fcm_img = $att->getFile($TB_FCM_VIEW, $_row["IDX"], "fcm_img");

?>
    <script language="javascript">
        Loading(true);
    </script>
    <div id="Contents" style="border-bottom:0px;">
        <h1>기타관리 &gt; FCM 푸시 &gt; <strong>FCM 푸시 알림창</strong></h1>

        <h3 style="padding:20px 0 7px 0;">◎ 발송정보</h3>
        <table class="tbl1" cellspacing="0" summary="리스트 검색" style="width:100%;">
            <colgroup>
                <col width="35%"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>설정정보</th>
                <th>관리</th>
            </tr>
            <tr>
                <td>
                    <?
                    if ($_row["FCM_STATUS"] == "y") {
                        ?>
                        <center>
                            <table style="width:360px;">
                                <tr>
                                    <td><?= stripslashes($_row["FCM_TITLE"]) ?></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right;"><?= $_row["REG_DATE"] ?></td>
                                </tr>
                                <tr>
                                    <td class="left">
                                        <?php
                                        if (!isNull($fcm_img["IDX"])) {
                                            ?><img src="../_core/_files/etc/<?= $fcm_img["PHYSICAL_NAME"] ?>"
                                                   width="320"><br><?
                                        } else {
                                            ?>
                                            FCM 이미지 없음
                                            <?
                                        }

                                        echo nl2br(stripslashes($_row["FCM_MSG"]));
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </center>
                        <?
                    } else {
                        echo "페이지 사용 안함";
                    }
                    ?>
                </td>
                <td class="left">
                    <form id="fcmForm" name="fcmForm" method="POST" ENCTYPE="multipart/form-data"
                          action="./_action/etc.do.php" target="ipushForm">
                        <input type="hidden" name="mode" id="mode" value="fcm_config"/>
                        <input type="hidden" name="idx" id="idx" value="<?= $_row["IDX"] ?>"/>
                        <input type="hidden" name="fcm_img" id="fcm_img" value="<?= $fcm_img["PHYSICAL_NAME"] ?>"/>
                        <table style="width:700px;">
                            <colgroup>
                                <col width="30%"/>
                                <col width="*"/>
                            </colgroup>
                            <tr>
                                <th>페이지 이동</th>
                                <td class="left">
                                    <input type="radio" id="fcm_status_y" name="fcm_status"
                                           value="y" <?= $_row["FCM_STATUS"] == "y" ? "checked" : ""; ?>> <label
                                            for="fcm_status_y">페이지 사용</label> &nbsp;&nbsp;
                                    <input type="radio" id="fcm_status_n" name="fcm_status"
                                           value="n" <?= $_row["FCM_STATUS"] == "n" ? "checked" : ""; ?>> <label
                                            for="fcm_status_n">메인으로 이동</label>
                                </td>
                            </tr>
                            <tr>
                                <th>제목</th>
                                <td class="left">
                                    <input type="text" id="fcm_title" name="fcm_title"
                                           value="<?= stripslashes($_row["FCM_TITLE"]) ?>" style="width:90%;">
                                </td>
                            </tr>
                            <tr>
                                <th>본문 이미지</th>
                                <td class="left">
                                    <?
                                    if (!isNull($fcm_img["IDX"])) {
                                        ?>
                                        <img src="../_core/_files/etc/<?= $fcm_img["PHYSICAL_NAME"] ?>" width="320">
                                        <br><?
                                        ?>
                                        <div style="margin:10px 0 10px 0;">
                                            <input type="checkbox" id="del_fcm" name="del_fcm"
                                                   value="<?= $fcm_img["PHYSICAL_NAME"] ?>"/>
                                            <label for="del_fcm">FCM 이미지 삭제</label>
                                        </div>
                                        <?php
                                    } else {
                                        ?>
                                        <div style="margin:10px 0 10px 0;">
                                            FCM 이미지 없음
                                        </div>
                                        <?
                                    }
                                    ?>
                                    <input type="file" id="up_fcm" name="up_fcm" style="width:90%;">
                                    <input type="hidden" id="hidden_fcm" class="uploadBtn" name="hidden_fcm"
                                           value="<?= $fcm_img["PHYSICAL_NAME"] ?>">

                                </td>
                            </tr>
                            <tr>
                                <th>내용</th>
                                <td class="left">
                                    <textarea id="fcm_msg" name="fcm_msg"
                                              style="width:97%;height:180px;"><?= stripslashes($_row["FCM_MSG"]) ?></textarea>
                                </td>
                            </tr>
                        </table>
                        <div style="padding:5px 0;">
                            <input type="submit" value="정보관리" class="btn_w80s" style="width:100px; height:28px;">
                        </div>
                    </form>
                </td>
            </tr>
        </table>


    </div>
    <iframe id="ipushForm" name="ipushForm" style="display:block;"></iframe>

<? $db->db_close(); ?>