<?php

$page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

// 검색 변수
$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["keyfield1"] = isNull($_GET["keyfield1"]) ? "" : $_GET["keyfield1"];
$_search["keyword1"] = isNull($_GET["keyword1"]) ? "" : $_GET["keyword1"];
$_search["keyfield2"] = isNull($_GET["keyfield2"]) ? "" : $_GET["keyfield2"];
$_search["keyword2"] = isNull($_GET["keyword2"]) ? "" : $_GET["keyword2"];

$_opt = "page=" . $page . "&search_status=" . $_search["status"] . "&keyfield1=" . $_search["keyfield1"] . "&keyword1=" . $_search["keyword1"] . "&keyfield2=" . $_search["keyfield2"] . "&keyword2=" . $_search["keyword2"];

$idx = $_REQUEST["idx"];

$qry_001  = " SELECT t1.*, t1.REG_DATE AS date ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t1.C_MENTOR),'" . SECRET_KEY . "') as char) as mm_id ";
$qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as p_name ";
$qry_001 .= " FROM {$TB_COUNSEL} t1 ";
$qry_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.C_WRITE = t2.USER_ID ) ";
$qry_001 .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.C_MENTOR = t3.USER_ID ) ";
$qry_001 .= " WHERE t1.IDX = '" . $idx . "' ";

$qry_003 = " SELECT count(*) ";
$qry_003 .= " FROM {$TB_CR} ";
$qry_003 .= " WHERE PARENT_KEY = '{$idx}' ";

$res_001 = $db->exec_sql($qry_001);
$row_001 = $db->sql_fetch_array($res_001);

$res_003 = $db->exec_sql($qry_003);
$row_003 = $db->sql_fetch_row($res_003);
$totalnum = $row_003[0];


?>
<div id="Contents">
    <h1>상담관리 &gt; 상담 리스트 &gt; <strong>상담 상세페이지</strong></h1>

    <form name="frm" method="post" enctype="multipart/form-data" action="./_action/counsel.do.php"
          style="display:inline;" target="actionForm">
        <input type="hidden" id="Mode" name="Mode" value="add_reply">
        <input type="hidden" id="idx" name="idx" value="<?= $idx ?>">
        <table class="tbl1">
            <colgroup>
                <col width="15%"/>
                <col width="35%"/>
                <col width="15%"/>
                <col width="*"/>
            </colgroup>
            <tr>
                <th>분류</th>
                <td class="left">
                    <?= $row_001["C_TYPE"] ?>
                </td>
                <th>상태</th>
                <td class="left">
                    <?php $status = $row_001["C_STATUS"] == "y" ? "활성" : "비활성"; ?>
                    <?= $status ?>
                </td>
            </tr>

            <tr>
                <th>작성자</th>
                <td class="left">
                    <?= clear_escape($row_001["mm_name"]) ?>
                </td>
                <th>전문약사</th>
                <td class="left">
                    <?php $secret = (isNull($row_001["C_MENTOR"])) ? "전체공개" : "약사"; ?>
                    <?php
                    if ($secret == "약사") {
                        echo $row_001["p_name"] . " ( " . $row_001["mm_id"] . " ) ";
                    } else {
                        echo $secret;
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <th>제목</th>
                <td class="left">
                    <?= clear_escape($row_001["C_TITLE"]) ?>
                </td>
                <th>작성일</th>
                <td class="left">
                    <?= $row_001["date"] ?>
                </td>
            </tr>

            <tr>
                <th style="line-height:180%;">내용</th>
                <td colspan="3">
                    <?= nl2br(clear_escape($row_001["C_QUESTION"])) ?>
                </td>
            </tr>
        </table>

        <h1><strong>답변 목록</strong></h1>
        <table class='tbl1'>
            <colgroup>
                <col width="5%"/>
                <col width="10%"/>
                <col width="*"/>
                <col width="10%"/>
                <col width="10%"/>
            </colgroup>

            <tr>
                <th>No</th>
                <th>답변 작성자</th>
                <th>답변내용</th>
                <th>등록일</th>
                <th>관리</th>
            </tr>

            <?
            if ($totalnum > 0) {
                $_j = 1;
                $qry_002  = " SELECT t1.*, t1.REG_DATE AS date ";
                $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                $qry_002 .= " FROM {$TB_CR} t1 ";
                $qry_002 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.R_WRITE = t2.USER_ID ) ";

                $qry_002 .= " WHERE PARENT_KEY = '{$idx}' ";
                $res_002 = $db->exec_sql($qry_002);
                while ($row_002 = $db->sql_fetch_array($res_002)) {
                    ?>
                    <tr>
                        <td class="center"><?= $_j ?></td>
                        <td class="center"><?= clear_escape($row_002["mm_name"]) ?></td>
                        <td><?= nl2br(clear_escape($row_002["R_ANSWER"])) ?><br></td>
                        <td class="center"><?= clear_escape($row_002["date"]) ?></td>
                        <td class="center">
                            <input type="button" value="삭제" class="Small_Button btnRed w50 h24"
                                   onClick="del_cr('<?= $row_002["IDX"] ?>', '<?= $idx ?>');">
                        </td>
                    </tr>
                    <?
                    $_j++;
                }
            } else {
                ?>
                <tr>
                    <td colspan="7" style='height:100px;' class='center'> 등록된 답변이 없습니다 .</td>
                </tr>
                <?
            }
            ?>

        </table>

        <div style="margin-top:20px;" class="center">
            <input type="button" value="목 록" class="Button btnRed w120"
                   onClick="location.href='./admin.template.php?slot=counsel&type=counsel_list&<?= $_opt ?>'">
        </div>
    </form>

</div>

<script>
    function del_cr(cr_idx, idx) {
        if (confirm("정말 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다.")) {
            location.href = "./_action/counsel.do.php?Mode=del_cr&cr_idx=" + cr_idx + "&idx=" + idx;
        }
    }
</script>