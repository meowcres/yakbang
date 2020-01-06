<?
$offset     = 20 ;
$page_block = 10 ;
$startNum   = "" ;
$totalnum   = "" ;
$page       = "" ;
$_page      = isNull($_REQUEST["page"]) ? 0 : $_REQUEST["page"] ;

if(!isNull($_page)){
    $page     = $_page ;
    $startNum = ($page- 1) * $offset ;
}else{
    $page     = 1 ;
    $startNum = 0 ;
}


// 검색 변수
$_search = array();
$_search["schChkDate"]  = isNull($_GET["schChkDate"])    ? "" : $_GET["schChkDate"] ;
$_search["schReqSDate"] = isNull($_GET["schReqSDate"])   ? "" : $_GET["schReqSDate"] ;
$_search["schReqEDate"] = isNull($_GET["schReqEDate"])   ? "" : $_GET["schReqEDate"] ;

$_search["stype"]       = isNull($_GET["search_type"])   ? "" : $_GET["search_type"] ;
$_search["agency"]      = isNull($_GET["search_agency"]) ? "" : $_GET["search_agency"] ;

$_search["keyfield"]    = isNull($_GET["keyfield"])      ? "" : $_GET["keyfield"] ;
$_search["keyword"]     = isNull($_GET["keyword"])       ? "" : urldecode($_GET["keyword"]) ;

$_where[]  = "t1.USER_STATUS IN ('실행')" ;


//날짜
if($_search["schChkDate"] == "Y"){
    $_checked  = "checked"  ;
    $_disabled = "" ;

    $_where[]  = " t1.LAST_DATE BETWEEN '". date("Y-m-d H:i:s", strtotime($_search["schReqSDate"])) ."' AND '". date("Y-m-d H:i:s", strtotime("+1 days", strtotime($_search["schReqEDate"]) - 1)) ."' " ;
}else{
    $_checked  = ""  ;
    $_disabled = "disabled" ;
}



$thisYear = date("Y");
?>
    <script language="javascript">
        Loading(true);
    </script>
    <div id="Contents" style="border-bottom:0px;">
        <h1>기타관리 &gt; FCM 푸시 &gt; <strong>FCM 푸시 발송</strong></h1>

        <h3 style="padding:20px 0 7px 0;">◎ 발송정보</h3>
        <form id="pushForm" name="pushForm" method="POST" ENCTYPE="multipart/form-data" action="./_action/etc.do.php" onSubmit="return push_Checker();" target="ipushForm">
            <input type="hidden" name="mode" id="mode" value="send_fcm" />
            <table class="tbl1" cellspacing="0" summary="리스트 검색" style="width:100%;">
                <colgroup>
                    <col width="15%" />
                    <col width="*" />
                    <col width="12%" />
                </colgroup>
                <tr>
                    <th>푸시 제목</th>
                    <td class="left">
                        <input type="text" id="fcm_title" name="fcm_title" style="width:99%;">
                    </td>
                    <td rowspan="3">
                        <input type="submit" value="발송" class="btn_w80s" style="width:100%; height:80px;" />
                    </td>
                </tr>
                <tr>
                    <th>푸시 내용</th>
                    <td class="left">
                        <input type="text" id="fcm_msg" name="fcm_msg" style="width:99%;">
                    </td>
                </tr>
                <tr>
                    <th>푸시 이미지</th>
                    <td class="left">
                        <input type="file" id="fcm_img" name="fcm_img" style="width:70%;">
                    </td>
                </tr>
            </table>
        </form>


    </div>
    <iframe id="ipushForm" name="ipushForm" style="display:none;"></iframe>

    <script>

        function push_Checker(){
            if($("#fcm_msg").val() == ""){
                alert("푸시 내용을 입력하시기 바랍니다");
                $("#fcm_msg").focus();
                return false;
            };
        }

    </script>
<?$db->db_close();?>