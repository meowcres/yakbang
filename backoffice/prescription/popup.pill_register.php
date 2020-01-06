<?php
include_once "../../_core/_init.php" ;
include_once "../inc/in_top.php" ;
$code_key = "FAQ".mktime();

$ps_code = $_GET["ps_code"];
?>
    <div id="Popup_Contents" style="padding:10px;">
        <h1>처방전 관리 &gt; 처방전 목록 &gt; 처방전 상세목록 &gt; <strong> 처방전 등록</strong></h1>
        <form id="wfrm" name="wfrm" method="post">
            <input type="hidden" id="Mode" name="Mode" value="add_pill">
            <input type="hidden" id="ps_code" name="ps_code" value="<?=$ps_code?>">
            <table class="tbl1" summary="대분류 테이블 목록">
                <colgroup>
                    <col width="20%">
                    <col width="*">
                </colgroup>
                <tbody>
                <tr>
                    <th>1회 투약량</th>
                    <td>
                        <input type="number" id="one_injection" name="one_injection" class="w95p">
                    </td>
                </tr>
                <tr>
                    <th>1회 투여횟수</th>
                    <td>
                        <input type="number" id="day_injection" name="day_injection" class="w95p">
                    </td>
                </tr>
                <tr>
                    <th>총 투약일수</th>
                    <td>
                        <input type="number" id="total_injection" name="total_injection" class="w95p">
                    </td>
                </tr>
                <tr>
                    <th>약품명</th>
                    <td colspan="3">
                        <input type="text" id="pp_title" name="pp_title" class="w95p">
                    </td>
                </tr>
                <tr>
                    <th>사용법</th>
                    <td>
                        <textarea id="pp_usage" name="pp_usage" class="w95p"></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
            <div style="margin-top:30px;text-align:center;">
                <input type="button" id="frmSubmit" value="등록하기" class="btnGreen w100 h28" style="cursor:pointer;"> &nbsp;
                <input type="button" id="frmClose" value="창닫기" class="btnGray w100 h28" onClick="self.close();" style="cursor:pointer;">
            </div>
        </form>
    </div>

    <script language="javascript">
        <!--
        $("#frmSubmit").bind('click',function(e){
            if ($("#one_injection").val() == "") {
                alert("1회 투약량을 입력하여 주십시오");
                $("#one_injection").focus();
                return false;
            }
            if ($("#day_injection").val() == "") {
                alert("1회 투여횟수을 입력하여 주십시오");
                $("#day_injection").focus();
                return false;
            }
            if ($("#total_injection").val() == "") {
                alert("총 투약일수를 입력하여 주십시오");
                $("#total_injection").focus();
                return false;
            }
            if ($("#pp_title").val() == "") {
                alert("약품명을 입력하여 주십시오");
                $("#pp_title").focus();
                return false;
            }
            if ($("#pp_usage").val() == "") {
                alert("사용법을 입력하여 주십시오");
                $("#pp_usage").focus();
                return false;
            }

            $("#wfrm").attr('action','../_action/prescription.do.php');
            $("#wfrm").attr('target','actionForm');
            $("#wfrm").submit();
        });
        //-->
    </script>
<?php
include_once "../inc/in_bottom.php";