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

$_where[] = "1";

$_whereqry = count($_where) ? " WHERE " . implode(' AND ', $_where) : "";
$_order = " ORDER BY mm_name ";
$_limit = " LIMIT " . $startNum . "," . $offset;

$_sql = "SELECT ";
$_sql .= "count(*) ";
$_from = " FROM {$TB_PUSH_TMP} t1 ";
$_from .= " LEFT JOIN {$TB_MEMBER} t2 ON (t1.USER_ID = t2.USER_ID)  ";
$_from .= " LEFT JOIN {$TB_MEMBER_INFO} t3 ON (t1.USER_ID = t3.ID_KEY)  ";

$_res = $db->exec_sql($_sql . $_from . $_whereqry);
$_row = $db->sql_fetch_row($_res);

$totalnum = $_row[0];

?>
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
        <h3 style="padding:0 0 12px 5px;">◎ 푸시대상 회원목록 ( 검색 된 대상회원수 : <?= number_format($totalnum) ?> 명 )</h3>
        <form id='frm' name='frm' method='POST' action='../_action/etc.do.php' target='actionForm'>
            <input type="hidden" name="mode" id="mode" value="multi_del_push_member"/>
            <table id="groupTable" class="searchBox" cellspacing="0" summary="소속현황">
                <colgroup>
                    <col width="6%"/>
                    <col width="8%"/>
                    <col width="*"/>
                    <col width="15%"/>
                    <col width="12%"/>
                    <col width="12%"/>
                    <col width="18%"/>
                </colgroup>
                <tr>
                    <th><input type="checkbox" id="allChk" name="allChk"/></th>
                    <th>회원상태</th>
                    <th>회원아이디</th>
                    <th>회원이름</th>
                    <th>회원연락처</th>
                    <th>등록관리자</th>
                    <th>등록일</th>
                </tr>

                <?
                if ($totalnum > 0) {
                    unset($_sql);
                    unset($_res);
                    unset($_row);

                    $qry_001 = " SELECT t1.IDX, t1.* ";
                    $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t1.USER_ID),'" . SECRET_KEY . "') as char) as mm_id ";
                    $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t2.USER_NAME),'" . SECRET_KEY . "') as char) as mm_name ";
                    $qry_001 .= " , CAST(AES_DECRYPT(UNHEX(t3.USER_PHONE),'" . SECRET_KEY . "') as char) as mm_phone ";

                    $res_001 = $db->exec_sql($qry_001 . $_from . $_whereqry . $_order . $_limit);

                    while ($row_001 = $db->sql_fetch_array($res_001)) {
                        ?>
                        <tr onMouseOver="bgColor='#fbfce4'" onMouseOut="bgColor='#FFFFFF';">
                            <td class="center">
                                <input type="checkbox" name="checked_member[]" value="<?= $row_001['USER_ID'] ?>"/>
                            </td>
                            <td class="center"><?= $member_status_array[$row_001["USER_STATUS"]] ?></td>
                            <td class="center"><?= $row_001["mm_id"] ?></td>
                            <td class="center"><?= $row_001["mm_name"] ?></td>
                            <td class="center"><?= $row_001["mm_phone"] ?></td>
                            <td class="center"><?= $row_001["ADMIN_ID"] ?></td>
                            <td class="center"><?= $row_001["REG_DATE"] ?></td>
                        </tr>
                        <?
                    }
                } else {
                    ?>
                    <tr>
                        <td class="center" colspan="7" style="height:80px;">푸시대상이 없습니다.</td>
                    </tr>
                    <?
                }
                ?>
            </table>
            <div class="left" style="padding-top:10px;">
                <input type="button" value="선택삭제" class="custbtn3" style="width:150px;height:35px;font-size:1.2em"
                       onclick="checkedSubmit();"/>
                <input type="button" value="전체삭제" class="custbtn3" style="width:150px;height:35px;font-size:1.2em"
                       onclick="allDELmember();"/>
            </div>
        </form>
    </div>
    <div id="Paser">
        <?
        $paging = new paging("./frame_tmp_member_list.php", "", $offset, $page_block, $totalnum, $page, $_opt);
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
        if (confirm("선택하신 회원을 해당푸시그룹으로부터 삭제하시겠습니까?")) {
            $("#frm").submit();
        } else {
            return false;
        }
    }

    function allDELmember() {
        if (confirm("푸시대상 회원목록을 전부 삭제하겠습니까?")) {
            // 폼 보내기
            var _frm = new FormData();

            _frm.append("mode", "allDelPush");

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
            //actionForm.location.href = "../_action/etc.do.php?mode=allDelPush";
        }
    }
</script>

</body>
</html>