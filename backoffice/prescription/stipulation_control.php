<?
$idx = "";

if(isNull($_GET["idx"])){
    alert_js("alert_back","약관 정보가 옳바르지 않습니다.","");
}else{
    $idx = $_GET["idx"] ;

    $qry_001 = "SELECT * FROM {$TB_STIPULATION} WHERE IDX='{$idx}'";
    $res_001 = $db->exec_sql($qry_001);
    $row_001 = $db->sql_fetch_array($res_001);

    $contents = clear_escape($row_001["A_CONTENTS"]);
}
?>
<div id="Contents">
    <h1>처방전관리 &gt; 약관정보 &gt; <strong><?=$row_001["A_TITLE"]?></strong></h1>

    <form name="frm" method="post" action="./_action/member.do.php" style="display:inline;" target="actionForm">
        <input type="hidden" name="Mode" value="stipulation_update">
        <input type="hidden" name="idx" value="<?=$idx?>">
        <table>
            <colgroup>
                <col width="12%" />
                <col width="38%" />
                <col width="12%" />
                <col width="*" />
            </colgroup>
            <tr>
                <th>항목</th>
                <td class="left"><input type="text" id="title" name="title" value="<?=$row_001["A_TITLE"]?>" class="Text Kor" style="width:95%;"></td>
                <th>최종변경일</th>
                <td class="left"><?=$row_001["REG_DATE"]?></td>
            </tr>
            <tr>
                <th>약관내용</th>
                <td colspan="3" class="left">
                    <textarea name="contents" class="input" style="width:95%;height:600px;padding:3pt;"><?=$contents?></textarea>
                </td>
            </tr>
        </table>

        <div style="text-align:center;">
            <input type="submit" value=" 수정 " class="btnGreen w100 h28">
        </div>
    </form>

</div>