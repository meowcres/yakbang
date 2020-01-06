<?php
include_once "../../_core/_init.php" ;
include_once "../inc/in_top.php" ;

$CD_KEY = $_GET['CD_KEY'] ;

$qry_001 = "SELECT * FROM {$TB_CODE} WHERE CD_KEY = '{$CD_KEY}' AND CD_DEPTH = '1' " ;
$res_001 = $db->exec_sql($qry_001) ;
$row_001 = $db->sql_fetch_array($res_001);

$status_array[$row_001['CD_STATUS']] = "selected" ;

?> 
<div id="Popup_Contents" style="padding:10px;">
    <h1>커뮤니티 &gt; 분류관리 &gt; <strong> 문의 분류수정</strong></h1>
    <form id="wfrm" name="wfrm" method="post">
    <input type="hidden" id="mode"     name="mode"     value="up_board_type">
    <input type="hidden" id="cd_type"  name="cd_type"  value="<?=$row_001['CD_TYPE']?>">
    <input type="hidden" id="cd_depth" name="cd_depth" value="<?=$row_001['CD_DEPTH']?>">
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
                        <option value="y" <?=$status_array["y"]?>>활성</option>
                        <option value="n" <?=$status_array["n"]?>>비활성</option>
                    </select>
                </td>
                <th>정렬순위</th>
                <td>
                    <select id="order_seq" name="order_seq" class="w80">
                    <?
                    for($i=1;$i<=99;$i++){
                        $selected = $i == $row_001['ORDER_SEQ'] ? "selected" : "" ;
                        ?><option value="<?=$i?>" <?=$selected?>><?=$i?></option><?
                    }
                    ?>
                    </select>&nbsp;
                </td>
            </tr>
            <tr>
                <th>분류 CODE</th>
                <td colspan="3"><?=$row_001['CD_KEY']?>
                    <input type="hidden" id="cd_key" name="cd_key" value="<?=$row_001['CD_KEY']?>" class="w90pro">
                </td>
            </tr>
            <tr>
                <th>분류명</th>
                <td colspan="3">
                    <input type="text" id="cd_title" name="cd_title" value="<?=clear_escape($row_001['CD_TITLE'])?>" class="w95p">
                </td>
            </tr>
        </tbody>
    </table>
    <div style="margin-top:30px;text-align:center;">
        <input type="button" id="frmSubmit" value="수정하기" class="btnGreen w100 h28" style="cursor:pointer;"> &nbsp;
        <input type="button" id="frmClose" value="창닫기" class="btnGray w100 h28" onClick="self.close();" style="cursor:pointer;">
    </div>
    </form>
</div>

<script language="javascript">
<!--
$("#frmSubmit").bind('click',function(e){
    if ($("#cd_title").val() == "") {
        alert("공지사항 분류명을 입력하여 주십시오");
        $("#cd_title").focus();
        return false;
    }

    $("#wfrm").attr('action','../_action/board.do.php');
    $("#wfrm").attr('target','actionForm');
    $("#wfrm").submit();
});
//-->
</script>

<?
include_once "../inc/in_bottom.php";
?>