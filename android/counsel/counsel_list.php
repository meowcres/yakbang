<?php
include_once "../../_core/_init.php";
include_once "../inc/top.php";
include_once "../inc/sub_header.php";
include_once "../_member.php";

$qry_cnt = " SELECT COUNT(t1.*)";

$qry_001 = " SELECT t1.*, t2.*, t1.REG_DATE AS date, t1.IDX AS id ";
$qry_001  .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
$qry_001  .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as p_name ";
$from_001  = " FROM {$TB_COUNSEL} t1 ";
$from_001 .= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.C_WRITE = t2.USER_ID ) ";
$from_001 .= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.C_MENTOR = t3.USER_ID ) ";

// 회원일 경우
$where_001 = " WHERE t1. C_TYPE = 1 OR (t1.C_TYPE = 2 AND t1.C_WRITE = '{$mm_row["USER_ID"]}') ";

// 약사일 경우
$where_002 = " WHERE ( t1.C_TYPE = 1 AND t1.C_MENTOR = '' AND t1.C_SEX = '') 
               OR ( t1.C_TYPE = 2 AND t1.C_SEX = '{$mm_row["USER_SEX"]}' AND t1.C_MENTOR = '') 
               OR t1.C_MENTOR = '{$mm_row["USER_ID"]}' ";

$order_001 = " ORDER BY t1.C_STATUS DESC, t1.REG_DATE DESC ";

$res_cnt = $db->exec_sql($qry_cnt . $from_001);
$row_cnt = $db->sql_fetch_row($res_cnt);
$totalnum = $row_cnt[0];

?>
    <div class="coNtent">
        <div class="position_wrap">
            <span>상담</span>
            <span>상담목록</span>
        </div>
        <div class="inner_coNtbtnwrap3">
            <div class="fixedbodycoNt">
                <div class="consulting_wrap">
                    <ul>
                        <?php
                        if ($mm_type == 1) {
                            $res_001 = $db->exec_sql($qry_001 . $from_001 . $where_001 . $order_001);
                            while ($row_001 = $db->sql_fetch_array($res_001)) {
                                $secret = $row_001["C_TYPE"] == '1' ? "전체공개" : "비공개";                    
                            ?>
                                <li>                      
                                    <a href="./counsel_detail.php?idx=<?= $row_001["id"] ?>">
                                        <span><?= $secret ?></span>
                                        <div class="iNtit">
                                            <?= clear_escape($row_001["C_TITLE"]) ?>
                                        </div>
                                        <div class="iNtxx">
                                            <em><?= mb_substr($row_001["mm_name"], 0, 1, 'UTF-8') ?>**</em>
                                            <em><?= clear_escape($row_001["date"]) ?></em>
                                        </div>
                                    </a>
                 
                                </li>
                            <?
                            }
                        } else if ($mm_type == 2) {
                            $res_001 = $db->exec_sql($qry_001 . $from_001 . $where_002 . $order_001);
                            while ($row_001 = $db->sql_fetch_array($res_001)) {
                                $secret = $row_001["C_TYPE"] == '1' ? "전체공개" : "비공개";
                            ?>                            
                            <li>                  
                                <a href="./counsel_detail.php?idx=<?= $row_001["id"] ?>">
                                    <span><?= $secret ?></span>
                                    <div class="iNtit">
                                        <?= clear_escape($row_001["C_TITLE"]) ?>
                                    </div>
                                    <div class="iNtxx">
                                        <em><?= mb_substr($row_001["mm_name"], 0, 1, 'UTF-8') ?>**</em>
                                        <em><?= clear_escape($row_001["date"]) ?></em>
                                    </div>
                                </a>             
                            </li>
                            <?
                            }
                        }
                        ?>     
                    </ul>
                </div>
            </div>
        </div>
        <?php
        if (!isNull($_COOKIE["cookie_user_id"])) {
            ?>

            <!-- 회원만 상담 등록 가능-->
            <?php
            if ($mm_type == 1) {
                ?>
                <div class="coNtBtn">
                    <div class="coNtbtn_wrap">
                        <a href="./counsel_register.php" class="ecolor"><span class="noiMg">상담 등록</span></a>
                    </div>
                </div>
                <?
            } else if ($mm_type == 2) {
                ?>
                
                 <!-- 약사는 상담등록 불가 -->
                <?
            }
            ?>
            <!-- 약사는 상담등록 불가 끝 -->


            <?
        }
        ?>

    </div>

<?php
include_once "../inc/footer.php";
include_once "../inc/bottom.php";