<?
include_once "../inc/in_top.php";
include_once "../../_core/_init.php";

$offset = 30;
$page_block = 10;
$startNum = "";
$totalnum = "";
$page = "";
$_page = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"];

if (!isNull($_page)) {
    $page = $_page;
    $startNum = ($page - 1) * $offset;
} else {
    $page = 1;
    $startNum = 0;
}


// 검색 변수
$_search = array();
$_search["schChkDate"] = isNull($_GET["schChkDate"]) ? "" : $_GET["schChkDate"];
$_search["schReqSDate"] = isNull($_GET["schReqSDate"]) ? "" : $_GET["schReqSDate"];
$_search["schReqEDate"] = isNull($_GET["schReqEDate"]) ? "" : $_GET["schReqEDate"];
$_search["stype"] = isNull($_GET["search_type"]) ? "" : $_GET["search_type"];
$_search["agency"] = isNull($_GET["search_agency"]) ? "" : $_GET["search_agency"];
$_search["keyfield"] = isNull($_GET["keyfield"]) ? "" : $_GET["keyfield"];
$_search["keyword"] = isNull($_GET["keyword"]) ? "" : urldecode($_GET["keyword"]);


$_where[]  = " ( t1.USER_TYPE = 1 AND t1.USER_STATUS = 1 )" ;


//날짜
if ($_search["schChkDate"] == "Y") {
    $_checked = "checked";
    $_disabled = "";

    $_where[] = " t1.LAST_DATE BETWEEN '" . date("Y-m-d H:i:s", strtotime($_search["schReqSDate"])) . "' AND '" . date("Y-m-d H:i:s", strtotime("+1 days", strtotime($_search["schReqEDate"]) - 1)) . "' ";
} else {
    $_checked = "";
    $_disabled = "disabled";
}


// 고객 구분
if (!isNull($_search["stype"])) {
    $_where[] = "t1.JOIN_TYPE = '{$_search["stype"]}'";
}


// 에이젼시 구분
if (!isNull($_search["agency"])) {
    $_where[] = "t1.AGENCY_CODE = '{$_search["agency"]}'";
}


// 키워드 검색
if (!isNull($_search["keyword"])) {
    $_where[] = "instr({$_search["keyfield"]}, '{$_search["keyword"]}') > 0 ";
}


$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY mm_name ";
$_limit = " LIMIT " . $startNum . "," . $offset;

$_sql = "SELECT ";
$_sql .= "count(*) ";
$_from = " FROM {$TB_MEMBER} t1 ";
$_from .= " LEFT JOIN {$TB_MEMBER_INFO} t2 ON (t1.USER_ID = t2.ID_KEY)  ";

$_res = $db->exec_sql($_sql . $_from . $_whereqry);
$_row = $db->sql_fetch_row($_res);

$totalnum = $_row[0];

$_opt =
    "schChkDate=" . $_search['schChkDate'] . "&schReqSDate=" . $_search['schReqSDate'] . "&schReqEDate=" . $_search['schReqEDate'] . "&search_type=" . $_search['stype'] . "&search_agency=" . $_search['agency'] . "&keyfield=" . $_search['keyfield'] . "&keyword=" . $_search['keyword'];
?>
<link type="text/css" rel="stylesheet" href="../resources/css/iframe.css">
<style>
    .searchBox {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        border: 1px solid #eaeaea;
        font-size: 12px;
        line-height: 24px;
        background: #fff;
    }

    .searchBox th {
        text-align: center;
        padding: 6px 0;
        color: #000;
        border: 1px solid #dddddd;
        background: #eeeeee;
        font-weight: 700;
    }

    .searchBox td {
        padding: 4px 15px;
        color: #5a5450;
        border: 1px solid #dddddd;
    }

    .searchBox input, .searchBox select {
        padding: 3px;
    }

    .custbtn {
        width: 50px;
        height: 26px;
        background-color: #B9BAAB;
        color: #fff;
    }

    .custbtn2 {
        width: 50px;
        height: 26px;
        background-color: #E46575;
        color: #fff;
    }

    .custbtn3 {
        width: 60px;
        height: 26px;
        background-color: #C6A0C9;
        color: #fff;
    }
