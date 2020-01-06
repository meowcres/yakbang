<?
include_once "../../_core/_init.php";
include_once "../../_core/_common/var.admin.php";
include_once "../inc/in_top.php";

if (isNull($_GET["p_code"])) {
    alert_js("alert_selfclose", "정보가 정확하지 않습니다", "");
    exit;
} else {
    $p_code = $_GET["p_code"];
}

// 페이지 분할 변수
$offset = 10;
$page_block = 5;
$startNum = "";
$totalnum = "";
$page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

// 검색 변수
$search = array();

$search["status"] = isNull($_GET["search_status"]) ? "" : $_GET["search_status"];
$search["region"] = isNull($_GET["search_region"]) ? "" : $_GET["search_region"];
$search["sex"] = isNull($_GET["search_sex"]) ? "" : $_GET["search_sex"];

$search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$search["keyword"] = isNull($_GET["keyword"]) ? "" : $_GET["keyword"];

if (!isNull($page)) {
    $page = $page;
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}

// 리스트 조건절
$qry_where_array[] = "t1.USER_STATUS in ('1')";
$qry_where_array[] = "t1.USER_TYPE in ('2')";


// 국적구분 검색
if (!isNull($search["region"])) {
    $qry_where_array[] = "t1.MM_REGION in ('" . $search["region"] . "')";
}

// 성별 검색
if (!isNull($search["sex"])) {
    $qry_where_array[] = "t1.MM_SEX in ('" . $search["sex"] . "')";
}

// 키워드 검색
if (!isNull($search["keyword"])) {
    if ($search["keyword"] == "t2.LICENSE_NUMBER") {
        $qry_where_array[] = "instr({$search["keyfield"]}, '{$search["keyword"]}') > 0 ";
    } else {
        $qry_where_array[] = "{$search["keyfield"]} = HEX(AES_ENCRYPT('" . $search["keyword"] . "','" . SECRET_KEY . "'))";
    }
}

$qry_where = count($qry_where_array) ? " WHERE " . implode(' AND ', $qry_where_array) : "";
$qry_order = " ORDER BY t1.USER_STATUS, IDX DESC";
$qry_limit = " LIMIT " . $startNum . "," . $offset;

$qry_001 = " SELECT ";
$qry_001 .= " count(*) ";

$qry_from = " FROM {$TB_MEMBER} t1 ";
$qry_from .= " LEFT JOIN {$TB_MEMBER_INFO} t2 ON (t1.USER_ID = t2.ID_KEY) ";


$res_001 = $db->exec_sql($qry_001 . $qry_from . $qry_where);
$row_001 = $db->sql_fetch_row($res_001);
$totalnum = $row_001[0];

