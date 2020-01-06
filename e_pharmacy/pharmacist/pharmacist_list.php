<?php
// 페이지 분할 변수
$offset = 20;
$page_block = 10;
$startNum = "";
$totalnum = "";
$page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

if (!isNull($page)) {
    $page = $page;
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

// 검색 변수
$_search = array();
$_search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$_search["type"] = isNull($_GET["search_type"]) ? "1" : $_GET["search_type"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];

// 리스트 조건절
$qry_where_array[] = "t1.PHARMACY_CODE = '{$_pharmacy["code"]}'";
$qry_where_array[] = "t2.USER_TYPE = '2'";
$qry_where_array[] = "t1.P_STATUS != '2'";

if ($_search["schChkDate"] == "Y") {
    $_checked = "checked";
    $_disabled = "";

    $_where[] = " t1.reg_date BETWEEN '" . date("Y-m-d H:i:s", strtotime($_search["schReqSDate"])) . "' AND '" . date("Y-m-d H:i:s", strtotime("+1 days", strtotime($_search["schReqEDate"]) - 1)) . "' ";
} else {
    $_checked = "";
    $_disabled = "disabled";
}

// 활동상태
if (!isNull($_search["status"])) {
    $qry_where_array[] = "t1.USER_STATUS='{$_search["status"]}'";
}
$_status[$_search["status"]] = "selected";

// 키워드 검색
if (!isNull($_search["keyword"])) {
    $qry_where_array[] = $_search["keyfield"] . " = HEX(AES_ENCRYPT('" . $_search["keyword"] . "','" . SECRET_KEY . "'))";
}

$_opt = "&search_status=" . $_search["status"] . "&keyfield=" . $_search["keyfield"] . "&keyword=" . $_search["keyword"] . "&schChkDate=" . $_search["schChkDate"] . "&schReqSDate=" . $_search["schReqSDate"]. "&schReqEDate=" . $_search["schReqEDate"];


$qry_where = count($qry_where_array) ? " WHERE " . implode(' AND ', $qry_where_array) : "";
$qry_order = " ORDER BY t1.P_GRADE DESC";
$qry_limit = " LIMIT " . $startNum . "," . $offset;

$qry_001 = "SELECT ";
$qry_001 .= "count(*) ";

$qry_from = "FROM {$TB_PP} t1 ";
$qry_from .= "LEFT JOIN {$TB_MEMBER} t2 ON (t1.USER_ID = t2.USER_ID) ";
$qry_from .= "LEFT JOIN {$TB_MEMBER_INFO} t3 ON (t1.USER_ID = t3.ID_KEY) ";

$res_001 = $db->exec_sql($qry_001 . $qry_from . $qry_where);
$row_001 = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];

// 주소이동변수
$url_opt = "&search_status=" . $search["status"] . "&search_region=" . $search["region"] . "&search_sex=" . $search["sex"] . "&search_support=" . $search["support"] . "&search_nation=" . $search["nation"] . "&search_ssCode=" . $search["sscode"] . "&keyfield=" . $search["keyfield"] . "&keyword=" . urlencode($search["keyword"]);
?>

