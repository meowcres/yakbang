<?php
include_once "../../_core/_init.php" ;
include_once "../inc/in_top.php" ;
$code_key = "FAQ".mktime();
?>
    <div id="Popup_Contents" style="padding:10px;">
        <h1>커뮤니티 &gt; 분류관리 &gt; <strong> FAQ 분류등록</strong></h1>
        <form id="wfrm" name="wfrm" method="post">
            <input type="hidden" id="mode" name="mode" value="add_board_type">
            <input type="hidden" id="cd_type" name="cd_type" value="FAQ">
            <input type="hidden" id="cd_depth" name="cd_depth" value="1">
            <table class="tbl1" summary="대분류 테이블 목록">
                <colgroup>
                    <col width="20%">
                    <col width="30%">
                    <col width="20%">
                    <col width="*">
                </colgroup>
                <tbody>
                <tr>
                    <th>상태</th>
                    <td>
                        <select id="cd_status" name="cd_status" class="w80">
                            <option value="y">활성</option>
                            <option value="n">비활성</option>
                        </select>
                    </td>
                    <th>정렬순위</th>
                    <td>
                        <select id="order_seq" name="order_seq" class="w80">
                            <?
                            for($i=1;$i<=99;$i++){
                                $selected = $i == "25" ? "selected" : "" ;
                                ?><option value="<?=$i?>" <?=$selected?>><?=$i?></option><?
                            }
                            ?>
                        </select>&nbsp;
                    </td>
                </tr>
                <tr>
                    <th>분류 CODE</th>
                    <td colspan="3"><?=$code_key?>
                        <input type="hidden" id="cd_key" name="cd_key" value="<?=$code_key?>" class="w90pro">
                    </td>
                </tr>
                <tr>
                    <th>분류명</th>
                    <td colspan="3">
                        <input type="text" id="cd_title" name="cd_title" class="w95p">
                    </td>
                </tr>
                <!--
                <tr>
                    <th>이동 URL</th>
                    <td colspan="3">
                        <input type="text" id="cd_url" name="cd_url" class="w95p">
                    </td>
                </tr>
                -->
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
            if ($("#cd_title").val() == "") {
                alert("FAQ 분류명을 입력하여 주십시오");
                $("#cd_title").focus();
                return false;
            }

            $("#wfrm").attr('action','../_action/board.do.php');
            $("#wfrm").attr('target','actionForm');
            $("#wfrm").submit();
        });
        //-->
    </script>
<?php
include_once "../inc/in_bottom.php";