// 주소이동변수
$url_opt = "";
?>

    <div class="adm_table_style02">
        <h3 class="h3_title ">전문약사 목록</h3>


        <table>
            <colgroup>
                <col style="width:10%"/>
                <col style="*"/>
            </colgroup>
            <form id="sfrm" name="sfrm" method="GET" action="./popup_pharmacist_register.php">
                <input type="hidden" id="p_code" name="p_code" value="<?= $p_code ?>">
                <tbody>
                <tr>
                    <th>검색조건</th>
                    <td class="left">
                        <select id="keyfield" name="keyfield">
                            <option value="t2.LICENSE_NUMBER" <? if ($search["keyfield"] == "t2.LICENSE_NUMBER") echo "selected"; ?>>
                                약사번호
                            </option>
                            <option value="t1.USER_ID" <? if ($search["keyfield"] == "t1.USER_ID") echo "selected"; ?>>
                                아이디
                            </option>
                            <option value="t1.USER_NAME" <? if ($search["keyfield"] == "t1.USER_NAME") echo "selected"; ?>>
                                이름
                            </option>
                            <option value="t2.USER_PHONE" <? if ($search["keyfield"] == "t2.USER_PHONE") echo "selected"; ?>>
                                연락처
                            </option>
                        </select>
                        <input type="text" id="keyword" name="keyword" value="<?= $search["keyword"] ?>" class="w40p">
                        <a onclick="sfrm.submit()" class="btn_s btn16">검색</a>
                    </td>
                </tr>
                </tbody>
        </table>
        </form>

        <table>
            <colgroup>
                <col style="width:5%"/>
                <col style="*"/>
                <col style="width:18%"/>
                <col style="width:27%"/>
                <col style="width:15%"/>
                <col style="width:8%"/>
            </colgroup>
            <thead>
            <tr>
                <th>No</th>
                <th>아이디 (이메일)</th>
                <th>약사번호</th>
                <th>이름 (성별)</th>
                <th>연락처</th>
                <th>관리</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($totalnum > 0) {
                $qry_002 = "SELECT t1.*, t2.*";
                $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
                $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                $qry_002 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

                $res_002 = $db->exec_sql($qry_002 . $qry_from . $qry_where . $qry_order . $qry_limit);
                $count_num = 0;
                while ($row_002 = $db->sql_fetch_array($res_002)) {

                    $member_count = $totalnum - ($startNum + $count_num);

                    $user_id = $row_002['mm_id'];
                    $user_name = clear_escape($row_002['mm_name']);
                    $user_sex = $row_002['USER_SEX'] == "M" ? "<font color='#3300FF'>남</font>" : "<font color='#FF6600'>여</font>";
                    $user_phone = clear_escape($row_002['mm_phone']);

                    $qry_003 = "SELECT IDX FROM {$TB_PP} WHERE PHARMACY_CODE='{$p_code}' AND USER_ID='{$row_002['USER_ID']}'";
                    $res_003 = $db->exec_sql($qry_003);
                    $row_003 = $db->sql_fetch_row($res_003);

                    $_class = $row_003[0] > 0 ? "style='background-color:#e2efe4';" : "";

                    ?>
                    <tr>
                        <td class="center" <?= $_class ?>><?= $member_count ?></td>
                        <td class="center" <?= $_class ?>><?= $user_id ?></td>
                        <td class="center" <?= $_class ?>><?= $row_002['LICENSE_NUMBER'] ?></td>
                        <td <?= $_class ?>><?= $user_name ?> (<?= $user_sex ?>)</td>
                        <td class="center" <?= $_class ?>><?= $user_phone ?></td>
                        <td class="center" <?= $_class ?>>
                            <?php
                            if ($row_003[0] > 0) {
                                ?><a onclick="del_pp('<?= $row_003[0] ?>');" class="btn_s btn14">제외</a><?
                            } else {
                                ?><a onclick="add_pp('<?= $user_id ?>','<?= $p_code ?>');" class="btn_s btn13">추가</a><?
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                    $count_num++;
                }
            } else {
                ?>
                <tr>
                    <td class="t_c" colspan="7" height="250">전문약사가 없습니다.</td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <br><br>
        <div class="b_page_no">
            <?php
            $paging = new paging("./popup_pharmacist_regster.php", "p_code=" . $p_code, $offset, $page_block, $totalnum, $page, $url_opt);
            $paging->pagingArea("", "");
            ?>
        </div>
    </div>

    <script>
        <!--
        function add_pp(user_id, p_code) {
            if (confirm("전문약사를 추가 하시겠습니까?")) {
                var url = "../_action/pharmacy.do.php?Mode=add_pharmacist&user_id=" + user_id + "&p_code=" + p_code;
                actionForm.location.href = url;
            }
        }

        function del_pp(idx) {
            if (confirm("전문약사를 제외 시키겠습니까?")) {
                var url = "../_action/pharmacy.do.php?Mode=del_pharmacist&idx=" + idx;
                actionForm.location.href = url;
            }
        }

        //-->
    </script>

<?
include_once "../inc/in_bottom.php";
?>