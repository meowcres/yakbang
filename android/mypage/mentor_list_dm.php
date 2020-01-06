<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

$mentee_id = $_REQUEST["mentee_id"];
$mentor_id = $_REQUEST["mentor_id"];

$qry_cnt = " SELECT COUNT(*) ";
$qry_sel = " SELECT *, t1.REG_DATE AS reg_date ";
$qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t1.SEND_ID),'" . SECRET_KEY . "') as char) as s_id ";
$qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t1.RECEIVE_ID),'" . SECRET_KEY . "') as char) as r_id ";
$qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as s_name ";
$qry_sel .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as r_name ";
$qry_001 = " FROM {$TB_DM} t1 ";
$qry_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.SEND_ID = t2.USER_ID ) ";
$qry_001 .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.RECEIVE_ID = t3.USER_ID ) ";
$qry_001 .= " WHERE ( t1.SEND_ID = '{$mentee_id}' AND t1.RECEIVE_ID = '{$mentor_id}' ) OR ( t1.SEND_ID = '{$mentor_id}' AND t1.RECEIVE_ID = '{$mentee_id}' ) ";
$qry_001 .= " ORDER BY t1.S_DATE ";
$qry_001 .= " LIMIT 0, 100 ";

$res_cnt = $db->exec_sql($qry_cnt . $qry_001);
$row_cnt = $db->sql_fetch_row($res_cnt);
$totalnum = $row_cnt[0];
?>
<input type="hidden" id="mentee_id" name="mentee_id" value="<?= $mentee_id ?>">
<input type="hidden" id="mentor_id" name="mentor_id" value="<?= $mentor_id ?>">
<div class="coNtent2">
    <div class="dm_wrap">
        <div class="inNerdM" id="inNerdM">
            <?php
            if ($totalnum > 0) {
                $res_001 = $db->exec_sql($qry_sel . $qry_001);
                while ($row_001 = $db->sql_fetch_array($res_001)) {
                    if ($row_001["R_STATUS"] == 1) {
                        $status = "읽음";
                    } else if ($row_001["R_STATUS"] == 2) {
                        $status = "1";
                    } else if ($row_001["R_STATUS"] == 3) {
                        $status = "삭제";
                    }
                    $reg_date = $row_001["reg_date"];
                    $r_status = $row_001["R_STATUS"];

                    if ($row_001["RECEIVE_ID"] == $mentee_id) {
                        ?>
                        <div class="lefTBx">
                            <div class="inName">
                                <span><?= $row_001["s_name"] ?><em
                                            class="sdate"><?= $row_001["S_DATE"] ?></em><em><?= $status ?></em></span>
                                <div class="sAytxx">
                                    <?= $row_001["MESSAGE"] ?>
                                </div>
                            </div>
                        </div>
                        <?
                    } else {
                        ?>
                        <div class="riGhtBx">
                            <div class="inName">
                                <span><em><?= $status ?></em><em
                                            class="sdate"><?= $row_001["S_DATE"] ?></em><?= $row_001["s_name"] ?></span>
                                <div class="sAytxx">
                                    <?= $row_001["MESSAGE"] ?>
                                </div>
                            </div>
                        </div>
                        <?
                    }
                }
                ?>
                <input type="hidden" id="reg_date" name="reg_date" value="<?= $reg_date ?>">
                <input type="hidden" id="r_status" name="r_status" value="<?= $r_status ?>">
                <?
            } else {

            }
            ?>
            <!--<div class="riGhtBx">
                <div class="inName">
                    <span><em>1</em>홍길동</span>
                    <div class="sAytxx">
                        중얼중얼중얼중얼
                    </div>
                </div>
            </div>-->
        </div>
        <div class="dMiNput">
            <label for="message">내용삽입</label>
            <input type="text" id="message" name="message">
            <input type="button" title="보내기버튼" value="보내기" onclick="dm_add('<?= $mentee_id ?>', '<?= $mentor_id ?>');">
        </div>
    </div>
</div>

<script>
    function dm_add(send_id, receive_id) {

        // 폼 보내기
        var message = $('#message').val();
        var _frm = new FormData();

        _frm.append("Mode", "dm_add");
        _frm.append("send_id", send_id);
        _frm.append("receive_id", receive_id);
        _frm.append("message", message);

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
                        location.href = "./mentor_list_dm.php?mentee_id=" + send_id + "&mentor_id=" + receive_id;
                        break;
                    default :
                        alert("실패");
                        break;
                }
            }
        });
    }
</script>

<script>
    $(document).ready(function () {
        $("#inNerdM").scrollTop($("#inNerdM")[0].scrollHeight);

        ajax_call = function () {
            var r_status = $('#r_status').val();
            var reg_date = $('#reg_date').val();
            var mentee_id = $('#mentee_id').val();
            var mentor_id = $('#mentor_id').val();

            var _frm = new FormData();

            _frm.append("Mode", "ajax_call");
            _frm.append("r_status", r_status);
            _frm.append("reg_date", reg_date);
            _frm.append("mentee_id", mentee_id);
            _frm.append("mentor_id", mentor_id);

            $.ajax({
                type: 'POST',
                url: '../_action/mypage.do.php',
                processData: false,
                contentType: false,
                data: _frm,
                dataType: "html",
                success: function (_res) {
                    switch (_res) {
                        case  "999" :
                            //alert(_res);
                            ajax_change();
                            break;
                        default :
                            //alert(_res);
                            break;

                    }
                }
            });
        };

        var interval = 1000;
        setInterval(ajax_call, interval);

    });

    function ajax_change() {
        var mentee_id = $('#mentee_id').val();
        var mentor_id = $('#mentor_id').val();

        var _frm = new FormData();

        _frm.append("Mode", "ajax_call_mentor");
        _frm.append("mentee_id", mentee_id);
        _frm.append("mentor_id", mentor_id);

        $.ajax({
            type: 'POST',
            url: '../_action/mypage.do.php',
            processData: false,
            contentType: false,
            data: _frm,
            dataType: "html",
            success: function (_res) {
                //alert(_res);
                $("#inNerdM").html(_res);
                $("#inNerdM").scrollTop($("#inNerdM")[0].scrollHeight);
            }
        });
    }
</script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
?>
