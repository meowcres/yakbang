<?
$offset = 20;
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

$_where[] = " ( t1.USER_TYPE = 1 AND t1.USER_STATUS = 1 )";


//날짜
if ($_search["schChkDate"] == "Y") {
    $_checked = "checked";
    $_disabled = "";

    $_where[] = " t1.LAST_DATE BETWEEN '" . date("Y-m-d H:i:s", strtotime($_search["schReqSDate"])) . "' AND '" . date("Y-m-d H:i:s", strtotime("+1 days", strtotime($_search["schReqEDate"]) - 1)) . "' ";
} else {
    $_checked = "";
    $_disabled = "disabled";
}


$thisYear = date("Y");
?>
    <script language="javascript">
        Loading(true);
    </script>
    <div id="Contents" style="border-bottom:0px;">
        <h1>기타관리 &gt; 푸시 관리 &gt; <strong>푸시 등록</strong></h1>

        <table>
            <colgroup>
                <col width="50%"/>
                <col width="50%"/>
            </colgroup>
            <tr>
                <td class="left" style="padding:5px;">
                    <h3 style="padding:20px 0 7px 0;">◎ 대상회원검색</h3>
                    <form id="sfrm" name="sfrm" method="GET" action="./etc/frame_member_list.php" target="iFrame1">
                        <table>
                            <colgroup>
                                <col width="15%"/>
                                <col width="35%"/>
                                <col width="15%"/>
                                <col width="*"/>
                            </colgroup>
                            <tr>
                                <th>최종접속일자</th>
                                <td colspan="3" class="left">
                                    <input type="checkbox" id="schChkDate" name="schChkDate" value="Y"
                                           onClick="dateDisable();" <?= $_checked ?>> &nbsp;&nbsp;
                                    <input type="text" name="schReqSDate" id="schReqSDate" readonly
                                           value="<?= $schReqSDate ?>"
                                           style="width:125px;text-align:right;padding-right:5px;" <?= $_disabled ?>/> 일
                                    부터
                                    <input type="text" name="schReqEDate" id="schReqEDate" readonly
                                           value="<?= $schReqEDate ?>"
                                           style="width:125px;text-align:right;padding-right:5px;" <?= $_disabled ?>/> 일
                                    까지
                                </td>
                            </tr>
                            <th>회원분류</th>
                            <td class="left">
                                <select id="search_type" name="search_type" onChange="sfrm.submit();">
                                    <option value="">::: 분류 전체 :::</option>
                                    <option value="1">일반 회원</option>
                                    <option value="3">AG</option>
                                </select>
                            </td>
                            </tr>
                            <tr>
                                <th>검색</th>
                                <td colspan="3" class="left">
                                    <select id="keyfield" name="keyfield">
                                        <option value="t1.USER_NAME">이름</option>
                                        <option value="t1.USER_MOBILE">전화번호</option>
                                    </select>&nbsp;&nbsp;
                                    <input type="text" id="keyword" name="keyword" value="<?= $_search["keyword"] ?>">&nbsp;
                                    <input type="submit" value="검색" class="btn_w80s" style="width:60px; height:28px;"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
                <td class="left" style="padding:5px;">
                    <h3 style="padding:20px 0 7px 0;">◎ 푸시정보</h3>
                    <form id="pushForm" name="pushForm" method="POST" action="./_action/etc.do.php"
                          onSubmit="return push_Checker();" target="ipushForm">
                        <input type="hidden" name="Mode" id="Mode" value="send_push"/>
                        <table class="tbl1" cellspacing="0" summary="리스트 검색" style="width:100%;">
                            <colgroup>
                                <col width="15%"/>
                                <col width="*"/>
                                <col width="12%"/>
                            </colgroup>
                            <tr>
                                <th>푸시내용</th>
                                <td class="left">
                                    <textarea id="p_msg" name="p_msg" style="width:99%;height:100px;"></textarea><br>
                                    ※ 치환문구 : {{user}} => 발송시 대상회원이름으로 치환
                                </td>
                                <td>
                                    <input type="button" value="발송" onclick="push_Checker();" class="btn_w80s"
                                           style="width:100%; height:80px;"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>

            <tr>
                <td style="padding:5px;vertical-align:top;">
                    <iframe name="iFrame1" id="iFrame1" style="width:100%; border:1px solid #afafaf;"
                            src="./etc/frame_member_list.php" onload="changeHeight('iFrame1');"></iframe>
                </td>
                <td style="padding:5px;vertical-align:top;">
                    <iframe name="iFrame2" id="iFrame2" style="width:100%; border:1px solid #9cc2a5;"
                            src="./etc/frame_tmp_member_list.php" onload="changeHeight('iFrame2');"></iframe>
                </td>
            </tr>

        </table>

    </div>
    <iframe id="ipushForm" name="ipushForm" style="display:none;"></iframe>
    <script>
        function changeHeight(iframeID) {
            //alert() ;
            //아이프레임 안쪽 페이지 높이를 먼저구하신후
            var the_height = document.getElementById(iframeID).contentWindow.document.body.scrollHeight;
            // 아이프레임 높이를 바꿔주시면 됩니다.

            plus_height = the_height == the_height ? the_height : the_height;
            document.getElementById(iframeID).height = plus_height + 40;
        }

        function push_Checker() {
            if ($("#push_msg").val() == "") {
                alert("푸시내용을 입력하시기 바랍니다");
                $("#push_msg").focus();
                return false;
            }

            if (confirm("푸시내용을 발송하시겠습니까?")) {

                // 폼 보내기
                var p_msg = $('#p_msg').val();

                var _frm = new FormData();

                _frm.append("mode", "send_push");
                _frm.append("p_msg", p_msg);

                $.ajax({
                    method: 'POST',
                    url: "./_action/etc.do.php",
                    processData: false,
                    contentType: false,
                    data: _frm,
                    success: function (_res) {
                        console.log(_res);
                        switch (_res) {
                            case "0" :
                                parent.location.href = "./admin.template.php?slot=etc&type=push_register";
                                break;
                            case "1" :
                                alert("푸시 대상회원이 없습니다.");
                                break;
                            default :
                                alert("실패");
                                break;
                        }
                    }
                });
            }
        }

        $(document).ready(function () {

            var dates = $("#schReqSDate, #schReqEDate").datepicker({
                changeYear: true,
                changeMonth: true,
                showMonthAfterYear: true,
                onSelect: function (selectedDate) {
                    var option = this.id == "schReqSDate" ? "minDate" : "maxDate",
                        instance = $(this).data("datepicker"),
                        date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                    dates.not(this).datepicker("option", option, date);
                }
            });

        });


    </script>
<? $db->db_close(); ?>