<div id="content">
    <div class="sub_tit">약사관리 > 약사목록</div>
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
                                <b>상태</b> &nbsp;:&nbsp;
                                <select id="search_status" name="search_status" class="wid10" onChange="srFrm.submit();">
                                    <option value="">전체</option>
                                    <?php
                                    foreach ($pharmacist_status_array as $key => $val) {
                                        $selected = $key == $_search["status"] ? "SELECTED" : "";
                                        ?>
                                    <option value="<?= $key ?>" <?= $selected ?> > <?= $val ?> </option><?
                                    }
                                    ?>
                                </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <b>유형</b> &nbsp;:&nbsp;
                                <select id="search_region" name="search_region" class="wid10"
                                        onChange="srFrm.submit();">
                                    <option value="">전체</option>
                                    <?php
                                    foreach ($pharmacist_grade_array as $key => $val) {
                                        $selected = $key == $_search["status"] ? "SELECTED" : "";
                                        ?>
                                    <option value="<?= $key ?>" <?= $selected ?> > <?= $val ?> </option><?
                                    }
                                    ?>
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

            <h3 class="h3_title mt40">약사 목록 ( <?= number_format($totalnum) ?> )</h3>

            <div class="adm_table_style02">
                <table>
                    <colgroup>
                        <col style="width:15%"/>
                        <col style="width:8%"/>
                        <col style="width:8%"/>
                        <col style="width:15%"/>
                        <col style="width:6%"/>
                        <col style="*"/>
                        <col style="width:18%"/>
                        <col style="width:10%"/>
                    </colgroup>
                    <thead>
                    <tr>
                        <th>승인날짜</th>
                        <th>상태</th>
                        <th>유형</th>
                        <th>약사명</th>
                        <th>성별</th>
                        <th>약사번호</th>
                        <th>소속기간</th>
                        <th>관리</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($totalnum > 0) {

                        $qry_002 = "SELECT t1.*, t2.*, t3.* ";
                        $qry_002 .= ", CAST(AES_DECRYPT(UNHEX(t2.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
                        $qry_002 .= ", CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                        $qry_002 .= ", t1.REG_DATE as ss_date ";
                        $qry_002 .= ", t1.IDX as ppidx ";


                        $res_002 = $db->exec_sql($qry_002 . $qry_from . $qry_where . $qry_order . $qry_limit);

                        $count_num = 0;
                        while ($row_002 = $db->sql_fetch_array($res_002)) {

                            $member_sex = $row_002['USER_SEX'] == "M" ? "<font color='#3300FF'>남성</font>" : "<font color='#FF6600'>여성</font>";
                            $pharmacist_grade = $row_002['P_GRADE'] == "2" ? "<font color='#3300FF'>메인약사</font>" : "<font color='#FF6600'>협동약사</font>";
                            $pharmacy_code = $row_002["PHARMACY_CODE"];
                            ?>
                            <tr>
                                <td><?= $row_002['ss_date'] ?></td>
                                <td><?= $pharmacist_status_array[$row_002['P_STATUS']] ?></td>
                                <td><?= $pharmacist_grade ?></td>
                                <td><?= $row_002['mm_name'] ?></td>
                                <td><?= $member_sex ?></td>
                                <td><?= $row_002['LICENSE_NUMBER'] ?></td>
                                <td><?= $row_002['S_DATE'] ?> ~ <?= $row_002['E_DATE'] ?></td>
                                <td>
                                    <a href="javascript:void(0);"
                                       onclick="openWin('./pharmacist/popup_pharmacist_update.php?idx=<?=$row_002["ppidx"]?>&p_code=<?=$pharmacy_code?>','pharmacist_update',1000,400,'scrollbars=yes')"
                                       class="btn_s btn13">관리</a>
                                    <a href="javascript:void(0);" class="btn_s btn14" onclick="del_pp('<?=$row_002["ppidx"]?>');">제명</a>
                                </td>
                            </tr>
                            <?php
                        }

                    } else {
                        ?>
                        <tr>
                            <td class="t_c" colspan="9" height="250">등록된 약사가 없습니다.</td>
                        </tr>
                        <?php
                    }
                    ?>

                    </tbody>
                </table>
            </div>

            <div class="b_page_no">
                <?php
                $paging = new paging("./admin.member.php", "slot=member&type=member_list", $offset, $page_block, $totalnum, $page, $url_opt);
                $paging->pagingArea("", "");
                ?>
            </div>

            <br><br><br><br>
        </div>
    </div><!-- cont -->
</div><!-- content e -->


<script>
    <!--
    function del_pp(idx){
        if(confirm("전문약사를 신청을 취소 하시겠습니까?")){
            var url = "./_action/pharmacist.do.php?Mode=del_pharmacist&idx="+idx ;
            actionForm.location.href=url ;
        }
    }
    //-->
</script>

