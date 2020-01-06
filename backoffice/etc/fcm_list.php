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
$_search["keyfield"]    = isNull($_GET["keyfield"])      ? "" : $_GET["keyfield"] ;
$_search["keyword"]     = isNull($_GET["keyword"])       ? "" : urldecode($_GET["keyword"]) ;


$_where[]  = " 1 " ;


// 키워드 검색
if(!isNull($_search["keyword"])){
    $_where[] = "instr({$_search["keyfield"]}, '{$_search["keyword"]}') > 0 ";
}



$_whereqry = count($_where) ? " WHERE ".implode(' AND ',$_where) : "" ;
$_order    = " ORDER BY t1.IDX DESC" ;
$_limit    = " LIMIT ".$startNum.",".$offset ;

$_sql  = " SELECT " ;
$_sql .= " count(*) " ;
$_from = " FROM {$TB_FCM} t1 " ;

$_res = $db->exec_sql($_sql.$_from.$_whereqry);
$_row = $db->sql_fetch_row($_res);
$totalnum = $_row[0];

?>
<div id="Contents">
    <h1>기타관리 &gt; FCM 푸시 &gt; <strong>FCM 푸시 목록</strong></h1>


    <form id="sfrm" name="sfrm" method="GET" action="./dw.etc.php">
        <input type="hidden" id="slot" name="slot" value="etc">
        <input type="hidden" id="type" name="type" value="fcm_list">
        <table>
            <colgroup>
                <col width="150px" />
                <col width="*" />
            </colgroup>
            <tr>
                <th>검색</th>
                <td class="left">
                    <select id="keyfield" name="keyfield">
                        <option value="t1.FCM_TITLE" <? if($_search["keyfield"] == "t1.FCM_TITLE"){ echo "selected"; } ?>>제 목</option>
                        <option value="t1.FCM_MSG"   <? if($_search["keyfield"] == "t1.FCM_MSG"){   echo "selected"; } ?>>내 용</option>
                    </select>&nbsp;&nbsp;
                    <input type="text" id="keyword" name="keyword" value="<?=$_search["keyword"]?>" style="width:260px;">&nbsp;&nbsp;
                    <input type="submit" value="검색"   class="btn_w80s" style="width:60px; height:28px;" /> &nbsp;&nbsp;
                    <input type="button" value="초기화" class="btn_w80s" style="width:60px; height:28px;" onClick="location.href='./dw.etc.php?slot=etc&type=fcm_list'"/>
                </td>
            </tr>
        </table>
    </form>

    <form id='frm' name='frm' method='POST' action='./_action/etc.do.php' target='actionForm'>
        <input type="hidden" name="Mode" id="Mode" value="multi_del_fcm_information" />
        <table id="groupTable">
            <colgroup>
                <col width="2%" />
                <col width="5%" />
                <col width="10%" />
                <col width="15%" />
                <col width="25%" />
                <col width="*" />
            </colgroup>
            <tr>
                <th>
                    <input type='checkbox' id='allChk' name='allChk'>
                </th>
                <th>발송번호</th>
                <th>발송일</th>
                <th>이미지</th>
                <th>제목</th>
                <th>내용</th>
            </tr>
            <?
            if($totalnum > 0){

                $_sql  = " SELECT t1.* ";

                $_res  = $db->exec_sql($_sql.$_from.$_whereqry.$_order.$_limit);

                while($_row = $db->sql_fetch_array($_res)){
                    ?>
                    <tr>
                        <td class='center'><input type="checkbox" name="checked_member[]" value="<?=$_row['IDX']?>" /></td>
                        <td><?=$_row["IDX"]?></td>
                        <td><?=$_row["REG_DATE"]?></td>
                        <td>
                            <?
                            /*if(is_file($FCM_URL.$_row["FCM_IMG"])){
                                if(isImageExt($_row["FCM_IMG"])){
                                    $_PHOTO = getImgReSize($_row["FCM_IMG"],$FCM_URL,50,"h",$_row["FCM_TITLE"]);
                                    echo $_PHOTO[0];
                                }
                            }*/
                            ?>
                        </td>
                        <td class="left"><?=stripslashes($_row["FCM_TITLE"])?></td>
                        <td class="left"><?=stripslashes($_row["FCM_MSG"])?></td>
                    </tr>
                    <?
                }
            }else{
                ?>
                <tr>
                    <td colspan="10" class='center' style='height:200px;'>발송한 FCM 푸시메시지가 없습니다.</td>
                </tr>
                <?
            }
            ?>
        </table>
        <div class="left" style="padding-top:10px;">
            <input type="button" value="푸시정보삭제" class="custbtn3" style="width:150px;height:35px;font-size:1.2em" onclick="checkedSubmit();" />
        </div>
    </form>

    <div id="Paser">
        <?
        $paging = new paging("./dw.etc.php","slot=etc&type=fcm_list",$offset,$page_block,$totalnum,$page,$_opt);
        $paging->pagingArea("","") ;
        ?>
    </div>
</div>

<script language="JavaScript" type="text/JavaScript">
    <!--
    $("#allChk").click(function(){
        if($("#allChk").prop("checked") == true){
            $("#groupTable input[type='checkbox']").prop("checked",true);
        }else{
            $("#groupTable input[type='checkbox']").prop("checked",false);
        }
    });

    function checkedSubmit(){
        if(0 == $("input[name='checked_member[]']:checked").length){
            alert("최소 한개의 게시물 이상을 선택하셔야 합니다.");
            return false;
        }

        if(confirm("푸시정보를 삭제하시겠습니까? \n\n삭제 후에는 복구가 불가능합니다")){
            $("#frm").submit();
        }

    }

    $(document).ready(function() {
        var dates = $("#schReqSDate, #schReqEDate").datepicker({
            changeYear: true,
            changeMonth: true,
            showMonthAfterYear: true,
            onSelect: function(selectedDate) {
                var option = this.id == "schReqSDate" ? "minDate": "maxDate",
                    instance = $(this).data("datepicker"),
                    date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                dates.not(this).datepicker("option", option, date);
            }
        });
    });

    function msgLayer(e){


        var sWidth = window.innerWidth;
        var sHeight = window.innerHeight;

        var oWidth = $('.popupLayer').width();
        var oHeight = $('.popupLayer').height();

        // 레이어가 나타날 위치를 셋팅한다.
        var divLeft = e.clientX + 10;
        var divTop = e.clientY + 5;

        // 레이어가 화면 크기를 벗어나면 위치를 바꾸어 배치한다.
        if( divLeft + oWidth > sWidth ) divLeft -= oWidth;
        if( divTop + oHeight > sHeight ) divTop -= oHeight;

        // 레이어 위치를 바꾸었더니 상단기준점(0,0) 밖으로 벗어난다면 상단기준점(0,0)에 배치하자.
        if( divLeft < 0 ) divLeft = 0;
        if( divTop < 0 ) divTop = 0;

        $('.popupLayer').css({
            "top": divTop,
            "left": divLeft,
            "position": "absolute"
        }).show();

        $('popupLayer').html("aaa");

    }
    //-->
</script>
<div id="msgLayerForm" style="display:none;">
    <div id="msgLayerMsg">zzzzzzzzzzzzz</div>
</div>