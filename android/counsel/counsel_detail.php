<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

$idx = $_REQUEST["idx"];

$qry_001   = " SELECT t1.*, t2.*, t1.REG_DATE date ";
$qry_001  .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
$qry_001  .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as p_name ";
$from_001  = " FROM {$TB_COUNSEL} t1 ";
$from_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.C_WRITE = t2.USER_ID ) ";
$from_001 .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.C_MENTOR = t3.USER_ID ) ";
$where_001 = " WHERE t1.IDX = '{$idx}' ";
$order_001 = " ORDER BY t1.C_STATUS DESC, t1.REG_DATE DESC ";

$qry_003 = " SELECT COUNT(*) ";
$qry_003 .= " FROM {$TB_CR} t1";
$qry_003 .= " WHERE PARENT_KEY = '{$idx}' ";

$res_003 = $db->exec_sql($qry_003);
$row_003 = $db->sql_fetch_row($res_003);
$totalnum = $row_003[0];

?>
    <div class="coNtent">
        <div class="position_wrap">
            <span>상담</span>
            <span>상담목록</span>
            <span>상담상세</span>
        </div>
        <div class="inner_coNtbtnwrap2">
            <div class="fixedbodycoNt">
                <div class="consulting_detail_wrap">
                    <input type="hidden" id="idx" name="idx" value="<?=$idx?>">                    

                    <?php
                    $res_001 = $db->exec_sql($qry_001 . $from_001 . $where_001 . $order_001);
                    $row_001 = $db->sql_fetch_array($res_001);
                    $secret = $row_001["C_MENTOR"] == '' ? "전체공개" : "";
                    ?>
                    <ul class="cNdtBxList">
                        <li>
                            <span>전문약사</span>
                            <?php
                            if ($secret == "") {
                                ?>
                                <span><?= mb_substr(clear_escape($row_001["p_name"]), 0, 1, 'UTF-8') ?>**</span>
                                <?
                            } else {
                                ?>
                                <span><?= $secret ?></span>
                            <?
                            }
                            ?>
                        </li>
                        <li>
                            <span>상담 제목</span>
                            <span><?= clear_escape($row_001["C_TITLE"]) ?></span>
                        </li>
                        <li>
                            <span>질문 내용</span>
                            <span><?= nl2br(clear_escape($row_001["C_QUESTION"])) ?></span>
                        </li>
                        <li>
                            <span>작성자</span>
                            <span><?= mb_substr(clear_escape($row_001["mm_name"]), 0, 1, 'UTF-8') ?>**</span>
                        </li>
                        <li>
                            <span>작성일</span>
                            <span><?= clear_escape($row_001["date"]) ?></span>
                        </li>
                    </ul>
                    <hr>
                    <?
                    if ($totalnum > 0) {
                        ?>
                        <h3>답변목록</h3>
                        <?php
                        $qry_002 = " SELECT t1.*, t1.REG_DATE AS date ";
                        $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                        $qry_002 .= " FROM {$TB_CR} t1 ";
                        $qry_002 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.R_WRITE = t2.USER_ID ) ";
                        $qry_002 .= " WHERE t1.PARENT_KEY = '{$idx}' ";

                        $res_002 = $db->exec_sql($qry_002);
                        while ($row_002 = $db->sql_fetch_array($res_002)) {

                            ?>

                            <div class="iNanswer">
                                <div class="iNanswerBx">
                                    <!-- 약사는 멘토 등록 불가 -->
                                    <?php
                                    if ($mm_type == 1) {
                                        ?>
                                            <span>
                                                <?= mb_substr(clear_escape($row_002["mm_name"]), 0, 1, 'UTF-8') ?>**                                     
                                                <a href="javascript:void(0);" onclick="add_mentor('<?= $row_001["USER_ID"] ?>', '<?= $row_002["R_WRITE"] ?>', '<?= $idx ?>');">( 멘토등록 )</a>
                                            </span>
                                        <?
                                    } else if ($mm_type == 2) {
                                        ?>
                                            <span>
                                                <?= mb_substr(clear_escape($row_002["mm_name"]), 0, 1, 'UTF-8') ?>**                                     
                                            </span>
                                        <?
                                    }
                                    ?>

                                    <span><?= clear_escape($row_002["date"]) ?></span>
                                </div>
                                <div class="iNanswercoNt">
                                    <?= nl2br(clear_escape($row_002["R_ANSWER"])) ?>
                                </div>
                            </div>
                            <?
                        }
                    } else {
                        ?>
                        <div class="noDAta">
                            등록된 답변이 없습니다.
                        </div>
                        <?
                    }
                    ?>
                </div>
                <!-- content end -->
            </div>
        </div>
        <div class="coNtBtn">
            <div class="coNtbtn_wrap">

                <!-- 회원은 답변 등록 불가 -->
                <?php
                if ($mm_type == 1) {
                    ?>
                        <a href="javascript:void(0);" onclick="history.back();" class="ecolor"><span class="noiMg">목록</span></a>
                    <?
                } else if ($mm_type == 2) {
                    ?>
                        <a href="javascript:void(0);" onclick="history.back();" class="ecolor"><span class="noiMg">목록</span></a>    
                        <a href="./counsel_reply.php?idx=<?= $idx ?>" class="ecolor_plus"><span class="noiMg">답변하기</span></a>
                    <?
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        function add_mentor(mentee_id, mentor_id, idx) {

            var _frm = new FormData();

            _frm.append("Mode", "add_mentor");
            _frm.append("mentee_id", mentee_id);
            _frm.append("mentor_id", mentor_id);
            _frm.append("idx", idx);

            $.ajax({
                method: 'POST',
                url: "../_action/counsel.do.php",
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    console.log(_res);
                    switch (_res) {
                        case "0" :
                            alert("멘토 등록이 완료되었습니다.");
                            break;
                        case "1" :
                            alert("멘토 등록은 로그인 후 가능합니다.");
                            break;
                        case "2" :
                            alert("이미 등록된 멘토입니다.");
                            break;
                        default :
                            alert("에러");
                            break;
                    }
                }
            });
        }
    </script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";