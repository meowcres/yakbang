<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

$qry_001 = " SELECT count(*) ";
$_from = " FROM {$TB_MENTOR} t1";
$_from .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.MENTOR_ID = t2.USER_ID ) ";
$_from .= " LEFT JOIN {$TB_MEMBER_INFO} t3 ON ( t2.USER_ID = t3.ID_KEY ) ";
$_where = " WHERE t1.MENTEE_ID = '{$mm_row["USER_ID"]}' ";
$_order = " ORDER BY t1.REG_DATE DESC ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_where);
$row_001 = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];
?>
    <div class="coNtent">
        <div class="position_wrap">
            <span>mypage</span>
            <span>멘토 리스트</span>
        </div>
        <div class="coNtent2 bgcolor02">
            <ul class="memtorList_wrap">
                <?php
                if ($totalnum > 0) {
                    $qry_002 = " SELECT t1.*, t2.*, t1.REG_DATE AS date ";
                    $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
                    $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                    $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

                    $_pic_url = "../../Web_Files/pharmacist/";

                    $res_002 = $db->exec_sql($qry_002 . $_from . $_where . $_order);
                    while ($row_002 = $db->sql_fetch_array($res_002)) {
                        $qry_003 = " SELECT * FROM {$TB_ATTECH_FILES} WHERE REFERENCE_CODE = '{$row_002["mm_id"]}' AND TYPE_CODE = 'pharmacist_img' ";
                        $res_003 = $db->exec_sql($qry_003);
                        $row_003 = $db->sql_fetch_array($res_003);

                        $qry_004 = " SELECT *  ";
                        $qry_004 .= " FROM {$TB_PP} t1 LEFT JOIN {$TB_PHARMACY} t2 ON ( t1.PHARMACY_CODE = t2.PHARMACY_CODE ) ";
                        $qry_004 .= " WHERE t1.USER_ID = '{$row_002["USER_ID"]}' ";
                        $qry_004 .= " AND t1.P_STATUS = '1' ORDER BY t1.P_GRADE DESC, t2.PHARMACY_NAME ";
                        $qry_004 .= " LIMIT 0, 1 ";
                        ?>
                        <li>
                            <div class="infomemtor">
                                <a href="javascript:void(0);"
                                   onclick="mentor_list_dm('<?= $mm_row["USER_ID"] ?>', '<?= $row_002["USER_ID"] ?>');">
                                    <div class="imGArea"
                                         style='background-image:url("<?= $_pic_url . $row_003["PHYSICAL_NAME"] ?>");'></div>
                                    <div class="infoinNer">
                                        <p class="mmName">약사 : <?= $row_002["mm_name"] ?>
                                            <?php
                                            $res_004 = $db->exec_sql($qry_004);
                                            while ($row_004 = $db->sql_fetch_array($res_004)) {
                                                $qry_005 = " SELECT count(*) ";
                                                $qry_005 .= " FROM {$TB_DM} ";
                                                $qry_005 .= " WHERE SEND_ID = '{$row_002["USER_ID"]}' AND RECEIVE_ID = '{$mm_row["USER_ID"]}' AND R_STATUS = '2' ";
                                                $res_005 = $db->exec_sql($qry_005);
                                                $row_005 = $db->sql_fetch_row($res_005);
                                                if ($row_005[0] > 0) {
                                                    $status = $row_005[0];
                                                } else {
                                                    $status = "";
                                                }
                                                ?>
                                                <em class="phaName">( <?= $row_004["PHARMACY_NAME"] ?>
                                                    )</em>&nbsp;&nbsp;&nbsp;&nbsp;<font
                                                        color="FF0000"><?= $status ?></font>
                                                <?
                                            }
                                            ?>
                                        </p>
                                        <p class="mmDate">멘토등록일 : <?= $row_002["date"] ?></p>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <?
                    }
                } else {
                    ?>
                    <li>
                        <div class="infomemtor">
                            <a href="javascript:void(0);">
                                <div class="infoinNer">
                                    <p class="mmName">등록된 멘토가 없습니다.</p>
                                </div>
                            </a>
                        </div>
                    </li>
                <?
                }
                ?>
            </ul>
        </div>
    </div>
    <script>
        function mentor_list_dm(mentee_id, mentor_id) {

            // 폼 보내기
            var _frm = new FormData();

            _frm.append("Mode", "mentor_list_dm_read");
            _frm.append("mentee_id", mentee_id);
            _frm.append("mentor_id", mentor_id);

            $.ajax({
                method: 'POST',
                url: "../_action/mypage.do.php",
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    console.log(_res);
                    switch (_res) {
                        case "0" :
                            location.href = "./mentor_list_dm.php?mentee_id="+mentee_id + "&mentor_id=" + mentor_id;
                            break;
                        default :
                            alert("실패");
                            break;
                    }
                }
            });
        }
    </script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";