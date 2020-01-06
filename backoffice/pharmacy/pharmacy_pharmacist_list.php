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
$search = array();

$search["sex"] = isNull($_GET["search_sex"]) ? "" : $_GET["search_sex"];
$search["region"] = isNull($_GET["search_region"]) ? "" : $_GET["search_region"];
$search["support"] = isNull($_GET["search_support"]) ? "" : $_GET["search_support"];
$search["nation"] = isNull($_GET["search_nation"]) ? "" : $_GET["search_nation"];
$search["sscode"] = isNull($_GET["search_ssCode"]) ? "" : $_GET["search_ssCode"];
$search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];


// 리스트 조건절
$qry_where_array[] = "t1.P_STATUS != '1'";
$qry_where_array[] = "t1.P_STATUS != '4'";
$qry_where_array[] = "t1.P_STATUS != '5'";
$qry_where_array[] = "t2.USER_TYPE = '2'";


// 로그인 상태 검색
if (!isNull($search["status"])) {
    $qry_where_array[] = "t1.MM_STATUS in ('" . $search["status"] . "')";
}

// 성별 검색
if (!isNull($search["sex"])) {
    $qry_where_array[] = "t1.MM_SEX in ('" . $search["sex"] . "')";
}

// 유형 검색
if (!isNull($search["region"])) {
    $qry_where_array[] = "t1.MM_REGION in ('" . $search["region"] . "')";
}

// 지원여부 검색
if (!isNull($search["support"])) {
    if ($search["support"] == "no") {
        $qry_where_array[] = "t3.SUPPORT_STATUS is NULL";
    } else {
        $qry_where_array[] = "t3.SUPPORT_STATUS in ('" . $search["support"] . "')";
    }
}

// 국적 검색
if (!isNull($search["nation"])) {
    $qry_where_array[] = "t2.NATION_CODE in ('" . $search["nation"] . "')";
}


// 키워드 검색
if (!isNull($search["keyword"])) {
    $qry_where_array[] = "instr({$search["keyfield"]}, '{$search["keyword"]}') > 0 ";
}


$qry_where = count($qry_where_array) ? " WHERE " . implode(' AND ', $qry_where_array) : "";
$qry_order = " ORDER BY ss_date DESC";
$qry_limit = " LIMIT " . $startNum . "," . $offset;

$qry_001 = "SELECT ";
$qry_001 .= "count(*) ";

$qry_from = "FROM {$TB_PP} t1 ";
$qry_from .= "LEFT JOIN {$TB_MEMBER} t2 ON (t1.USER_ID = t2.USER_ID) ";
$qry_from .= "LEFT JOIN {$TB_MEMBER_INFO} t3 ON (t1.USER_ID = t3.ID_KEY) ";
$qry_from .= "LEFT JOIN {$TB_PHARMACY} t4 ON (t1.PHARMACY_CODE = t4.PHARMACY_CODE) ";


$res_001 = $db->exec_sql($qry_001 . $qry_from . $qry_where);
$row_001 = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];

// 주소이동변수
$url_opt = "&search_status=" . $search["status"] . "&search_region=" . $search["region"] . "&search_sex=" . $search["sex"] . "&search_support=" . $search["support"] . "&search_nation=" . $search["nation"] . "&search_ssCode=" . $search["sscode"] . "&keyfield=" . $search["keyfield"] . "&keyword=" . urlencode($search["keyword"]);
?>

