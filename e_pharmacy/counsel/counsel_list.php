<?
$offset = 10;
$page_block = 10;
$startNum = "";
$totalnum = "";
$page = "";
$page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

if (!isNull($page)) {
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

// 검색 변수
$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["type"] = isNull($_GET["search_type"]) ? "" : $_GET["search_type"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];

//$_where[] = " ( t1.C_MENTOR = '' OR  t1.C_MENTOR = '{$_pharmacist["key"]}' ) ";


$_where[] = " ( t1.C_TYPE = 1 AND t1.C_MENTOR = '' AND t1.C_SEX = '') 
               OR ( t1.C_TYPE = 2 AND t1.C_SEX = '{$_SESSION["pharmacy"]["sex"]}' AND t1.C_MENTOR = '') 
               OR t1.C_MENTOR = '{$_pharmacist["key"]}' ";

// 상태
if (!isNull($_search["status"])) {
    $_where[] = " t1.N_STATUS = '{$_search["status"]}' ";
}
$_status[$_search["status"]] = "selected";

// 분류
if (!isNull($_search["type"])) {
    $_where[] = " t1.N_TYPE = '{$_search["type"]}' ";
}

// 키워드 검색
if (!isNull($_search["keyword"])) {
    $_where[] = "instr({$_search["keyfield"]}, '{$_search["keyword"]}') >0 ";

}

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY C_STATUS DESC, REG_DATE DESC";
$_limit = " LIMIT " . $startNum . "," . $offset;

$qry_001 = " SELECT   ";
$qry_001 .= " count(*) ";

$_from = " FROM {$TB_COUNSEL} t1 ";
$_from.= " LEFT JOIN {$TB_MEMBER} t2 ON ( t1.C_WRITE = t2.USER_ID ) ";
$_from.= " LEFT JOIN {$TB_MEMBER} t3 ON ( t1.C_MENTOR = t3.USER_ID ) ";

$res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry);
$row_001 = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];

$_opt = "&search_status=" . $_search["status"] . "&search_type=" . $_search["type"] . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"];

?>

