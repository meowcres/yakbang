<?php

$page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

// 검색 변수
/*$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["type"] = isNull($_GET["search_type"]) ? "" : $_GET["search_type"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];
$_opt = "page=" . $page . "&search_status=" . $_search["status"] . "&search_type=" . $_search["type"] . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"];*/

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
$secret = ($row_002["C_TYPE"] == 1) ? "전체공개" : "비공개";
?>
<div id="content">
    <div class="sub_tit">상담관리 > 상담목록 > 상담 상세</div>
    <div id="cont">
        <div class="adm_cts">
            <div class="adm_table_style01">
                <table>
                    <colgroup>
                        <col style="width:15%"/>
                        <col style="width:35%"/>
                        <col style="width:15%"/>
                        <col style="*"/>
                    </colgroup>
                    <tr>
                        <th>분류</th>
                        <td>
                            <?= $secret ?>
                        </td>
                        <th>상태</th>
                        <td>
                            <?php $status = $row_001["C_STATUS"] == "y" ? "활성" : "비활성"; ?>
                            <?= $status ?>
                        </td>
                    </tr>

                    <tr>
                        <th>작성자</th>
                        <td>
                            <?= clear_escape($row_001["mm_name"]) ?>
                        </td>
                        <th>조회수</th>
                        <td><?=$row_001["HIT"]?></td>
                    </tr>

                    <tr>
                        <th>제목</th>
                        <td>
                            <?= clear_escape($row_001["C_TITLE"]) ?>
                        </td>
                        <th>작성일</th>
                        <td>
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

                <h3 class="h3_title mt40">답변 목록 ( <?= number_format($totalnum) ?> )</h3>
                    <table>
                        <colgroup>
                            <col style="width:4%"/>
                            <col style="width:10%"/>
                            <col style="width:*"/>
                            <col style="width:12%"/>
                            <col style="width:8%"/>
                        </colgroup>
                        <thead>
                        <tr style="height: 50px">
                            <th>No</th>
                            <th>답변 작성자</th>
                            <th>답변내용</th>
                            <th>등록일</th>
                            <th>관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        if ($totalnum > 0) {
                            $_j = 1;
                            $qry_002  = " SELECT t1.*, t1.REG_DATE AS date ";
                            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t1.R_WRITE),'" . SECRET_KEY . "') as char) as mm_write ";
                            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                            $qry_002 .= " FROM {$TB_CR} t1 ";
                            $qry_002 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.R_WRITE = t2.USER_ID ) ";
                            $qry_002 .= " WHERE PARENT_KEY = '{$idx}' ";
                            $res_002 = $db->exec_sql($qry_002);
                            while ($row_002 = $db->sql_fetch_array($res_002)) {
                                ?>
                                <tr>
                                    <td style="text-align: center"><?= $_j ?></td>
                                    <td style="text-align: center"><?= clear_escape($row_002["mm_name"]) ?></td>
                                    <td><?= nl2br(clear_escape($row_002["R_ANSWER"])) ?><br></td>
                                    <td style="text-align: center"><?= clear_escape($row_002["date"]) ?></td>

                                    <?php
                                    if ($_pharmacist["id"] == $row_002["mm_write"]) {
                                        ?>
                                            <td style="text-align: center">
                                                <input type="button" value="삭제" class="btn_s btn14" onClick="del_cr('<?= $row_002["IDX"] ?>', '<?= $idx ?>', '<?= $_pharmacist["id"] ?>');">
                                            </td>
                                        <?
                                    } else {
                                        ?>
                                            <td style="text-align: center">-</td>
                                        <?
                                    }
                                    ?>

                                </tr>
                                <?
                                $_j++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td class="t_c" colspan="5" height="100">등록된 답변이 없습니다.</td>
                            </tr>
                            <?
                        }
                        ?>
                        </tbody>
                    </table>
                <form id="frm" name="frm" method="post" action="./_action/counsel.do.php" style="display:inline;" target="actionForm">
                    <input type="hidden" id="Mode" name="Mode" value="add_cr">
                    <input type="hidden" id="idx" name="idx" value="<?= $idx ?>">
                    <input type="hidden" id="cr_idx" name="cr_idx" value="<?= $row_002["IDX"] ?>">

                    <h3 class="h3_title mt40">답변 등록</h3>
                    <div class="adm_table_style01">
                        <table>
                            <colgroup>
                                <col style="width:15%"/>
                                <col style="width:35%"/>
                                <col style="width:15%"/>
                                <col style="*"/>
                            </colgroup>
                            <tr>
                                <th>작성자</th>
                                <td>
                                    <input id="r_write" name="r_write" value="<?= $_pharmacist["id"] ?>" type="text"
                                           readonly>
                                </td>
                                <th>등록일</th>
                                <td>
                                    <input id="reg_date" name="reg_date" value="<?= date('Y-m-d') ?>" type="text"
                                           readonly>
                                </td>
                            </tr>
                            <tr>
                                <th>답변 내용</th>
                                <td colspan="3">
                                    <textarea id="r_answer" name="r_answer"></textarea>
                                </td>
                            </tr>

                        </table>
                    </div>
                    <br>
                    <div class="btn_area t_c">
                        <a onClick="add_cr()" class="btn_b btn21">작 성</a>
                        <a onClick="location.href='./pharmacy.template.php?slot=counsel&type=counsel_list&<?= $_opt ?>'"
                           class="btn_b btn01">목 록</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function add_cr() {
        $("#frm").submit();
    }

    function del_cr(cr_idx, idx, r_write) {
        if (confirm("정말 삭제하시겠습니까? \n\n삭제후에는 복구가 불가능합니다.")) {
            actionForm.location.href = "./_action/counsel.do.php?Mode=del_cr2&cr_idx=" + cr_idx + "&idx=" + idx + "&r_write=" + r_write;
        }
    }
</script>