</style>

<div id="Wrap">
    <div id="buyframeList_form1" style="padding:10px;">
        <h3 style="padding:0 0 12px 5px;">◎ 회원목록 ( 활동회원 : <?= number_format($totalnum); ?> 명 )</h3>
        <form id='frm' name='frm' method='POST' action='../_action/etc.do.php' target='actionForm'>
            <input type="hidden" name="mode" id="mode" value="multi_add_push_member"/>
            <table id="groupTable" class="searchBox" cellspacing="0" summary="현황">
                <colgroup>
                    <col width="6%"/>
                    <col width="8%"/>
                    <col width="*"/>
                    <col width="15%"/>
                    <col width="20%"/>
                    <col width="18%"/>
                </colgroup>
                <tr>
                    <th><input type="checkbox" id="allChk" name="allChk"/></th>
                    <th>회원상태</th>
                    <th>회원아이디</th>
                    <th>회원이름</th>
                    <th>회원연락처</th>
                    <th>마지막접속일</th>
                </tr>

                <?
                if ($totalnum > 0) {
                    unset($_sql);
                    unset($_res);
                    unset($_row);

                    $qry_001 = " SELECT t1.IDX, t1.* ";
                    $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
                    $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                    $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

                    $res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry . $_order . $_limit);

                    while ($row_001 = $db->sql_fetch_array($res_001)) {
                        ?>
                        <tr onMouseOver="bgColor='#fbfce4'" onMouseOut="bgColor='#FFFFFF';">
                            <td class="center">
                                <input type="checkbox" name="checked_member[]" value="1|<?=$row_001['USER_ID']?>"/>
                            </td>
                            <td class="center"><?= $member_status_array[$row_001["USER_STATUS"]] ?></td>
                            <td class="center"><?= $row_001["mm_id"] ?></td>
                            <td class="center"><?= $row_001["mm_name"] ?></td>
                            <td class="center"><?= $row_001["mm_phone"] ?></td>
                            <td class="center"><?= $row_001["LAST_LOGIN"] ?></td>
                        </tr>
                        <?
                    }
                } else {
                    ?>
                    <tr>
                        <td class="center" colspan="6" style="height:80px;">검색결과가 없습니다.</td>
                    </tr>
                    <?
                }
                ?>
            </table>
            <div class="left" style="padding-top:10px;">
                <input type="button" value="푸시대상회원추가" class="custbtn3" style="width:150px;height:35px;font-size:1.2em"
                       onclick="checkedSubmit();"/> &nbsp;&nbsp;&nbsp;
                <input type="button" value="전체회원추가" class="custbtn3" style="width:150px;height:35px;font-size:1.2em"
                       onclick="allADDmember();"/>
            </div>
        </form>
    </div>
    <div id="Paser">
        <?
        $paging = new paging("./frame_member_list.php", "", $offset, $page_block, $totalnum, $page, $_opt);
        $paging->pagingArea("", "");
        ?>
    </div>
</div>

<script>
    $("#allChk").click(function () {
        if ($("#allChk").prop("checked") == true) {
            $("#groupTable input[type='checkbox']").prop("checked", true);
        } else {
            $("#groupTable input[type='checkbox']").prop("checked", false);
        }
    });

    function checkedSubmit() {
        if (0 == $("input[name='checked_member[]']:checked").length) {
            alert("최소 한명 이상의 회원을 선택하셔야 합니다.");
            return false;
        }

        $("#frm").submit();

    }

    function allADDmember() {
        if (confirm("전체회원을 추가하겠습니까?")) {
            //actionForm.location.href = "../_action/etc.do.php?mode=allPush";

            // 폼 보내기
            var _frm = new FormData();

            _frm.append("mode", "allPush");

            $.ajax({
                method: 'POST',
                url: "../_action/etc.do.php",
                processData: false,
                contentType: false,
                data: _frm,
                success: function (_res) {
                    console.log(_res);
                    switch (_res) {
                        case "0" :
                            parent.parent.location.reload();
                            break;
                        default :
                            alert("실패");
                            break;
                    }
                }
            });
        }
    }
</script>

</body>
</html>