<div id="content">
    <div class="sub_tit">상담관리 > 상담목록</div>
    <div id="cont">
        <div class="adm_cts">

            <h3 class="h3_title">검색설정 </h3>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" id="srFrm">
                <input type="hidden" id="sh_slot" name="slot" value="<?= $_slot ?>">
                <input type="hidden" id="sh_type" name="type" value="<?= $_type ?>">
                <div class="adm_table_style01 pb20">
                    <table>
                        <colgroup>
                            <col style="width:10%"/>
                            <col style="width:10%"/>
                            <col style="width:*"/>
                        </colgroup>
                        <tbody>
                        <tr>
                            <th rowspan="4">검색조건</th>
                            <th>승인날짜 &nbsp; <input type="checkbox" id="schChkDate" name="schChkDate" value="Y"
                                                   onClick="dateDisable();" <?= $_checked ?>></th>
                            <td>
                                <input type="text" name="schReqSDate" id="schReqSDate" readonly
                                       value="<?= $schReqSDate ?>"
                                       class="wid15" <?= $_disabled ?>/> 일 부터 &nbsp;&nbsp;
                                <input type="text" name="schReqEDate" id="schReqEDate" readonly
                                       value="<?= $schReqEDate ?>"
                                       class="wid15" <?= $_disabled ?>/> 일 까지
                            </td>
                        </tr>
                        <tr>
                            <th>구 분</th>
                            <td>
                                <b>성별</b> &nbsp;:&nbsp;
                                <select id="search_sex" name="search_sex" class="wid10" onChange="srFrm.submit();">
                                    <option value="">전체</option>
                                    <option value="M" <?php if ($search["sex"] == "M") {
                                        echo 'selected';
                                    } ?>>남성
                                    </option>
                                    <option value="F" <?php if ($search["sex"] == "F") {
                                        echo 'selected';
                                    } ?>>여성
                                    </option>
                                </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <b>유형</b> &nbsp;:&nbsp;
                                <select id="search_region" name="search_region" class="wid10"
                                        onChange="srFrm.submit();">
                                    <option value="">전체</option>
                                    <option value="i" <?php if ($search["region"] == "i") {
                                        echo 'selected';
                                    } ?>>메인약사
                                    </option>
                                    <option value="o" <?php if ($search["region"] == "o") {
                                        echo 'selected';
                                    } ?>>협동약사
                                    </option>
                                </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr>
                            <th>조건검색</th>
                            <td colspan="3">
                                <select name="keyfield" class="wid15">
                                    <option value="t1.MM_NAME" <?php if ($search["keyfield"] == "t1.MM_NAME") {
                                        echo 'selected';
                                    } ?>>이름
                                    </option>
                                    <option value="t1.MM_EMAIL" <?php if ($search["keyfield"] == "t1.MM_EMAIL") {
                                        echo 'selected';
                                    } ?>>이메일
                                    </option>
                                    <option value="t2.MM_HP" <?php if ($search["keyfield"] == "t2.MM_HP") {
                                        echo 'selected';
                                    } ?>>연락처
                                    </option>
                                    <option value="t2.MM_HP" <?php if ($search["keyfield"] == "t2.MM_HP") {
                                        echo 'selected';
                                    } ?>>약사면허
                                    </option>
                                </select>
                                <input name="keyword" type="text" class="wid40" value="<?= $search["keyword"] ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <th>검 색</th>
                            <td colspan="3">
                                <a class="btn btn04" onclick="srFrm.submit();">검색</a>&nbsp;&nbsp;
                                <a class="btn btn01"
                                   onclick="location.href='./pharmacy.template.php?slot=<?= $_slot ?>&type=<?= $_type ?>'">초기화</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </form>
            <h3 class="h3_title mt40">상담 목록 ( <?= number_format($totalnum) ?> )</h3>
            <form id='frm' name='frm'>
                <input type="hidden" id="Mode" name="Mode" value="">
                <div class="adm_table_style02">
                    <table>
                        <colgroup>
                            <col style="width:4%"/>
                            <col style="width:6%"/>
                            <col style="width:15%"/>
                            <col style="*"/>
                            <col style="width:12%"/>
                            <col style="width:5%"/>
                            <col style="width:12%"/>
                            <col style="width:6%"/>
                        </colgroup>
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>상태</th>
                            <th>분류</th>
                            <th>제목</th>
                            <th>작성자</th>
                            <th>클릭수</th>
                            <th>등록일</th>
                            <th>관리</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($totalnum > 0) {

                            $qry_002  = " SELECT t1.*, t1.REG_DATE AS date ";
                            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t1.C_WRITE),'" . SECRET_KEY . "') as char) as mm_id ";
                            $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_NAME),'" . SECRET_KEY . "') as char) as p_name ";
                            $res_002 = $db->exec_sql($qry_002 . $_from . $_whereqry . $_order . $_limit);

                            $_j = 0;
                            while ($row_002 = $db->sql_fetch_array($res_002)) {

                                $_jul = $totalnum - ($startNum + $_j);
                                $_status_view = $row_002["C_STATUS"] == "y" ? "활성" : "비활성";
                                $secret = ($row_002["C_TYPE"] == 1) ? "<font color='0000FF'>전체공개</font>" : "<font color='FF0000'>비공개</font>";
                                $up_url = "./pharmacy.template.php?slot=counsel&type=counsel_detail&idx=" . $row_002["IDX"] . "&page=" . $page . $_opt;

                                ?>
                                <tr>
                                    <td class="center"><?= $_jul ?></td>
                                    <td class="center"><?= $_status_view ?></td>
                                    <td class="center"><?=$secret?>
                                    </td>
                                    <!--<td class="center"><?/*= clear_escape($row_002["CD_TITLE"]) */ ?></td>-->
                                    <td class="center"><?= clear_escape($row_002["C_TITLE"]) ?><br></td>
                                    <td class="center"><?= clear_escape($row_002["mm_name"]) ?></td>
                                    <td class="center"><?= number_format($row_002["HIT"]) ?></td>
                                    <td class="center"><?= clear_escape($row_002["date"]) ?></td>
                                    <td class="center">
                                        <input type="button" value="상세" class="btn_s btn13" onClick="location.href='<?= $up_url ?>'">&nbsp;

                                    </td>
                                </tr>
                                <?
                                $_j++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="9" height="250" class='t_c'>등록된 상담이 없습니다.</td>
                            </tr>
                            <?
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="b_page_no">
                <?
                $paging = new paging("./pharmacy.template.php", "slot=counsel&type=counsel_list", $offset, $page_block, $totalnum, $page, $_opt);
                $paging->pagingArea("", "");
                ?>
            </div>
            <br><br><br><br>
        </div>
    </div>
</div>