<div id="Contents">
    <h1>약국관리 &gt; 약국 관리 &gt; <strong>약국목록</strong></h1>


    <div id="cont">
        <div class="adm_cts">

            <h3 class="h3_title">검색설정 </h3>

            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" id="srFrm" target="actionForm">
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
                                </select>
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
                                <input type="submit" value="검색" class="btnOrange w80 h24" onclick="srFrm.submit();"> &nbsp;
                                <input type="button" value="초기화" class="btnGray w80 h24"
                                       onClick="location.href='./admin.template.php?slot=<?= $_slot ?>&type=<?= $_type ?>'">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </form>

            <div class="left" style="margin-top:15px;"><b>소속약사 신청 목록</b> ( 검색 인원 : <?= number_format($totalnum) ?> 명 )</div>

            <table>
                <colgroup>
                    <col style="width:4%"/>
                    <col style="width:12%"/>
                    <col style="width:6%"/>
                    <col style="width:15%"/>
                    <col style="*"/>
                    <col style="width:10%"/>
                    <col style="width:4%"/>
                    <col style="width:12%"/>
                    <col style="width:10%"/>
                    <col style="width:10%"/>
                </colgroup>
                <thead>
                <tr>
                    <th>선택</th>
                    <th>신청일</th>
                    <th>상태</th>
                    <th>[관리번호] 약국명</th>
                    <th>약사번호</th>
                    <th>약사명</th>
                    <th>성별</th>
                    <th>아이디</th>
                    <th>연락처</th>
                    <th>관리</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($totalnum > 0) {

                    $qry_002 = "SELECT t1.IDX as ID, t1.*, t2.*, t3.*, t4.* ";
                    $qry_002 .= ", CAST(AES_DECRYPT(UNHEX(t2.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
                    $qry_002 .= ", CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                    $qry_002 .= ", CAST(AES_DECRYPT(UNHEX(t3.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";
                    $qry_002 .= ", t1.REG_DATE as ss_date ";
                    $qry_002 .= ", t4.PHARMACY_NAME as p_name ";
                    $qry_002 .= ", t4.PHARMACY_NUMBER as p_num ";


                    $res_002 = $db->exec_sql($qry_002 . $qry_from . $qry_where . $qry_order . $qry_limit);

                    $count_num = 0;
                    while ($row_002 = $db->sql_fetch_array($res_002)) {

                        $member_sex = $row_002['USER_SEX'] == "M" ? "남성" : "여성";
                        $pharmacist_status = $row_002['P_STATUS'] == "2" ? "<font color='#3300FF'>$pharmacist_status_array[2]</font>" : "<font color='#FF6600'>$pharmacist_status_array[3]</font>";


                        $sign_pp = "../_action/pharmacy.do.php?Mode=sign_pp&idx=" . $row_002["ID"];
                        ?>
                        <tr>
                            <td class="center">
                                <input type="checkbox" id="check" name="check" value="<?=$row_002["ID"]?>">
                            </td>
                            <td class="center"><?= $row_002['ss_date'] ?></td>
                            <td class="center"><?= $pharmacist_status ?></td>
                            <td class="center">[ <?= $row_002['p_num'] ?> ] <?= $row_002['p_name'] ?></td>
                            <td class="center"><?= $row_002['LICENSE_NUMBER'] ?></td>
                            <td class="center"><?= $row_002['mm_name'] ?></td>
                            <td class="center"><?= $member_sex ?></td>
                            <td class="center"><?= $row_002['mm_id'] ?></td>
                            <td class="center"><?= $row_002['mm_phone'] ?></td>
                            <td class="center">
                                <input type="button" value="승인" class="Small_Button btnGreen"
                                       onClick="sign_pp('<?=$row_002["ID"]?>');">
                                <input type="button" value="보류" class="Small_Button btnGray"
                                       onClick="hold_pp('<?=$row_002["ID"]?>');">
                                <input type="button" value="취소" class="Small_Button btnRed"
                                       onClick="cancel_pp('<?=$row_002["ID"]?>');">
                            </td>
                        </tr>
                        <?php
                    }

                } else {
                    ?>
                    <tr>
                        <td class="center" colspan="10" height="250">신청중인 약사가 없습니다.</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>


            <div align="center" style="padding-top:10px;">
                <?
                $_url = "&slot=pharmacy&type=pharmacy_list";
                $paging = new paging("./admin.template.php", $_url, $offset, $page_block, $totalnum, $page, $_opt);
                $paging->pagingArea("", "");
                ?>
            </div>

        </div>
    </div>
</div>

<script>
    <!--
    function sign_pp(idx){
        if(confirm("소속약사 신청을 승인 하시겠습니까?")){
            var url = "./_action/pharmacy.do.php?Mode=sign_pp&idx="+idx ;
            actionForm.location.href=url ;
        }
    }

    function hold_pp(idx){
        if(confirm("소속약사 신청을 보류 하시겠습니까?")){
            var url = "./_action/pharmacy.do.php?Mode=hold_pp&idx="+idx ;
            actionForm.location.href=url ;
        }
    }

    function cancel_pp(idx){
        if(confirm("소속약사 신청을 취소시키겠습니까?")){
            var url = "./_action/pharmacy.do.php?Mode=cancel_pp&idx="+idx ;
            actionForm.location.href=url ;
        }
    }
    //-->
</script>