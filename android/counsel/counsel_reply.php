<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

if (isNull($_COOKIE["cookie_user_id"])) {
    alert_js("alert_parent_back","로그인 후 이용가능합니다.","");
}

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
            <span>답변등록</span>
        </div>

        <div class="inner_coNtbtnwrap2">
            <div class="fixedbodycoNt">
                <div class="consulting_detail_wrap">
                    <?php
                    $res_001 = $db->exec_sql($qry_001 . $from_001 . $where_001 . $order_001);
                    $row_001 = $db->sql_fetch_array($res_001);
                    $secret = $row_001["C_MENTOR"] == '' ? "전체공개" : "";
                    ?>

                        
                    <form id="frm" name="frm" method="post" action="./_action/counsel.do.php" style="display:inline;" target="actionForm">
                        <input type="hidden" id="parent_key" name="parent_key" value="<?=$idx?>">
                        <input type="hidden" id="r_write" name="r_write" value="<?= $mm_row["USER_ID"] ?>">

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

                            <li>
                                <span>답변하기</span>
                                <span><textarea name="r_answer" id="r_answer" style="height: 150px"></textarea></span>
                              
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>

        <div class="coNtBtn">
            <div class="coNtbtn_wrap">
                <a href="javascript:void(0);" onclick="chk_form();" class="ecolor"><span class="noiMg">답변 등록</span></a>
            </div>
        </div>
    </div>

<script>
    function chk_form() {

        if ($("#r_answer").val() == "") {
            alert("내용 입력 해 주세요");
            $("#r_answer").focus();
            return false;
        }

        var parent_key = $("#parent_key").val();
        var r_write = $("#r_write").val();
        var r_answer = $("#r_answer").val();
        var _frm = new FormData();

        _frm.append("Mode", "reply_counsel");
        _frm.append("parent_key", parent_key);
        _frm.append("r_write", r_write);
        _frm.append("r_answer", r_answer);

        $.ajax({
            method: 'POST',
            url: "../_action/counsel.do.php",
            processData: false,
            contentType: false,
            data: _frm,
            success: function (_res) {
                console.log(_res);
                switch (_res) {
                    case "100" :
                        alert("상담을 등록하였습니다.");
                        location.href = "../counsel/counsel_list.php";
                        break;
                    default :
                        alert("상담 등록 실패");
                        break;
                }
            }
        });
    }
</script>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";
